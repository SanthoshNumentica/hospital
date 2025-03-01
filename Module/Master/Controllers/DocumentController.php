<?php
namespace App\Controllers;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Libraries\MessageSender;

class DocumentController extends BaseController {
	use DMLController;
	private $pdf;
	public function __construct() {
		$this->initializeFunction();
		// $this->pdf = new PDF();
	}

	public function index() {}

	function genDocContent($eventName, $id,$is_pdf=false) {
		// print_r($eventName);
		// return;
		$msgRepo = new MessageSender();
		$data['body'] = $msgRepo->genDocument($eventName, ['id' => $id],$is_pdf);
		return $this->message(200, $data, 'success');
	}
}
