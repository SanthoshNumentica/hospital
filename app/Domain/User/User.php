<?php
namespace Core\Domain\User;
use CodeIgniter\Entity;

class User extends Entity {
	protected $attributes = ['fname' => null, 'lname' => null, 'avatar' => null, 'gender' => null, 'color_code' => null, 'specialization' => null, 'last_reset_password' => null, 'app_version' => null, 'temp_block' => null, 'forgot_password' => null, 'mobile_no' => null, 'email_id' => null, 'user_name' => null, 'is_doctor' => null, 'password' => null, 'counter_fk_id' => null];
	public function setPassword(string $password) {
		if (!empty($password)) {
			$this->attributes['password'] = md5($password);
		}
		return $this;
	}
}
