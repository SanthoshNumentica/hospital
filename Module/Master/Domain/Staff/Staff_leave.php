<?php
namespace App\Domain\Staff;

use CodeIgniter\Entity;
    class Staff_leave extends Entity
    {
         protected $attributes = [ 'leave_type_id'=> null,'reason'=> null,'leave_date'=> null,'to_leave_date'=> null,'status'=> null,'approved_reason'=> null,'reject_reason'=> null,'created_by'=> null,'last_modify_by'=> null,'remarks'=> null,'document_img'=> null,'staff_fk_id'=> null,'approved_on'=> null,'total_paid_leave'=> null,
         ];
    }
?>