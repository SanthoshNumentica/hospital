<?php
namespace App\Controllers\Appointment;

use App\Domain\Appointment\Appointment;
use App\Infrastructure\Persistence\Appointment\SQLAppointmentRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\whatsApp;
use Core\Libraries\ExportExcel;
use PhpParser\Node\Expr\Print_;

class AppointmentController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $excelLib;
	public function __construct() {
		$this->initializeFunction();
		helper('Core\Helpers\Date');
		$this->repository = new SQLAppointmentRepository();
		$this->excelLib             = new ExportExcel();
	}

	public function save() {
		$data = $this->getDataFromUrl('json');
		$userId = $this->userData->user_id ?? 1;
		if (!checkValue($data, 'patient_fk_id')) {
			return $this->message(400, null, 'Patient Id Is Required');
		}
		if (!checkValue($data, 'doctor_fk_id')) {
			return $this->message(400, null, 'Doctor Id Is Required');
		}
		$action = 'updated';
		if (!checkValue($data, 'id')) {
			$action = 'created';
			$data['is_rescheduled'] = 0;
			$data['created_by'] = $userId;
			$data['created_byName'] = $this->userData->fname ?? '';
			$data['title'] = ($data['fname'] ?? '') . ' - ' . $data['appointment_for'];
			$data['start'] = date('Y-m-d H:i:s', strtotime($data['appointment_on']));
		} else {
			if (isset($data['created_by'])) {
				unset($data['created_by']);
			}
		}
		$action = !checkValue($data, 'id') ? 'created' : 'updated ';
		if (checkValue($data, 'id')) {
			$res = $this->repository->save(new Appointment($data));
		} else {
			$data['id'] = $this->repository->insert(new Appointment($data));
			$res = true;
		}
		//whatsApp message for NEW_APPOINTMENT
		if(checkValue($data,'is_whatsapp')){
			$whatsApp=new whatsApp();
			// $whatsApp->whatsAppSendByEvents('NEW_APPOINTMENT',$data);
		}
		return $this->message($res ? 200 : 400, $data, $res ? "Appointment $action Successfully" : 'Unable to save changes');
	}

	public function reschedule($id) {
		$req = $this->getDataFromUrl('json');
		$update = ['is_rescheduled' => 1, 'rescheduled_reason' => $req['rescheduled_reason'] ?? '', 'appointment_on' => $req['appointment_on']];
		if (checkValue($req, 'patient_fk_id')) {
			$update['patient_fk_id'] = $req['patient_fk_id'];
		}
		if (checkValue($req, 'doctor_fk_id')) {
			$update['doctor_fk_id'] = $req['doctor_fk_id'];
		}
		$res = $this->repository->updateById($id, $update);
		$req['start'] = date('Y-m-d H:i:s', strtotime($req['appointment_on']));
		$req['title'] = ($req['fname'] ?? $req['patientName']) . ' - ' . $req['appointment_for'];
		$req['id'] = $id;
		//whatsApp message for RESCHEDULE_APPOINTMENT
		if(checkValue($req,'is_whatsapp')){
			$whatsApp=new whatsApp();
			$whatsApp->whatsAppSendByEvents('RESCHEDULE_APPOINTMENT',$req);
		}
		return $this->message($res ? 200 : 400, $req, $res ? 'Successfully Resechduled' : 'Failed to Save');
	}

	public function getDaysList() {
		// Retrieve data for today, yesterday, and upcoming days
		$data['yesterday_data'] = $this->repository->findByYesterdaysData();
		$data['todays_data'] = $this->repository->findByTodaysData();
		$data['upcoming_data'] = $this->repository->findByUpcomingData();
		return $this->message(200, $data, 'Success');
	}
	public function getTodayList($doctor_fk_id = null) {
		$dateRange = [date('Y-m-d')];
		$data = $this->repository->getAllByMonth($dateRange, $doctor_fk_id);
		return $this->message(200, $data, 'Success');
	}
	public function getTodaysAppointment()
	{
		$data = $this->repository->findAll();
		return $this->message(200, $data, 'Success');
	}
	// public function getTodaysAppointments()
	// {
	// 	$data = $this->repository->findTodayAppointments();
	// 	// print_r($data);
	// 	return $this->message(200, $data, 'Success');
	// }
	public function getAll() {
		$req = $this->getDataFromUrl('json');
		$da = startAndEndMonthByDate($req['date'] ?? date('Y-m-d'));
		if(!checkValue($req,'from_date')){
			return $this->message(400,null,'Date is Required');
		}
		$dateRange=[];
		if(!checkValue($req,'to_date')){
			$dateRange[1]= date('Y-m-d');
		}else{
			$dateRange[1] = $req['to_date'];
		}
		$dateRange[0] = $req['from_date'];
		// $dateRange = [$da[2], $da[3]];
		$d = $this->repository->getAllByMonth($dateRange, $req['doctor_fk_id'] ?? null);
		return $this->message(200, $d, 'Successfully');
	}
	public function appointmentsReport() {
		$req = $this->getDataFromUrl('json');
		$formattedStartDate = date('Y-m-d', strtotime($req['start_date']));
		$formattedEndDate = isset($req['end_date']) ? date('Y-m-d', strtotime($req['end_date'])) : $formattedStartDate;
		
		$data = $this->repository->findAllAppointmentsByMonth($formattedStartDate, $formattedEndDate);
		if ($req['print'] == true) {
			$col = [
			['colName' => 'patientName', 'title' => 'Patient Name'],
			['colName' => 'doctorName', 'title' => 'Doctor Name'],
			['colName' => 'patient_id', 'title' => 'Patinet Id'],
			['colName' => 'amount', 'title' => 'Amount'],
			['colName' => 'appointment_for', 'title' => 'Appointment for'],
			['colName' => 'appointment_on', 'title' => 'Appointment On'],
			['colName' => 'token_no', 'title' => 'Token No'],
			['colName' => 'statusName', 'title' => 'Status'],
			['colName' => 'rescheduledStatusName', 'title' => ' Reschedule Status'],
			['colName' => 'to_date', 'title' => 'Reschedule Date']
			];
			
			$dataResult = array_map(function ($payment) {
				return ['col' => $payment];
			}, $data);
			
			return $this->excelLib->export($dataResult, ['col' => $col]);
		} else {
			if ($data) {
				return $this->message(200, $data, 'Success.');
			} else {
				return $this->message(200, null, 'No Data.');
			}
		}
	}

}
