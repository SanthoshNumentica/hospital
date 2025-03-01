<?php
namespace App\Infrastructure\Persistence\Patient;

use App\Domain\Patient\PatientVisit;
use App\Domain\Patient\PatientVisitRepository;
use App\Models\Patient\PatientVisitModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatientVisitRepository implements PatientVisitRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect;

	public function __construct() {
		$this->model = new PatientVisitModel();

	}
	public function setEntity($d) {
		return new PatientVisit($d);
	}
	public function globalJoin() {
		// $this->model->select('patients .*,bg.blood_groupName,t.titleName,s.stateName,i.illnessName,g.genderName,c.cityName')
		// ->join('blood_group as bg', 'bg.id = patients.blood_group_fk_id', 'left')
		// ->join('title as t', 't.id = patients.title_fk_id', 'left')
		// ->join('state as s', 's.id = patients.state_fk_id', 'left')
		// ->join('illness as i', 'i.id = patients.medical_history_fk_id', 'left')
		// ->join('city as c', 'c.id = patients.city', 'left')
		// ->join('gender as g', 'g.id = patients.gender_fk_id', 'left');
	}
	public function findById($id) {
		$this->model->select('u.fname as doctorName,patient_visit.*,p.f_name as patientName,p.patient_id,CASE When patient_visit.status  = 1 then "complete"
			When patient_visit.status = 2 then "pending" when patient_visit.status = 3 then "active" else "missed" end as statusName,c.counterName', false)->join('patient as p', 'p.id=patient_fk_id', 'inner')
			->join('counter as c', 'c.id = patient_visit.counter_fk_id', 'left')
			->join('user_login as u', 'u.user_id = doctor_fk_id', 'left');
		if ((int) $id) {
			return $this->model->asArray()->allowCallbacks(true)->find($id);
		} else {
			return $this->model->where(['doctor_fk_id' => $id])->asArray()->allowCallbacks(true)->findAll()[0] ?? '{}';
		}
	}
	public function findByTimeData(): array {
		$currentHour = date('H');
		$currentMinute = date('i');
		$firstShiftStart = 6;
		$firstShiftEnd = 16;
		$secondShiftStartHour = 16;
		$secondShiftStartMinute = 1;

		$isFirstShift = ($currentHour > $firstShiftStart && $currentHour < $firstShiftEnd) ||
			($currentHour === $firstShiftStart && $currentMinute >= 0) ||
			($currentHour === $firstShiftEnd && $currentMinute === 0);

		$isSecondShift = ($currentHour > $secondShiftStartHour && $currentHour <= 23) ||
			($currentHour === $secondShiftStartHour && $currentMinute >= $secondShiftStartMinute);

		if ($isFirstShift || $isSecondShift) {
			$shiftStart = $isFirstShift ? $firstShiftStart : $secondShiftStartHour;
			$shiftEnd = $isFirstShift ? $firstShiftEnd : 23;
			$today = date('Y-m-d');

			return $this->fetchData($today, $shiftStart, $shiftEnd);
		} else {
			return [];
		}
	}

	private function fetchData(string $date, int $startTime, int $endTime): array {
		try {
			return $this->model
				->asArray()
				->where('DATE(visit_on)', $date)
				->where('HOUR(visit_on) >=', $startTime)
				->where('HOUR(visit_on) <', $endTime)
				->orderBy('visit_on', 'ASC')
				->findAll();
		} catch (\Exception $e) {
			// Handle exceptions (e.g., logError($e->getMessage()))
			return [];
		}
	}
	protected function todayQuery() {
		$date = date('Y-m-d');

		$this->model->select('u.fname as doctorName,patient_visit.*,p.f_name as patientName,p.patient_id,CASE When patient_visit.status  = 1 then "complete"
			When patient_visit.status = 2 then "pending" when patient_visit.status = 3 then "active" else "missed" end as statusName,c.counterName', false)->join('patient as p', 'p.id=patient_fk_id', 'inner')
			->join('counter as c', 'c.id = patient_visit.counter_fk_id', 'left')
			->join('user_login as u', 'u.user_id = doctor_fk_id', 'left');
		$this->model->where('DATE(visit_on)', $date);
	}

	public function getTodayToken($id) {
		$this->todayQuery();
		if ($id) {
			$this->model->where('doctor_fk_id', $id);
		}
		return $this->model->whereIn('patient_visit.status', [2, 3, 4])->asArray()->findAll();
	}

	function callNextToken($cond = []) {
		$date = date('Y-m-d');
		$cond['patient_visit.status'] = 2;
		$this->todayQuery();
		$d = $this->model->where($cond)->orderBy('visit_on', 'asc')->asArray()->first();
		$this->makeAllInactive($cond);
		if (!empty($d)) {
			$d = (array) $d;
			// make active
			$this->model->set(['status' => 3])->update($d['id']);
			//make all inactive token
		} else {
			$this->todayQuery();
			if ($cond['patient_visit.status']) {
				unset($cond['patient_visit.status']);
			}
			$cond['patient_visit.status !='] = 1;
			$d = $this->model->where($cond)->orderBy('visit_on', 'asc')->orderBy('patient_visit.status', 'asc')->asArray()->first();
			if (!empty($d)) {
				$this->model->set(['status' => 3])->update($d['id']);
			}
		}
		return $d;
	}

	function makeAllInactive($cond) {
		$date = date('Y-m-d');
		$cond['patient_visit.status'] = 3;
		$this->model->where($cond);
		return $this->model->set(['status' => 4])->where(['DATE(visit_on)' => $date])->update();
	}

	public function getActiveTokenByCounter($id) {
		$this->todayQuery();
		if ($id) {
			$this->model->where('patient_visit.counter_fk_id', $id);
		}
		return $this->model->whereIn('patient_visit.status', [3])->orderBy('visit_on', 'ASC')->asArray()->first();
	}
	public function markCompleteById($id) {
		return $this->model
			->set('status', 1)->update($id);
	}

public function markCompleteByPatientId($id) {
	return $this->model
		->set('status', 1)->where(['patient_fk_id'=>$id,'DATE(visit_on)' => date('Y-m-d')])->update();
}
}