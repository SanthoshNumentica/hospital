<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_investigation;
use App\Domain\Patient\Patient_investigationRepository;
use App\Models\Patient\Patient_investigationModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_investigationRepository implements Patient_investigationRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_investigationModel();
	}
	public function setEntity($d) {
		return new Patient_investigation($d);
	}
	function globalJoin() {
		$this->model->select('patient_investigation.*,concat(u.fname," ",ifnull(u.lname,"")) as created_byName')
			->join('user_login as u', 'u.user_id = created_by', 'left');
	}

}