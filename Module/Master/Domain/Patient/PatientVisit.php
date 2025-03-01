<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class PatientVisit extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'visit_on ' => null, 'token_no' => null, 'doctor_fk_id' => null, 'counter_fk_id' => null,
	];
}
?>