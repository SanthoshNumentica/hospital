<?php
namespace App\Models\Invoice;
use CodeIgniter\Model;

class Invoice_itemModel extends Model {
	protected $table = 'invoice_item';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Invoice\Invoice_item';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['invoice_fk_id', 'treatment_fk_id', 'description', 'amount'];
	protected $useTimestamps = true;
}
?>