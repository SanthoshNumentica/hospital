<?php

namespace Core\Controllers;

use Config\Services;
use Core\Domain\Exception\RecordNotFoundException;
use Core\Domain\User\UserRepository;
use Core\Libraries\Otp;
use mysqli;
use Core\Models\Logs\LogsModel;
use Core\Models\Utility\UtilityModel;

class Utility extends BaseController
{

	private $repository;
	private $utilityRepo;
	private $LogModel;
	private $appConfig;
	private $otpLib;
	public function __construct()
	{
		helper('Core\Helpers\File');
		helper('Core\Helpers\Utility');
		helper('Core\Helpers\UserAgent');
		$this->initializeFunction();
		$this->utilityRepo = new UtilityModel();
		$this->LogModel = new LogsModel();
		$this->otpLib = new Otp();
		$this->appConfig = new \Config\AppConstant();

		$this->repository = Services::UserRepository();
	}
	public function getCountryPhone()
	{
		$json_url = BASEURL . '/public/countries.json';
		$json = file_get_contents($json_url);
		$data = json_decode($json, true);
		return $this->message(200, $data);
	}

	public function isEmailUnique()
	{

		if ($this->reqMethod == 'post') {
			$data = $this->getDataFromUrl('json');
			$email = $data['email'];
			if ($email) {
				try {
					$data = $this->repository->findUserByUserName($email);
					if (!empty($data)) {
						$data = false;
					} else {
						$data = true;
					}
				} catch (RecordNotFoundException $e) {

					return $this->message(404, $e->getMessage());
				}
				return $this->message(200, $data);
			} else {
				return $this->message(400, null, 'Bad Request');
			}
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}

	public function getRole()
	{
		if (strtolower($this->reqMethod) == 'get') {
			$data = $this->utilityRepo->getRole();
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}
	public function getBloodGroup()
	{
		if (strtolower($this->reqMethod) == 'get') {
			$data = $this->utilityRepo->getBloodGroup();
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}

	public function getById($tbl, $id)
	{
		if (strtolower($this->reqMethod) == 'get') {
			$where = [$tbl . '.id' => $id];
			$data = $this->utilityRepo->getDataById($tbl, $where);
			if (isset($data->id) && $tbl == 'form_purpose') {
				$d = json_decode($data->form_schema);
				$data->form_schema = $d;
			}
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}

	public function saveData($table)
	{
		if (strtolower($this->reqMethod) == 'post') {
			$req_data = $this->getDataFromUrl('json');
			$where = array();
			$masterConfigData = [];
			$emailTemplateData = [];
			switch ($table) {
				case 'email_template':
					$where['id'] = $req_data['template_id'] ?? '';
					$emailTemplateData = [
						'event_name' => $req_data['event_name'] ?? '',
						'subject' => $req_data['subject'] ?? '',
						'body' => $req_data['body'] ?? '',
						'is_attach_pdf' => $req_data['is_attach_pdf'] ?? '0',
						'allow_to_send_email' => $req_data['allow_to_send_email'] ?? '0',
						'allow_send_sms' => $req_data['allow_send_sms'] ?? '0',
					];
					$masterConfigData = [
						'master_config_idName' => $req_data['master_config_idName'] ?? '',
						'last_key' => $req_data['last_key'] ?? '',
						'prefix' => $req_data['prefix'] ?? '',
						'sep' => $req_data['sep'] ?? null,
						'is_year_append' => $req_data['is_year_append'] ?? '0',
						'is_month_append' => $req_data['is_month_append'] ?? '0',
						'padding' => $req_data['padding'] ?? '0',
						'last_update_on' => $req_data['last_update_on'] ?? null,
						'status' => $req_data['status'] ?? '0',
					];
					break;
			}
			if (!empty($where)) {
				$data_p = $this->utilityRepo->getDataById($table, $where);
				if (!empty($data_p)) {
					if (!isset($req_data['template_id']) || $data_p->id != $req_data['template_id']) {
						return $this->message(400, 'Email Template Data Already Exists');
					}
				}
			}
			if (checkValue($req_data, 'template_id')) {
				$emailTemplateData = $this->utilityRepo->updateData($table, $emailTemplateData, ['id' => $req_data['template_id']]);
			} else {
				$emailTemplateData = $this->utilityRepo->addNewData($table, $emailTemplateData);
			}
			if (!empty($masterConfigData)) {
				$masterConfigWhere = ['master_config_idName' => $req_data['master_config_idName'] ?? ''];
				$masterConfigDataExists = $this->utilityRepo->getDataById('master_config_id', $masterConfigWhere);
				if (!empty($masterConfigDataExists)) {
					$this->utilityRepo->updateData('master_config_id', $masterConfigData, $masterConfigWhere);
				} else {
					return $this->message(400, 'Master Config Data Not Found for Update');
				}
			}

			return $this->message(200, ['email_template' => $emailTemplateData, 'master_config_id' => $masterConfigData]);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}
	public function exportData($tName = '')
	{
		$req_data = $this->getDataFromUrl('json');
		return $this->utilityRepo->exportExcel($tName, $req_data);
	}

	public function getData($join, $table, $c1 = array(), $limit = 0)
	{
		$db = \Config\Database::connect();

		// Adjust table name based on conditions
		if ($table == 'doctor') {
			$table = 'user_login';
		}
		if ($table == 'country_code') {
			return $this->getCountryPhone();
		}

		// Handle the email_template case
		if ($table == 'email_template') {
			$emailTemplateData = $this->getEmailTemplateWithMasterConfig();
			return $this->message(200, $emailTemplateData);
		}

		$cond = array();
		if ($c1) {
			$cond = json_decode(utf8_decode(urldecode($c1)));
		}
		$ftbl = false;
		if ($limit !== 0) {
			$ftbl = json_decode(utf8_decode(urldecode($limit)));
		}
		$where = array();
		$tbl = $table;
		$tbl = ($tbl == 'city' || $tbl == 'panchayat') ? 'city' : $tbl;

		switch ($tbl) {
			case 'email_template':
				array_push($where, 'module_id');
				break;
		}

		if (strtolower($this->reqMethod) == 'get') {
			if (count($cond)) {
				$slice = array_slice($where, 0, count($cond));
				$where = [];
				foreach ($cond as $k => $v) {
					$where[$slice[$k]] = $v;
				}
			} else {
				$where = array();
			}
			$key = array_search('all', $cond);
			if ($key < -1) {
				if ($table != 'user_login' && $table != 'church') {
					$where[$table . '.status'] = 1;
				}
			} else if ($key >= 0) {
				if (array_key_exists($key, $cond)) {
					unset($cond[$key]);
				}
			}
			$data = $this->utilityRepo->getData($table, $where, $join, $ftbl);
			return $this->message(200, $data);
		}
	}
	private function getEmailTemplateWithMasterConfig()
{
    $db = \Config\Database::connect();
    $query = $db->query("
        SELECT m.*, e.*
        FROM master_config_id m
        INNER JOIN email_template e ON m.master_config_idName = e.event_name
        WHERE m.master_config_idName IN ('INVOICE', 'RECEIPT','PRESCRIPTION')
    ");
    
    return $query->getResultArray();
}
	public function search($tbl, $terms)
	{
		$col = [$tbl . 'Name'];
		$select = '*';
		switch ($tbl) {
			case 'patient':
				$col = ['f_name', 'mobile_no', 'patient_id'];
				$select = 'patient_id,f_name as patientName,f_name,l_name,id as patient_fk_id,id,gender_fk_id,mobile_no,email_id,address';
				break;
			case 'medicine':
				$col = ['medicine.medicineName'];
				$select = 'medicine.id, description, medicine_typeName, medicine.status as status, medicineName';
				$join = 'LEFT JOIN medicine_type ON medicine.medicine_type__fk_id = medicine_type.id';
				break;
		}
		return $this->message(200, $this->utilityRepo->tableSearch($tbl, $col, $terms, $select), 'success');
	}


	public function save_role_permission($id)
	{
		if (strtolower($this->reqMethod) == 'post') {
			$req_data = $this->getDataFromUrl('json');
			if (isset($req_data['role']) && $id) {
				$data = $this->utilityRepo->updateRolePermission($req_data['role'], $id);
				return $this->message(200, $data);
			} else {
				return $this->message(401, null, 'data required');
			}
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}

	public function savePromotional()
	{
		if (strtolower($this->reqMethod) == 'post') {
			$req_data = $this->getDataFromUrl('json');
			if (!checkValue($req_data, 'promotionalName')) {
				return $this->message(400, null, 'Promotional Name required');
			}
			if (!checkValue($req_data, 'phone')) {
				return $this->message(400, null, 'Phone Number required');
			}

			if (checkValue($req_data, 'promotional_id')) {
				$proData = $this->utilityRepo->getDataById('promotional_office', ['promotional_id' => $req_data['promotional_id']]);
				if (empty($proData)) {
					return $this->message(400, null, 'Promotional Data Not found please check your promotional id');
				}
			}

			if (isset($req_data['promotional_id']) && !empty($req_data['promotional_id'])) {

				$res = $this->utilityRepo->updateData('promotional_office', $req_data, ['promotional_id' => $req_data['promotional_id']]);

				return $this->message($res ? 200 : 400, $req_data, $res ? 'Successfully Saved' : 'Oops Something went to wrong');
			} else {
				$req_data['promotional_id'] = generateKey('PROMOTIONAL_OFFICE');
				$res = $this->utilityRepo->addNewData('promotional_office', $req_data);
				return $this->message($res ? 200 : 400, $req_data, $res ? 'Successfully Saved' : 'Oops Something went to wrong');
			}
		} else {
			return $this->message(401, null, 'Invalid Call');
		}
	}

	public function getAllPermission($role)
	{
		$cond = explode(',', $role);
		$data = $this->utilityRepo->getAllPermission($cond);
		return $this->message(200, $data);
	}

	public function importData()
	{
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$arySt = [
			"uttara" => 20,
			"jammu" => 22,
			"hariyana" => 21,
			"mehalaya" => 23,
			"arunachal" => 24,
			"manipur" => 25,
			"nagaland" => 26,
			"tripura" => 27,
			"mizoram" => 28,
			"delhi" => 29,
			"goa" => 30,
			"andaman" => 31,
			"ladakh" => 32,
			"diu" => 33,
			'asam' => 15,
			"chhattisgarh" => 16,
			"gujarat" => 18,
			"himachal" => 17,
			"odisha" => 12,
			"punjab" => 19,
			"rajasthan" => 13,
			"west_bengal" => 14,
			"chandigar" => 34,
			"lakshdweep" => 35,
			"skkim" => 36
		];

		foreach ($arySt as $arKey => $arValue) {
			$json_url = BASEURL . '/public/' . $arKey . '.json';
			$json = file_get_contents($json_url);
			$data = json_decode($json, true);
			$vArray = array();
			$dArray = array();
			$sArray = array();
			$pArray = array();
			$cArray = array();
			$wArray = array();
			$dataMap = array('country_id' => 1, 'state_id' => $arValue);
			$i = 0;
			foreach ($data as $k => $v) {
				foreach ($v as $key => $value) {
					print_r($value);
					if (!isset($dArray[$value['Dt_Code']])) {
						$districtData = $dataMap;
						$districtData['districtName'] = $value['Dt_Name'];
						$res = $this->utilityRepo->addNewData('district', $districtData);
						$dArray[$value['Dt_Code']] = $res;
					}

					if (!isset($sArray[$value['Sbdt_Code']])) {
						$sub_districtData = $dataMap;
						$sub_districtData['district_id'] = $dArray[$value['Dt_Code']];
						$sub_districtData['subDistrictName'] = $value['Sbdt_Name'];
						$res = $this->utilityRepo->addNewData('subdistrict', $sub_districtData);
						$sArray[$value['Sbdt_Code']] = $res;
					}
					if (isset($value['Pnchyt_Code'])) {
						$pCode = $value['Sbdt_Code'] . '' . $value['Pnchyt_Code'];
						if (!isset($pArray[$pCode])) {
							$panData = $dataMap;
							$panData['district_id'] = $dArray[$value['Dt_Code']];
							$panData['sub_district_id'] = $sArray[$value['Sbdt_Code']];
							$panData['pName'] = $value['Pnchyt_Name'];
							$res = $this->utilityRepo->addNewData('panchayat', $panData);
							$pArray[$pCode] = $res;
						}
					}
					if (isset($value['V_Code'])) {
						if (!isset($vArray[$value['V_Code']])) {
							$pCode = $value['Sbdt_Code'] . '' . $value['Pnchyt_Code'];
							$villageData = $dataMap;
							$villageData['district_id'] = $dArray[$value['Dt_Code']];
							$villageData['sub_district_id'] = $sArray[$value['Sbdt_Code']];
							$villageData['panchayat_id'] = $pArray[$pCode];
							$villageData['vName'] = $value['V_Name'];
							$res = $this->utilityRepo->addNewData('village', $villageData);
							$vArray[$value['V_Code']] = $res;
						}
					}
					if (isset($value['Town_City_Code'])) {
						if (!isset($cArray[$value['Town_City_Code']])) {
							$cityData = $dataMap;
							$cityData['district_id'] = $dArray[$value['Dt_Code']];
							$cityData['sub_district_id'] = $sArray[$value['Sbdt_Code']];
							$cityData['cityName'] = $value['Town_City_Name'];
							$res = $this->utilityRepo->addNewData('city', $cityData);
							$cArray[$value['Town_City_Code']] = $res;
						}
					}

					if (isset($value['Ward_No'])) {
						$wardData = $dataMap;
						$wardData['district_id'] = $dArray[$value['Dt_Code']];
						$wardData['sub_district_id'] = $sArray[$value['Sbdt_Code']];
						$wardData['city_id'] = $cArray[$value['Town_City_Code']];
						$wardData['wardName'] = $value['Ward_Name'];
						$res = $this->utilityRepo->addNewData('ward', $wardData);
						//$vArray[$value['V_Code']]       = $res;
					}
					echo $i++ . " data inserted <br>";
				}
			}
		}
		echo 'imported';
	}

	public function genModule($table, $moduleName, $appName = 'core')
	{
		$tblU = ucwords($table);
		$modU = ucwords($moduleName);
		$db = new UtilityModel($appName == 'core' ? 'app' : $appName);
		$res = $db->showTableColum($table);
		$appNamespace = $appName == 'master' ? 'App' : ucfirst(strtolower($appName));
		$basePath = $appName == 'core' ? APPPATH : ROOTPATH . '/Module/' . ucfirst(strtolower($appName));
		$controllerFilePath = $basePath . "/Controllers/" . $modU . '/' . $tblU . "Controller.php";
		$entityFilePath = $basePath . "/Domain/" . $modU . '/' . $tblU . ".php";
		$entityRepoFilePath = $basePath . "/Domain/" . $modU . '/' . $tblU . "Repository.php";
		$modelFilePath = $basePath . "/Models/" . $modU . '/' . $tblU . "Model.php";
		$modalRepoFilePath = $basePath . "/Infrastructure/Persistence/" . $modU . '/SQL' . $tblU . "Repository.php";
		$entitiyText = '';
		$modalText = '';
		$eliminate = array("created_at", "updated_at", "deleted_at", "id");
		foreach ($res as $key => $value) {
			if (in_array($value['Field'], $eliminate)) {
				continue;
			}
			$entitiyText .= "'" . $value['Field'] . "'=> null,";
			$modalText .= "'" . $value['Field'] . "',";
		}

		$txt = '<?php
namespace "' . $appNamespace . '"\Domain\"' . $modU . '";

use CodeIgniter\Entity;
    class "' . $tblU . '" extends Entity
    {
         protected $attributes = [ "' . $entitiyText . '"
         ];
    }
?>';

		$mtxt = '<?php
namespace "' . $appNamespace . '"\Models\"' . $modU . '";
use CodeIgniter\Model;

    class "' . $tblU . '"Model extends Model
    {
        protected $table      = `"' . $table . '"`;
    protected $primaryKey = `id`;
    protected $returnType = `"' . $appNamespace . '"\Domain\"' . $modU . '"\"' . $tblU . '"`;
    protected $useSoftDeletes = true;
         protected $allowedFields = [ "' . $modalText . '"];
         protected $useTimestamps = true;
    }
?>';

		$repotxt = '<?php
namespace "' . $appNamespace . '"\Domain\"' . $modU . '";

use Core\Domain\DMLRepository;

interface "' . $tblU . '"Repository extends DMLRepository
{

}?>';
		$repoModal = '<?php
namespace "' . $appNamespace . '"\Infrastructure\Persistence\"' . $modU . '";
use Core\Domain\Exception\RecordNotFoundException;
use "' . $appNamespace . '"\Domain\"' . $modU . '"\"' . $tblU . '"Repository;
use "' . $appNamespace . '"\Domain\"' . $modU . '"\"' . $tblU . '";
use Core\Infrastructure\Persistence\DMLPersistence;
use "' . $appNamespace . '"\Models\"' . $modU . '"\"' . $tblU . '"Model;

class SQL"' . $tblU . '"Repository implements "' . $tblU . '"Repository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new "' . $tblU . '"Model();
    }
    public function setEntity($d)
    {
        return new "' . $tblU . '"($d);
    }

}';

		$controllerTxt = '<?php
namespace "' . $appNamespace . '"\Controllers\"' . $modU . '";
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use "' . $appNamespace . '"\Infrastructure\Persistence\"' . $modU . '"\SQL"' . $tblU . '"Repository;

class "' . $tblU . '"Controller extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQL"' . $tblU . '"Repository();
    }
}';
		fileWrite($entityRepoFilePath, $repotxt, ['"']);
		fileWrite($controllerFilePath, $controllerTxt, ['"']);
		fileWrite($modalRepoFilePath, $repoModal, ['"']);
		fileWrite($entityFilePath, $txt, ['"']);
		fileWrite($modelFilePath, $mtxt, ['"', '`'], ['', "'"]);

		foreach ($res as $key => $value) {
			echo '<pre>';
			echo "'" . $value['Field'] . "'=> null,";
			echo '</pre>';
		}
	}

	public function sendEmail()
	{
		$data = $this->getDataFromUrl('json');
	}

	public function generateId($name)
	{
		if (strtolower($this->reqMethod) == 'get') {
			$data = $this->utilityRepo->generateId($name);
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}

	public function exportExcel()
	{
		//$this->load->helper('download');

		$filename = "website_data_" . date('Ymd') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");

		$flag = false;
		$data = $this->utilityRepo->getData('zone', []);
		foreach ($data as $row) {
			if (!$flag) {
				// display field/column names as first row
				echo implode("\t", array_keys($row)) . "\r\n";
				$flag = true;
			}
			array_walk($row, __NAMESPACE__ . '\cleanData');
			echo implode("\t", array_values($row)) . "\r\n";
		}
		flush();
		readfile($filename);
		exit;
	}

	public function sendOTP($mobile_no, $type)
	{
		$otp = $this->otpLib->generate($mobile_no, $type);
		return $this->message($otp['result'] == true ? 200 : 400, $otp, $otp['response'] ?? 'OTP Generated');
	}
	public function resendOTP($mobile_no, $type)
	{
		$otp = $this->otpLib->reSend($mobile_no, $type);
		return $this->message($otp['result'] == true ? 200 : 400, $otp, $otp['response']);
	}
	public function getAppVersion()
	{
		$rows = $this->utilityRepo->executeQuery('Select * from settings where description =? or description =?', ['APP_VERSION', 'BLOCK_LIST'])->getResultArray() ?? [];
		$data = [];
		foreach ($rows as $key => $v) {
			if ($v['description'] == 'BLOCK_LIST') {
				$b = explode(',', $v['value'] ?? '');
				$data['blockList'] = [];
				foreach ($b as $k => $v) {
					$mobile_no = trimMobileNumber($v, true);
					$mobile_no = '91' . $mobile_no;
					array_push($data['blockList'], $mobile_no);
				}
			} else if ($v['description'] == 'APP_VERSION') {
				if (!empty($v['value'])) {
					$data['appVersion'] = json_decode($v['value'], true);
				}
			}
		}
		return $this->message($data == true ? 200 : 400, $data, 'Success');
	}

	public function cleanData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
	}

	public function uploadTempFile()
	{
		$data = array();
		if (strtolower($this->reqMethod) == 'post') {
			$imagefile = $this->request->getFiles();
			if ($imagefile) {
				if (validatFileExtension($imagefile)) {
					if (!validateSize($imagefile)) {
						return $this->message(400, null, 'File size exceed..');
					}
				} else {
					return $this->message(400, null, 'File type Not Allowed..');
				}
			}
			$tempPath = getTempPath();
			//foreach ($imagefile['files'] as $img) {
			$fileName = uploadFile($imagefile['files'], $tempPath);
			$data['file_name'] = $fileName;
			$data['file_path'] = getFilePath($tempPath, $fileName);
			//}
			return $this->message(200, $data);
		} else {
			return $this->message(400, null, 'Method Not Allowed');
		}
	}
	private $masterTables = [
		'action_name',
		'blood_group',
		'city',
		'counter',
		'examination',
		'expense_type',
		'gender',
		'illness',
		'master_config_id',
		'medicine',
		'medicine_dosage',
		'medicine_duration',
		'medicine_frequency',
		'medicine_type',
		'module',
		'payment_type',
		'role',
		'sms_templates',
		'state'
	];

	public function generateMigrations()
	{
		$db = \Config\Database::connect();
		$tables = $db->listTables();
		$successTables = [];
		$failedTables = [];

		// Clear existing migrations
		$this->clearMigrationFiles();

		foreach ($tables as $table) {
			try {
				$fields = $db->getFieldData($table);
				$isMasterTable = $this->isMasterTable($table);
				$this->createMigrationFile($table, $fields, $isMasterTable);
				$successTables[] = $table;
			} catch (\Exception $e) {
				$failedTables[] = $table;
			}
		}
		// Output success and failed tables
		return $this->message(200, [
			'successTables' => $successTables,
			'failedTables' => $failedTables,
		], 'Migration generation completed.');
	}

	private function isMasterTable($table)
	{
		return in_array($table, $this->masterTables);
	}

	private function createMigrationFile($table, $fields, $isMasterTable)
	{
		$migrationName = "Create" . ucfirst($table) . "Table";
		$filename = APPPATH . 'Database/Migrations/' . $migrationName . '.php';
		$content = "<?php\n\n";
		$content .= "namespace App\Database\Migrations;\n\n";
		$content .= "use CodeIgniter\Database\Migration;\n\n";
		$content .= "class $migrationName extends Migration\n{\n";
		$content .= "    public function up()\n    {\n";
		$content .= "        \$this->forge->addField([\n";

		foreach ($fields as $field) {
			$fieldType = $this->getFieldType($field);
			$content .= "            '{$field->name}' => [\n";
			$content .= "                'type' => '$fieldType',\n";
			$content .= "                'constraint' => " . ($field->max_length ?? 'null') . ",\n";
			$content .= "                'null' => " . ($field->nullable ? 'true' : 'false') . ",\n";
			$content .= "            ],\n";
		}

		$content .= "        ]);\n";
		$content .= "        \$this->forge->addKey('id', true);\n";
		$content .= "        \$this->forge->createTable('$table');\n";

		if ($isMasterTable) {
			$data = $this->getMasterTableData($table);
			$content .= "\n        // Insert initial data\n";
			$content .= "        \$this->db->table('$table')->insertBatch(" . var_export($data, true) . ");\n";
		}

		$content .= "    }\n\n";
		$content .= "    public function down()\n    {\n";
		$content .= "        \$this->forge->dropTable('$table');\n";
		$content .= "    }\n";
		$content .= "}\n";

		file_put_contents($filename, $content);
	}

	private function clearMigrationFiles()
	{
		$migrationPath = APPPATH . 'Database/Migrations/';
		$files = glob($migrationPath . '*.php'); // Get all migration files
		foreach ($files as $file) {
			unlink($file); // Delete each file
		}
	}

	private function getFieldType($field)
	{
		// Map field types to CodeIgniter types
		switch ($field->type) {
			case 'int':
				return 'INT';
			case 'varchar':
				return 'VARCHAR';
			case 'datetime':
				return 'DATETIME';
			default:
				return 'VARCHAR';
		}
	}

	private function getMasterTableData($table)
	{
		$db = \Config\Database::connect();
		return $db->table($table)->get()->getResultArray();
	}
	public function migrateDatabase()
{
    // Increase maximum execution time for this script
    set_time_limit(3000);  // 300 seconds (50 minutes)

    // Local Database Credentials
    $localHost = getenv('LOCAL_DB_HOST') ?: "localhost";
    $localUser   = getenv('LOCAL_DB_USER') ?: "root";
    $localPass = getenv('LOCAL_DB_PASS') ?: "";
    $localDbName = getenv('LOCAL_DB_NAME') ?: "admin_iem_new_prod";

    // Development Database Credentials
    $devHost = getenv('DEV_DB_HOST') ?: "iemdbserver.mysql.database.azure.com";
    $devUser   = getenv('DEV_DB_USER') ?: "iem_admin";
    $devPass = getenv('DEV_DB_PASS') ?: "Admin@123";
    $devDbName = getenv('DEV_DB_NAME') ?: "iem";

    // Connect to Local Database
    $localDb = new mysqli($localHost, $localUser  , $localPass, $localDbName);
    if ($localDb->connect_error) {
        die(json_encode(["error" => "Local Database Connection Failed: " . $localDb->connect_error]));
    }

    // Connect to Development Database
    $devDb = new mysqli($devHost, $devUser  , $devPass, $devDbName);
    if ($devDb->connect_error) {
        die(json_encode(["error" => "Development Database Connection Failed: " . $devDb->connect_error]));
    }

    // Fetch all tables from Local Database
    $tables = [];
    $result = $localDb->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    // Disable foreign key checks before dropping tables
    $this->executeQuery($devDb, "SET FOREIGN_KEY_CHECKS = 0");

    // Drop existing tables in Development Database
    foreach ($tables as $table) {
        $this->executeQuery($devDb, "DROP TABLE IF EXISTS `$table`");
    }

    // Enable foreign key checks after dropping tables
    $this->executeQuery($devDb, "SET FOREIGN_KEY_CHECKS = 1");

    // Create tables in Development Database
    foreach ($tables as $table) {
        // Get CREATE TABLE statement from Local Database
        $createTable = $localDb->query("SHOW CREATE TABLE `$table`")->fetch_assoc();
        $this->executeQuery($devDb, $createTable['Create Table']);
    }

    echo json_encode(["success" => "Database structure migration completed successfully."]);

    // Close connections
    $localDb->close();
    $devDb->close();
}

private function executeQuery($db, $query)
{
    if (!$db->query($query)) {
        die(json_encode(["error" => "Query Failed: " . $db->error]));
    }
}

}
