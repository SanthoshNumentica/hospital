<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppConstant extends BaseConfig {

	public $password_encrept_key = 'abcdefghtjklmnopqrstuvwxyz1234567890';
	public $jwt_key = 'ddfgdjgjiodniduo';
	public $expireTimeInteravel = 4 * 3600; // 4h
	public $paginationPerPage = 15;
	public $app_name = ['ADMIN_APP_WEB', 'MOBILE_APP_STAFF', 'MOBILE_APP_SPONSOR', 'API', 'CLIENT_SERVER'];
	public $userUploadPath = 'uploads/user/';
	public $uploadPath = 'uploads/';
	public $patientImagesPath = 'uploads/patient/';
	public $companyUploadPath = 'uploads/company/';
	public $expenseUploadPath = 'uploads/expense/';
	public $activityPath = 'uploads/activity/';
	public $serverPathUpload;
	public $TEM_PATH = 'uploads/temp/';
	public $TOKEN_REMOTE_ACCESS = 'YMsIVVsthyRIknXFpOnqkxnqqOYxW6nv_duANIEdB_g';
	public $LOG_STATUS = array('ERROR' => '0', 'INFO' => '1', 'CRITICAL_ERROR' => '4', 'ALERT' => '3', 'WARNING' => '2');
	public $ERROR_LOG_ENABLE = true;
	public $INFO_LOG_ENABLE = true;
	public $WARNING_LOG_ENABLE = true;
	public $OTP_TRIES = 3;
	public $OTP_VALID = 5; // 5mints
	public $mobileAppPath = 'uploads/app/apk';

}
define('APPKEY', '6e20f87b-1441-4667-bc13-f30a5bb68e4e');
define('AUTHKEY', 'no1GWuva2aRdt5TeXqjTSuXQMD73AO4Pb3uBy5dOjD4FLiPEo2');
