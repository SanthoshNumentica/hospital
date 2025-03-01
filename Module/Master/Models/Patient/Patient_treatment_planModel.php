<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_treatment_planModel extends Model {
	protected $table = 'patient_treatment_plan';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_treatment_plan';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_fk_id', 'description', 'notes', 'created_by', 'status', 'treatment_fk_id', 'teeth_number', 'remarks'];
	protected $useTimestamps = true;
}
//status 1 => completed 2 for pending

?>