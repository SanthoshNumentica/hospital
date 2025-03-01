<?php

namespace App\Controllers\Whatsapp;

use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Whatsapp\SQLSmstransactionsRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\Sms;
use Core\Libraries\WhatsApp;
use Core\Models\Utility\UtilityModel;
use Exception;

class SmstransactionsController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $utilityModel;
	private $patient_Repo;
	private $WhatsApp;
	private $sms;
	public function __construct() {
		$this->initializeFunction();
		helper('Core\Helpers\Task');
		$this->repository = new SQLSmstransactionsRepository();
		$this->utilityModel = new UtilityModel();
		$this->patient_Repo = new SQLPatientRepository();
		$this->WhatsApp = new WhatsApp();
		$this->sms = new Sms();
	}

	public function sendMessage() {
		$data = $this->getDataFromUrl('json');
		// Check the message type
		$messageType = $data['message_type'] ?? 1; // Assuming 'message_type' is in the data
		if ($messageType == 1) {
			$whatsappsend = $this->WhatsApp->whatsAppSend($data['mobile_no'], $data['message'], $data['file_path'] ?? '', true);
			$result = $whatsappsend['result'] ?? false;
		} elseif ($messageType == 2) {
			$sms = $this->sms->sendSMS($data['message'], $data['mobile_no']);
			$result = $sms['result'] ?? false;
		} else {
			$result = "Unsupported message type";
		}
		return $this->message($result ? 200 : 400, $data, $result ? "Message Sent Successfully" : 'Unable to Send the message');
	}

	public function sentPatientGreetings() {
		set_time_limit(0);
		// $db = \Config\Database::connect();
		$data = $this->getDataFromUrl('json');
		// $req = $this->patient_Repo->getpatientByCond($data['age_condition'] ?? '', $data['age'] ?? '', $data['gender_fk_id'] ?? '', $data['state_fk_id'] ?? '');
		$req = $this->patient_Repo->getpatientByCond(25);
		// print_r($req);
		// exit();
		$insertBatchData = [];
		$res['total_record'] = count($req);
		$i = 0;
		foreach ($req as $key => $k) {
			if (checkValue($k, 'mobile_no')) {
				if (checkValue($k, 'patientName')) {
					$k['patientName'] = ucfirst(strtolower($k['patientName']));
				}
				$message = parameterReplace(array_keys($k), $k, $data['message']);
				$status = $this->WhatsApp->whatsAppSend($k['mobile_no'], $message, $data['file_path'] ?? '') ? 1 : 3;
				unset($req[$key]);
				if ($status == 1) {
					//on success only
					$i++;
				}
				// $insertBatchData[] = [
				// 	'mobile_no' => $k['mobile_no'],
				// 	'bulk_send' => 1,
				// 	'status' => $status,
				// 	'message' => $message,
				// 	'message_type' => 1, // whatsapp only
				// 	'file' => $data['file_path'] ?? '',
				// ];
			}
		}
		$res['total_sent'] = $i;
		return $this->message(200, $res, 'Success');
		// if (!empty($insertBatchData) && count($insertBatchData)) {
		// 	$db->table('smstransactions')->insertBatch($insertBatchData);
		// 	//call genMsgToPatients from MessageSender
		// 	$userId = $this->userData->user_id ?? 1;
		// 	$deleteData = addTask(PROCESS_API_INDEX . "/whatsapp/bulkPatientGreetings", 'Sent Bulk Patients Greetings', $userId, '', 2, true);
		// 	if ($deleteData) {
		// 		return $this->message(200, null, "Report being sent..");
		// 	} else {
		// 		return $this->message(400, null, "Data unable to add on Queue !");
		// 	}
		// } else {
		// 	return $this->message(400, null, "No Report to Added.");
		// }
	}
	protected function sentMsg($page) {

	}
	public function genMsgToPatients($uId = '') {
		$smsLib = new Sms();
		set_time_limit(0);
		$data_item = $this->utilityModel->executeQuery('select * from smstransactions where status = ? and bulk_send=1', [2]) ?? ['total' => 0];
		$total_record = count($data_item);
		if ($total_record == 0) {
			return completeTaks($uId, 'Successfully All Record Sent');
		}
		$rows = 10;
		try {
			sleep(2);
			for ($i = 0; $i <= ceil($total_record / $rows); $i++) {
				sleep(5);
				$wData = $this->utilityModel->executeQuery('select * from smstransactions where status = 2 and bulk_send=1 limit ? , ?', [($i * 10), 10]);
				foreach ($wData as $k) {
					if ($k['message_type'] == 2 || $k['message_type'] == 3) {
						// SMS to be sent
						$result = $smsLib->sendSMS($k['message'], $k['from_mobile_no']);
					}
					if ($k['message_type'] == 1 || $k['message_type'] == 3) {
						// WhatsApp message to be sent
						$result = $this->WhatsApp->whatsAppSend($k['to_mobile_no'], $k['message']);
					}
					$upData = [];
					if ($result == true) {
						$upData['status'] = 1;
						$this->utilityModel->updateData('smstransactions', $upData, ['id' => $k['id']]);
					}
				}
			}
		} catch (Exception $e) {
			$status = 3;
			$result = $e;
		}
		return completeTaks($uId, $result);
	}

	public function getSmsTransactionList($tblLazy, $active = true) {
		$ftbl;
		$isActive = ($active === 'false') ? false : true;
		if ($tblLazy) {
			$ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
		}
		$data = $this->repository->findAllPagination($ftbl, $isActive);
		return $this->message(200, $data, 'Success');
	}
}
