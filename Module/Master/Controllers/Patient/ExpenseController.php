<?php
namespace App\Controllers\Patient;

use App\Domain\Patient\Expense;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Patient\SQLExpenseRepository;

class ExpenseController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLExpenseRepository();
    }

    public function save()
{
    $data = $this->getDataFromUrl('json'); 
    if (!checkValue($data, 'expense_id')) {
    $data['expense_id'] = generateKey('EXPENSE');
    }
    if (checkValue($data, 'id')) {
        // Update data
        $res = $this->repository->save(new Expense($data));
        return $this->message(200, $data, "Data Updated successfully");
    } else {
        // Insert data
        $res = $this->repository->insert(new Expense($data));
        return $this->message(200, $data, "Data Created successfully");
    }
}

    public function getList($tblLazy, $active=true)
    {
        $ftbl = '';
        $isActive = ($active === 'false') ? false : true;
        if ($tblLazy) {
            $ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
        }
        $data = $this->repository->findAllPagination($ftbl);
        return $this->message(200, $data, 'Success');
    }

    public function get($id = false)
    {
        $id = $id ? $id : 0;
        $data ='';
    
        if ($id === 0) {
            $data = $this->repository->findAll();
        } else {
            $data = $this->repository->findById($id);
        }
    
        if ($data) {
            return $this->message(200, $data, 'Successfully Retrieved');
        } else {
            return $this->message(400, $data, 'No Data Found');
        }
    }
    
}