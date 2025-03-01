<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_treatment extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'treatment_fk_id' => null, 'description' => null, 'invoice_fk_id' => null, 'status' => null, 'amount' => null, 'created_by' => null, 'doctor_fk_id' => null,
	];
}
?>