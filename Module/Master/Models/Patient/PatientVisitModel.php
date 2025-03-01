<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class PatientVisitModel extends Model {
	protected $table = 'patient_visit';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\PatientVisit';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_fk_id', 'visit_on', 'status', 'token_no', 'doctor_fk_id', 'created_by', 'counter_fk_id'];
	protected $useTimestamps = true;
}
// status 1 => completed 2 => Waiting 3=> In Service 4 missed
?>