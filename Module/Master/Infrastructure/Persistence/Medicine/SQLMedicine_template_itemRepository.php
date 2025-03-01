<?php
namespace App\Infrastructure\Persistence\Medicine;
use App\Domain\Medicine\Medicine_template_item;
use App\Domain\Medicine\Medicine_template_itemRepository;
use App\Models\Medicine\Medicine_template_itemModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLMedicine_template_itemRepository implements Medicine_template_itemRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new Medicine_template_itemModel();
	}
	public function setEntity($d) {
		return new Medicine_template_item($d);
	}
	public function globalJoin() {
		$this->model->select('medicine_template_item.*,
            m.medicineName,
            md.medicine_dosageName,
            mf.medicine_frequencyName,
            mdn.medicine_durationName')
			->join('medicine_dosage as md', 'md.id = medicine_template_item.medicine_dosage_fk_id', 'left')
			->join('medicine_frequency as mf', 'mf.id = medicine_template_item.medicine_frequency_fk_id', 'left')
			->join('medicine_duration as mdn', 'mdn.id = medicine_template_item.medicine_duration_fk_id', 'left')
			->join('medicine as m', 'm.id = medicine_template_item.medicine_fk_id', 'left');

	}

}