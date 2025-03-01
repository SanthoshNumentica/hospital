<?php
namespace App\Infrastructure\Persistence\Settings;
use App\Domain\Settings\Settings;
use App\Domain\Settings\SettingsRepository;
use App\Models\Settings\SettingsModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLSettingsRepository implements SettingsRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new SettingsModel();
	}
	public function setEntity($d) {
		return new Settings($d);
	}
	function getSetting() {
		return $this->model->asArray()->allowCallbacks(true)->first();
	}

}