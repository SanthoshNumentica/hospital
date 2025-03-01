<?php
namespace App\Models\Medicine;
use CodeIgniter\Model;

class Medicine_templateModel extends Model {
	protected $table = 'medicine_template';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Medicine\Medicine_template';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['medicine_templateName', 'status'];
	protected $useTimestamps = false;
}
?>