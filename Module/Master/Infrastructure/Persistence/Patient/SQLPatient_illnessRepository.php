<?php
namespace App\Infrastructure\Persistence\Patient;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Patient\Patient_illnessRepository;
use App\Domain\Patient\Patient_illness;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Patient\Patient_illnessModel;

class SQLPatient_illnessRepository implements Patient_illnessRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Patient_illnessModel();
    }
    function globalJoin() {
		$this->model->select('patient_illness.*,p.f_name as patientName,i.illnessName')
        ->join('illness as i', 'i.id = patient_illness.illness_fk_id', 'left')
			->join('patient as p', 'p.id = patient_illness.patient_fk_id', 'left');
	}
    public function setEntity($d)
    {
        return new Patient_illness($d);
    }

}