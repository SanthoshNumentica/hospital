<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_prescription_item extends Entity {
	protected $attributes = ['medicine' => null, 'frequency' => null, 'dosage' => null, 'm_type' => null, 'duration' => null, 'notes' => null, 'patient_prescription_fk_id' => null,
	];
}
?>