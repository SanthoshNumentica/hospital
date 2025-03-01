<?php
namespace App\Controllers\Patient;
use App\Infrastructure\Persistence\Patient\SQLPatient_examinationRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatment_teethRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Patient_examinationController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLPatient_examinationRepository();
	}

	function patientDentalChart($id) {
		$treRepo = new SQLPatient_treatment_teethRepository();
		$data['exam'] = $this->repository->patientDentalChart($id) ?? [];
		$data['tre'] = $treRepo->denatChartTreatment($id) ?? [];
		$unionD = array_merge($data['exam'], $data['tre']);
		$result = [];
		foreach ($unionD as $k => $v) {
			// code...
			$result[$v['teethNumber']] = $result[$v['teethNumber']] ?? [];
			array_push($result[$v['teethNumber']], $v);
		}
		return $this->message(200, $result, 'Success');
	}
}