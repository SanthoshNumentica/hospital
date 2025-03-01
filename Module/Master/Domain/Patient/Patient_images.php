<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_images extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'document' => null, 'remarks' => null,
	];
}
?>