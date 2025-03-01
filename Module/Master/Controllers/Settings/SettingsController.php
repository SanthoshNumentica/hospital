<?php
namespace App\Controllers\Settings;
use App\Infrastructure\Persistence\Settings\SQLSettingsRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Models\Utility\UtilityModel;
use PharIo\Manifest\License;

class SettingsController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $utilityRepo;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLSettingsRepository();
		$this->utilityRepo = new UtilityModel();
	}
	public function save() {
		$req = $this->getDataFromUrl('json');
		$req['id'] = 1;
		$res = $this->repository->save($req);
		$d = $this->repository->getSetting();
		return $this->message($res ? 200 : 400, $d, $res ? 'Success' : 'Failed');
	}
	function getAllSetting() {
		$d = $this->repository->getSetting();
		$d['socketPort'] = PORT;
		$d['license'] = $this->utilityRepo->getLicence();
		return $this->message(200, $d, 'Sucess');
	}
	function renewLicence(){
		$req = $this->getDataFromUrl('json');
		if($req){
		$res = $this->utilityRepo->updateLicence($req);
	}
		$d = $this->repository->getSetting();
		$d['license'] = $this->utilityRepo->getLicence();
		return $this->message($res ? 200 : 400, $d, $res ? 'Success' : 'Failed');
	}
}