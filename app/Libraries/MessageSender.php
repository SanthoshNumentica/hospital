<?php
namespace Core\Libraries;

use App\Infrastructure\Persistence\Appointment\SQLAppointmentRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoiceRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoice_itemRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientVisitRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescriptionRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescription_itemRepository;
use App\Infrastructure\Persistence\Settings\SQLSettingsRepository;
use Core\Libraries\Sms;
use Core\Libraries\WhatsApp;
use Core\Models\Utility\UtilityModel;

class MessageSender {
	private $response;
	private $utilityModel;
	private $pdfMaker;
	public function __construct() {
		helper('Core\Helpers\Date');
		$this->response = \Config\Services::response();
		$this->utilityModel = new UtilityModel();
		$this->pdfMaker = new PDFMaker();
	}

	public function genMsgContent($eventName, $data = [], $is_sent = null) {
		$msgTemData = $this->utilityModel->getDataById('sms_templates', ['event_name' => trim($eventName)]);
		$cData = $data;
		switch ((int) $msgTemData->module_id) {
		case 1:
			//patinet
			if (checkValue($data, 'id') || checkValue($data, 'patient_fk_id')) {
				$pid = $data['patient_fk_id'] ?? $data['id'];
				$cData = $this->getPatientData($pid);
			}
			$cData['patientName'] = $data['patientName'] ?? $cData['f_name'];
			break;
		}
		$msgTemData->sms_content = parameterReplace(array_keys($cData), $cData, $msgTemData->template_content);
		$msgTemData->whatsapp_content = parameterReplace(array_keys($cData), $cData, $msgTemData->whatsapp_content);
		if ($is_sent && (int) $msgTemData->allow_to_send) {
			$cData['mobile_no'] = $data['mobile_no'] ?? $cData['mobile_no'];
			//1 => sms_only 2 for whatsapp_only 3 for both
			if ($is_sent == 1 || $is_sent == 3) {
				//sms to sent
				$smsLib = new Sms();
				$smsLib->sendSMS($msgTemData->sms_content, $cData['mobile_no']);
			}
			if ($is_sent == 2 || $is_sent == 3) {
				$whatLib = new WhatsApp();
				// $whatLib->whatsAppSend($cData['mobile_no'], $msgTemData->whatsapp_content);
			}
		}
		return (array) $msgTemData;
	}

	private function getPatientData($id) {
		$pRepo = new SQLPatientRepository();
		$d = $pRepo->findById($id);
		return (array) $d;
	}

	private function getAppointmentData($id) {
		$pRepo = new SQLAppointmentRepository();
		$d = $pRepo->findById($id);
		return (array) $d;
	}

	private function getToken($id) {
		$pRepo = new SQLPatientVisitRepository();
		$d = $pRepo->findById($id);
		return (array) $d;
	}
	private function getInvoice($id) {
		$pRepo = new SQLInvoiceRepository();
		$invoiceItemRepo = new SQLInvoice_itemRepository();
		$d = $pRepo->findById($id);
		$d['item'] = $invoiceItemRepo->findAllByWhere(['invoice_fk_id' => $id]);
		return (array) $d;
	}
	public function genDocument($event, $data = [], $is_pdf = false, $dataReturn = false) {
		$cData = $data;
		$section = [];
		$dateCol = ['created_at'];
		$setRepo = new SQLSettingsRepository();
		switch (strtoupper($event)) {
		case 'TOKEN':
			$j_url = FCPATH . '/templates/token.txt';
			if (!checkValue($data, 'patientName') || !checkValue($data, 'token_no')) {
				$cData = $this->getToken($data['id']);
			}
			$cData['token_date'] = date('d-m-Y', strtotime($cData['visit_on']));
			$cData['token_time'] = date('H:i A', strtotime($cData['visit_on']));
			break;
		case 'INVOICE':
			$dateCol = ['created_at', 'invoice_date'];
			$j_url = FCPATH . '/templates/invoice.txt';
			$section = [];
			$cData = $data;
			if (!checkValue($data, 'patientName')) {
				$cData = $this->getInvoice($data['id']);
			}
			$cData = $this->genInvoiceSection($cData);
			$cData = changeDateFormat($dateCol, $cData);
			break;
		case 'PRESCRIPTION':
			$j_url = BASEURL . '/templates/prescription_2.txt';
			if (!checkValue($data, 'patientName')) {
				$cData = $this->getPrescription($data['id']);
			}
			$section = ['item'];
			$cData = $this->genPrescriptionSection($cData);
			$cData['prescription_date'] = date('d M Y', strtotime($cData['visits_on']));
			$cData['genderFirstLetter'] = strtoupper(substr($cData['genderName'], 0, 1));

			break;

		case 'PATIENT_CARD':
			$j_url = FCPATH . '/templates/patient_id_card.txt';
			if (!checkValue($data, 'patientName') || !checkValue($data, 'token_no')) {
				$cData = $this->getPatientById($data['id']);
			}
			break;
		}
		$setData = $setRepo->getSetting();
		$cData['logo_src'] = $setData['logo_white_path'] ?? '';
		$cData['companyName'] = $setData['companyName'] ?? '';
		$cData['companyAddress'] = $setData['address'] ?? '';
		$cData['companyAddress_1'] = $setData['address_1'] ?? '';
		$cData['companyAddress_2'] = $setData['address_2'] ?? '';
		$cData['companyEmail_id'] = $setData['email_id'] ?? '';
		$cData['companyMobile_no'] = $setData['mobile_no'] ?? '';
		$cData['companyAlt_mobile_no'] = $setData['alt_mobile_no'] ?? '';
		$cData['companyWebsite_url'] = $setData['website_url'] ?? '';
		$html = file_get_contents($j_url);
		if (!empty($html)) {
			if (is_array($section)) {

				foreach ($section as $key => $v) {
					$html = findReplaceWithData($html, $v, $cData[$v] ?? [], $dateCol, []);
					if (isset($cData[$v])) {
						unset($cData[$v]);
					}
				}
			}
			if (is_array($cData)) {
				$html = parameterReplace(array_keys($cData), $cData, $html);
				// print_r($html);
			}
		}
		if ($dataReturn) {
			return ['data' => $cData, 'html' => $html];
		}
		// print_r($html);
		// return;
		// if ($is_pdf) {
		// 	$pdf = new PDFMaker($html, 'A4-P', '', $section, $dateCol);
		// 	// print_r($pdf);
		// 	// return
		// 	$output=$pdf->create($cData);
		// }
		return $html;
	}
	protected function getPatientById($id) {
		$pRepo = new SQLPatientRepository();
		$d = $pRepo->findById($id);
		return (array) $d;
	}

	protected function getPrescription($id) {
		$preRepo = new SQLPatient_prescriptionRepository();
		$pItemRepo = new SQLPatient_prescription_itemRepository();
		$data = $preRepo->getBasicById($id);
		$data['item'] = $pItemRepo->getItemById($id);
		return $data;
	}

	protected function genPrescriptionSection($data) {
		$i = 0;
		$itemHtml = '';
		foreach ($data['item'] as $k => $v) {
			$i++;
			$days = $v['duration'] ? '--' . $v['duration'] : '';
			$frequencies = explode('-', $v['frequency']);
			$frequencyHtml = '';
			foreach ($frequencies as $frequency) {
				$frequencyHtml .= "<td style='border-right: 1px solid black;'>{$frequency}</td>";
			}
			$itemHtml .= '<tr><td style="border-right: 1px solid black;">' . $i . '</td>';
			$itemHtml .= "<td style='border-right: 1px solid black;'>{$v['medicine']} {$v['dosage']}{$days}{$frequencyHtml}</td>";
			$itemHtml .= '</tr>';
		}
		$data['prescriptionItem'] = $itemHtml;
		return $data;
	}

	protected function genInvoiceSection($data) {
		$data['statusName'] = $data['status'] == 1 ? 'Fully Paid ' : 'Due';
		$data['dueAmount'] = '';
		if ($data['status'] != 1) {
			$due = $data['total_amount'] - $data['total_paid_amount'];
			$data['dueAmount'] = '<tr><td class="text-left pt-2"><h5>Due Amount:</h5></td><td class="text-right"><h3 style="padding-top: 0px;"><strong>' . $due . ' /-</strong></h3></td></tr>';

		}
		$i = 0;
		$itemHtml = '';
		foreach ($data['item'] as $k => $v) {
			$i++;
			$itemHtml .= '<tr><td>' . $i . '</td>';
			$itemHtml .= "<td>{$v['description']}</td>
            <td class='right-align right-border'>{$v['amount']}</td>";
			$itemHtml .= '</tr>';
		}
		$data['invoiceItem'] = $itemHtml;
		return $data;
	}
}