<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_illnessModel extends Model {
	protected $table = 'patient_illness';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_illness';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_fk_id', 'illness_fk_id','updated_at'];
	protected $useTimestamps = true;
}
?>