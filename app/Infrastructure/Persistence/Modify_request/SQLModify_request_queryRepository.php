<?php
namespace Core\Infrastructure\Persistence\Modify_request;
use Core\Domain\Exception\RecordNotFoundException;
use Core\Domain\Modify_request\Modify_request_queryRepository;
use Core\Infrastructure\Persistence\DMLPersistence;
use Core\Models\Modify_request\Modify_request_queryModel;

class SQLModify_request_queryRepository implements Modify_request_queryRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Modify_request_queryModel();
    }

}