<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_prescription;
use App\Domain\Patient\Patient_prescriptionRepository;
use App\Models\Patient\Patient_prescriptionModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_prescriptionRepository implements Patient_prescriptionRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_prescriptionModel();
	}
	public function setEntity($d) {
		return new Patient_prescription($d);
	}
	public function globalJoin() {
		$this->model->select('patient_prescription .*,ppi.medicine,ppi.frequency,ppi.dosage,ppi.duration,u.fname AS created_byName')
			->join('user_login as u', 'u.user_id =patient_prescription.created_by', 'left')
			->join('patient_prescription_item as ppi', 'ppi.patient_prescription_fk_id =patient_prescription.id', 'left');
	}

	function getBasicById($id) {
		return $this->model->select('patient_prescription.*,p.patient_id,concat(t.titleName, "", p.f_name," ",p.l_name) as patientName,p.mobile_no,g.genderName,TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age', false)->join('patient as p', 'p.id=patient_fk_id', 'left')
			->join('title as t', 't.id = title_fk_id', 'left')
			->join('gender as g', 'g.id = gender_fk_id', 'left')
			->asArray()->find($id);
	}

}