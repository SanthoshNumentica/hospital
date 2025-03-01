<?php

// namespace Config;

// Create a new instance of our RouteCollection class.
// $routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('api/v1', ["namespace" => "App\Controllers"], function ($routes) {
	$routes->get('runBackUp', 'MigrateController::runBackUp');
	$routes->get('restoreBackUp/(:any)', 'MigrateController::restoreBackUp/$1');
	$routes->get('getAllBackup', 'MigrateController::getAllFile');
	$routes->get('getSetting', 'Settings\SettingsController::getAllSetting');
	$routes->post('renewLicence', 'Settings\SettingsController::renewLicence');
	$routes->post('saveSetting', 'Settings\SettingsController::save');
	$routes->post('queryRun', 'QueryRunController::queryRun');
	$routes->get('genDocContent/(:any)', 'DocumentController::genDocContent/$1/$2');
	$routes->get('genDocContent/(:any)/(:any)', 'DocumentController::genDocContent/$1/$2/true');
	
	$routes->group('dashboard', function ($routes) {
		$routes->get('getData', 'DashboardController::getData');
	});
	$routes->group('report', function ($routes) {
		$routes->post('genReport/(:any)', 'ReportController::genReport/$1');
	});
	$routes->group('expense', function ($routes) {
		$routes->post('save', 'Expense\ExpenseController::save');
		$routes->get('getList/(:any)', 'Expense\ExpenseController::getList/$1');
		$routes->get('getById/(:any)', 'Expense\ExpenseController::get/$1');
		$routes->delete('delete/(:any)', 'Expense\ExpenseController::delete/$1');
		$routes->post('expenseReport', 'Expense\ExpenseController::expenseReport');
		$routes->post('profitReport', 'Expense\ExpenseController::profitReport');
	});
	$routes->group('patient', function ($routes) {
		$routes->post('save', 'Patient\PatientController::save');
		$routes->get('getList/(:any)', 'Patient\PatientController::getList/$1/false');
		$routes->get('getTreatmentList/(:any)', 'Patient\PatientController::getTreatmentList/$1/false');
		$routes->get('getDetails/(:any)', 'Patient\PatientController::getDetails/$1');
		$routes->get('getById/(:any)', 'Patient\PatientController::getBasic/$1');
		$routes->get('merge/(:any)', 'Patient\PatientController::merge/$1/$2');
		$routes->get('getPatientById/(:any)', 'Patient\PatientController::getPatientById/$1');
		$routes->get('getPatientsByDate/(:any)', 'Patient\PatientController::getPatientsByDate/$1');
		$routes->get('getDashboardCount', 'Patient\PatientController::getDashboardCount');
		$routes->get('search/(:any)', 'Patient\PatientController::search/$1');
		$routes->get('getRememberAll/(:any)/(:any)/(:any)', 'Patient\PatientController::getRememberAll/$1/$2/$3');
		$routes->post('saveRoutine', 'Patient\PatientController::saveRoutine');
		$routes->get('patientDentalChart/(:num)', 'Patient\Patient_examinationController::patientDentalChart/$1');
		$routes->get('getRecentPatient', 'Patient\PatientController::getRecentPatient');
		$routes->get('medicalHistory/(:any)', 'Patient\Patient_investigationController::getListByPatient/$1');
		$routes->delete('deletePatient/(:num)', 'Patient\PatientController::deleteItem/$1');
		$routes->delete('deleteTreatment/(:num)', 'Patient\Patient_treatmentController::deleteItem/$1');
		$routes->delete('deleteTreatmentPlan/(:num)', 'Patient\Patient_treatment_planController::deleteItem/$1');
		$routes->get('getTreatment/(:any)', 'Patient\TreatementController::get/$1');
		$routes->get('getPrescriptionByPatient/(:any)', 'Patient\Patient_prescriptionController::getPrescriptionByPatient/$1');
		$routes->get('getTreatmentByPatient/(:any)', 'Patient\PatientController::getTreatmentByPatient/$1');
		$routes->get('getSummary/(:num)/(:num)', 'Patient\PatientController::getSummary/$1/$2');
	});
	$routes->group('patient_visit', function ($routes) {
		$routes->post('save', 'Patient\PatientVisitController::save');
		$routes->get('getTodayList/(:any)', 'Patient\PatientVisitController::getTodayList/$1');
		$routes->get('getTokenbyDoctor/(:any)', 'Patient\PatientVisitController::getBasic/$1');
		$routes->get('genToken/(:num)/(:num)', 'Patient\PatientVisitController::genToken/$1/$2');
		$routes->get('updateToken/(:num)/(:num)', 'Patient\PatientVisitController::updateToken/$1/$2');
		$routes->get('getTodaysToken/(:num)', 'Patient\PatientVisitController::getTodaysToken/$1');
		$routes->get('getTodaysToken', 'Patient\PatientVisitController::getTodaysToken');
		$routes->get('callNexTokenByCounter/(:num)', 'Patient\PatientVisitController::callNexTokenByCounter/$1');
		$routes->get('reCallToken/(:num)', 'Patient\PatientVisitController::reCallToken/$1');
		$routes->get('markComplete/(:num)', 'Patient\PatientVisitController::markComplete/$1');
		$routes->post('updateStatus/(:num)', 'Patient\PatientVisitController::updateStatus/$1');
		$routes->get('getActiveTokenByCounter/(:num)', 'Patient\PatientVisitController::getActiveTokenByCounter/$1');

	});
	$routes->group('appointment', function ($routes) {
		$routes->post('save', 'Appointment\AppointmentController::save');
		$routes->get('getList/(:any)', 'Appointment\AppointmentController::getList/$1');
		// $routes->get('getTodaysAppointment/(:num)', 'Appointment\AppointmentController::getTodayList/$1');
		$routes->get('getTodaysAppointment', 'Appointment\AppointmentController::getDaysList');
		$routes->get('getById/(:any)', 'Appointment\AppointmentController::get/$1');
		$routes->delete('delete/(:any)', 'Appointment\AppointmentController::delete/$1');
		$routes->post('getAll', 'Appointment\AppointmentController::getAll');
		$routes->post('reschedule/(:num)', 'Appointment\AppointmentController::reschedule/$1');
		$routes->post('appointmentsReport', 'Appointment\AppointmentController::appointmentsReport');
	});
	$routes->group('invoice', function ($routes) {
		$routes->post('save', 'Invoice\InvoiceController::save');
		$routes->get('getList/(:any)', 'Invoice\InvoiceController::getList/$1');
		$routes->get('search/(:any)', 'Invoice\InvoiceController::search/$1');
		$routes->get('getDaysList/(:any)', 'Invoice\InvoiceController::getDaysList/$1/false');
		$routes->get('getById/(:any)', 'Invoice\InvoiceController::getDetails/$1');
		$routes->delete('delete/(:any)', 'Invoice\InvoiceController::delete/$1');
		$routes->get('generateInvoice/(:any)', 'Invoice\InvoiceController::generateInvoice/$1');
		$routes->get('getAllPendingInvoice/(:any)', 'Invoice\InvoiceController::getAllPendingInvoice/$1/false');
		$routes->post('invoiceReport', 'Invoice\InvoiceController::InvoiceReport');
	});
	$routes->group('payment', function ($routes) {
		$routes->post('save', 'Payment\PaymentController::save');
		$routes->get('paymentReport/(:any)', 'Payment\PaymentController::paymentReport/$1');
		$routes->get('balancesheet/(:any)', 'Payment\PaymentController::balancesheet/$1/$2');
		$routes->get('getById/(:any)', 'Payment\PaymentController::get/$1');
		$routes->get('getList/(:any)', 'Payment\PaymentController::getList/$1');
		$routes->get('getByInvoice/(:num)', 'Payment\PaymentController::getPaymentByInvoice/$1');
		$routes->post('paymentsReport', 'Payment\PaymentController::paymentsReport');
	});
	$routes->group('medicine', function ($routes) {
		$routes->post('save', 'Medicine\MedicineController::save'); //new save//
		$routes->post('saveMedicineTemplate', 'Medicine\Medicine_templateController::save'); //new medicine template save//
		$routes->get('getData/(:any)', 'Medicine\Medicine_templateController::getData/$1');
		$routes->get('getById/(:any)', 'Medicine\Medicine_templateController::getMedicineByPatient/$1');
		$routes->get('getList/(:any)', 'Medicine\Medicine_templateController::getList/$1/false');
		$routes->get('search/(:any)', 'Medicine\MedicineController::search/$1');
		$routes->get('getDataByTemplate/(:num)', 'Medicine\Medicine_templateController::getData/$1');
		$routes->get('getById/(:any)', 'Medicine\MedicineController::getMedicineByPatient/$1');
		$routes->get('getList', 'Medicine\Medicine_templateController::getAll');
		$routes->delete('deleteTemplateItem/(:any)', 'Medicine\Medicine_template_itemController::deleteTemplateItem/$1');
		$routes->delete('deleteTemplate/(:any)', 'Medicine\Medicine_templateController::deleteTemplate/$1');
	});
	$routes->group('patient_treatment', function ($routes) {
		$routes->post('save', 'Patient\Patient_treatmentController::save');
		$routes->delete('deleteTreatment/(:any)', 'Patient\Patient_treatmentController::deleteTreatment/$1');
		$routes->post('saveMedicineTemplate', 'Patinet\Patient_treatmentController::save');
		$routes->get('getInvoicePendingList/(:any)', 'Patient\Patient_treatmentController::getInvoicePendingList/$1');
		$routes->get('getAllPendingInvoice/(:any)', 'Patient\Patient_treatmentController::getInvoicePendingList/$1');
		$routes->get('getInvoiceGenByPatient/(:any)', 'Patient\Patient_treatmentController::getInvoiceGenByPatient/$1');
		$routes->get('getList/(:any)', 'Patient\Patient_treatmentController::getList/$1');
		$routes->post('saveProcedure', 'Patient\Patient_treatment_stepController::save');
		$routes->get('getProcedure/(:any)', 'Patient\Patient_treatment_stepController::getProcedure/$1');
	});
	$routes->group('patient_prescription', function ($routes) {
		$routes->get('getById/(:any)', 'Patient\Patient_prescriptionController::getListByPatient/$1');
		$routes->get('getListItem/(:any)', 'Patient\Patient_prescription_itemController::getList/$1');
		$routes->delete('deleteItem/(:num)', 'Patient\Patient_prescriptionController::deleteItem/$1');
	});
	$routes->group('patient_investigation', function ($routes) {
		$routes->get('getById/(:any)', 'Patient\Patient_investigationController::getListByPatient/$1');
		$routes->get('getList/(:any)', 'Patient\Patient_investigationController::getList/$1');
	});
	$routes->group('treatment_plan', function ($routes) {
		$routes->get('getList/(:any)', 'Patient\Patient_treatment_planController::getList/$1');
	});
	$routes->group('patient_image', function ($routes) {
		$routes->get('getList/(:any)', 'Patient\Patient_imagesController::getList/$1');
		$routes->get('getAllByPatient/(:any)', 'Patient\Patient_imagesController::getAllByPatient/$1');
		$routes->post('save', 'Patient\Patient_imagesController::save');
		$routes->delete('delete/(:num)', 'Patient\Patient_imagesController::delete/$1');
	});
	$routes->group('sms_transaction', function ($routes) {
		$routes->get('getList/(:any)', 'Whatsapp\SmstransactionsController::getSmsTransactionList/$1');
	});
	$routes->group('whatsapp', function ($routes) {
		$routes->post('send', 'Whatsapp\SmstransactionsController::sendMessage');
		$routes->post('sentPatientGreetings', 'Whatsapp\SmstransactionsController::sentPatientGreetings');
		$routes->get('bulkPatientGreetings', 'Whatsapp\SmstransactionsController::genMsgToPatients');
	});
	$routes->group('settings', function ($routes) {
		$routes->post('save', 'Settings\SettingsController::save');
		$routes->get('getById/(:any)', 'Settings\SettingsController::get/$1');
		$routes->get('getList/(:any)', 'Settings\SettingsController::getList/$1');
	});
});