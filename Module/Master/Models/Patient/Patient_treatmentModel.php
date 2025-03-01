<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_treatmentModel extends Model {
	protected $table = 'patient_treatment';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_treatment';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['patient_fk_id', 'treatment_fk_id', 'description', 'invoice_fk_id', 'status', 'amount', 'created_by', 'doctor_fk_id'];
	protected $useTimestamps = true;
}
?>