<?php
namespace App\Controllers\Patient;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescriptionRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_prescription_itemRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Patient_prescriptionController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $patient;
	private $patientpresItem;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatient_prescriptionRepository();
		$this->patient = new SQLPatientRepository();
		$this->patientpresItem = new SQLPatient_prescription_itemRepository();
	}
	public function getListByPatient($id) {
		$data = $this->patient->findById($id);
		$patientId = $data['id'] ?? '';
		$data['prescription_item'] = $this->repository->findAllByWhere(['patient_fk_id' => $patientId]);
		return $this->message(200, $data, 'Success');
	}
	public function getPrescriptionByPatient($id) {
		$data = $this->repository->findAllByWhere(['patient_fk_id' => $id]);
		return $this->message(200, $data, 'Success');
	}

	function deleteItem($id) {
		if ($id) {
			$req = $this->getDataFromUrl('json');
			$res = $this->repository->deleteOfId($id);
			$this->patientpresItem->deleteWhere(['patient_prescription_fk_id' => $id]);
			if (checkValue($req, 'remarks')) {
				$this->repository->updateById($id, ['remarks' => $req['remarks']]);
			}
			return $this->message($res ? 200 : 400, $req, $res ? 'success' : 'unable to delete Treatment');
		}
	}
}
