<?php
namespace App\Controllers\Patient;

use App\Domain\Patient\Patient;
use App\Infrastructure\Persistence\Appointment\SQLAppointmentRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoiceRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientVisitRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_examinationRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_illnessRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_imagesRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_investigationRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescriptionRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescription_itemRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatmentRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_planRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_stepRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_teethRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Models\Utility\UtilityModel;

class PatientController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $appointment;
	private $invRepo;
	private $treatements;
	private $preItemRepo;
	private $utilityRepo;
	private $preRepo;
	private $patientExamRepo;
	private $patientVisitRepo;
	private $illnessRepo;
	private $planRepo;
	public function __construct() {
		$this->initializeFunction();
		$this->utilityRepo = new UtilityModel();
		$this->repository = new SQLPatientRepository();
		$this->appointment = new SQLAppointmentRepository();
		$this->invRepo = new SQLPatient_investigationRepository();
		$this->treatements = new SQLPatient_treatmentRepository();
		$this->preItemRepo = new SQLPatient_prescription_itemRepository();
		$this->preRepo = new SQLPatient_prescriptionRepository();
		$this->patientVisitRepo = new SQLPatientVisitRepository();
		$this->patientExamRepo = new SQLPatient_examinationRepository();
		$this->illnessRepo = new SQLPatient_illnessRepository();
		$this->planRepo = new SQLPatient_treatment_planRepository();

	}

	public function save() {
		$data = $this->getDataFromUrl('json');
		$userId = $this->userData->user_id ?? 1;
		if (!checkValue($data, 'f_name')) {
			return $this->message(400, null, 'Patient Name is Required');
		}
		if (!checkValue($data, 'mobile_no')) {
			return $this->message(400, null, 'Mobile Number is Required');
		}
		if (!checkValue($data, 'id')) {
			$data['patient_id'] = generateKey('PATIENT');
		}
		$action = 'update';
		startDbTrans();
		$utilityRepo = new UtilityModel();
		// check city
		if (checkValue($data, 'cityName')) {
			//get city id
			$oldCityId = $utilityRepo->tableTermsMatch('city', 'cityName', $data['cityName']);
			if (empty($oldCityId)) {
				$data['city'] = $utilityRepo->addNewData('city', ['cityName' => $data['cityName']]);
			} else {
				$data['city'] = $oldCityId;
			}
		}
		if (checkValue($data, 'id')) {
			if (checkValue($data, 'patient_id')) {
				unset($data['patient_id']);
			}
			$this->repository->save(new Patient($data));
			$utilityRepo->deleteData('patient_illness', ['patient_fk_id' => $data['id']]);
		} else {
			$action = 'insert';
			$data['id'] = $this->repository->insert(new Patient($data));
			// if (checkValue($data, 'doctor_fk_id')) {
			// 	// gen Token
			// }
		}
		if (checkValue($data, 'medical_history_fk_id') && is_array($data['medical_history_fk_id'])) {
			if ($action != 'insert') {
				$utilityRepo->deleteData('patient_illness', ['patient_fk_id' => $data['id']]);
			}
			foreach ($data['medical_history_fk_id'] as $key => $mv) {
				$illnessid = '';
				if (!checkValue($mv, 'id')) {
					//insert ne illness
					$illnessid = $utilityRepo->addNewData('illness', ['illnessName' => $mv['illnessName']]);
				}
				$utilityRepo->addNewData('patient_illness', ['patient_fk_id' => $data['id'], 'illness_fk_id' => checkValue($mv, 'id') ? $mv['id'] : $illnessid]);
			}
		}
		$res = applyDbChanges();
		//whatsApp message for NEW_PATIENT
		// if (checkValue($data, 'allow_sms') && $action == 'insert') {
		// 	$whatsApp = new MessageSender();
		// 	if (checkValue($data, 'patient_id')) {
		// 		$data['patientName'] = $data['f_name'];
		// 	}
		// 	$whatsApp->genMsgContent('NEW_PATIENT', $data, 3);
		// }
		return $this->message($res ? 200 : 400, $data, $res ? "Data Updated successfully" : "Unable to save Patient");
	}

	public function saveRoutine() {
		$req = $this->getDataFromUrl('json');
		if (!checkValue($req, 'id')) {
			return $this->message(400, null, 'Unable to find Patient');
		}
		$userId = $this->userData->user_id ?? 1;
		$arrayKey = ['investigation', 'treatment', 'examination', 'prescription', 'treatment_plan', 'doc'];
		$arayMerge = ['patient_fk_id' => $req['id'], 'created_by' => $userId, 'visits_on' => $req['visits_on'] ?? date('Y-m-d')];
		$req = mergeArrayKey($arrayKey, $req, $arayMerge);
		$lv = $this->repository->updateById($req['id'], ['last_visit' => date('d m y')]);

		//save Investigation
		// startDbTrans();
		if (checkValue($req, 'investigation')) {
			//save Investigation
			$inv = $req['investigation'];
			if (checkValue($inv, 'temp') || checkValue($inv, 'weight') or checkValue($inv, 'observation') or checkValue($inv, 'blood_sugar') or checkValue($inv, 'bp')) {
				$inv = $this->invRepo->setEntity($inv);
				$this->invRepo->save($inv);
			}
		}
		if (checkValue($req, 'prescription')) {
			//save Investigation
			$preItemRepo = new SQLPatient_prescription_itemRepository();
			$preRepo = new SQLPatient_prescriptionRepository();
			$pk_id = $preRepo->insert($arayMerge);
			$pd = [];
			foreach ($req['prescription'] as $pk => $pv) {
				$pd['medicine'] = $pv['medicineName'];
				$pd['dosage'] = $pv['medicine_dosageName'] ?? '';
				$pd['duration'] = $pv['medicine_durationName'];
				$pd['frequency'] = $pv['medicine_frequencyName'];
				$pd['patient_prescription_fk_id'] = $pk_id;
				// before insert check the  column data then already there or not ?
				if (isset($pv['medicine_dosage_fk_id'])) {
					$this->utilityRepo->checkAndReplace('medicine_dosage', ['medicine_dosageName' => $pd['dosage']], 'medicine_dosageName');
				}
				if (isset($pv['medicine_frequency_fk_id'])) {
					$this->utilityRepo->checkAndReplace('medicine_frequency', ['medicine_frequencyName' => $pd['frequency']], 'medicine_frequencyName');
				}
				if (isset($pv['medicine_fk_id'])) {
					$this->utilityRepo->checkAndReplace('medicine', ['medicineName' => $pd['medicine']], 'medicineName');
				}
				if (isset($pv['medicine_duration_fk_id'])) {
					$this->utilityRepo->checkAndReplace('medicine_duration', ['medicine_durationName' => $pd['duration']], 'medicine_durationName');
				}
				$preItemRepo->insert($pd);
			}
		}
		$planRepo = new SQLPatient_treatment_planRepository();
		if (checkValue($req, 'treatment_plan')) {
			//save Treatment plan
			$plan = $planRepo->setEntity($req['treatment_plan']);
			$planRepo->save($plan->toRawArray(true));
		}
		if (checkValue($req, 'treatment') && is_array($req['treatment']) && count($req['treatment'])) {
			//save Investigation
			$trementRepo = new SQLPatient_treatmentRepository();
			foreach ($req['treatment'] as $k => $v) {
				// $tEntity = $trementRepo->setEntity($v);
				if (!checkValue($v, 'doctor_fk_id')) {
					$v['doctor_fk_id'] = $userId;
					$v['created_by'] = $userId;
				}
				$setField = $trementRepo->setEntity($v);
				$tkid = $trementRepo->insert($setField);
				if (checkValue($v, 'patient_treatment_stepName')) {
					//add new procure on
					$stepRepo = new SQLPatient_treatment_stepRepository();
					$stepRepo->insert(['patient_treatment_fk_id' => $tkid, 'patient_treatment_stepName' => $v['patient_treatment_stepName']]);
				}
				$addTeeth = $v['add_tooth'] ?? '';
				// $teethArray = [];
				// if (!empty($addTeeth)) {
				//     $teethArray = explode(',', $addTeeth);
				// }
				foreach ($addTeeth as $tk => $tv) {
					$tRepo = new SQLPatient_treatment_teethRepository();
					$pTeeth = ['patient_treatment_fk_id' => $tkid, 'patient_fk_id' => $req['id'], 'teethNumber' => $tv['toothNumber']];
					// $this->utilityRepo->replaceData('patient_treatment_teeth', [$pTeeth['teethNumber']]);
					$tRepo->insert($pTeeth);
					//check the tratment plan found and update status
					$planRepo->chekUpdateStatus($req['id'], $tv['toothNumber']);
				}
			}
		}

		if (checkValue($req, 'doc')) {
			//save Investigation
			$docRepo = new SQLPatient_imagesRepository();
			$doc = $docRepo->setEntity($req['doc']);
			$docRepo->save($doc->toRawArray(true));
		}
		if (checkValue($req, 'examination')) {
			//save Investigation
			$exaRepo = new SQLPatient_examinationRepository();
			$exp = $exaRepo->setEntity($req['examination']);
			$exaRepo->save($exp->toRawArray(true));
		}
		if (checkValue($req, 'appointment_on')) {
			$checkDate = strtotime($req['appointment_on']);
			if ($checkDate) {
				//save Appointment
				if (!checkValue($req, 'appointment_for')) {
					$req['appointment_for'] = 'Follow Up Treatment';
				}
				$this->appointment->makeAppointment($req['appointment_on'], $req['id'], $req['appointment_for']);
				// $tRepo->insert($exaRepo);
			}

		}
		//checkaAppointment present
		$visRepo = new SQLPatientVisitRepository();
		$visRepo->markCompleteByPatientId($req['id']);
		$res = applyDbChanges();
		return $this->message($res ? 200 : 400, $req, $res ? 'Success' : 'Failed');
	}
	public function merge($old_id, $new_id) {
		if (!$old_id || !$new_id) {
			return $this->message('Both old and new IDs are required');
		}
		$data = $this->repository->findById($old_id);
		if (!$data) {
			return $this->message('Unable to find patient');
		}
		$updatedData = [];
		$repositories = [
			'treatments' => $this->treatements,
			'prescription' => $this->preRepo,
			'patient_visit' => $this->patientVisitRepo,
			'examination' => $this->patientExamRepo,
			'illness' => $this->illnessRepo,
			'investigation' => $this->invRepo,
			'treatment_plan' => $this->planRepo,
			'appointment' => $this->appointment,
		];
		foreach ($repositories as $key => $repo) {
			$data[$key] = $repo->findAllByWhere(['patient_fk_id' => $old_id]);
			if ($data[$key]) {
				$updatedData[$key] = $repo->updateById(['patient_fk_id' => $old_id], ['patient_fk_id' => $new_id]);
			}
		}
		if($updatedData[$key]){
		$deletedData = $this->repository->deleteOfId($old_id);
		}
		return $this->message(200, $updatedData, 'Successfully Updated and Old patient Deleted');
	}

	public function search($terms, $where = null) {
		if ($this->reqMethod == 'get') {
			$data = [];
			$ftbl = [];
			if ($where) {
				$ftbl = json_decode((urldecode($where)));
			}
			$terms = $terms == 'null' ? '' : $terms;
			//if (!empty($terms)) {
			$data = $this->repository->search($terms, $ftbl);
			//}
			return $this->message(200, $data, 'Success');
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}
	public function getRememberAll($tblLazy, $type = 'BIRTHDAY', $cat = 'TODAY', $print = false) {
		if ($tblLazy) {
			$ftbl = json_decode(urldecode($tblLazy));
		}
		$dataMember = $this->repository->findAllRember($ftbl, $type, $cat, !$print);
		return $this->message($dataMember ? 200 : 400, $dataMember, $dataMember ? "Success" : "No data");
	}

	public function getBasic($id = false) {
		$data = $this->repository->findById($id);
		return $this->message(200, $data, 'suc');
	}

	public function getDetails($id = false) {
		$treatment = new SQLPatient_treatmentRepository();
		$illnesRepo = new SQLPatient_illnessRepository();
		$data = $this->repository->findById($id);
		$data['medical_history'] = $illnesRepo->findAllByWhere(['patient_fk_id' => $id]);
		// $data['treatment'] = $treatment->findAllByWhere(['patient_fk_id' => $id]);
		// $data['medical_history'] = $this->$patient_illness->findAllByWhere(['patient_fk_id' => $id]);
		$invRepo = new SQLInvoiceRepository();
		$data['total_due'] = $invRepo->totalDueCalculate($id);
		$docRepo = new SQLPatient_imagesRepository();
		$data['doc'] = $docRepo->findByPatient($id) ?? [];
		// $toalNeed
		return $this->message(200, $data, 'suc');
	}
	function getSummary($id, $page = 0) {
		$tremRepo = new SQLPatient_treatmentRepository();
		$data = $tremRepo->getSummary($id);
		return $this->message(200, $data, 'Success');
	}
	public function getTreatmentByPatient($id = false) {
		$treatment = new SQLPatient_treatmentRepository();
		$data = $treatment->findAllByWhere(['patient_fk_id' => $id]);
		return $this->message(200, $data, 'success');
	}
	public function getTreatmentList($tblLazy, $active = true) {	
		$treatment = new SQLPatient_treatmentRepository();
		$isActive = ($active === 'false') ? false : true;
		if ($tblLazy) {
			$ftbl = json_decode((urldecode($tblLazy)));
		}
		$data = $this->$treatment->findAllPagination($ftbl, $isActive);
		return $this->message(200, $data, 'Success');
	}
	public function getRecentPatient() {
		$data = $this->repository->getRecentPatient();
		return $this->message(200, $data, 'Success');
	}
	public function getPatientById($id) {
		$data = $this->repository->findById($id);
		return $this->message(200, $data, 'succcess');
	}
	public function getPatientsByDate($date) {
		$data = $this->repository->findAll();
		$filteredPatients = [];
		foreach ($data as $patient) {
			if (isset($patient['created_at']) && date('Y-m-d', strtotime($patient['created_at'])) == $date) {
				$filteredPatients[] = $patient;
			}
		}
		if (!empty($filteredPatients)) {
			return $this->message(200, $filteredPatients, 'success');
		} else {
			return $this->message(404, null, 'No patients found for the given date');
		}
	}

	function deleteItem($id) {
		if ($id) {
			$req = $this->getDataFromUrl('json');
			$res = $this->repository->deleteOfId($id);
			$utilityRepo = new UtilityModel();
			if (checkValue($req, 'remarks')) {
				$this->repository->updateById($id, ['remarks' => $req['remarks']]);
				$utilityRepo->deleteData('patient_illness', ['patient_fk_id' => $data['id']]);
			}
			return $this->message($res ? 200 : 400, $req, $res ? 'success' : 'unable to delete Treatment');
		}
	}
}