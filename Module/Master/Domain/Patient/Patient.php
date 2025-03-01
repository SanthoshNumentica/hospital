<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;

class Patient extends Entity {

	protected $attributes = ['patient_id' => null, 'title_fk_id' => null, 'f_name' => null, 'l_name' => null, 'blood_group_fk_id' => null, 'dob' => null, 'address' => null, 'city' => null, 'state_fk_id' => null, 'mobile_no' => null, 'email_id' => null, 'gender_fk_id' => null, 'chief_complaint' => null, 'remarks' => null, 'allow_sms' => null, 'patient_category_fk_id' => null,

	];
}
?>