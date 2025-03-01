<?php
namespace App\Domain\Staff;

use CodeIgniter\Entity;
    class Staff_attendence extends Entity
    {
         protected $attributes = [ 'staff_fk_id'=> null,'clock_in_time'=> null,'clock_out_time'=> null,'clock_in_ip'=> null,'clock_out_ip'=> null,'leave_type_fk_id'=> null,'is_present'=> null,'work_from_type_id'=> null,'created_by'=> null,'last_modify_by'=> null,
         ];
    }
?>