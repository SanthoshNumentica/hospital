<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use Config\Services;
// use Core\Events\LogQueryEvent;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */
$log = Services::LogQueryEvent();
$queryResult = [];
Events::on('DBQuery', [$log, 'log_queries'], HOOKS_PRIORITY_NORMAL);
Events::on('post_system', [$log, 'addLog'], HOOKS_PRIORITY_NORMAL);
// Events::on('DBQuery', static function (\CodeIgniter\Database\Query $query) {
// 	$res = $log::log_queries($query);

// }
// );
// Events::on('post_controller_constructor', static function ($query) {
// 	print_r($query);
// 	echo 'post';

// }
// );
Events::on('pre_system', static function () {
	if (ENVIRONMENT !== 'testing') {
		if (ini_get('zlib.output_compression')) {
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0) {
			ob_end_flush();
		}

		ob_start(static fn($buffer) => $buffer);
	}

	/*
		     * --------------------------------------------------------------------
		     * Debug Toolbar Listeners.
		     * --------------------------------------------------------------------
		     * If you delete, they will no longer be collected.
	*/
	if (CI_DEBUG && !is_cli()) {
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
		Services::toolbar()->respond();
	}
});
