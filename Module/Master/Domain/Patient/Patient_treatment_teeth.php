<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;
    class Patient_treatment_teeth extends Entity
    {
         protected $attributes = [ 'patient_treatment_fk_id'=> null,'teethNumber'=> null,
         ];
    }
?>