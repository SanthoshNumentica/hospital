<?php
namespace App\Domain\Appointment;

use CodeIgniter\Entity;
    class Appointment extends Entity
    {
       
         protected $attributes = [ 'patient_id'=> null,'doctor_fk_id'=> null,'created_by'=> null,'appointment_for'=> null,'appointment_on'=> null,'is_rescheduled'=> null,'rescheduled_reason'=> null,'is_visited'=> null,'remarks'=> null,'to_date'=> null,
         ];
    }
?>