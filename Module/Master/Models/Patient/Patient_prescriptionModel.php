<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_prescriptionModel extends Model {
	protected $table = 'patient_prescription';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_prescription';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['patient_fk_id', 'created_by', 'visits_on', 'prescription_notes'];
	protected $useTimestamps = true;
}
?>