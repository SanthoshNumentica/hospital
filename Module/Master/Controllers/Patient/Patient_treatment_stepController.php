<?php
namespace App\Controllers\Patient;
use App\Domain\Patient\Patient_treatment_step;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_stepRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Patient_treatment_stepController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatient_treatment_stepRepository();
	}
	public function save() {
		$req = $this->getDataFromUrl('json');
		if (!empty($req)) {
			$d = new Patient_treatment_step($req);
			$res = $this->repository->insert($d);
			return $this->message($res ? 200 : 400, $req, 'success');
		} else {
			return $this->message(400, null, 'Date Not Available');
		}
	}
	function getProcedure($id) {
		$data = $this->repository->getLatestById($id);
		return $this->message(200, $data, 'success');
	}
}