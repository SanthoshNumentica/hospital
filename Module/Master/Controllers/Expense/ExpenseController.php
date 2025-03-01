<?php
namespace App\Controllers\Expense;

use App\Domain\Expense\Expense;
use App\Infrastructure\Persistence\Expense\SQLExpenseRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoiceRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use  Core\Libraries\ExportExcel;

class ExpenseController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $invoiceRepo;
	private $excelLib;
	private $expenseRepo;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLExpenseRepository();
		$this->invoiceRepo  =new SQLInvoiceRepository();
		$this->expenseRepo = new SQLExpenseRepository();
		$this->excelLib = new ExportExcel();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		if (!checkValue($data, 'vendor_fk_id')) {
			return $this->message(400, null, 'Vendor Id is Required');
		}
		if (!checkValue($data, 'expense_type_fk_id')) {
			return $this->message(400, null, 'Category is Required');
		}
		if (!checkValue($data, 'amount')) {
			return $this->message(400, null, 'Amount is Required');
		}

		if (!checkValue($data, 'id')) {
			$data['expense_id'] = generateKey('EXPENSE');
		}
		$data['status'] = 1;
		$res = $this->repository->save(new Expense($data));
		$action = !checkValue($data, 'id') ? 'created' : 'updated';
		return $this->message($res ? 200 : 400, $data, $res ? "Expense $action Successfully" : 'Unable to save changes');
	}
		public function expenseReport() {
			$req = $this->getDataFromUrl('json');
			$formattedStartDate = date('Y-m-d', strtotime($req['start_date']));
			$formattedEndDate = isset($req['end_date']) ? date('Y-m-d', strtotime($req['end_date'])) : $formattedStartDate;
			
			$data = $this->repository->findAllExpenseByMonth($formattedStartDate, $formattedEndDate);
			
			if ($req['print'] == true) {
				$col = [
				['colName' => 'expense_id', 'title' => 'Expense Id'],
				['colName' => 'description', 'title' => 'Expense Description'],
				['colName' => 'invoice_date', 'title' => 'Invoice date'],
				['colName' => 'amount', 'title' => 'Amount'],
				['colName' => 'total_paid', 'title' => 'total Paid'],
				['colName' => 'statusName', 'title' => 'Status'],
				['colName' => 'payment_typeName', 'title' => 'payment Type']
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
		public function profitReport() {
			$req = $this->getDataFromUrl('json');
			$formattedStartDate = date('Y-m-d', strtotime($req['start_date']));
			$formattedEndDate = isset($req['end_date']) ? date('Y-m-d', strtotime($req['end_date'])) : $formattedStartDate;
			$data = $this->invoiceRepo->findAllInvoiceByDate($formattedStartDate,$formattedEndDate);
			$expense = $this->expenseRepo->findAllExpense($formattedStartDate,$formattedEndDate);
			$profitandloss = $data + $expense;
				if ($data) {
					return $this->message(200, $profitandloss, 'Success.');
				} else {
					return $this->message(200, null, 'No Data.');
				}
			}
		}
