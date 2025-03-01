<?php
namespace Core\Controllers;

use Config\Services;
use Core\Domain\Exception\RecordNotFoundException;
use Core\Domain\User\User;
use Core\Domain\User\UserLoginRepository;
use Core\Domain\User\UserRepository;
use Core\Infrastructure\Persistence\Role\SQLUser_roleRepository;
use Core\Models\Logs\LogsModel;

class UsersController extends BaseController {

	private $repository;
	private $role_repository;
	private $login_repository;
	private $logsModel;

	public function __construct() {
		$this->initializeFunction();
		$this->repository = Services::UserRepository();
		$this->login_repository = Services::UserLoginRepository();
		$this->role_repository = new SQLUser_roleRepository();
		$this->logsModel = new LogsModel();

	}

	public function index() {

		//$this->UserListing();
	}

	public function UserListing($tblLazy, $activeUser = true) {
		$ftbl;
		$isActive = ($activeUser === 'false') ? false : true;

		if ($tblLazy) {
			$ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
		}
		$data = $this->login_repository->findAllUserPagination($ftbl, $isActive);
		return $this->message(200, $data);
	}

	public function addUser() {
		$data = $this->getDataFromUrl('json');
		$userId = $data['user_id'] ?? '';
		if (!checkValue($data, 'email_id')) {
			return $this->message(400, null, ' Email Id Required');
		}
		// if(!checkValue($data,'mobile_no')){
		// return $this->message(400,null,' Mobile No Required');
		// }
		if (!checkValue($data, 'user_id') && !checkValue($data, 'password')) {
			return $this->message(400, null, ' Password Required');
		}
		if (!checkValue($data, 'fname')) {
			return $this->message(400, null, ' Name is Required');
		}
		$data['user_name'] = $data['email_id'];
		$userLogin = new User($data);
		try
		{
			$userId = isset($data['user_id']) ? $data['user_id'] : '';
			if (empty($userId)) {
				//insert check user already exsits or not
				$chekUser = $this->login_repository->findUserUniqueByField('email_id', '', $data['email_id']);
				if (!$chekUser) {
					return $this->message(400, null, 'User Email Id Exsits');
				}
				$userId = $this->repository->insert($userLogin);
				$data['user_id'] = (int) $userId;
			} else if ($userId) {
				// $userLogin =$userLogin->toRawArray();
				$res = $this->repository->save($userLogin);
			}

		} catch (RecordNotFoundException $e) {
			return $this->message(404, $e->getMessage());
		}

		if ($userId) {
			$this->role_repository->deleteOfId($userId);
			$userRole = ['role_id' => $data['role_id'], 'user_id' => $userId];
			$this->role_repository->insert($userRole);

		}
		return $this->message(200, $data);

	}

	public function isEmailUnique($email) {
		$result = $this->login_repository->findUserByUserName($email);
		return $this->message(200, $result);
	}

	public function isUnique($field, $email) {
		$result = $this->login_repository->findUserUnique($field, $email);
		return $this->message(200, $result);
	}

	public function getUserDetail($id) {
		if (strtolower($this->reqMethod) == 'get') {
			$data = $this->repository->findById($id);
			if (!empty($data)) {
				unset($data['password']);
			}
			$roleData = $this->role_repository->findByRoleId($id);
			$data['role'] = $roleData;
			if (!empty($roleData) && isset($roleData[0])) {
				$data['role_id'] = $roleData[0]['role_id'];
			}
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}

	}

	public function create() {

		$token = $this->token_get();
		try
		{
			//    $album = $this->repository->findAlbumOfId($id);
			$data = $this->repository->findUserOfId(1);
		} catch (RecordNotFoundException $e) {
			//throw new PageNotFoundException($e->getMessage());
			return $this->message(404, $e->getMessage());
		}
		return $this->message(200, $data);
	}

	public function deleteUser($id) {
		if ($id) {
			if ($this->login_repository->deleteOfId($id)) {
				return $this->message(200, $id, 'Success');
			} else {
				return $this->message(400, null, 'Failed to Delete');
			}

		}
	}

	public function makeActive($id) {
		if ($id) {
			if ($this->login_repository->update(array('user_id' => $id), array('deleted_at' => null))) {
				return $this->message(200, $id, 'Success');
			} else {
				return $this->message(400, null, 'Failed to Inactive');
			}

		}
	}

	public function show404() {
		$message = array(
			'statusCode' => 400,
			'message' => 'Method Not Allowed',
			'result' => null);
		print_r(json_encode($message));
	}
}
