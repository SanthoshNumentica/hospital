<?php
namespace App\Models\Staff;
use CodeIgniter\Model;

    class Staff_leaveModel extends Model
    {
        protected $table      = 'staff_leave';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Staff\Staff_leave';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'leave_type_id','reason','leave_date','to_leave_date','status','approved_reason','reject_reason','created_by','last_modify_by','remarks','document_img','staff_fk_id','approved_on','total_paid_leave',];
         protected $useTimestamps = true;
    }
?>