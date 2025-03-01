<?php
namespace App\Domain\Invoice;

use CodeIgniter\Entity;

class Invoice extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'total_amount' => null, 'total_paid_amount' => null, 'status' => null, 'remarks' => null, 'invoice_date' => null, 'created_by' => null, 'discount' => null, 'invoice_id' => null,
	];
}
?>