<?php
namespace App\Infrastructure\Persistence\Patient;

use App\Domain\Patient\Expense;
use App\Domain\Patient\ExpenseRepository;
use App\Models\Patient\ExpenseModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLExpenseRepository implements ExpenseRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect;

	public function __construct() {
		$this->model = new ExpenseModel();

	}
	public function setEntity($d) {
		return new Expense($d);
	}
	public function globalJoin() {
		$this->model->select('expense .*,pt.payment_typeName')
			->join('payment_type as pt', 'pt.id = expense.payment_type_fk_id', 'left');
		// ->join('title as t', 't.id = patients.title_fk_id', 'left')
		// ->join('state as s', 's.id = patients.state_fk_id', 'left')
		// ->join('illness as i', 'i.id = patients.medical_history_fk_id', 'left')
		// ->join('city as c', 'c.id = patients.city', 'left')
		// ->join('gender as g', 'g.id = patients.gender_fk_id', 'left');
	}
	function findDateRange($startDate, $endDate) {
		// $this->globalJoin();
		return $this->model
			->select('count(expense.id) as total_expense_count,SUM(IFNULL(expense.amount,0)) as total__expense_amount')
			->where('expense.invoice_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"')->asArray()->first();
	}
}