<?php
namespace App\Models\Expense;
use CodeIgniter\Model;

class ExpenseModel extends Model {
	protected $imageColum = [];
	public function __construct() {
		helper('Core\Helpers\File');
		$appConstant = new \Config\AppConstant();
		$this->imageColum = array('document' => $appConstant->expenseUploadPath);
	}
	protected $table = 'expense';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Expense\Expense';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['expense_id', 'vendor_fk_id', 'description', 'amount', 'status', 'expense_type_fk_id', 'payment_ref_number', 'payment_ref_remarks', 'total_paid', 'invoice_date', 'document', 'payment_type_fk_id'];
	protected $useTimestamps = true;
	protected $beforeInsert = ['beforeSave'];
	protected $beforeUpdate = ['beforeSave'];
	protected $afterFind = ['addImageRealPath'];
	public function beforeSave(array $data) {
		$data['data'] = modelFileHandler($data['data'], $this->imageColum);
		return $data;
	}
	protected function addImageRealPath(array $data) {
		$data['data'] = addImageRealPath($data['data'], $this->imageColum);
		return $data;
	}
}
?>