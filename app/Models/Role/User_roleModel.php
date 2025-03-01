<?php
namespace Core\Models\Role;

use CodeIgniter\Model;

class User_roleModel extends Model
{
    protected $table          = 'user_role';
    protected $primaryKey     = 'user_id';
    protected $returnType     = 'Core\Domain\Role\User_role';
    protected $useSoftDeletes = false;
    protected $allowedFields  = ['user_id', 'role_id', 'zone', 'region', 'promotional_office', 'institution', 'department', 'trust', 'ad_office','sponsorship_module','home','church'
    ];
    protected $protectFields = true;
    protected $useTimestamps = false;
}
