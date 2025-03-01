<?php
namespace App\Models\Staff;
use CodeIgniter\Model;

    class Staff_attendenceModel extends Model
    {
        protected $table      = 'staff_attendence';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Staff\Staff_attendence';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'staff_fk_id','clock_in_time','clock_out_time','clock_in_ip','clock_out_ip','leave_type_fk_id','is_present','work_from_type_id','created_by','last_modify_by',];
         protected $useTimestamps = true;
    }
?>