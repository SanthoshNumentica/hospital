<?php
namespace App\Controllers\Payment;

use App\Infrastructure\Persistence\Patient\SQLExpenseRepository;
use App\Infrastructure\Persistence\Payment\SQLPaymentRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\whatsApp;
use Core\Libraries\ExportExcel;

class PaymentController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $expenceRepo;
	private $excelLib;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPaymentRepository();
		$this->expenceRepo = new SQLExpenseRepository();
		$this->excelLib             = new ExportExcel();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		$paymentData = $this->repository->newPayment($data['type'], $data['ref_fk_id'], $data['payments_des'], $data['user_id'], $data['credit_type'], $data['pay_type'], $data['payment_date'], $data['pay_ref_number'], $data['pay_ref_remarks']);
		//whatsApp message for NEW_PAYMENT
		if (checkValue($data, 'is_whatsapp')) {
			$whatsApp = new whatsApp();
			// $whatsApp->whatsAppSendByEvents('NEW_PAYMENT', $data);
		}
		return $this->message($paymentData ? 200 : 400, $paymentData, $paymentData ? "Data created successfully" : "Unable to save Data");
	}
	public function paymentReport($month) {
		try {
			if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
				return $this->message(400, null, "Invalid month format. Please provide a valid month in 'Y-m' format.");
			}
			list($year, $requestedMonth) = explode('-', $month);
			$startDate = date('Y-m-01', strtotime("$year-$requestedMonth-01"));
			$endDate = date('Y-m-t', strtotime("$year-$requestedMonth-01"));
			$data = $this->repository->findAllByWhere([
				'created_at >=' => $startDate,
				'created_at <=' => $endDate,
			]);
			if (!empty($data)) {
				return $this->message(200, $data, "Success");
			} else {
				return $this->message(400, null, "No data found for the specified month.");
			}
		} catch (\Exception $e) {
			return $this->message(500, null, "Internal Server Error: " . $e->getMessage());
		}
	}
	public function getList($tblLazy, $active = true) {
		$isActive = ($active === 'false') ? false : true;
		if ($tblLazy) {
			$ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
		}
		$data = $this->repository->findAllPagination($ftbl, $isActive);
		return $this->message(200, $data, 'Success');
	}

	function getPaymentByInvoice($id) {
		$data = $this->repository->findByInvoice($id);
		return $this->message(200, $data, 'successfully');
	}
	public function balancesheet($from_date, $to_date) {
		$data = [];
		if (empty($to_date)) {
			$to_date = date('Y-m-d');
		}
		$from_date = date('Y-m-d', strtotime($from_date));
		$to_date = date('Y-m-d', strtotime($to_date));
		$data['payment'] = $this->repository->findDateRange($from_date, $to_date);
		$data['expense'] = $this->expenceRepo->findDateRange($from_date, $to_date);
		$data['net_amount'] = (float) $data['payment']['total__payment_amount'] - (float) $data['expense']['total__expense_amount'];
		$data['profit_status'] = $data['net_amount'] > 0 ? 1 : ($data['net_amount'] == 0 ? 3 : 2);
		
		return $this->message(200, $data, 'data');
	}
	public function paymentsReport() {
		$req = $this->getDataFromUrl('json');
		$formattedStartDate = date('Y-m-d', strtotime($req['start_date']));
		$formattedEndDate = isset($req['end_date']) ? date('Y-m-d', strtotime($req['end_date'])) : $formattedStartDate;
		
		$data = $this->repository->findeAllPaymentByMonth($formattedStartDate, $formattedEndDate);
		
		if ($req['print'] == true) {
			$col = [
			['colName' => 'payments_id', 'title' => 'Payment Id'],
			['colName' => 'payments_des', 'title' => 'Payment Description'],
			['colName' => 'payment_date', 'title' => 'Payment date'],
			['colName' => 'amount', 'title' => 'Amount'],
			['colName' => 'due_amount', 'title' => 'Due amount'],
			['colName' => 'patientName', 'title' => 'patient Name'],
			['colName' => 'payment_typeName', 'title' => 'Payemnt Type'],
			['colName' => 'patient_id', 'title' => 'Patient Id'],
			['colName' => 'invoice_id', 'title' => 'Invoice Id'],
		 	['colName' => 'created_byName', 'title' => 'Created By'],
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