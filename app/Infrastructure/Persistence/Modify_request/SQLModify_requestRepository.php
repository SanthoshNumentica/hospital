<?php
namespace Core\Infrastructure\Persistence\Modify_request;

use Core\Domain\Modify_request\Modify_requestRepository;
use Core\Infrastructure\Persistence\DMLPersistence;
use Core\Models\Modify_request\Modify_requestModel;

class SQLModify_requestRepository implements Modify_requestRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Modify_requestModel();
    }

    public function findAllByUserPagination($ftbl, $user_id)
    {
        $groupStart = false;
        $this->model->builder()
            ->select('modify_request.*,zone.zoneName,u.fname as created_name')
            ->join('zone', 'zone.id = zone', 'left')
            ->join('user_login as u', 'u.user_id = modify_request.created_by', 'inner');
        if (isset($ftbl->whereField) && count($ftbl->whereField)) {
            $w = $ftbl->whereField;
            $this->model->groupStart();
            $this->setWhere($w);
            $this->model->where('modify_request.created_by ', $user_id);
            $this->model->groupEnd();
            $this->model->orGroupStart();
            $this->setWhere($w);
            $this->model->groupEnd();
        }
        unset($ftbl->whereField);
        if (!isset($ftbl->sort) || empty($ftbl->sort)) {
            $ftbl->sort = [['colName' => 'updated_at', 'sortOrder' => 'desc']];
        }
        return $this->paginationQuery($ftbl);
    }
}
