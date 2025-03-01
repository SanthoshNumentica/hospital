<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;
    class Patient_illness extends Entity
    {
         protected $attributes = [ 'patient_fk_id'=> null,'illness_fk_id'=> null,
         ];
    }
?>