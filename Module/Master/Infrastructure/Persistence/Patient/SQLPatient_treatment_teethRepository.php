<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_treatment_teeth;
use App\Domain\Patient\Patient_treatment_teethRepository;
use App\Models\Patient\Patient_treatment_teethModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_treatment_teethRepository implements Patient_treatment_teethRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_treatment_teethModel();
	}
	public function setEntity($d) {
		return new Patient_treatment_teeth($d);
	}

	function denatChartTreatment($id) {
		$this->model->select('e.examinationName,e.color_code,teethNumber,t.treatmentName,pt.created_at,u.fname as created_byName')
			->join('patient_treatment as pt', 'pt.id = patient_treatment_fk_id', 'inner')
			->join('treatment as t', 't.id = treatment_fk_id', 'inner')
			->join('examination as e', 'e.id=t.examination_fk_id', 'left')
			->where('patient_fk_id', $id);
		$this->model->join('user_login as u', 'u.user_id = pt.doctor_fk_id', 'left');
		// echo $this->model->builder()->getCompiledSelect();
		return $this->model->asArray()->findAll();
	}
}