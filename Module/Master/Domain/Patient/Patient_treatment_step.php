<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_treatment_step extends Entity {
	protected $attributes = ['patient_treatment_stepName' => null, 'patient_treatment_fk_id' => null,
	];
}
?>