<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_treatment_plan extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'description' => null, 'notes' => null, 'created_by' => null, 'status' => null, 'treatment_fk_id' => null, 'teeth_number' => null, 'remarks' => null,
	];
}
?>