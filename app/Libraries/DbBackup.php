<?php
namespace Core\Libraries;
use Core\Models\Utility\UtilityModel;

/**
 * Define database parameters here
 */
define("TABLES", '*'); // Full backup
//define("TABLES", 'table1, table2, table3'); // Partial backup
define('IGNORE_TABLES', array(
	'smstransactions',
	'db_query_log', 'illness',
	'app_logs',
)); // Tables to ignore
define("CHARSET", 'utf8');

// Also number of rows per INSERT statement in backup file
class DbBackup {
	private $response;
	private $batchSize;
	private $disableForeignKeyChecks;
	private $gzipBackupFile;
	private $backupDir;
	private $utilityModel;
	private $backupFile;
	private $dbName;
	private $output = '';
	public function __construct() {
		// helper('Core\Helpers\Date');
		$this->response = \Config\Services::response();
		$this->utilityModel = new UtilityModel();
		$this->batchSize = 1000; // Batch size when selecting rows from database in order to not exhaust system memory
		$this->disableForeignKeyChecks = true; // Set to true if you are having foreign key constraint fails
		$this->gzipBackupFile = true; // Set to false if you want plain SQL backup files (not gzipped)
		$this->backupDir = 'uploads/backup/';
		$this->dbName = MASTER_DB_NAME;
		$this->backupFile = 'clinic-backup-' . date("Ymd_His", time()) . '.sql';
	}
	public function setFileName($file) {
		$this->backupFile = $file . '.sql.gz';
	}
	/**
	 * Backup the whole database or just some tables
	 * Use '*' for whole database or 'table1 table2 table3...'
	 * @param string $tables
	 */
	public function backupTables($tables = '*') {
		try {
			/**
			 * Tables to export
			 */
			if ($tables == '*') {
				$tables = array();
				// $result = mysqli_query($this->conn, 'SHOW TABLES');
				$tables = $this->utilityModel->executeQuery('SHOW TABLES', []);
				// $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));

				$sql = 'CREATE DATABASE IF NOT EXISTS `' . $this->dbName . '`' . ";\n\n";
				$sql .= 'USE `' . $this->dbName . "`;\n\n";

				/**
				 * Disable foreign key checks
				 */
				if ($this->disableForeignKeyChecks === true) {
					$sql .= "SET foreign_key_checks = 0;\n\n";
				}

				/**
				 * Iterate tables
				 */
				foreach ($tables as $t) {
					$table = $t['Tables_in_' . $this->dbName];
					if (in_array($table, IGNORE_TABLES)) {
						continue;
					}

					$this->obfPrint("Backing up `" . $table . "` table..." . str_repeat('.', 50 - strlen($table)), 0, 0);

					/**
					 * CREATE TABLE
					 */
					$sql .= 'DROP TABLE IF EXISTS `' . $table . '`;';
					$row = $this->utilityModel->executeQuery('SHOW CREATE TABLE `' . $table . '`', [])[0];
					$sql .= "\n\n" . $row['Create Table'] . ";\n\n";

					/**
					 * INSERT INTO
					 */

					// $row =  mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `'.$table.'`'));
					$numRows = $this->utilityModel->countAll($table, false);
					if ($numRows) {

						$cols = $this->utilityModel->showTableColum($table);
						$colAr = [];
						foreach ($cols as $ck => $cv) {
							array_push($colAr, $cv['Field']);
						}
						$sql .= 'INSERT INTO `' . $table . '` (' . implode(',', $colAr) . ') ';
						// Split table in batches in order to not exhaust system memory
						$numBatches = intval($numRows / $this->batchSize) + 1; // Number of while-loop calls to perform
						for ($i = 0; $i <= ceil($numRows / $this->batchSize); $i++) {
							$db = $this->utilityModel->get_db();
							$query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($i * $this->batchSize) . ',' . $this->batchSize;
							$result = $this->utilityModel->executeQuery($query, []);
							if (!empty($result)) {

								$valAr = [];
								foreach ($result as $key => $row) {
									$vR = [];
									foreach ($colAr as $ck => $cv) {
										// code...
										if (isset($row[$cv])) {
											$row[$cv] = addslashes($row[$cv]);
											$row[$cv] = str_replace("\n", "\\n", $row[$cv]);
											$row[$cv] = str_replace("\r", "\\r", $row[$cv]);
											$row[$cv] = str_replace("\f", "\\f", $row[$cv]);
											$row[$cv] = str_replace("\t", "\\t", $row[$cv]);
											$row[$cv] = str_replace("\v", "\\v", $row[$cv]);
											$row[$cv] = str_replace("\a", "\\a", $row[$cv]);
											$row[$cv] = str_replace("\b", "\\b", $row[$cv]);
											if ($row[$cv] == 'true') {
												$row[$cv] = 'true';
											} else if ($row[$cv] == 'false') {
												$row[$cv] = 'false';
											} else if (preg_match('/^-?[1-9][0-9]*$/', $row[$cv])) {
												$row[$cv] = $row[$cv];
											} else if ($row[$cv] == 'NULL' || $row[$cv] == 'null' || $row[$cv] == null) {
												$row[$cv] = 'NULL';
											} else {
												$row[$cv] = '"' . $row[$cv] . '"';
											}

										} else {
											$row[$cv] = 'NULL';
										}
										//on each col
										array_push($vR, $row[$cv]);
									}
									$s = '(' . implode(',', $vR) . ')';
									array_push($valAr, $s);
								}

							}
						}
						$sql .= 'VALUES ' . implode(',', $valAr) . ';';
					}
					$sql .= "\n";
					// $this->saveFile($sql);
				}

				/**
				 * CREATE TRIGGER
				 */

				// Check if there are some TRIGGERS associated to the table
				/*$query = "SHOW TRIGGERS LIKE '" . $table . "%'";
					                $result = mysqli_query ($this->conn, $query);
					                if ($result) {
					                    $triggers = array();
					                    while ($trigger = mysqli_fetch_row ($result)) {
					                        $triggers[] = $trigger[0];
					                    }

					                    // Iterate through triggers of the table
					                    foreach ( $triggers as $trigger ) {
					                        $query= 'SHOW CREATE TRIGGER `' . $trigger . '`';
					                        $result = mysqli_fetch_array (mysqli_query ($this->conn, $query));
					                        $sql.= "\nDROP TRIGGER IF EXISTS `" . $trigger . "`;\n";
					                        $sql.= "DELIMITER $$\n" . $result[2] . "$$\n\nDELIMITER ;\n";
					                    }

					                    $sql.= "\n";

					                    $this->saveFile($sql);
					                    $sql = '';
				*/

				$sql .= "\n\n";

				$this->obfPrint('OK');
			}

			/**
			 * Re-enable foreign key checks
			 */
			if ($this->disableForeignKeyChecks === true) {
				$sql .= "SET foreign_key_checks = 1;\n";
			}

			$this->saveFile($sql);

			if ($this->gzipBackupFile) {
				$this->gzipBackupFile();
			} else {
				$this->obfPrint('Backup file succesfully saved to ' . $this->backupDir . '/' . $this->backupFile, 1, 1);
			}
		} catch (Exception $e) {
			print_r($e->getMessage());
			return false;
		}

		return true;
	}

	protected function saveFile(&$sql) {
		if (!$sql) {
			return false;
		}

		try {

			if (!file_exists($this->backupDir)) {
				mkdir($this->backupDir, 0777, true);
			}

			file_put_contents($this->backupDir . '/' . $this->backupFile, $sql, FILE_APPEND | LOCK_EX);

		} catch (Exception $e) {
			print_r($e->getMessage());
			return false;
		}

		return true;
	}

	public function obfPrint($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
		if (!$msg) {
			return false;
		}

		if ($msg != 'OK' and $msg != 'KO') {
			$msg = date("Y-m-d H:i:s") . ' - ' . $msg;
		}
		$output = '';

		if (php_sapi_name() != "cli") {
			$lineBreak = "<br />";
		} else {
			$lineBreak = "\n";
		}

		if ($lineBreaksBefore > 0) {
			for ($i = 1; $i <= $lineBreaksBefore; $i++) {
				$output .= $lineBreak;
			}
		}

		$output .= $msg;

		if ($lineBreaksAfter > 0) {
			for ($i = 1; $i <= $lineBreaksAfter; $i++) {
				$output .= $lineBreak;
			}
		}

		// Save output for later use
		$this->output .= str_replace('<br />', '\n', $output);

		echo $output;

		if (php_sapi_name() != "cli") {
			if (ob_get_level() > 0) {
				ob_flush();
			}
		}

		$this->output .= " ";

		flush();
	}

	protected function gzipBackupFile($level = 9) {
		if (!$this->gzipBackupFile) {
			return true;
		}

		$source = $this->backupDir . '/' . $this->backupFile;
		$dest = $source . '.gz';

		$this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);

		$mode = 'wb' . $level;
		if ($fpOut = gzopen($dest, $mode)) {
			if ($fpIn = fopen($source, 'rb')) {
				while (!feof($fpIn)) {
					gzwrite($fpOut, fread($fpIn, 1024 * 256));
				}
				fclose($fpIn);
			} else {
				return false;
			}
			gzclose($fpOut);
			if (!unlink($source)) {
				return false;
			}
		} else {
			return false;
		}

		$this->obfPrint('OK');
		return $dest;
	}
	protected function gunzipBackupFile() {
		// Raising this value may increase performance
		$bufferSize = 4096; // read 4kb at a time
		$error = false;

		$source = $this->backupDir . '/' . $this->backupFile;
		$dest = $this->backupDir . '/' . date("Ymd_His", time()) . '_' . substr($this->backupFile, 0, -3);

		$this->obfPrint('Gunzipping backup file ' . $source . '... ', 1, 1);

		// Remove $dest file if exists
		if (file_exists($dest)) {
			if (!unlink($dest)) {
				return false;
			}
		}

		// Open gzipped and destination files in binary mode
		if (!$srcFile = gzopen($this->backupDir . '/' . $this->backupFile, 'rb')) {
			return false;
		}
		if (!$dstFile = fopen($dest, 'wb')) {
			return false;
		}

		while (!gzeof($srcFile)) {
			// Read buffer-size bytes
			// Both fwrite and gzread are binary-safe
			if (!fwrite($dstFile, gzread($srcFile, $bufferSize))) {
				return false;
			}
		}

		fclose($dstFile);
		gzclose($srcFile);

		// Return backup filename excluding backup directory
		return str_replace($this->backupDir . '/', '', $dest);
	}
	public function restoreDb() {
		try {
			$sql = '';
			$multiLineComment = false;

			$backupDir = $this->backupDir;
			$backupFile = $this->backupFile;

			/**
			 * Gunzip file if gzipped
			 */
			$backupFileIsGzipped = substr($backupFile, -3, 3) == '.gz' ? true : false;
			if ($backupFileIsGzipped) {
				if (!$backupFile = $this->gunzipBackupFile()) {
					throw new Exception("ERROR: couldn't gunzip backup file " . $backupDir . '/' . $backupFile);
				}
			}

			/**
			 * Read backup file line by line
			 */
			$handle = fopen($backupDir . '/' . $backupFile, "r");
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					$line = ltrim(rtrim($line));
					if (strlen($line) > 1) {
						// avoid blank lines
						$lineIsComment = false;
						if (preg_match('/^\/\*/', $line)) {
							$multiLineComment = true;
							$lineIsComment = true;
						}
						if ($multiLineComment or preg_match('/^\/\//', $line)) {
							$lineIsComment = true;
						}
						if (!$lineIsComment) {
							$sql .= $line;
							if (preg_match('/;$/', $line)) {
								// execute query
								$sql = str_replace('0000-00-00 00:00:00', NULL, $sql);
								if ($this->utilityModel->executeNoResult($sql, [])) {
									if (preg_match('/^CREATE TABLE `([^`]+)`/i', $sql, $tableName)) {
										$this->obfPrint("Table succesfully created: `" . $tableName[1] . "`");
									}
									$sql = '';
								} else {
									throw new Exception("ERROR: SQL execution error: " . mysqli_error($this->conn));
								}
							}
						} else if (preg_match('/\*\/$/', $line)) {
							$multiLineComment = false;
						}
					}
				}
				fclose($handle);
			} else {
				throw new Exception("ERROR: couldn't open backup file " . $backupDir . '/' . $backupFile);
			}
		} catch (Exception $e) {
			print_r($e->getMessage());
			return false;
		}

		if ($backupFileIsGzipped) {
			unlink($backupDir . '/' . $backupFile);
		}

		return true;
	}

	public function getAllFile() {
		$files = scandir($this->backupDir);
		$files = array_diff($files, array('.', '..', ' ', '.svn', '.htaccess', 'index.html', '.sql'));
		return $files;

// Loop through the files and get the date of creation
		$d = [];
		foreach ($files as $file) {
			$filePath = '/' . $file;
			array_push($d, $filePath);
			// Check if the path is a file (not a directory)
			if (is_file($filePath)) {
				// Get the date of creation
				$creationDate = date("Y-m-d H:i:s", filemtime($filePath));

				// Output the filename and date of creation
				echo "File: $file, Creation Date: $creationDate\n";
			}
		}
		return $d;
	}
}
?>