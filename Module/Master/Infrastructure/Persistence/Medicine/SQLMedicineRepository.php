<?php
namespace App\Infrastructure\Persistence\Medicine;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Medicine\MedicineRepository;
use App\Domain\Medicine\Medicine;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Medicine\MedicineModel;

class SQLMedicineRepository implements MedicineRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new MedicineModel();
    }
    function globalJoin() {
        $this->model->select('medicine_template.*,
            medicine_template.medicine_templateName,
            m.medicineName,
            md.medicine_dosageName,
            mf.medicine_frequencyName,
            mdn.medicine_durationName,s.statusName')
            ->join('medicine_template_item as mti', 'mti.medicine_template_fk_id = medicine_template.id', 'left')
            ->join('medicine_dosage as md', 'md.id = mti.medicine_dosage_fk_id', 'left')
            ->join('medicine_frequency as mf', 'mf.id = mti.medicine_frequency_fk_id', 'left')
            ->join('medicine_duration as mdn', 'mdn.id = mti.medicine_duration_fk_id', 'left')
            ->join('status as s', 's.id = medicine_template.status', 'left')
            ->join('medicine as m', 'm.id = mti.medicine_fk_id', 'left');
    }
    public function setEntity($d)
    {
        return new Medicine($d);
    }

}