<?php
namespace App\Models\Medicine;
use CodeIgniter\Model;

class Medicine_template_itemModel extends Model {
	protected $table = 'medicine_template_item';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Medicine\Medicine_template_item';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['medicine_template_fk_id', 'medicine_fk_id', 'medicine_dosage_fk_id', 'medicine_frequency_fk_id', 'medicine_duration_fk_id'];
	protected $useTimestamps = false;
}
?>