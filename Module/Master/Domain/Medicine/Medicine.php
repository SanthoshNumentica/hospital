<?php
namespace App\Domain\Medicine;

use CodeIgniter\Entity;
    class Medicine extends Entity
    {
         protected $attributes = [ 'medicineName'=> null,'description'=> null,'status'=> null,'medicine_type_fk_id'=> null,
         ];
    }
?>