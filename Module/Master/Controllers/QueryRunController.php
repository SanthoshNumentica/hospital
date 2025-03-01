<?php

namespace App\Controllers;
use mysqli;

use Core\Controllers\BaseController;
class QueryRunController extends BaseController {
    public function __construct() {
	}
    public function queryRun()
    {
        $json = $this->getDataFromUrl('json');
        $dbname= $json['db_name'];
        $data = $json['file'];
        $fileContent = file_get_contents($data);
        $mysqli = new mysqli('localhost', 'root', '', $dbname);
        
        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        if ($mysqli->multi_query($fileContent)) {
            $affectedTables = 0;
    
            do {
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
                $affectedTables += $mysqli->affected_rows;
    
            } while ($mysqli->next_result());
    
            echo "SQL queries executed successfully! $affectedTables tables affected.";
        } else {
            echo "Error executing SQL queries: " . $mysqli->error;
        }
        $mysqli->close();
    }
    

    

}