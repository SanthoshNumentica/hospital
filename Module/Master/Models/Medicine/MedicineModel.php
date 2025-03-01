<?php
namespace App\Models\Medicine;
use CodeIgniter\Model;

    class MedicineModel extends Model
    {
        protected $table      = 'medicine';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Medicine\Medicine';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'medicineName','description','status','medicine_type_fk_id',];
         protected $useTimestamps = true;
    }
?>