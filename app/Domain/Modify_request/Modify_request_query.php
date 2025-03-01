<?php
namespace Core\Domain\Modify_request;

use CodeIgniter\Entity;
    class Modify_request_query extends Entity
    {
         protected $attributes = [ 'query_remark'=> null,'created_by'=> null,'modify_request_fk_id'=> null,
         ];
    }
?>