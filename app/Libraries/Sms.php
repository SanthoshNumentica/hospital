<?php
namespace Core\Libraries;
use Core\Models\Logs\LogsModel;
use Core\Models\Utility\UtilityModel;

class Sms {
	private $response;
	private $UtilityModel;
	public function __construct() {
		helper('Core\Helpers\Utility');
		$this->UtilityModel = new UtilityModel();
		$this->response = \Config\Services::response();
	}
// send Sms
	public function send($id, $data, $is_send = false) {
		$template = $this->UtilityModel->getDataById('sms_templates', ['id' => $id]);
		$template->message = parameterReplace($template->parameter, $data, $template->template_content ?? '');
		if ($is_send && (int) $template->allow_to_send) {
			$logModel = new LogsModel();
			$res = $this->sendSMS($template->message, $data['mobile_no'], $template->sender_id ?? '');
			//add Log
			$messageLog = ['message_type' => 2, 'status' => $res['result'] ? 1 : 3];
			$this->logModel->messageLog($res['mobile_no'], $res['message'], $messageLog);

		}
		return (array) $template;
	}
	function resent($id) {
		$logModel = new LogsModel();
		$d = (array) $logModel->getMsgLog($id);
		$res = ['result' => false];
		if (!empty($d)) {
			$res = $this->sendSMS($d['message'], $d['mobile_no'], '');
			if ($res['result']) {
				//update
				$this->logModel->messageLog($res['mobile_no'], $res['message'], 2, $res['result'] ? 1 : 0, $id);
			}
		}
		return $res['result'] ?? false;
	}
	public function sendSMS($message, $mobile_no, $sender_id = null) {
		$mobile_no = trimMobileNumber($mobile_no);
		if (ENVIRONMENT != 'production') {
			$mobile_no = WHATSAPP;
		}
		$access_token = SMS_ACCESS_TOKEN;
		$queryParams = ['senderid' => $sender_id, 'APIKey' => SMS_ACCESS_TOKEN, 'channel' => 2, 'flashsms' => 0, 'number' => $mobile_no, 'text' => rawurlencode($message), 'route' => 1];
		$url = SMS_API_URL . http_build_query($queryParams);
		// $message = rawurlencode($message); //This for encode your message content

		$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=' . SMS_ACCESS_TOKEN . '&senderid=' . $sender_id . '&channel=2&DCS=0&flashsms=0&number=' . $mobile_no . '&text=' . rawurlencode($message) . '&route=1';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
		$data = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		// echo $http_status;
		// $client = \Config\Services::curlrequest();
		// echo $url;
		// exit();
		// $response = $client->request('POST', $url, [
		// 	//'query' => ['senderid' => $sender_id, 'APIKey' => SMS_ACCESS_TOKEN, 'channel' => 2, 'flashsms' => 0, 'number' => $mobile_no, 'text' => $message, 'route' => 1],
		// 	'verify' => false, 'debug' => true, 'http_errors' => true, 'form_params' => '']);
		$result = (int) $http_status == 200 ? true : false; // 200
		return ['result' => $result, 'message' => $message, 'mobile_no' => $mobile_no];
	}
}
