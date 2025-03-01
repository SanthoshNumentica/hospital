<?php
namespace App\Infrastructure\Persistence\Patient;
use App\Domain\Patient\Patient_examination;
use App\Domain\Patient\Patient_examinationRepository;
use App\Models\Patient\Patient_examinationModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLPatient_examinationRepository implements Patient_examinationRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;
	protected $compactSelect = 'e.examinationName,patient_examination.*,e.color_code,ul.fname as created_byName';
	public function __construct() {
		$this->model = new Patient_examinationModel();
	}
	public function setEntity($d) {
		return new Patient_examination($d);
	}
	function globalJoin() {
		$this->model->select($this->compactSelect, false)
			->join('user_login as ul', 'ul.user_id = created_by', 'left')
		// ->join('patient as p', 'p.id = patient_fk_id', 'left')
			->join('examination as e', 'e.id = examination_fk_id', 'left');
	}

	public function patientDentalChart($id) {
		$this->globalJoin();
		$select = "concat(e.examinationName),e.color_code,teethNumber,t.treatmentName,pt.created_at,u.faname as created_byName";
		return $this->model->where(['patient_fk_id' => $id])->asArray()->findAll();
		//$teethRepo = new SQLPatient_treatment_teethRepository();
		// $teeth = $teethRepo->model->select('e.examinationName,e.color_code,teethNumber,t.treatmentName,pt.created_at')
		// 	->join('patient_treatment as pt', 'pt.id = patient_treatment_fk_id', 'inner')
		// 	->join('treatment as t', 't.id = treatment_fk_id', 'inner')
		// 	->join('examination as e', 'e.id=t.examination_fk_id', 'inner')
		// 	->where('patient_fk_id', $id)->asArray()->findAll();
		//$teeth = $teethRepo->denatChartTreatment($id);

		// $builder = $db->table('users')->select('id, name')->limit(10);
		// $union = $db->table('groups')->select('id, name');
		//$this->model->union($teeth)->get();

	}

}