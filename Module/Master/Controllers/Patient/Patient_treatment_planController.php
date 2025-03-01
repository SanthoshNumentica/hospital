<?php
namespace App\Controllers\Patient;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_planRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Patient_treatment_planController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatient_treatment_planRepository();
	}
	function deleteItem($id) {
		if ($id) {
			$req = $this->getDataFromUrl('json');
			$res = $this->repository->deleteOfId($id);
			if (checkValue($req, 'remarks')) {
				$this->repository->updateById($id, ['remarks' => $req['remarks']]);
			}
			return $this->message($res ? 200 : 400, $req, $res ? 'success' : 'unable to delete Treatment');
		}
	}
}