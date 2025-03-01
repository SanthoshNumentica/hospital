<?php
namespace App\Models\Invoice;
use CodeIgniter\Model;

class InvoiceModel extends Model {
	protected $table = 'invoice';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Invoice\Invoice';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['patient_fk_id', 'total_amount', 'total_paid_amount', 'status', 'remarks', 'invoice_date', 'created_by', 'discount', 'invoice_id'];
	protected $useTimestamps = true;
	//status => 1 => 'Paid' 2 => "pending" 3=> "dues" 4 => "cancelled";
}
?>