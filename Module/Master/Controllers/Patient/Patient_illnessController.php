<?php
namespace App\Controllers\Patient;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Patient\SQLPatient_illnessRepository;

class Patient_illnessController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLPatient_illnessRepository();
    }
}