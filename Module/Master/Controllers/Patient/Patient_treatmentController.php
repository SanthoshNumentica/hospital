<?php
namespace App\Controllers\Patient;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatmentRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Patient_treatmentController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $patientRepo;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatient_treatmentRepository();
		$this->patientRepo = new SQLPatientRepository();
	}
	public function getInvoicePendingList() {
		$data = $this->repository->getAllPendingInvoiceByList();
		return $this->message(200, $data, 'success');
	}
	function getInvoiceGenByPatient($pid) {
		$date = date('Y-m-d');
		$data = $this->patientRepo->findById($pid);
		if (isset($data['status'])) {
			unset($data['status']);
		}
		$today = date('Y-m-d');
		$data['item'] = $this->repository->getPendingInvoicesByDate($pid, null);
		return $this->message(200, $data, 'success');
	}
	public function getTreatmentList() {
		$data = $this->repository->findAll();
		return $this->message(200, $data, 'Success');
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
