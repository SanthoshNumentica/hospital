<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class Patient_examinationModel extends Model {
	protected $table = 'patient_examination';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_examination';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['patient_fk_id', 'examination_fk_id', 'remarks', 'teethNumber', 'created_by'];
	protected $useTimestamps = true;
}
?>