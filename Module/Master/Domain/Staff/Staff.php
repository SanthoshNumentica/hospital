<?php
namespace App\Domain\Staff;

use CodeIgniter\Entity;
    class Staff extends Entity
    {
         protected $attributes = [ 'school_fk_id'=> null,'staff_emp_id'=> null,'email_id'=> null,'name'=> null,'mobile_no'=> null,'last_name'=> null,'name_cert'=> null,'dob'=> null,'do_bap'=> null,'do_join'=> null,'do_marraige'=> null,'father_name'=> null,'maritial_status'=> null,'region'=> null,'zone'=> null,'church'=> null,'department'=> null,'field'=> null,'designation'=> null,'profile_img'=> null,'last_modify_by'=> null,'gender'=> null,'reason_relive'=> null,'modify_request'=> null,'last_rejoin_date'=> null,'created_by'=> null,'last_approved_by'=> null,'alt_mobile_no'=> null,'staff_status_id'=> null,'finger_print'=>null,
         ];
    }
?>