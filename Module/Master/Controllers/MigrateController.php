<?php

namespace App\Controllers;

use Core\Controllers\BaseController;
use Core\Libraries\DbBackup;

class MigrateController extends BaseController {
	public function __construct() {
		helper('array');
	}

	public function index() {
		$migrate = \Config\Services::migrations();

		try
		{
			//$migrate->regress(0);
			$migrate->latest();
			echo 'migration successfully';
		} catch (\Throwable $e) {
			print_r($e);
			// Do something with the error here...
		}
	}

	public function runBackUp() {
		$bckLib = new DbBackup();
		return $bckLib->backupTables();
	}
	public function restoreBackUp($file) {
		$bckLib = new DbBackup();
		$bckLib->setFileName($file);
		return $bckLib->restoreDb();
	}
	public function getAllFile() {
		$bckLib = new DbBackup();
		$d = $bckLib->getAllFile();
		// $data['totalRecord'] = count($d);
		$data = [];
		foreach ($d as $v) {
			$f = explode('.', $v)[0] ?? '';
			$pattern = '/(\d{4})(\d{2})(\d{2})/';
			$dateString = '';
			if (preg_match($pattern, $f, $matches)) {
				$year = $matches[1];
				$month = $matches[2];
				$day = $matches[3];
				$dateString = $year . '-' . $month . '-' . $day;
			}
			$timeString = explode('_', $f);
			$timeString = end($timeString);
			$pattern = '/(\d{2})(\d{2})(\d{2})/';
			if (preg_match($pattern, $timeString, $matches)) {
				$h = $matches[1];
				$min = $matches[2];
				$sec = $matches[3];
				$dateString .= ' ' . $h . ':' . $min . ':' . $sec;
			}
			array_push($data, ['file' => $v, 'fileName' => $f, 'created_at' => $dateString]);
		}

		array_sort_by_multiple_keys($data, [
			'created_at' => SORT_DESC,
		]);
		return $this->message(200, $data, '');
	}

}
