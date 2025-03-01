<?php
namespace App\Infrastructure\Persistence\Patient;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Patient\TreatmentRepository;
use App\Domain\Patient\Treatment;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Patient\TreatementModel;

class SQLTreatementRepository implements TreatmentRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;
    protected $compactSelect;

    public function __construct()
    {
        $this->model = new TreatementModel();
        
    }
    public function setEntity($d)
    {
        return new Treatment($d);
    }
//    public function globalJoin()
//     {
//         $this->model->select('treatment .*,td.treatmentName')
//         ->join('treatment as td', 'td.id = treatment_details.treatment_fk_id', 'left');
//     }
}