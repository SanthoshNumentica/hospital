<?php
namespace App\Models\Whatsapp;
use CodeIgniter\Model;

class SmstransactionsModel extends Model {
	protected $table = 'smstransactions';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Whatsapp\Smstransactions';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['message_type', 'mobile_no', 'message', 'status', 'file'];
	protected $useTimestamps = true;
}
?>