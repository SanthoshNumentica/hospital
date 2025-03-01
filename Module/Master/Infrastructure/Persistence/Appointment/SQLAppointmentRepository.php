<?php
namespace App\Infrastructure\Persistence\Appointment;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\AppointmentRepository;
use App\Models\Appointment\AppointmentModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLAppointmentRepository implements AppointmentRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	protected $compactSelect;
	protected $overWriteConditionKey = ['patient_fk_id' => 'p.id'];
	public function __construct() {
		$this->model = new AppointmentModel();
	}
	public function setEntity($d) {
		return new Appointment($d);
	}
	// public function globalJoin()
	// {
	//     $this->model->select('appointment .*,p.f_name,p.l_name,pv.token_no')
	//     ->join('patient as p', 'p.id = appointment.patient_fk_id', 'left')
	//     ->join('gender as g', 'g.id = p.gender_fk_id', 'left')
	//     ->join('patient_visit as pv', 'pv.patient_fk_id = p.id', 'left')
	//     ->join('blood_group as bg', 'bg.id = p.blood_group_fk_id', 'left');
	// }
	// public function findByDay($day="today")
	// {
	//     if ($day='yesterday'){
	//         $date = date('Y-m-d', strtotime($day));
	//     }elseif($day='tomorrow'){
	//         $date = date('Y-m-d', strtotime($day));
	//     }else{
	//         $date = date('Y-m-d');
	//     }
	//   return $this->model
	//     ->asArray()
	//     ->where('appointment_on >=', $date)
	//     ->where('appointment_on <', date('Y-m-d'))
	//     ->orderBy('appointment_on', 'DESC')
	//     ->allowCallbacks(true)
	//     ->findAll();
	// }
	public function findByYesterdaysData() {
		$this->globalJoin();
		$yesterday = date('Y-m-d', strtotime('yesterday'));
		return $this->model
			->asArray()
			->where('appointment_on >=', $yesterday)
			->where('appointment_on <', date('Y-m-d'))
			->orderBy('appointment_on', 'DESC')
			->allowCallbacks(true)
			->findAll();
	}
	public function findByUpcomingData() {
		$this->globalJoin();
		$tomorrow = date('Y-m-d', strtotime('tomorrow'));
		return $this->model
			->asArray()
			->where('appointment_on >', $tomorrow)
			->where('appointment_on >', date('Y-m-d'))
			->orderBy('appointment_on', 'DESC')
			->allowCallbacks(true)
			->findAll();
	}
	public function findByTodaysData() {
		$this->globalJoin();
		$todayStart = date('Y-m-d 00:00:00'); // Start of today
		$todayEnd = date('Y-m-d 23:59:59'); // End of today
		return $this->model
			->asArray()
			->where('appointment_on >=', $todayStart)
			->where('appointment_on <=', $todayEnd)
			->orderBy('appointment_on', 'DESC')
			->allowCallbacks(true)
			->findAll();
	}

	public function globalJoin() {
		$title = 'CONCAT(d.fname, " - ", p.f_name) AS title';
		$this->model->select('appointment.*, d.fname AS doctorName, pv.token_no, u.fname AS created_byName, p.f_name AS patientName,
								DATE(appointment_on) AS appointment_date,
								DATE_FORMAT(appointment_on, "%h:%i %p") AS appointment_time,
								p.patient_id, p.mobile_no,
								CASE WHEN is_rescheduled = 1 THEN "Yes" ELSE "NO" END AS rescheduledStatusName,
								CASE
				WHEN appointment.is_visited = 1 THEN "Visited"
				WHEN CURDATE() = DATE(appointment.appointment_on) THEN "Active"
				WHEN CURDATE() > DATE(appointment.appointment_on) THEN "Missed"
				ELSE "Pending"
			END AS statusName,CASE WHEN is_visited = 1 THEN 1
			WHEN CURDATE() = DATE(appointment.appointment_on) THEN 2
			 WHEN CURDATE() > appointment_on THEN 4 ELSE 3 END AS status
			 ,
								' . $title, false)
			->join('user_login AS u', 'u.user_id = appointment.created_by', 'left')
			->join('patient AS p', 'p.id = appointment.patient_fk_id', 'left')
			->join('user_login AS d', 'd.user_id = doctor_fk_id', 'inner')
			->join('patient_visit AS pv', 'pv.patient_fk_id = p.id', 'left');
	}

	public function findAllPagination($ftbl, $isDeleted = false) {
		$this->globalJoin();
		if (!$isDeleted) {
			$this->model->onlyDeleted();
		}
		if (isset($ftbl->queryParams) && is_array($ftbl->queryParams)) {
			foreach ($ftbl->queryParams as $key => &$v) {
				if ($v->colName == 'status') {
					$v->operation = 'having';
					$v->matchMode = 'having';
				}
			}
		}
		if (!isset($ftbl->sort) || empty($ftbl->sort)) {
			$ftbl->sort = [['colName' => 'f_name', 'sortOrder' => 'asc']];
		}
		return $this->paginationQuery($ftbl, []);

	}

	public function getAllByMonth($dateRange, $doctor_id = 0) {
		$title = (int) $doctor_id ? 'concat(p.f_name, " - ", appointment_for)' : 'concat(d.fname, " - ", p.f_name)';

		$this->model->select('appointment.*, d.fname as doctorName, u.fname as created_byName, appointment.appointment_on, p.f_name as patientName, p.patient_id, ' . $title . ' as title,
			CASE
				WHEN appointment.is_visited = 1 THEN "Visited"
				WHEN CURDATE() = DATE(appointment.appointment_on) THEN "Active"
				WHEN CURDATE() > DATE(appointment.appointment_on) THEN "Missed"
				ELSE "Pending"
			END AS statusName,CASE WHEN is_visited = 1 THEN 1
			WHEN CURDATE() = DATE(appointment.appointment_on) THEN 2
			 WHEN CURDATE() > appointment_on THEN 4 ELSE 3 END AS status', false)
			->join('user_login as u', 'u.user_id = appointment.created_by', 'left')
			->join('patient as p', 'p.id = appointment.patient_fk_id', 'left')
			->join('user_login as d', 'd.user_id = appointment.doctor_fk_id', 'inner');
		if (is_array($dateRange) && isset($dateRange[1])) {
			$this->setBeweenDate('appointment_on', $dateRange[0], $dateRange[1]);
		} else {
			$date = is_array($dateRange) ? $dateRange[0] : $dateRange;
			$this->model->where('DATE(appointment_on)', $date);
		}
		if ((int) $doctor_id) {
			$this->model->where('appointment.doctor_fk_id', $doctor_id);
		}
		// echo $this->model->builder()->getCompiledSelect();
		$this->model->orderBy('appointment_on', 'DESC');
		return $this->model->asArray()->findAll();
	}
	public function findByDay($day = "today", $status = true) {
		if ($day = 'yesterday') {
			$date = date('Y-m-d', strtotime($day));
		} elseif ($day = 'tomorrow') {
			$date = date('Y-m-d', strtotime($day));
		} else {
			$date = date('Y-m-d');
		}
		if ($status) {
			$this->model->where('is_visited', 0);
		}
		return $this->model
			->asArray()
			->where('appointment_on >=', $date)
			->where('appointment_on <', date('Y-m-d'))
			->orderBy('appointment_on', 'asc')
			->allowCallbacks(true)
			->findAll();
	}
	public function markVisitByPatient($id) {
		return $this->model
			->set('is_visited', 1)
			->where(['DATE(appointment_on)' => date('Y-m-d'), 'patient_fk_id' => $id])->update();
	}
	public function makeAppointment($date, $pid, $reason) {
		//check appointment is there
		$d = $this->model->where('patient_fk_id', $pid)->where('DATE(appointment_on)', date('Y-m-d', strtotime($date)))->asArray()->first();
		if (empty($d)) {
			//new appointmnet
			return $this->model->insert(['appointment_on' => $date, 'appointment_for' => $reason, 'patient_fk_id' => $pid]);
		} else {
			$d = (array) $d;
			return $this->model->set(['appointment_on' => $date, 'appointment_for' => $reason, 'patient_fk_id' => $pid])->update($d['id']);
		}
	}

	public function getSubQuery($id) {
		return $this->model->builder()
			->select('appointment_on,appointment_for,appointment.created_at,d.fname as app_doctorName')
			->join('user_login as d', 'd.user_id= doctor_fk_id', 'inner')->where('patient_fk_id', $id)->orderBy('appointment.created_at', 'desc')->getCompiledSelect();
	}

	public function getNonTreatmentQuery($id) {
		return $this->model->builder()
			->select('null as treatmentName,null as teethNumber,d.fname as doctorName,null as medicine,null as frequency,null as dosage, null as duration,null as patient_prescription_fk_id,appointment_on,appointment_for,d.fname as app_doctorName,appointment.created_at')
			->join('user_login as d', 'd.user_id= doctor_fk_id', 'inner')
			->join('patient_treatment as pt', 'DATE(pt.created_at) != DATE(appointment.created_at)', 'inner')
			->where('appointment.patient_fk_id', $id)->orderBy('appointment.created_at', 'desc');
	}
	public function findAllAppointmentsByMonth($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
		$appointments = $this->model->select('appointment.*')
			->where('appointment_on >=', $startOfMonth)
			->where('appointment_on <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();

		// Filter appointments where 'is_visited' is 1
		$visitedAppointments = array_filter($appointments, function ($appointment) {
			return $appointment['is_visited'] == 1;
		});
		$missedAppointments = array_filter($appointments, function ($appointment) {
			return $appointment['is_visited'] == 0;
		});
		$rescheduledAppointments = array_filter($appointments, function ($appointment) {
			return $appointment['is_rescheduled'] == 1;
		});

		$totalAppointments = count($appointments);
		$totalVisited = count($visitedAppointments);
		$missedAppointments = count($missedAppointments);
		$rescheduledAppointments = count($rescheduledAppointments);

		return [
			'details' => $appointments, // This now contains only visited appointments
			'total_appointments' => $totalAppointments,
			'visited_appointments' => $totalVisited,
			'missed_appointments' => $missedAppointments,
			'rescheduled_appointments' => $rescheduledAppointments,
		];
	}

}
