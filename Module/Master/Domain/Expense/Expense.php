<?php
namespace App\Domain\Expense;

use CodeIgniter\Entity;
    class Expense extends Entity
    {
         protected $attributes = [ 'expense_id'=> null,'vendor_fk_id'=> null,'description'=> null,'amount'=> null,'status'=> null,'expense_type_fk_id'=> null,'payment_ref_number'=> null,'payment_ref_remarks'=> null,'total_paid'=> null,'invoice_date'=> null,'document'=> null,'payment_type_fk_id'=> null,
         ];
    }
?>