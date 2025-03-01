<?php
namespace Core\Models\Utility;

use CodeIgniter\Model;
use Core\Libraries\ExportExcel;
use DateTime;

class UtilityModel extends Model
{
	private $staffRepo;
	private $fieldRepo;
	protected $db;
	public function __construct($profile = '')
	{
		parent::__construct();
		if ($profile) {
			$this->db = \Config\Database::connect($profile);
		} else {
			$this->db = \Config\Database::connect();
		}

		helper('Core\Helpers\File');
		$this->appConstant = new \Config\AppConstant();
	}
	public function get_db()
	{
		return $this->db;
	}
	public function addNewData($tName, $data)
	{
		if ($tName == 'trust') {
			$data = modelFileHandler($data, ['logo_img' => $this->appConstant->trustLogoUploadPath, 'water_mark_img' => $this->appConstant->trustWaterMarkUploadPath]);
		}
		$this->db->table($tName)->insert($data);
		return $this->db->insertID();
	}

	public function deleteData($tName, $cond)
	{
		return $this->db->table($tName)->where($cond)->delete();
	}

	public function replaceData($tName, $data)
	{
		return $this->db->table($tName)->replace($data);
	}

	public function checkAndReplace($tName, $data, $searchKey)
	{
		$s = $data[$searchKey] ?? '';
		$s = strtolower($s);
		if (!$s) {
			return true;
		}
		$res = $this->db->table($tName)->select('id')->where('LOWER(' . $searchKey . ')', $s)->get()->getResultArray();
		if (empty($res)) {
			$this->db->table($tName)->insert($data);
			return $this->db->insertID();
		}
	}

	public function mapColTbl($tName, $d)
	{
		$col = $this->showTableColum($tName);
		$mapData = [];
		foreach ($col as $key => $v) {
			$field = $v['Field'];
			if (isset($d[$field]) && !in_array($field, ['created_at', 'updated_at', 'deleted_at'])) {
				$mapData[$field] = $d[$field];
			}
		}
		return $mapData;
	}

	public function updateData($tName, $data, $where)
	{
		if ($tName == 'trust') {
			$data = modelFileHandler($data, ['logo_img' => $this->appConstant->trustLogoUploadPath, 'water_mark_img' => $this->appConstant->trustWaterMarkUploadPath]);
		}
		return $this->db->table($tName)->update($data, $where);
	}
	public function getDataById($tbl, $cond, $returnType = 'Object')
	{
		$builder = $this->db->table($tbl)->select('*');
		if ($returnType == 'array') {
			$data = $builder->where($cond)->get()->getResultArray();
		} else {
			$data = $builder->where($cond)->get()->getRow();
		}
		if ($tbl == 'trust') {
			$data = (array) $data;
			$data = addImageRealPath($data, ['logo_img' => $this->appConstant->trustLogoUploadPath, 'water_mark_img' => $this->appConstant->trustWaterMarkUploadPath]);
		}
		return $data;
	}
	function getUserByCounter($id)
	{
		$builder = $this->db->table('user_login')->select('user_id,fname,user_name,lname,mobile_no,counter_fk_id,counterName,last_token,token_updated_at,token_prefix,token_seperator')
			->join('counter as c', 'c.id=counter_fk_id', 'left');
		return $builder->where(['user_id' => $id])->get()->getRow();
	}

	private function mapQuery($tName, $builder)
	{
		switch ($tName) {
			case 'city':
				$builder->select($tName . '.id as id, ' . $tName . '.status as status');
				$builder->join('state', 'state.id = state_id', 'inner');
				break;
			case 'medicine':
				$builder->select($tName . '.*,' . $tName . '.id as id, ' . $tName . '.status as status');
				$builder->join('medicine_type as t', 't.id = medicine_type_fk_id', 'left');
				break;

			case 'module':
				$builder->select('module_action.id as moduleActionId,module.moduleName,action_name.actionName');
				$builder->join('module_action', 'module_action.module_id = module.id', 'inner');
				$builder->join('action_name', 'action_name.id = module_action.action_id', 'inner');

				break;
			case 'sms_templates':
				$builder->select('sms_templates.*,case when allow_to_send = 1 then "Yes" else "No" end as  allow_to_sendName', false);

				break;
			case 'role_permission':
				$cond = array();
				$builder->join('role', 'role.id = role_permission.role_id', 'inner');
				$builder->join('module_action', 'module_action.module_id = role_permission.moduleActionId', 'inner');
				$builder->join('module', 'module.id = module_action.module_id', 'inner');
				$builder->join('action_name', 'action_name.id = module_action.action_id', 'inner');
				break;

		}
	}

	public function exportExcel($tName, $col, $cond = [])
	{
		$builder = $this->db->table($tName)->select('*');
		$this->mapQuery($tName, $builder);
		if (!empty($cond)) {
			$builder->where($cond);
		}
		$dataResult = [];
		if ($tName == 'field') {
			$result = $this->fieldRepo->findDetail(true, '');
		} else {
			$result = $builder->get()->getResultArray();
		}
		foreach ($result as $k => &$v) {
			$dE['col'] = $v;
			array_push($dataResult, $dE);
		}
		$excelLib = new ExportExcel();
		return $excelLib->export($dataResult, $col);
	}

	public function getData($tName, $cond, $join = false, $ftbl = false)
	{
		$orderByCol;
		if ($tName == 'user_login') {
			$cond = array_merge($cond ?? [], ["is_doctor" => 1]);
		}
		$builder = $this->db->table($tName)->select('*');

		if ($join) {
			$this->mapQuery($tName, $builder);
		}
		foreach ($cond as $key => $value) {
			if (is_array($value)) {
				$builder->whereIn($key, $value);
			} else {
				$builder->where($key, $value);
			}

		}
		if ($ftbl) {
			if (isset($ftbl->queryParams)) {
				if (count($ftbl->queryParams)) {
					foreach ($ftbl->queryParams as $key => $v) {
						if ($v->value) {
							$builder->like($v->colName, $v->value);
						}
					}
				}
			}
			$result['totalRecord'] = $builder->countAllResults('', false);
			if (isset($ftbl->rows) && isset($ftbl->page)) {
				$builder->limit($ftbl->rows, ($ftbl->rows * $ftbl->page));
			}
			if (isset($ftbl->sort)) {
				if (count($ftbl->sort)) {
					foreach ($ftbl->sort as $key => $v) {
						$builder->orderBy($v->colName, $v->sortOrder);
					}
				}
			}
			$result['data'] = $builder->get()->getResultArray();
			if ($tName == 'trust') {
				// $result = (array) $result['data'];
				$result['data'] = addImageRealPath($result['data'], ['logo_img' => $this->appConstant->trustLogoUploadPath]);
			}
			return $result;
		}
		$scol = ['email_template' => 'event_name', 'title' => 'id', 'church' => 'church_name', 'settings' => 'description', 'payroll_head' => 'order_id', 'user_login' => 'fname'];
		foreach ($scol as $k => $v) {
			if ($tName == $k) {
				$orderByCol = $v;
			}
		}
		if ($tName == 'user_login') {
			$builder->where(['deleted_at is Null ' => null]);
		} else {
			$builder->where([$tName . '.status' => 1]);
		}
		$builder->orderBy($orderByCol ?? $tName . 'Name', 'asc');
		//echo $builder->getCompiledSelect();
		return $builder->get()->getResultArray();
	}

	public function updateRolePermission($data, $roleId)
	{
		$builder = $this->db->table('role_permission');
		$builder->delete(['role_id' => $roleId]);
		$result = $builder
			->insertBatch($data);
		return $result;
	}

	public function getAllPermission($roleId)
	{
		return $this->db->table('role_permission')->select('*')
			->join('role', 'role.id = role_permission.role_id', 'inner')
			->join('module_action', 'module_action.module_id = role_permission.moduleActionId', 'inner')
			->join('module', 'module.id = module_action.module_id', 'inner')
			->join('action_name', 'action_name.id = module_action.action_id', 'inner')
			->whereIn('role_id', $roleId)
			->get()->getResultArray();
	}

	public function tableTermsMatch($tbl, $col, $terms)
	{
		$query = $this->db->table($tbl)->select('id')->where('LOWER(' . $col . ')', strtolower($terms))->limit(1)->get()->getResultArray();
		return !empty($query) ? $query[0]['id'] ?? '' : '';
	}
	public function tableSearch($tbl, $col, $terms, $select = '*')
	{
		$query = $this->db->table($tbl)->select($select);
		if ($tbl == 'medicine') {
			$select = 'concat(ifnull(medicine_typeName,""),".",medicineName) as medicineName,' . $select;
			$query->select($select, false)->join('medicine_type as mt', 'mt.id = medicine_type_fk_id', 'left');
		}
		if (is_array($col) && count($col)) {
			$i = 0;
			foreach ($col as $v) {
				if ($i == 0) {
					$query->like($v, $terms, 'both');
				} else {
					$query->orLike($v, $terms, 'both');
				}
				$i++;
			}
		} else {
			if ($tbl == 'medicine') {
				$query->havingLike('medicineName', $terms, 'both');
			} else {
				$query->like($col, $terms, 'both');
			}
		}
		return $query->limit(10)->get()->getResultArray();
	}

	public function countAll($tName, $active = true, $cond = [])
	{
		$builder = $this->db->table($tName)->select('id');
		if ($active) {
			if ($tName == 'user_login') {
				$builder->where($tName . '.deleted_at is null', null);
			} else {
				$builder->where($tName . '.status', 1);
			}
			if (count($cond)) {
				$builder->where($cond);
			}
		}
		return $builder->countAllResults('', false);
	}

	public function showTableColum($tbl)
	{
		$sql = "Show columns from ?";
		$excSql = $this->db->query("Show columns from " . $tbl);
		return $excSql->getResultArray();
	}
	public function getRole()
	{
		$query = $this->db->query('select * from role where isDeleted=0');
		return $query->getResultArray();
	}
	public function getBloodGroup()
	{
		$query = $this->db->query('select * from blood_group where isDeleted=0');
		return $query->getResultArray();
	}
	public function getOtp($mobile_no)
	{
		$query = $this->db->query('select * from otp where mobile_no=? order by created_at desc', [$mobile_no]);
		return $query->getResultArray();
	}
	public function executeQuery($query, $param, $page = null, $rows = 20)
	{
		$query = $this->db->query($query, $param);
		$data = $query->getResultArray();
		$query->freeResult();
		return $data;
	}
	public function getLicence()
	{
		$query = $this->db->query('SELECT * FROM licence LIMIT 1');
		return $query->getResultArray();
	}
	public function updateLicence($req)
	{
		$id = 1;
		$licence_key = $req['licence_key'];
		$start_date = new DateTime();
		$expire_date = clone $start_date;
		$expire_date->modify('+3 months'); // Adding 3 months to the expire date
		$formatted_start_date = $start_date->format('Y-m-d');
		$formatted_expire_date = $expire_date->format('Y-m-d');

		$stmt = $this->db->query("UPDATE licence SET licence_key = ?, start_date = ?, expire_date = ? WHERE id = ?", [$licence_key, $formatted_start_date, $formatted_expire_date, $id]);
		return $stmt;
	}
	public function executeNoResult($query, $param = [])
	{
		return $this->db->query($query, $param);
	}

	public function getAnyPreviousMonthDate($monthsBefore = null, $startDate = null)
	{
		$monthsBefore = $monthsBefore ?? 1; //php7
		$monthsBefore = abs($monthsBefore);
		$c = $startDate ?? date('Y-m-d');
		for ($i = 0; $i < $monthsBefore; $i++) {
			$c = date('Y-m-d', strtotime('last day of previous month ' . $c));
		}
		return $c;
	}

	public function updateHistory($id, $data, $date)
	{
		$sql = 'select id from sponsorship_history where sponsorship_id=? AND DATE_FORMAT(from_date,"%Y-%m") = DATE_FORMAT(?, "%Y-%m")';
		$query = $this->db->query($sql, [$id, $date]);
		$result = $query->getResultArray();
		$builder = $this->db->table('sponsorship_history');
		$expireDate = $this->getAnyPreviousMonthDate(1, $date);
		$fromDate = date("y-m-01", strtotime($date));
		$res = false;
		if (empty($result)) {
			$data['from_date'] = $fromDate;
			$res = $builder->set('expire_date', $expireDate)
				->where('expire_date is Null', null, false)
				->where('sponsorship_id', $id)
				->update();
			$builder->insert($data);
		} else {
			$res = $builder->where('id', $result[0]['id'])
				->update($data);
		}
		return $res;
	}

	public function generateId(string $des)
	{
		$description = (string) '"' . $des . '"';
		$query = $this->db->query('select * from master_config_id where property_name=' . $description . ' limit 1');
		$result = $query->getFirstRow();
		$prf = $result->prefix ?? '';
		$sep = $result->sep ?? '';
		$last_code = $result->last_key ? $result->last_key + 1 : 1;
		$padding = $result->padding ?? 0;
		$month = (string) $result->is_month_append ? date('m') : '';
		$year = (string) $result->is_year_append ? date('y') : '';
		$ext = $prf . $sep . $year . $month;
		$hasRest = false;
		if ($des == 'TOKEN') {
			//check new token
			if (date('Y-m-d') != date('Y-m-d', strtotime($result->last_update_on))) {
				$hasRest = true;
				$last_code = 1;
			}
		}
		$this->updateId($des, $hasRest);
		switch ($des) {
			// case 'ADS_KEY':
			// 	$last_code = sprintf("%03d", $last_code);
			// 	break;
			// case 'i':
			// 	$iquery = $this->db->query('select COUNT(id)+1 as num from items');
			// 	$last_code = $iquery->getResult()[0]->num;
			// 	break;
		}
		$number = sprintf("%0" . $padding . "d", $last_code);
		$code = $ext . $number;
		return $code;
	}

	public function updateId($name, $hasRest = false)
	{
		$builder = $this->db->table('master_config_id');
		if ($hasRest) {
			// $builder->set('month', date('m'), false);
			$builder->set('last_key', 1, false);
		} else {
			$builder->set('last_key', 'last_key+1', false);
		}
		$builder->where('property_name', $name);
		$builder->set('last_update_on', date('Y-m-d H:i:s'));
		$builder->update();
	}

}
