<?php
namespace App\Controllers\Patient;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Patient\SQLPatient_imagesRepository;

class Patient_imagesController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLPatient_imagesRepository();
    }
}