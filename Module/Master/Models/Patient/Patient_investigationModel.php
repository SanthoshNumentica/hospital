<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_investigationModel extends Model {
	protected $table = 'patient_investigation';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_investigation';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_fk_id', 'temp', 'weight', 'bp', 'observation', 'blood_sugar', 'created_by'];
	protected $useTimestamps = false;
}
?>