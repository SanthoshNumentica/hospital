<?php
namespace App\Controllers\Staff;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Staff\SQLStaff_attendenceRepository;

class Staff_attendenceController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLStaff_attendenceRepository();
    }
}