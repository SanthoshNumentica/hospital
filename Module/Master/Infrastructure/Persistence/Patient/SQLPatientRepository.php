<?php

namespace App\Infrastructure\Persistence\Patient;

use App\Domain\Patient\Patient;
use App\Domain\Patient\PatientRepository;
use App\Models\Patient\PatientModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatientRepository implements PatientRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect = 'patient .*,bg.blood_groupName,t.titleName,s.stateName,g.genderName,c.cityName,
	t.titleName,concat(t.titleName , "", patient.f_name, " ", patient.l_name) as patient_fullName,TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age,f_name as patientName';
	public function __construct() {
		$this->model = new PatientModel();
	}
	public function setEntity($d) {
		return new Patient($d);
	}
	function globalJoin() {
		$this->model->select($this->compactSelect, false)
			->join('state as s', 's.id = patient.state_fk_id', 'left')
			->join('city as c', 'c.id = patient.city', 'left')
			->join('gender as g', 'g.id = patient.gender_fk_id', 'left')
			->join('blood_group as bg', 'bg.id =patient.blood_group_fk_id', 'left')
			->join('title as t', 't.id = patient.title_fk_id', 'left');
	}
	public function findById($id) {
		$this->globalJoin();
		$this->model->select($this->compactSelect . ',pc.patient_categoryName', false);
		$this->model->join('patient_category as pc', 'pc.id = patient.patient_category_fk_id', 'left');
		return $this->model->asArray()->allowCallbacks(true)->withDeleted()->find($id);
	}
	public function findReports($cond): array {
		$this->model->select("patient.*,b.blood_groupName")
			->join('blood_group as b', 'b.id = sd.blood_group_id', 'left');
		$this->setWhere($cond);
		return $this->model->asArray()->allowCallbacks(true)->findAll();
	}
	public function findAllPagination($ftbl, $isDeleted = false) {
		$this->globalJoin();
		$this->groupTerms($ftbl, ['f_name', 'l_name', 'mobile_no', 'cityName', 'address']);
		if ($isDeleted) {
			$this->model->onlyDeleted();
		}
		if (!isset($ftbl->sort) || empty($ftbl->sort)) {
			$ftbl->sort = [['colName' => 'f_name', 'sortOrder' => 'asc']];
		}
		return $this->paginationQuery($ftbl, []);
	}
	public function search($terms, $whereField = []) {
		$this->model
			->groupStart()
			->like('f_name', $terms, 'both')
			->orLike('l_name', $terms, 'both')
			->orLike('patient_id', $terms, 'both')
			->orLike('mobile_no', $terms, 'both')
			->orLike('id', $terms, 'both')
			->groupEnd();
		$this->setWhere($whereField);
		return $this->model->asArray()->allowCallbacks(true)->findAll(10);
	}
	public function findAllRember($ftbl, $type = 'BIRTHDAY', $cat = 0, $all = true) {
		$this->model->select('dob,TIMESTAMPDIFF(YEAR, dob,CURDATE()) AS age,patient_id');

		if ($type == 'BIRTHDAY') {
			$field = 'patient.dob';
		}
		$cat = '+' . $cat ?? 0;
		$this->model->where('DAYOFYEAR(curdate()) <= DAYOFYEAR(' . $field . ') AND DAYOFYEAR(curdate()) ' . $cat . ' >= DAYOFYEAR(' . $field . ')');
		$this->model->where('patient.deleted_at', null);
		if (!isset($ftbl->sort) || empty($ftbl->sort)) {
			$ftbl->sort = [['colName' => 'MONTH(' . $field . '), DAYOFMONTH(' . $field . ')', 'sortOrder' => 'asc']];
		}
		if (!$all) {
			return $this->model->asArray()->findAll();
		}
		return $this->paginationQuery($ftbl);
	}
	function getRecentPatient() {
		$this->globalJoin();
		return $this->model->orderBy('created_at', 'desc')->asArray()->findAll(5);
	}

	public function getPatientReport($cond) {
		$this->globalJoin();
		$this->setWhere($cond);
		return $this->model->asArray()->allowCallbacks(true)->findAll();
	}

	public function getpatientByCond($page) {
		$rows = 50;
		$q = $this->model->select('GROUP_CONCAT(DISTINCT patient_id) as patient_id,
			GROUP_CONCAT(DISTINCT mobile_no) as mobile_no,
			GROUP_CONCAT(DISTINCT concat(patient.f_name," ",patient.l_name)) as patientName,
			GROUP_CONCAT(DISTINCT TIMESTAMPDIFF(YEAR, dob, CURDATE())) AS age');
		// if ($ageType == 'above') {
		// 	$q->having("age > $age");
		// } elseif ($ageType == 'below') {
		// 	$q->having("age < $age");
		// }
		// if ($gender) {
		// 	$q->where('gender_fk_id', $gender);
		// }
		// if ($state) {
		// 	$q->where('state_fk_id', $state);
		// }
		$this->model->where('mobile_no != ', '')->notLike('mobile_no', '0465')->having('CHAR_LENGTH(mobile_no)', 10, false)->groupBy(['mobile_no', 'f_name']);
		return $q->asArray()->allowCallbacks(true)->findAll($rows, ($rows * $page));
	}

}
