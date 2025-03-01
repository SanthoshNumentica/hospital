<?php
namespace Core\Controllers\Modify_request;
use Core\Models\Logs\LogsModel;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Infrastructure\Persistence\Modify_request\SQLModify_request_queryRepository;

class Modify_request_queryController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    private $logModel;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLModify_request_queryRepository();
        $this->logModel   = new LogsModel();
    }
}