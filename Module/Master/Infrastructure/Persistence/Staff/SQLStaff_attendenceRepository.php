<?php
namespace App\Infrastructure\Persistence\Staff;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Staff\Staff_attendenceRepository;
use App\Domain\Staff\Staff_attendence;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Staff\Staff_attendenceModel;

class SQLStaff_attendenceRepository implements Staff_attendenceRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Staff_attendenceModel();
    }
    public function setEntity($d)
    {
        return new Staff_attendence($d);
    }

}