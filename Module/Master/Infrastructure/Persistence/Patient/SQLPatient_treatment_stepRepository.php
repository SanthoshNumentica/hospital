<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_treatment_step;
use App\Domain\Patient\Patient_treatment_stepRepository;
use App\Models\Patient\Patient_treatment_stepModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_treatment_stepRepository implements Patient_treatment_stepRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_treatment_stepModel();
	}
	public function setEntity($d) {
		return new Patient_treatment_step($d);
	}

	function getLatestById($id, $limit = 0) {
		return $this->model->asArray()->where('patient_treatment_fk_id', $id)->orderBy('created_at', 'DESC')->findAll($limit);
	}

}