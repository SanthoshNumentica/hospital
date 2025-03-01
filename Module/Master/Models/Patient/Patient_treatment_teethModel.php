<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_treatment_teethModel extends Model {
	protected $table = 'patient_treatment_teeth';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_treatment_teeth';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_treatment_fk_id', 'teethNumber'];
	protected $useTimestamps = false;
}
?>