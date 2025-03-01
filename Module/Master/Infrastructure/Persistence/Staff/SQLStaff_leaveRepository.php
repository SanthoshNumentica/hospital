<?php
namespace App\Infrastructure\Persistence\Staff;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Staff\Staff_leaveRepository;
use App\Domain\Staff\Staff_leave;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Staff\Staff_leaveModel;

class SQLStaff_leaveRepository implements Staff_leaveRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Staff_leaveModel();
    }
    public function setEntity($d)
    {
        return new Staff_leave($d);
    }

}