<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

class PatientModel extends Model {
	protected $table = 'patient';
	protected $primaryKey = 'id';
	protected $returnType = 'Master\Domain\Patient\Patient';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['patient_id', 'title_fk_id', 'f_name', 'l_name', 'blood_group_fk_id', 'dob',
		'address', 'city', 'state_fk_id', 'mobile_no', 'email_id', 'gender_fk_id', 'chief_complaint', 'remarks', 'allow_sms', 'last_visit', 'patient_category_fk_id'];
	protected $useTimestamps = true;
}

?>