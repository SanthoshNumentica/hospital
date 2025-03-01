<?php
namespace App\Infrastructure\Persistence\Expense;
use App\Domain\Expense\Expense;
use App\Domain\Expense\ExpenseRepository;
use App\Models\Expense\ExpenseModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLExpenseRepository implements ExpenseRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new ExpenseModel();
	}
	public function setEntity($d) {
		return new Expense($d);
	}
	function globalJoin() {
		$this->model->select('expense.*,v.vendorName,e.expense_typeName,CASE WHEN expense.status = 1 THEN "Paid" else "pending" end as statusName,pt.payment_typeName ', false)
		->join('vendor as v', 'v.id=vendor_fk_id', 'left')
		->join('payment_type as pt', 'pt.id=payment_type_fk_id', 'left')
		->join('expense_type as e ', 'e.id=expense_type_fk_id', 'left');
	}
	public function findAllExpenseByMonth($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
		$expenses = $this->model->select('expense.*')
			->where('invoice_date >=', $startOfMonth)
			->where('invoice_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();
	
		$totalExpense = count($expenses);
		$totalAmount = array_sum(array_column($expenses, 'amount'));
		$totalPaidAmount = array_sum(array_column($expenses, 'total_paid'));
		$totalDueAmount = $totalAmount - $totalPaidAmount;
		return [
			'details' => $expenses,
			'total_expenses' => $totalExpense,
			'total_amount'=> $totalAmount,
			'total_paid'=>$totalPaidAmount,
			'total_due'=>$totalDueAmount
		];
	}
	public function findAllExpenseByProfit($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
		$expenses = $this->model->select('expense.*')
			->where('invoice_date >=', $startOfMonth)
			->where('invoice_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();
	
		$totalExpense = count($expenses);
		$totalAmount = array_sum(array_column($expenses, 'amount'));
		$totalPaidAmount = array_sum(array_column($expenses, 'total_paid'));
		$totalDueAmount = $totalAmount - $totalPaidAmount;
		return [
			'details' => $expenses,
			'total_expenses' => $totalExpense,
			'total_amount'=> $totalAmount,
			'total_paid'=>$totalPaidAmount,
			'total_due'=>$totalDueAmount
		];
	}
	public function findAllExpense($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
		$expenses = $this->model->select('expense.*')
			->where('invoice_date >=', $startOfMonth)
			->where('invoice_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();

		$totalAmount = array_sum(array_column($expenses, 'amount'));
		return [
			'total_expenses'=> $totalAmount
		];
	}
	
		
		}
	
	

