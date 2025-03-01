<?php
namespace App\Domain\Medicine;

use CodeIgniter\Entity;
    class Medicine_template_item extends Entity
    {
         protected $attributes = [ 'medicine_template_fk_id'=> null,'medicine_fk_id'=> null,'medicine_dosage_fk_id'=> null,'medicine_frequency_fk_id'=> null,'medicine_duration_fk_id'=> null,
         ];
    }
?>