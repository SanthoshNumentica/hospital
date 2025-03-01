<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient_examination extends Entity {
	protected $attributes = ['patient_fk_id' => null, 'examination_fk_id' => null, 'remarks' => null, 'teethNumber' => null, 'created_by' => null,
	];
}
?>