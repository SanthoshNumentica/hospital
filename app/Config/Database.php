<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config {
	/**
	 * The directory that holds the Migrations
	 * and Seeds directories.
	 */
	public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

	/**
	 * Lets you choose which connection group to
	 * use if no other is specified.
	 */
	public string $defaultGroup = 'default';

	/**
	 * The default database connection.
	 */
	public array $default = [
		'DSN' => '',
		'hostname' => 'localhost',
		'username' => DB_USERNAME,
		'password' => DB_PASSWORD,
		'database' => '',
		'DBDriver' => 'MySQLi',
		'DBPrefix' => '',
		'pConnect' => false,
		'DBDebug' => ENVIRONMENT == 'production' ? false : true,
		'charset' => 'utf8',
		'DBCollat' => 'utf8_general_ci',
		'swapPre' => '',
		'encrypt' => false,
		'compress' => true,
		'strictOn' => false,
		'failover' => [],
		'port' => 3306,
		// 'save_queries' => true,
	];
	public array $payroll = [];
	public array $master = [];
	public array $mail = [];
	public array $process = [];
	/**
	 * This database connection is used when
	 * running PHPUnit database tests.
	 */
	public array $tests = [
		'DSN' => '',
		'hostname' => '127.0.0.1',
		'username' => '',
		'password' => '',
		'database' => ':memory:',
		'DBDriver' => 'SQLite3',
		'DBPrefix' => 'db_', // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
		'pConnect' => false,
		'DBDebug' => true,
		'charset' => 'utf8',
		'DBCollat' => 'utf8_general_ci',
		'swapPre' => '',
		'encrypt' => false,
		'compress' => false,
		'strictOn' => false,
		'failover' => [],
		'port' => 3306,
		'foreignKeys' => true,
		'busyTimeout' => 1000,
	];

	public function __construct() {
		parent::__construct();
		$aryDb = ['master' => MASTER_DB_NAME];
		foreach ($aryDb as $k => $v) {
			$this->{$k} = $this->default;
			$this->{$k}['database'] = $v;
			// code...
		}
		$this->defaultGroup = strtolower(BASEAPP);
		// Ensure that we always set the database group to 'tests' if
		// we are currently running an automated test suite, so that
		// we don't overwrite live data on accident.
	}
}
