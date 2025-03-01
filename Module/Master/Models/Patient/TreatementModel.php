<?php
namespace App\Models\Patient;
use CodeIgniter\Model;

    class TreatementModel extends Model
    {
        protected $table      = 'treatment';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Domain\Patient\Treatement';
    protected $useSoftDeletes = true;
         protected $allowedFields = [ 'treatment_fk_id','amount','treatment_id'];
         protected $useTimestamps = true;
    }
?>