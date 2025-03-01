<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_treatment_plan;
use App\Domain\Patient\Patient_treatment_planRepository;
use App\Models\Patient\Patient_treatment_planModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_treatment_planRepository implements Patient_treatment_planRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect = 'patient_treatment_plan.*,t.treatmentName,t.treatment_code,
    teeth_number as teethNumber,u.fname AS doctorName,concat(t.treatment_code," ",t.treatmentName) as description,CASE WHEN patient_treatment_plan.status =1 then "Completed" else "Pending" end as statusName';
	public function __construct() {
		$this->model = new Patient_treatment_planModel();
	}
	public function setEntity($d) {
		return new Patient_treatment_plan($d);
	}
	function globalJoin() {
		$this->model->select($this->compactSelect, false)
			->join('user_login as u', 'u.user_id=created_by', 'left')
			->join('treatment as t', 't.id=treatment_fk_id', 'left');
	}
	function chekUpdateStatus($pid, $tid) {
		return $this->model->where(['patient_fk_id' => $pid, 'teeth_number' => $tid, 'status' => 2])->set(['status' => 1])->update();
	}
}