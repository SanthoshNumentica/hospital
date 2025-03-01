<?php
namespace App\Controllers\Patient;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescription_itemRepository;

class Patient_prescription_itemController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLPatient_prescription_itemRepository();
    }
}