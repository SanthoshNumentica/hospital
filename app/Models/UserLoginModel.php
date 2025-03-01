<?php
namespace Core\Models;

use CodeIgniter\Model;

class UserLoginModel extends Model {
	protected $primaryKey = 'user_id';
	protected $table = 'user_login';
	protected $returnType = 'Core\Domain\User\UserLogin';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['user_name', 'password', 'staff_fk_id', 'email_id', 'forgotPassword', 'resetPassword', 'mobile_no', 'last_login_date', 'sponsor_fk_id', 'profile_id', 'lname', 'fname', 'avatar', 'deleted_at', 'app_version', 'temp_block', 'block_reason', 'last_active_session', 'counter_fk_id'];
	protected $useTimestamps = true;
	protected $afterFind = ['removePasswordField'];

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
