<?php
namespace Core\Controllers;

use Core\Libraries\SocketConnetion;

class NotificationController extends BaseController {
	private $socketConnetionLib;
	public function __construct() {
		helper('Core\Helpers\Task');
		$this->initializeFunction();
		$this->socketConnetionLib = new SocketConnetion();
	}
	function runServer($id) {
		return $this->socketConnetionLib->init();
	}
	function initSocket() {
		$res = addTask('runServer', 'Socket Initiation', 1, '');
		return $this->message(200, $res, 'success');
	}
	function sendMessage($msg) {
		$this->socketConnetionLib->init();
		$this->socketConnetionLib->send($msg);
		return $this->message(200, null, 'success');
	}
}