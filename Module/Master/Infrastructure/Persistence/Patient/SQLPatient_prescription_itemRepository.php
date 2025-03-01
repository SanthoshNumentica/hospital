<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_prescription_item;
use App\Domain\Patient\Patient_prescription_itemRepository;
use App\Models\Patient\Patient_prescription_itemModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_prescription_itemRepository implements Patient_prescription_itemRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_prescription_itemModel();
	}
	public function setEntity($d) {
		return new Patient_prescription_item($d);
	}
	public function findAllPagination($ftbl, $isDeleted = false) {
		$this->model->builder()
			->select('GROUP_CONCAT(patient_prescription_item.medicine SEPARATOR "~") as medicine,GROUP_CONCAT(patient_prescription_item.frequency SEPARATOR "~") as frequency,GROUP_CONCAT(dosage SEPARATOR"~") as dosage,GROUP_CONCAT(duration SEPARATOR "~") as duration,GROUP_CONCAT(DISTINCT pp.visits_on SEPARATOR "~") as visit_on,GROUP_CONCAT(DISTINCT u.fname SEPARATOR "~") as doctorName,GROUP_CONCAT(DISTINCT patient_prescription_fk_id SEPARATOR "~") as patient_prescription_fk_id', false)
			->join('patient_prescription as pp', 'pp.id = patient_prescription_fk_id', 'inner')
			->join('user_login as u', 'u.user_id =pp.created_by', 'left')
			->groupBy('patient_prescription_fk_id');
		// $this->groupTerms($ftbl, ['f_name', 'l_name', 'mobile_no', 'cityName', 'address']);
		if (!isset($ftbl->sort) || empty($ftbl->sort)) {
			$ftbl->sort = [['colName' => 'patient_prescription_fk_id', 'sortOrder' => 'desc']];
		}
		return $this->paginationQuery($ftbl, ['patient_fk_id' => 'pp.patient_fk_id']);
	}

	function getSubQuery($id) {
		return $this->model->builder()
			->select('GROUP_CONCAT(patient_prescription_item.medicine SEPARATOR "~") as medicine,GROUP_CONCAT(patient_prescription_item.frequency SEPARATOR "~") as frequency,GROUP_CONCAT(dosage SEPARATOR"~") as dosage,GROUP_CONCAT(duration SEPARATOR "~") as duration,GROUP_CONCAT(DISTINCT DATE(pp.visits_on) SEPARATOR "~") as visit_on,GROUP_CONCAT(patient_prescription_fk_id SEPARATOR "~") as patient_prescription_fk_id', false)
			->join('patient_prescription as pp', 'pp.id = patient_prescription_fk_id', 'inner')
			->groupBy('patient_prescription_fk_id')->where('pp.patient_fk_id', $id)->getCompiledSelect();
	}

	function getItemById($id) {
		return $this->model->where('patient_prescription_fk_id', $id)->asArray()->allowCallbacks(false)->findAll();
	}
}