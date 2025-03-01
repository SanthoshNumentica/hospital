<?php
namespace App\Domain\Payment;

use CodeIgniter\Entity;

class Payment extends Entity {
	protected $attributes = ['payments_id' => null, 'payments_des' => null, 'created_by' => null, 'payment_date' => null, 'type' => null, 'ref_fk_id' => null, 'payment_type_fk_id' => null, 'payment_ref_number' => null, 'payment_remarks' => null, 'status' => null, 'credit_type' => null, 'amount' => null,
	];
}
?>