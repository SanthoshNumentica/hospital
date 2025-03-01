<?php
namespace App\Infrastructure\Persistence\Payment;

use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentRepository;
use App\Models\Payment\PaymentModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPaymentRepository implements PaymentRepository
{
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $overWriteConditionKey = ['invoice_id' => 'i.invoice_id', 'patient_id' => 'p.patient_id'];
	protected $commonSelect = "payment.*, CASE WHEN payment.status = 1 THEN 'Paid' ELSE 'NotPaid' END AS status, p.f_name AS patientName,pt.payment_typeName,p.patient_id,i.id AS invoice_id,p.patient_id,u.fname as created_byName";
	public function __construct()
	{
		$this->model = new PaymentModel();
	}
	public function setEntity($d)
	{
		return new Payment($d);
	}
	function globalJoin()
	{
		$this->model->select($this->commonSelect)
			->join('payment_type as pt', 'pt.id=payment_type_fk_id', 'left')
			->join('invoice as i', 'i.id=ref_fk_id', 'left')
			->join('patient as p', 'p.id=i.patient_fk_id', 'left')
			->join('user_login as u', 'u.user_id=payment.created_by', 'left');
	}
	function findByDateRange($startDate, $endDate)
	{
		$this->globalJoin();
		$results = $this->model
			->select('payment_type_fk_id')
			->where('payment.payment_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"')
			->withDeleted()
			->findAll();
		return $results;
	}
	function findDateRange($startDate, $endDate)
	{
		return  $this->model
			->select('count(payment.id) as total_payment_count,SUM(IFNULL(payment.amount,0)) as total__payment_amount')
			->where('payment.payment_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"')->asArray()
			->first();
	}

	function newPayment($ref_id, $amount, $des, $userId, $type = 1, $pay_type = 1, $payDate = null, $pay_ref_number = '', $pay_ref_remarks = '')
	{
		//create Voucher
		$data['payments_id'] = generateKey('PAYMENT');
		$data['payments_des'] = $des;
		$data['amount'] = $amount;
		$data['created_by'] = $userId;
		$data['type'] = $type;
		$data['credit_type'] = $type == 1 ? 1 : 2;
		$data['ref_fk_id'] = $ref_id;
		$data['payment_type_fk_id'] = $pay_type;
		$data['payment_ref_number'] = $pay_ref_number;
		$data['payment_remarks'] = $pay_ref_remarks;
		$data['payment_date'] = $payDate ? $payDate : date('Y-m-d');
		$data['id'] = $this->model->insert($data);
		return $data;
	}

	function getSumByInvoice($id)
	{
		$d = $this->model->selectSum('amount')->where(['ref_fk_id' => $id, 'type' => 1])->asArray()->get()->getRow();
		return $d->amount;
	}
	function findByInvoice($id)
	{
		return $this->model->select('payment.*,u.fname as created_byName')
			->join('user_login as u', 'u.user_id = created_by', 'left')
			->where(['ref_fk_id' => $id, 'type' => 1])->asArray()->findAll();
		// code...
	}
	public function findeAllPaymentByMonth($startDate, $endDate) {
		$this->globalJoin();
		$startOfMonth = date('Y-m-d', strtotime($startDate));
		$endOfMonth = date('Y-m-d', strtotime($endDate));
	
		$payments = $this->model->select('payment.*')
			->where('payment_date >=', $startOfMonth)
			->where('payment_date <=', $endOfMonth)
			->asArray()->allowCallbacks(true)->findAll();
			$totalInvoices = count($payments);
			$totalAmount = array_sum(array_column($payments, 'amount'));
			return [
				'details' => $payments,
				'total_payments' => $totalInvoices,
				'total_amount' => $totalAmount
			];
	
	}
}