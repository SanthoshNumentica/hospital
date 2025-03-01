<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// /*
//  * --------------------------------------------------------------------
//  * Router Setup
//  * --------------------------------------------------------------------
//  */

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('api/v1', ["namespace" => "Core\Controllers"], function ($routes) {
	$routes->get('search/(:any)/(:any)', 'Utility::search/$1/$2');
	$routes->get('initSocket', 'NotificationController::initSocket');
	$routes->get('runServer/(:num)', 'NotificationController::runServer/$1');
	$routes->get('sendMessage/(:any)', 'NotificationController::sendMessage/$1');
	$routes->post('uploadFile', 'Utility::uploadTempFile');
	$routes->get('exportExcel', 'Utility::exportExcel');
	$routes->add('get/(:any)', 'Utility::getData/false/$1');
	$routes->get('genModule/(:any)/(:any)', 'Utility::genModule/$1/$2');
	$routes->get('getAppVersion', 'Utility::getAppVersion');
	$routes->get('getCountryPhone', 'Utility::getCountryPhone');
	$routes->get('getbloodGroup', 'Utility::getBloodGroup');
	$routes->add('genEmail/(:any)', 'EmailController::generateEmail/$1');
	$routes->add('genEmail', 'EmailController::generateEmail');
	$routes->add('preview_pdf/(:any)', 'EmailController::preview_pdf/$1');
	$routes->post('preview_pdf', 'EmailController::preview_pdf');
	$routes->add('getfull/(:any)', 'Utility::getData/true/$1');
	$routes->add('saveData/(:any)', 'Utility::saveData/$1');
	$routes->add('getById/(:any)/(:any)', 'Utility::getById/$1/$2');
	$routes->add('importData', 'Utility::importData');
	$routes->add('getAllPermission/(:any)', 'Utility::getAllPermission/$1');
	$routes->post('exportData/(:any)', 'Utility::exportData/$1');
	$routes->get('sendOTP/(:any)/(:any)', 'Utility::sendOTP/$1/$2');
	$routes->get('resendOTP/(:any)/(:any)', 'Utility::resendOTP/$1/$2');
	$routes->get('generateMigrations', 'Utility::generateMigrations');
	$routes->get('migrateDatabase', 'Utility::migrateDatabase');
	$routes->group('role', function ($routes) {
		$routes->get('getPermission/(:any)', 'RoleController::PermissionByRole/$1');
		$routes->get('getPermissionFull/(:any)', 'RoleController::PermissionByRole/$1/true');
		$routes->get('getPermissionByUser/(:any)', 'RoleController::getPermissionByUser/$1');
		// $routes->get('getAllPermission', 'RoleController::getAllPermission/$1');
		$routes->post('updatePermission/(:any)', 'RoleController::updatePermission/$1');
	});

	$routes->group('Auth', function ($routes) {
		$routes->post('login', 'Auth::login');
		$routes->post('loginMobile', 'Auth::login/MOBILE');
		$routes->add('forgotPassword/(:any)', 'Auth::forgotPassword/$1');
		$routes->post('changePassword', 'Auth::changePassword');
		$routes->post('getToken', 'Auth::genToken');
		$routes->post('updateStats', 'Auth::updateStats');
		$routes->post('loginVerifyOtp', 'Auth::loginVerifyOtp');
	});
	$routes->group('users', function ($routes) {
		$routes->post('saveUser', 'UsersController::addUser');
		$routes->get('isUnique/(:any)/(:any)', 'UsersController::isUnique/$1/$2');
		$routes->get('isMobileUnique/(:any)', 'UsersController::isUnique/mobile_no/$1');
		$routes->add('getUserByUserName/(:any)', 'UsersController::getUserByUserName/$1');
		$routes->add('getUserDetails/(:any)', 'UsersController::getUserDetail/$1');
		$routes->get('getUserAll/(:any)', 'UsersController::UserListing/$1');
		$routes->get('getAllInactive/(:any)', 'UsersController::UserListing/$1/false');
		$routes->delete('deleteUser/(:any)', 'UsersController::deleteUser/$1');
		$routes->put('makeActive/(:any)', 'UsersController::makeActive/$1');
	});
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
//$appName = ucfirst(strtolower(BASEAPP));
// if (is_file(MODULE_PATH . $appName . '/Config/' . 'Routes.php')) {
//     require MODULE_PATH . $appName . '/Config/' . 'Routes.php';
// }
