<?php
namespace App\Controllers\Patient;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Patient\SQLPatient_investigationRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_illnessRepository;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;

class Patient_investigationController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    private $patient;
    private $patient_illness;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLPatient_investigationRepository();
        $this ->patient = new SQLPatientRepository();
        $this->patient_illness = new SQLPatient_illnessRepository();
    }
    public function getListByPatient($id)
    {
        $data['medical_history'] = $this->repository->findAllByWhere(['patient_fk_id' => $id]);
        // print_r($data);
    return $this->message(200, $data, 'Success');
}
}