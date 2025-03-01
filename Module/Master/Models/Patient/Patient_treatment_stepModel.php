<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_treatment_stepModel extends Model {
	protected $table = 'patient_treatment_step';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_treatment_step';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_treatment_stepName', 'patient_treatment_fk_id'];
	protected $useTimestamps = false;
}
?>