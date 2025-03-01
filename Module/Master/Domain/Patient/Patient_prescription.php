<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_prescription extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'created_by' => null, 'visits_on' => null, 'prescription_notes' => null,
	];
}
?>