<?php
namespace App\Domain\Patient;

use CodeIgniter\Entity;
    class Expense extends Entity
    {
         protected $attributes = [ 'Expense_id'=> null,'description'=> null,'deleted_at'=> null,'payment_ref_number'=> null,'payment_ref_remarks'=>null
         ];
    }
?>