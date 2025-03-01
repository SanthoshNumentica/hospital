<?php
namespace App\Controllers\Medicine;

use App\Domain\Medicine\Medicine;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Medicine\SQLMedicineRepository;

class MedicineController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLMedicineRepository();
    }
    public function save() {
		$data = $this->getDataFromUrl('json');
		if (!checkValue($data, 'medicine_type_fk_id')) {
			return $this->message(400, null, 'medicine Id Is Required');
		}
		$action = !checkValue($data, 'id') ? 'created' : 'updated ';
		if (checkValue($data, 'id')) {
			$res = $this->repository->save(new Medicine($data));
		} else {
			$data['id'] = $this->repository->insert(new Medicine($data));
			$res = true;
		}
		return $this->message($res ? 200 : 400, $data, $res ? "Medicine $action Successfully" : 'Unable to save changes');
	}
	
}
	