<?php
namespace App\Models\Payment;
use CodeIgniter\Model;

class PaymentModel extends Model {
	protected $table = 'payment';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Payment\Payment';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['payments_id', 'payments_des', 'created_by', 'payment_date', 'type', 'ref_fk_id', 'payment_type_fk_id', 'payment_ref_number', 'payment_remarks', 'status', 'credit_type', 'amount'];
	protected $useTimestamps = true;

	//type 1 => invoice 2 =>expense
}
?>