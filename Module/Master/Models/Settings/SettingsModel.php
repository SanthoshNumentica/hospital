<?php
namespace App\Models\Settings;
use CodeIgniter\Model;

class SettingsModel extends Model {
	public function __construct() {
		helper('Core\Helpers\File');
		$this->appConstant = new \Config\AppConstant();
		$this->imageColum = ['logo' => $this->appConstant->companyUploadPath, 'logo_white' => $this->appConstant->companyUploadPath, 'logo_water_mark' => $this->appConstant->companyUploadPath];
	}
	protected $table = 'settings';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Settings\Settings';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['companyName', 'logo', 'logo_white', 'address', 'address_1', 'address_2', 'mobile_no', 'alt_mobile_no', 'master_passcode', 'allow_notification', 'idl_timeout', 'email_id', 'website_url', 'logo_water_mark','theme_color'];
	protected $useTimestamps = false;
	protected $beforeInsert = ['beforeSave'];
	protected $beforeUpdate = ['beforeSave'];
	protected $afterFind = ['addImageRealPath'];
	public function beforeSave(array $data) {
		$data['data'] = modelFileHandler($data['data'], $this->imageColum);
		return $data;
	}

	protected function addImageRealPath(array $data) {

		$data['data'] = addImageRealPath($data['data'], $this->imageColum);
		return $data;
	}
}
?>