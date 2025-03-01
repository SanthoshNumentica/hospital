<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_investigation extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'temp' => null, 'weight' => null, 'bp' => null, 'observation' => null, 'blood_sugar' => null, 'created_by' => null,
	];
}
?>