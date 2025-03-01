<?php
namespace App\Controllers\Patient;

use App\Domain\Patient\Treatment;
use App\Infrastructure\Persistence\Patient\SQLTreatementRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class TreatementController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLTreatementRepository();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		if (!checkValue($data, 'treatment_id')) {
			$data['treatment_id'] = generateKey('TREATMENT');
		}
		if (checkValue($data, 'id')) {
			// Update data
			$res = $this->repository->save(new Treatment($data));
			return $this->message(200, $data, "Data Updated successfully");
		} else {
			// Insert data
			$res = $this->repository->insert(new Treatment($data));
			print_r($data);
			return $this->message(200, $data, "Data Created successfully");
		}
	}

	// public function save()
	// {
	//     $data = $this->getDataFromUrl('json');
	//     $currentTimestamp = time(); // Get current timestamp

	//     if (!checkValue($data, 'token_no') || isTokenExpired($data['token_no'])) {
	//         $data['token_no'] = generateKey('TOKEN');
	//         // $data['token_no'] = 1; // Reset token_no like  to 1
	//     } else {
	//         // Increment token_no like by 0
	//         $data['token_no'] = intval($data['token_no']) + 1;
	//     }

	//     if (checkValue($data, 'id')) {
	//         // Update data
	//         $res = $this->repository->save(new PatientVisit($data));
	//         return $this->message(200, $data, "Data Updated successfully");
	//     } else {
	//         // Insert data
	//         $res = $this->repository->insert(new PatientVisit($data));
	//         return $this->message(200, $data, "Data Created successfully");
	//     }
	// }

	// Function to check if the token is expired (one day has passed)
	function isTokenExpired($tokenTimestamp) {
		$oneDayInSeconds = 24 * 60 * 60; // One day in seconds
		return (time() - $tokenTimestamp) >= $oneDayInSeconds;
	}

	public function getList($tblLazy, $active = true) {
		$ftbl = '';
		$isActive = ($active === 'false') ? false : true;
		if ($tblLazy) {
			$ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
		}
		$data = $this->repository->findAllPagination($ftbl);
		return $this->message(200, $data, 'Success');
	}

	public function get($id = false) {
		$id = $id ? $id : 0;
		$data = '';

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