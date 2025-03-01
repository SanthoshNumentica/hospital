<?php
namespace App\Infrastructure\Persistence\Invoice;

use App\Domain\Invoice\Invoice;
use App\Domain\Invoice\InvoiceRepository;
use App\Models\Invoice\InvoiceModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLInvoiceRepository implements InvoiceRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new InvoiceModel();
	}
	public function globalJoin() {
		$this->model->select('invoice.*, p.patient_id,p.address, p.f_name as patientName, p.mobile_no, CONCAT(t.titleName, " ", p.f_name, " ", p.l_name) as patient_fullName, CASE WHEN invoice.status = 1 THEN "Paid" WHEN invoice.status = 2 THEN "Non-paid" WHEN invoice.status = 3 THEN "Due" ELSE "Cancelled" END as statusName, invoice.total_amount - invoice.total_paid_amount as due_amount', false)
			->join('patient as p', 'p.id = invoice.patient_fk_id', 'left')
			->join('title as t', 't.id = p.title_fk_id', 'left');
	}
	
	public function search($terms, $whereField = []) {
		$this->globalJoin();
		$this->model
			->groupStart()
			->Like('patient_id', $terms, 'both')
			->orLike('invoice_id', $terms, 'both')
			->orLike('p.f_name', $terms, 'both')
			->groupEnd();
		$this->setWhere($whereField);
		return $this->model->asArray()->allowCallbacks(true)->findAll(30);
	}
	public function setEntity($d) {
		return new Invoice($d);
	}
	public function findAmountDetailsForStatusTwo() {
		$cond = ['invoice.status' => 2];
		$results = $this->model
			->select('COALESCE(SUM(total_amount), 0) AS total_amount, COALESCE(SUM(total_paid_amount), 0) AS total_paid_amount, COALESCE(SUM(total_amount - total_paid_amount), 0) AS pending_amount, invoice.patient_fk_id, p.f_name AS patientName')
			->join('patient as p', 'p.id = invoice.patient_fk_id', 'left')
			->where($cond)
			->groupBy('invoice.patient_fk_id')
			->findAll();

		return $results;
	}

	public function totalDueCalculate($id) {
		$res = $this->model->select('SUM(total_amount - total_paid_amount) as due')->where('patient_fk_id', $id)->groupBy('patient_fk_id')->where('deleted_at is null ', null)->asArray()->get()->getRow();
		return $res->due ?? 0;
	}

	public function getInvoiceReport($cond) {
		$this->globalJoin();
		$this->setWhere($cond);
		return $this->model->asArray()->allowCallbacks(true)->findAll();
	}
	public function findAllInvoiceByMonth($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
	
		$invoices = $this->model->select('invoice.*')
			->where('invoice_date >=', $startOfMonth)
			->where('invoice_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();
	
		$totalInvoices = count($invoices);
		$totalAmount = array_sum(array_column($invoices, 'total_amount'));
		$totalPaidAmount = array_sum(array_column($invoices, 'total_paid_amount'));
		$totalDueAmount = $totalAmount - $totalPaidAmount;
	
		return [
			'details' => $invoices,
			'total_invoice' => $totalInvoices,
			'total_amount' => $totalAmount,
			'total_paid_amount' => $totalPaidAmount,
			'total_due_amount' => $totalDueAmount
		];
	}
	public function findAllInvoiceByDate($startDate, $endDate){
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
	
		$invoices = $this->model->select('invoice.*')
			->where('invoice_date >=', $startOfMonth)
			->where('invoice_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();
	
		$totalAmount = array_sum(array_column($invoices, 'total_amount'));
		$totalPaidAmount = array_sum(array_column($invoices, 'total_paid_amount'));
		$totalDueAmount = $totalAmount - $totalPaidAmount;
	
		return [
			'total_amount' => $totalAmount,
			'total_paid_amount' => $totalPaidAmount,
			'total_due_amount' => $totalDueAmount
		];
	}
	}
