<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

    class ExpenseModel extends Model
    {
        protected $table      = 'Expense';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Patient\Patient';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'expense_id','vendor_fk_id','description','amount','status','payment_type_fk_id','payment_ref_number','payment_ref_remarks','total_paid'];
         protected $useTimestamps = true;
    }
?>