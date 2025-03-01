<?php
namespace Core\Domain\Modify_request;

use CodeIgniter\Entity;

class Modify_request extends Entity
{
    protected $attributes = ['action_id' => null, 'request_data' => null, 'created_by' => null, 'module_id' => null, 'ref_id' => null, 'status' => null, 'action_by' => null, 'action_date' => null, 'zone' => null, 'region' => null, 'department' => null, 'institution' => null, 'description' => null, 'ad_office' => null, 'trust' => null,'home'=>null,'promotional_office' =>null,'sponsorship_module' =>null,'child_type' => null,'remarks' => null
    ];
}
