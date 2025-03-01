<?php
namespace App\Models\Appointment;
use CodeIgniter\Model;

    class AppointmentModel extends Model
    {
        protected $table      = 'appointment';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Appointment\Appointment';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'patient_fk_id','doctor_fk_id','created_by','appointment_for','appointment_on','is_rescheduled','rescheduled_reason','is_visited','remarks','to_date',];
         protected $useTimestamps = true;
    }
?>