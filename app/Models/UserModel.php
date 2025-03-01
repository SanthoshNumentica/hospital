<?php
namespace Core\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $imageColum = [];
	public function __construct() {
		helper('Core\Helpers\File');
		$appConstant = new \Config\AppConstant();
		$this->imageColum = array('avatar' => $appConstant->userUploadPath);
	}
	protected $table = 'user_login';
	protected $primaryKey = 'user_id';
	protected $returnType = 'Core\Domain\User\User';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['fname', 'lname', 'avatar', 'color_code', 'gender', 'specialization', 'last_reset_password', 'temp_block', 'forgot_password', 'mobile_no', 'email_id', 'user_name', 'is_doctor', 'password', 'counter_fk_id'];
	protected $useTimestamps = true;
	protected $beforeInsert = ['beforeSave'];
	protected $beforeUpdate = ['beforeSave'];
	protected $afterFind = ['addImageRealPath', 'removePasswordField'];
	public function beforeSave(array $data) {
		$data['data'] = modelFileHandler($data['data'], $this->imageColum);
		return $data;
	}
	protected function addImageRealPath(array $data) {
		$data['data'] = addImageRealPath($data['data'], $this->imageColum);
		return $data;
	}
	protected function removePasswordField(array $data) {
		if (isset($data['data']) && $data['data']) {
			if (isset($data['data']['password'])) {
				unset($data['data']['password']);
			} else {
				foreach ($data['data'] as &$item) {
					if (isset($item['password'])) {
						unset($item['password']);

					}
				}
			}
		}
		return $data;
	}
}
