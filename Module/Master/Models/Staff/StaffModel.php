<?php
namespace App\Models\Staff;
use CodeIgniter\Model;

    class StaffModel extends Model
    {
        protected $table      = 'staff';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Staff\Staff';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'school_fk_id','staff_emp_id','email_id','name','mobile_no','last_name','name_cert','dob','do_bap','do_join','do_marraige','father_name','maritial_status','region','zone','church','department','field','designation','profile_img','last_modify_by','gender','reason_relive','modify_request','last_rejoin_date','created_by','last_approved_by','alt_mobile_no','staff_status_id','finger_print',];
         protected $useTimestamps = true;
    }
?>