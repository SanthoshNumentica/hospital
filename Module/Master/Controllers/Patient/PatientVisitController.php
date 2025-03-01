<?php
namespace App\Controllers\Patient;

use App\Domain\Patient\PatientVisit;
use App\Infrastructure\Persistence\Patient\SQLPatientVisitRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\MessageSender;
use Core\Models\Utility\UtilityModel;

class PatientVisitController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatientVisitRepository();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		if (!checkValue($data, 'token_no')) {
			$data['token_no'] = generateKey('TOKEN');
		}
		$action = !checkValue($data, 'id') ? 'created' : 'updated ';
		if (checkValue($data, 'id')) {
			$res = $this->repository->save(new PatientVisit($data));
		} else {
			$data['id'] = $this->repository->insert(new PatientVisit($data));
			$res = true;
		}
		return $this->message($res ? 200 : 400, $data, $res ? "Patient Visit  $action Successfully" : 'Unable to save changes');
	}
	function genToken($patient_id, $doctor_fk_id) {
		startDbTrans();
		$userId = $this->userData->user_id ?? 1;
		$utilityRepo = new UtilityModel();
		$counter = $utilityRepo->getUserByCounter($doctor_fk_id);
		$data['counter_fk_id'] = $counter->counter_fk_id ?? 1;
		$last_token = (int) ($counter->initial_start_from ?? 1) || 1;
		if ((int) $counter->last_token) {
			$last_token = (int) $counter->last_token + 1;
			if (date('Y-m-d') != date('Y-m-d', strtotime($counter->token_updated_at))) {
				//format patient visit
				$utilityRepo->executeNoResult('DELETE FROM patient_visit WHERE visit_on < NOW() - INTERVAL ? DAY', [10]);
				$last_token = (int) ($counter->initial_start_from ?? 1) || 1;
			}
		}
		$data['token_no'] = "{$counter->token_prefix}{$counter->token_seperator}{$last_token}";
		$data['counterName'] = $counter->counterName ?? '';
		$utilityRepo->updateData('counter', ['last_token' => $last_token, 'token_updated_at' => date('Y-m-d H:i:s')], ['id' => $counter->counter_fk_id]);
		$data['patient_fk_id'] = $patient_id;
		$data['doctor_fk_id'] = $doctor_fk_id;
		$data['visit_on'] = date('Y-m-d H:i:s');
		$data['created_by'] = $userId;
		$token_id = $this->repository->insert(new PatientVisit($data));
		$res = applyDbChanges();
		$messageLib = new MessageSender();
		if ($res) {
			$doc = $messageLib->genDocument('TOKEN', ['id' => $token_id], false, true);
			$data['docContent'] = $doc['html'];
			$data['patientName'] = $doc['data']['patientName'] ?? '';
			$data['doctorName'] = $doc['data']['doctorName'] ?? '';
			$data['statusName'] = $doc['data']['statusName'] ?? '';
		}
		return $this->message($res ? 200 : 400, $data, $res ? 'Success' : 'unable to find');
	}
	public function updateToken($id,$doctor_fk_id){
		if($id){
			$data =$this->repository->findById($id);
		}
		if($data){
			$data =$this->repository->updateById($id,['doctor_fk_id'=>$doctor_fk_id]);
			return $this->message(200,$data,'Successfylly updated');
		}
		else{
			return $this->message(400,null,'no data found');
		}
		
	}
	public function getBasic($id) {
		$data = $this->repository->findAllByWhere(['doctor_fk_id' => $id]);
		return $this->message(200, $data, 'Success');
	}
	function getTodaysToken($id = 0) {
		$data = $this->repository->getTodayToken($id);
		return $this->message(200, $data, 'Success');
	}
	public function getTodayList() {
		$data['firstShift'] = $this->repository->findByTimeData();
		return $this->message(200, $data, 'Success');
		// print_r($data);
	}

	function updateStatus($id) {
		$req = $this->getDataFromUrl('json');
		if (!checkValue($req, 'status')) {
			return $this->message(400, '', 'Status is Required');
		}
		$s = (array) $this->repository->findById($id);
		$status = (int) $req['status'];
		if ($status == 3) {
			//active status
			if ((int) $s['status'] == 1) {
				return $this->message(200, $s, 'success');
			}
		}
		$s['status'] = $status;
		$s['statusName'] = $this->getStatusName($status);
		$res = $this->repository->updateById($id, ['status' => $status]);
		return $this->message($res ? 200 : 400, $s, $res ? 'Success' : 'uable to update status');
	}

	function nextToken($activeID, $nextId) {
		if (!empty($nextId)) {
			//update Token Id
			$s = $this->findById($activeID);
			$s_status = (int) $s['status'];
			if ($s_status != 1) {
				$this->repository->updateById($activeID, ['status' => 4]);
				$s['statusName'] = 'missed';
			}
			$res = $this->repository->updateById($nextId, ['status' => 3]);
			$data['active'] = $s;
			$data['next'] = $this->findById($nextId);
			return $this->message($res ? 200 : 400, $data, $res ? 'Success' : 'uable to update status');
		}
	}

	function callNexTokenByCounter($counter_id) {
		if ($counter_id) {
			//getActiveToken
			$d = $this->repository->callNextToken(['patient_visit.counter_fk_id' => $counter_id]);
			$d['statusName'] = 'active';
			return $this->message(200, $d, 'success');
		}
	}

	function reCallToken($id) {
		//make active
		$this->repository->updateById(['id' => $id], ['status' => 3]);
		$d = $this->repository->findById($id);
		$d = (array) $d;
		if (!empty($d) && $d['counter_fk_id']) {
			$d['statusName'] = 'active';
			$this->repository->makeAllInactive(['patient_visit.counter_fk_id' => $d['counter_fk_id'], 'id != ' => $id]);
		}
		return $this->message(200, $d, 'success');
	}

	function markComplete($id) {
		$res = $this->repository->markCompleteById($id);
		return $this->message($res ? 200 : 400, $res, $res ? 'Success' : 'uable to complete');
	}

	protected function getStatusName($status) {
		if ((int) $status == 1) {
			return 'completed';
		} else if ((int) $status == 2) {
			return 'pending';
		} else if ((int) $status == 3) {
			return 'active';
		}
		return 'missed';
	}

	function getActiveTokenByCounter($id) {
		$data = $this->repository->getActiveTokenByCounter($id);
		return $this->message(200, $data, 'success');
	}

}