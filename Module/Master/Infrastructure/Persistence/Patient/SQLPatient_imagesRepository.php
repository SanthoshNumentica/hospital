<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_images;
use App\Domain\Patient\Patient_imagesRepository;
use App\Models\Patient\Patient_imagesModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_imagesRepository implements Patient_imagesRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Patient_imagesModel();
	}
	public function setEntity($d) {
		return new Patient_images($d);
	}
	function findByPatient($pid) {
		return $this->model->where(['deleted_at is null ' => null, 'patient_fk_id' => $pid])->allowCallbacks(true)->asArray()->findAll();
	}
}