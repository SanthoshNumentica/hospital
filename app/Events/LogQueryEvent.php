<?php
namespace Core\Events;
use CodeIgniter\Events\Events;

class LogQueryEvent {
	private static $array_query = [];
	public static function log_queries(\CodeIgniter\Database\Query $queryObj) {
		$db = \Config\Database::connect();
		$query = $queryObj->getQuery();
		if ($queryObj->isWriteType() && !$queryObj->hasError()) {
			$tblName = self::findTableName($query);
			// echo ' table Name ' . self::findTableName($query) . '<br>';
			if ($query && in_array($tblName, ['db_query_log', 'smstransactions'])) {
				return true;
			}
			// save into log
			$lastInsertId = $db->insertID();
			if ($lastInsertId) {
				// echo " inser id " . $lastInsertId;
				$col = $tblName != 'user_login' ? 'id' : 'user_id';
				$query = self::addOnecolumToInsert($query, $col, $lastInsertId);
			}
			// print_r($query);
			array_push(self::$array_query, $query);
			// return $query;
			// $db->table('db_query_log')->insert(['db_query' => $query]);
			// Events::simulate(false);
		}
		// array_push(self::$array_query, $query);
		return false;
	}

	static function addLog() {
		// print_r(self::$array_query);
		$queries = self::$array_query;
		$db = \Config\Database::connect();
		Events::simulate(true);
		foreach ($queries as $key => $vq) {
			$db->table('db_query_log')->insert(['db_query' => $vq]);
		}
		// if(!empty(self::array_query()))
	}

	protected function str_replace_first($search, $replace, $subject) {
		$search = '/' . preg_quote($search, '/') . '/';
		return preg_replace($search, $replace, $subject, 1);
	}

	protected static function findTableName($query) {
		// Use regular expression to match the table name
		$matches = [];

		// Regular expression patterns for INSERT, UPDATE, and DELETE queries
		$patterns = [
			'/INSERT INTO `([^`]+)`/i',
			'/UPDATE `([^`]+)`/i',
			'/DELETE FROM `([^`]+)`/i',
		];

		foreach ($patterns as $pattern) {
			if (preg_match($pattern, $query, $matches)) {
				// The table name is captured in the first capturing group
				return $matches[1];
			}
		}
		// Return null if no match is found
		return null;
	}

	static function replaceLastOccurrence($search, $replace, $subject) {
		$pos = strrpos($subject, $search);
		if ($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}

	protected static function addOnecolumToInsert($query, $colName = 'id', $colValue = '') {
		$query = substr_replace($query, ", `$colName`", strpos($query, ')'), 0);
		$replace = ',' . $colValue . ')';
		$query = self::replaceLastOccurrence(')', $replace, $query);
		// $query = substr_replace($query, ", $colValue", strpos($query, ')'), 0);
		return $query;
	}
}
