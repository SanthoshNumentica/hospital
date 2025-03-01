<?php
namespace App\Infrastructure\Persistence\Staff;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Staff\StaffRepository;
use App\Domain\Staff\Staff;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Staff\StaffModel;

class SQLStaffRepository implements StaffRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new StaffModel();
    }
    public function setEntity($d)
    {
        return new Staff($d);
    }

    public function search($terms, $whereField = [])
    {
        $this->model
            ->groupStart()
            ->like('name', $terms, 'both')
            ->orLike('staff_emp_id', $terms, 'both')
            ->orLike('id', $terms, 'both')
            ->groupEnd();
        $this->setWhere($whereField);
        return $this->model->asArray()->allowCallbacks(true)->findAll(30);
    }

}