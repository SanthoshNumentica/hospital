<?php
namespace App\Domain\Invoice;

use CodeIgniter\Entity;
    class Invoice_item extends Entity
    {
         protected $attributes = [ 'invoice_fk_id'=> null,'treatment_fk_id'=> null,'description'=> null,'amount'=> null,
         ];
    }
?>