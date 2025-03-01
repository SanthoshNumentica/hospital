<?php
namespace App\Controllers;

use App\Infrastructure\Persistence\Appointment\SQLAppointmentRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientVisitRepository;
use Core\Controllers\BaseController;
use Core\Models\Utility\UtilityModel;

class DashboardController extends BaseController
{

	private $repository;
	private $role_repository;
	private $staff_repository;
	private $utility_repo;
	private $appointmentRepo;

	public function __construct()
	{
		$this->initializeFunction();
		// $this->staff_repository = new SQLStaffRepository();
		$this->utility_repo = new UtilityModel();
	}

	public function index()
	{

	}

	public function getData() {
		$patientRepo = new SQLPatientRepository();
		$appointmentRepo = new SQLAppointmentRepository();
		$patient_visitRepo = new SQLPatientVisitRepository();
		$data['todays_appointment'] = count($appointmentRepo->findAllByWhere(['appointment_on'=>date('y-m-d')]));
		$data['total_patient'] = $patientRepo->countAll(false);
		$data['today_visited_patients'] = count($patient_visitRepo->findAllByWhere(['visit_on'=>date('y-m-d')]));
		$data['todays_patients'] = count($patientRepo->findAllByWhere(['created_at'=>date('y-m-d')]));
		$data['total_doctor'] = $this->utility_repo->countAll('user_login', ['is_doctor' => 1]);
		$data['total_treatment'] = $this->utility_repo->countAll('treatment');
		return $this->message(200, $data, 'success');
	}
}
