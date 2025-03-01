<?php
namespace App\Controllers\Staff;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Staff\SQLStaff_leaveRepository;

class Staff_leaveController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLStaff_leaveRepository();
    }
}