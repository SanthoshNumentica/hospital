<?php

namespace Core\Libraries;

use Core\Models\Logs\LogsModel;
use Core\Models\Utility\UtilityModel;

class WhatsApp {
	private $response;
	private $utilityModel;
	private $logModel;
	public function __construct() {
		helper('Core\Helpers\Utility');
		$this->response = \Config\Services::response();
		$this->utilityModel = new UtilityModel();
		$this->logModel = new LogsModel();
	}
	public function whatsAppSend($mobile_no, $MorVariable = '', $file = '', $logSaveSuccessOnly = false) {
		$type = 'TEXT';
		if (ENVIRONMENT != 'production') {
			$mobile_no = WHATSAPP;
		}
		$filtered_phone_number = filter_var($mobile_no, FILTER_SANITIZE_NUMBER_INT);
		// Remove "-" from number
		$mobile_no = str_replace("-", "", $filtered_phone_number);
		$mobile_no = str_replace("+", "", $mobile_no);
		if (strlen($mobile_no) == 10) {
			$mobile_no = '91' . $mobile_no;
		}
		$to = $mobile_no;
		// $message='testing message';
		// sleep(1);
		$formData = [
			'appkey' => APPKEY,
			'authkey' => AUTHKEY, 'to' => $to,
		];
		// $url = "http://localhost/WaSender/waSender/public/api/create-message";
		$url = WHATSAPP_API_URL;
		if (is_array($MorVariable)) {
			foreach ($MorVariable as $key => $v) {
				$formData["variables[{{$key}}]"] = $v;
			}
		} else if ($MorVariable) {
			// $message             = str_replace(' ', '%20', $MorVariable);
			$formData['message'] = $MorVariable;
		}
		if (!empty($file)) {
			if (str_contains($file, 'localhost/')) {
				$file = 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf';
			}
			$formData['file'] = $file;
		}
		switch ($type) {
		case 'TEMPLATE':
			$formData['template_id'] = $template_id;
			break;
		}
		$req_url = filter_var($url, FILTER_SANITIZE_URL);
		// $req_url = WHATSAPP_API_URL;
		$client = \Config\Services::curlrequest();
		$response = $client->post($req_url, [
			'debug' => false,
			'http_errors' => false,
			'Content-Type' => 'application/x-www-form-urlencoded',
			'form_params' => $formData,
		]);
		$res = $response->getBody();
		$result = false;
		if (str_contains(trim(strtolower($res)), 'submitted')) {
			$result = true;
		}
		// return $this->message($res ? 200 : 400, $result, $res ? "Send Successfully" : 'Unable to Send');
		$messageLog = ['status' => $result ? 1 : 3, 'message_type' => 1, 'file' => $file];
		if ($logSaveSuccessOnly && $result = true) {
			$this->logModel->messageLog($mobile_no, $MorVariable, $messageLog);
		} else if (!$logSaveSuccessOnly) {
			$this->logModel->messageLog($mobile_no, $MorVariable, $messageLog);
		}
		return ['result' => $result, 'response' => trim($res)];
	}
	public function whatsAppSendTemplate($mobile_no, $data, $type = '', $url = '') {
		$temp_id = '';
		$variable = [];
		if (!empty($type)) {
			switch ($type) {
			case 'PAYSLIP':
				$temp_id = 'b7755569-11e5-4b13-a639-539ba95d9631';
				$variable = ['name' => $data['name'], 'monthYear' => $data['monthYear']];
				break;
			}
			return $this->whatsAppSend($mobile_no, $variable, 'TEMPLATE', $url, $temp_id);
		} else {
			// Execute 'text' case
			return $this->whatsAppSend($mobile_no, $variable, 'TEXT', $url, $temp_id);
		}
	}
	public function whatsAppSendByEvents($event, $data) {
		$template = $this->utilityModel->getDataById('sms_templates', ['event_name' => $event]);
		if ($template && $event == $template->event_name) {
			$variable = parameterReplace(array_keys($data), $data, $template->sms_content ?? '');
			return $this->whatsAppSendTemplate($data['mobile_no'], $variable);
		}
	}
}
