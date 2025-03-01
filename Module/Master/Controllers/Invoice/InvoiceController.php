<?php
namespace App\Controllers\Invoice;
use App\Domain\Invoice\Invoice;
use App\Infrastructure\Persistence\Invoice\SQLInvoiceRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoice_itemRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatmentRepository;
use App\Infrastructure\Persistence\Payment\SQLPaymentRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\ExportExcel;
use Core\Libraries\MessageSender;
use Core\Libraries\PDFGenerator;

class InvoiceController extends BaseController {
	use DMLController;
	private $repository;
	private $excelLib;
	private $userAgentHepler;
	private $pTreRepo;
	private $invoiceItemRepo;
	private $pdf;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLInvoiceRepository();
		$this->excelLib             = new ExportExcel();
		$this->pTreRepo = new SQLPatient_treatmentRepository();
		$this->invoiceItemRepo = new SQLInvoice_itemRepository();
		$this->pdf = new PDFGenerator();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		$userId = $this->userData->user_id ?? 1;
		//total_amount and total_paid_amount  is required
		if (!checkValue($data, 'total_amount')) {
			return $this->message(400, null, 'Total Amount is Required');
		}
		if (!checkValue($data, 'patient_fk_id')) {
			return $this->message(400, null, 'Patient is Required');
		}
		$messageLib = new MessageSender();

		if (checkValue($data, 'id')) {
			// Update data
			$inData = (array) $this->repository->findById($data['id']);
			if (empty($inData)) {
				return $this->message(400, null, 'invoice not found');
			}
			startDbTrans();
			if (checkValue($data, 'item')) {
				$d = mergeArrayKey(['item'], $data, ['invoice_fk_id' => $data['id'], 'patient_fk_id' => $data['patient_fk_id']]);
				$item = $this->invoiceItemRepo->setEntity($d['item']);
				$this->invoiceItemRepo->save($item->toRawArray(true));
			}
			if (checkValue($inData, 'status') && $inData['status'] != 4) {
				//get total Paid;
				$payRepo = new SQLPaymentRepository();
				$totalPaidAmount = $payRepo->getSumByInvoice($data['id']);
				if (checkValue($data, 'pay_amount') && (int) $data['pay_amount'] > 0) {
					$payRepo->newPayment($data['id'], $data['pay_amount'], 'Invoice Payment', $userId);
					$totalPaidAmount = $totalPaidAmount + (int) $data['pay_amount'];
				}
				$data['total_amount'] = $this->invoiceItemRepo->avgMax('amount', 'SUM', ['invoice_fk_id' => $data['id']]);
				if (checkValue($data, 'discount')) {
					$data['total_amount'] = (float) $data['total_amount'] - $data['discount'];
				}
				$data['total_paid_amount'] = $totalPaidAmount;
				$data['status'] = $this->invoiceStatus($data['total_amount'], $totalPaidAmount);
			}
			$res = $this->repository->save(new Invoice($data));
			$res = applyDbChanges();
			$msg = $res ? 'Invoice Update successfully' : 'Unable to Update invoice';
		} else {
			// Insert data
			$data['created_by'] = $userId;
			//check invoice already cretaed or not;
			$checked = false;
			foreach ($data['item'] as $k => $v) {
				//
				if (checkValue($v, 'patient_treatment_id') && !$checked) {
					$checked = true;
					//check already created or not
					$d = $this->pTreRepo->findById($v['patient_treatment_id']);
					if (checkValue($d, 'invoice_fk_id')) {
						return $this->message(400, null, 'Invoice Exsits');
					}
				}
			}
			$res = $this->newInvoice($data);
			$data['id'] = $res;
			$data['status'] = $data['total_amount'] == $data['pay_amount'] ? 1 : 3;
			$msg = $res ? 'Invoice Created successfully' : 'Unable to created invoice';
			//whatsApp message for NEW_INVOICE
			if ($res) {
				$messageLib->genMsgContent('NEW_INVOICE', $data, 3);
			}
		}
		if ($res) {
			//print body
			$data['docContent'] = $messageLib->genDocument('INVOICE', $data);
		}
		return $this->message($res ? 200 : 400, $data, $msg);
	}
	protected function invoiceStatus($totalAmount, $totalPaidAmount) {
		$balance = $totalAmount - $totalPaidAmount;
		return ($balance > 0) ? ($totalPaidAmount == 0 ? 2 : 3) : 1;
	}
	protected function calstaffDue($id) {
		return $this->repository->totalDueCalculate($id);
	}
	protected function newInvoice($d) {
		$userId = $this->userData->user_id ?? 1;
		$d['invoice_id'] = generateKey('INVOICE');
		$d['created_by'] = $userId;
		$d['invoice_date'] = $d['invoice_date'] ?? date('Y-m-d');
		$d['total_paid_amount'] = 0;
		if (checkValue($d, 'pay_amount') && (int) $d['pay_amount'] > 0) {
			$d['total_paid_amount'] = $d['pay_amount'] ?? 0;
		}
		$d['status'] = $this->invoiceStatus($d['total_amount'], $d['total_paid_amount'] ?? 0);
		startDbTrans();
		$invoice_id = $this->repository->insert(new Invoice($d));
		if (checkValue($d, 'pay_amount') && (int) $d['pay_amount'] > 0) {
			$payRepo = new SQLPaymentRepository();
			$payRepo->newPayment($invoice_id, $d['pay_amount'], 'Invoice Payment', $userId);
		}
		if ($invoice_id) {
			//insertInvoice item
			if (checkValue($d, 'item')) {
				$d = mergeArrayKey(['item'], $d, ['invoice_fk_id' => $invoice_id]);
				foreach ($d['item'] as $key => &$v) {
					//to Update Invoice id on treatment
					if (checkValue($v, 'patient_treatment_id')) {
						$this->pTreRepo->updateById($v['patient_treatment_id'], ['invoice_fk_id' => $invoice_id, 'status' => 1]);
					} else {
						$v['patient_treatment_id'] = null;
						$v['id'] = null;
					}
					$this->invoiceItemRepo->insert($v);
				}
			}
		}
		$res = applyDbChanges();
		return $invoice_id;
	}
	public function search($terms, $where = null) {
		if ($this->reqMethod == 'get') {
			$data = [];
			$ftbl = [];
			if ($where) {
				$ftbl = json_decode(utf8_decode(urldecode($where)));
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
	public function genInvoice($pid) {
		//check isthere any pending invoice

		$re = $this->pTreRepo->getPendingInvoiceGen($pid);
		if (!empty($re)) {
			//genInvoice
			$data['item'] = $this->pTreRepo->getPendingInvoiceGen($pid);
			if (!empty($data['item'])) {
				$data['total_amount'] = array_sum(array_column($data['item'], 'amount'));
				//genInvoice
				$this->newInvoice($data);
			}
		}
	}
	public function getAllPendingInvoice() {

		$data = $this->repository->findAmountDetailsForStatusTwo();
		return $this->message(200, $data, 'success');
	}

	public function getDetails($id) {
		$patientRepo = new SQLPatientRepository();
		$data = $this->repository->findById($id);
		$data['item'] = $this->invoiceItemRepo->findAllByWhere(['invoice_fk_id' => $id]);
		// $data['patient'] = $patientRepo->findById($data['patient_fk_id']);
		return $this->message(200, $data, 'successfully');
	}
	public function invoiceReport() {
		$req = $this->getDataFromUrl('json');
		$formattedStartDate = date('Y-m-d', strtotime($req['start_date']));
		$formattedEndDate = isset($req['end_date']) ? date('Y-m-d', strtotime($req['end_date'])) : $formattedStartDate;
		
		$data = $this->repository->findAllInvoiceByMonth($formattedStartDate, $formattedEndDate);
		
		if ($req['print'] == true) {
			$col = [
				['colName' => 'invoice_id', 'title' => 'Invoice Id Ref'],
				['colName' => 'invoice_date', 'title' => 'Invoice Date'],
				['colName' => 'total_amount', 'title' => 'Total Amount'],
				['colName' => 'total_paid_amount', 'title' => 'Total Paid'],
				['colName' => 'due_amount', 'title' => 'Due Amount'],
				['colName' => 'statusName', 'title' => 'Status'],
				['colName' => 'patient_id', 'title' => 'Patient Id'],
				['colName' => 'patient_fullName', 'title' => 'Patient Name']
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
	public function generateInvoice($invoice_id){
		$data = $this->repository->findById($invoice_id);
		// print_r($data);
		// return;
		$pdf = $this->pdf->create("invoice",$data);
		return $this->message(200, $pdf, 'Success.');
	}
	
}
