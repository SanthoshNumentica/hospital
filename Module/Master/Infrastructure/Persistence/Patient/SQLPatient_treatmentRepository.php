<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_treatment;
use App\Domain\Patient\Patient_treatmentRepository;
use App\Infrastructure\Persistence\Appointment\SQLAppointmentRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescription_itemRepository;
use App\Models\Patient\Patient_treatmentModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_treatmentRepository implements Patient_treatmentRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect = 'patient_treatment.*,t.treatmentName,t.treatment_code,
    (SELECT GROUP_CONCAT(teethNumber SEPARATOR  ",") FROM patient_treatment_teeth pt WHERE pt.patient_treatment_fk_id = patient_treatment.id) as teethNumbers,pt.fname AS doctorName';
	public function __construct() {
		$this->model = new Patient_treatmentModel();
	}
	public function setEntity($d) {
		return new Patient_treatment($d);
	}

	function getPendingInvoiceGen($id) {
		return $this->model->where(['patient_fk_id' => $id, 'invoice_fk_id is null ' => null])->asArray()->findAll();
	}
	function globalJoin() {
		$this->model->select($this->compactSelect, false)
			->join('treatment as t', 't.id = treatment_fk_id', 'left')
			->join('user_login as u', 'u.user_id = patient_treatment.created_by', 'left')
			->join('user_login as pt', 'pt.user_id =doctor_fk_id', 'left');
	}
	public function findAllPagination($ftbl, $isDeleted = false) {
		$select = 'GROUP_CONCAT(concat(t.treatment_code, "- ",t.treatmentName) SEPARATOR "~") as treatmentName,
		 GROUP_CONCAT( pt.teeth_concat SEPARATOR "~") as teethNumber,
		GROUP_CONCAT(DISTINCT u.fname SEPARATOR "~") as doctorName,
		GROUP_CONCAT(DISTINCT patient_treatment.id SEPARATOR "~") as id,
		GROUP_CONCAT(patient_treatment.amount SEPARATOR "~") as amount,
		GROUP_CONCAT(DISTINCT patient_treatment.invoice_fk_id SEPARATOR "~") as invoice_fk_id,
		GROUP_CONCAT(DISTINCT DATE(patient_treatment.created_at)) as created_at';
		$this->model->builder()->select($select, false)
			->join('(select patient_treatment_fk_id,CONCAT("(",group_concat(teethNumber SEPARATOR ","),")") as teeth_concat from patient_treatment_teeth group by patient_treatment_fk_id) as pt', 'pt.patient_treatment_fk_id=patient_treatment.id', 'left')
			->groupBy('DATE(patient_treatment.created_at)', 'desc')
			->join('treatment as t', 't.id = treatment_fk_id', 'left')
			->join('patient_treatment_step as pts', 'pts.patient_treatment_fk_id = patient_treatment.id', 'left')
			->join('user_login as u', 'u.user_id =doctor_fk_id', 'left');
		if (!isset($ftbl->sort) || empty($ftbl->sort)) {
			$ftbl->sort = [['colName' => 'DATE(patient_treatment.created_at)', 'sortOrder' => 'desc']];
		}
		$d = $this->paginationQuery($ftbl, ['patient_fk_id' => 'patient_treatment.patient_fk_id']);
		$result = [];
		$stepRepo = new SQLPatient_treatment_stepRepository();
		if (count($d['data'])) {
			foreach ($d['data'] as $key => $dv) {
				$result[$key] = ['created_at' => $dv['created_at'], 'invoice_fk_id' => $dv['invoice_fk_id']];
				$result[$key]['treatment'] = $this->mapKeyValueSummary($dv, ['treatmentName', 'doctorName', 'teethNumber', 'id', 'amount', 'teethNumber']);
				$s = $result[$key]['treatment'];
				if (!empty($s) && is_array($s)) {
					foreach ($s as $sk => $sv) {
						if ($sv['id']) {
							$result[$key]['treatment'][$sk]['treatment_step'] = $stepRepo->getLatestById($sv['id'], 2);
						}
					}
				}
			}
		}
		$d['data'] = $result;
		return $d;
	}
	function getSummary($id, $page = 0) {
		$preRepo = new SQLPatient_prescription_itemRepository();
		$appRepo = new SQLAppointmentRepository();
		$subQuery = $preRepo->getSubQuery($id);
		$queryApp = $appRepo->getSubQuery($id);
		$select = 'GROUP_CONCAT(concat(t.treatment_code, "- ",t.treatmentName) SEPARATOR "~") as treatmentName,
        GROUP_CONCAT( pt.teeth_concat SEPARATOR "~") as teethNumber,
		 GROUP_CONCAT(DISTINCT u.fname SEPARATOR "~") as doctorName,
		GROUP_CONCAT(DISTINCT pp.medicine SEPARATOR ",") as medicine,
		GROUP_CONCAT(DISTINCT pp.frequency SEPARATOR ",") as frequency,
		GROUP_CONCAT(DISTINCT pp.dosage SEPARATOR ",") as dosage,
		GROUP_CONCAT(DISTINCT pp.duration SEPARATOR ",") as duration,
		GROUP_CONCAT(DISTINCT pp.patient_prescription_fk_id SEPARATOR ",") as patient_prescription_fk_id,
		GROUP_CONCAT(DISTINCT app.appointment_on SEPARATOR ",") as appointment_on,
		GROUP_CONCAT(DISTINCT app.appointment_for SEPARATOR ",") as appointment_for,
		GROUP_CONCAT(DISTINCT app.app_doctorName SEPARATOR ",") as app_doctorName,
		DATE(patient_treatment.created_at) as created_at';
		$d = $this->model->select($select, false)
			->join('treatment as t', 't.id = treatment_fk_id', 'left')
			->join('user_login as u', 'u.user_id = patient_treatment.created_by', 'left')
			->join('(select patient_treatment_fk_id,CONCAT("(",group_concat(teethNumber SEPARATOR ","),")") as teeth_concat from patient_treatment_teeth
  group by patient_treatment_fk_id) as pt', 'pt.patient_treatment_fk_id=patient_treatment.id', 'left')
			->join('(' . $subQuery . ') as pp', 'DATE(pp.visit_on) = DATE(patient_treatment.created_at)', 'left')
			->join('(' . $queryApp . ') as app', 'DATE(app.created_at) = DATE(patient_treatment.created_at)', 'left')
			->where(['patient_fk_id' => $id, 'patient_treatment.deleted_at is null' => null])
			->groupBy(['DATE(app.created_at)', 'DATE(patient_treatment.created_at)'], 'desc')->builder()->union($appRepo->getNonTreatmentQuery($id));
		$db = \Config\Database::connect();
		$data = $db->newQuery()->fromSubquery($d, 'q')->orderBy('created_at', 'DESC')->limit(5, (5 * $page))->get()->getResultArray() ?? [];
		$result = [];
		if (count($data)) {
			foreach ($data as $key => $dv) {
				$dv['duration'] = !empty($dv['duration']) && !str_contains_any($dv['duration'], ['day', 'month', 'week', 'year']) ? $dv['duration'] . ' days' : $dv['duration'];
				$result[$key]['treatment'] = !empty($dv['treatmentName']) ? $this->mapKeyValueSummary($dv, ['treatmentName', 'doctorName', 'teethNumber']) : [];
				$result[$key]['prescription'] = !empty($dv['medicine']) ? $this->mapKeyValueSummary($dv, ['medicine', 'frequency', 'dosage', 'duration', 'patient_prescription_fk_id']) : [];
				$result[$key]['created_at'] = $dv['created_at'];
				$result[$key]['appointment_on'] = $dv['appointment_on'] ?? null;
				$result[$key]['appointment_for'] = $dv['appointment_for'];
				$result[$key]['app_doctorName'] = $dv['app_doctorName'];
				$result[$key]['doctorName'] = $dv['doctorName'];
			}
		}
		return $result;
	}

	protected function mapKeyValueSummary($dataV, $keys = []) {
		$result = [];
		foreach ($dataV as $key => $value) {
			if (in_array($key, $keys)) {
				$values = explode('~', $value);
				foreach ($values as $index => $splitValue) {
					if (!isset($result[$index])) {
						$result[$index] = [];
					}
					$result[$index][$key] = $splitValue;
				}
			}
		}
		return $result;
	}

	function getSummaryByDate($id, $date) {
		$date = date('Y-m-d', strtotime($date));
		return $d = $this->model->select($select, false)
			->join('treatment as t', 't.id = treatment_fk_id', 'left')
			->join('user_login as u', 'u.user_id = patient_treatment.created_by', 'left')
			->join('patient_treatment_teeth as pt', 'pt.patient_treatment_fk_id = patient_treatment.id', 'left')
			->where(['patient_fk_id' => $id])->where('DATE(patient_treatment.created_at)', 'DATE($date)', false)
			->groupBy('patient_treatment.id', 'desc')
			->asArray()->findAll();
	}

	public function getAllPendingInvoiceByList() {
		$this->model
			->select('GROUP_CONCAT(DISTINCT patient_fk_id SEPARATOR ",") as patient_fk_id, GROUP_CONCAT(DISTINCT DATE(patient_treatment.created_at) SEPARATOR ",") as  invoice_date,GROUP_CONCAT(DISTINCT p.f_name SEPARATOR ",") AS patientName,GROUP_CONCAT(DISTINCT patient_id) as patient_id,COALESCE(SUM(amount),0) AS total_amount,GROUP_CONCAT(DISTINCT p.mobile_no SEPARATOR ",")as mobile_no', false)
			->join('patient as p', 'p.id = patient_treatment.patient_fk_id', 'left')
			->where('invoice_fk_id is null ', null)
			->groupBy('patient_fk_id');
		// echo $this->model->builder()->getCompiledSelect();
		return $this->model->asArray()->findAll();
	}
	public function getPendingInvoicesByDate($pid, $date = null) {
		// CONCAT(GROUP_CONCAT(distinct tr.treatmentName) ," ",GROUP_CONCAT(CONCAT(`pt`.`teethNumber`) SEPARATOR ",")) AS description
		$query = $this->model
			->select('GROUP_CONCAT(distinct patient_treatment.id) as patient_treatment_id,GROUP_CONCAT(distinct patient_treatment.patient_fk_id) as patient_fk_id,
				CONCAT(tr.treatmentName, " ",patient_treatment.description) as description,
				,GROUP_CONCAT(distinct patient_treatment.amount) as amount,GROUP_CONCAT(distinct ul.fname) as created_by,GROUP_CONCAT(distinct treatment_fk_id) as treatment_fk_id')
			->join('patient as p', 'p.id=patient_treatment.patient_fk_id', 'left')
			->join('treatment as tr', 'tr.id=patient_treatment.treatment_fk_id', 'left')
		// ->Join('patient_treatment_teeth as pt ', 'patient_treatment.id=pt.patient_treatment_fk_id', 'left')
			->Join('user_login as ul', 'ul.user_id=created_by', 'left')
			->where('patient_treatment.invoice_fk_id')
			->where('patient_treatment.patient_fk_id', $pid)
			->where('patient_treatment.invoice_fk_id is null ', null)
			->groupBy('patient_treatment.id')
			->orderBy('patient_treatment_id', 'DESC');
		if ($date) {
			$formattedDate = date('Y-m-d');
			$query->where('DATE(patient_treatment.created_at)', $formattedDate);
		}
		// echo $this->model->builder()->getCompiledSelect();
		return $query->findAll();
	}
	// function getSummaryQuery() {
	// 	$this->globalJoin();
	// }
}
