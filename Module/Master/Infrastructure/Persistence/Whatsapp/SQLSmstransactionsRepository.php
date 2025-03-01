<?php
namespace App\Infrastructure\Persistence\Whatsapp;
use App\Domain\Whatsapp\Smstransactions;
use App\Domain\Whatsapp\SmstransactionsRepository;
use App\Models\Whatsapp\SmstransactionsModel;
use Core\Infrastructure\Persistence\DMLPersistence;

class SQLSmstransactionsRepository implements SmstransactionsRepository {
	use DMLPersistence;

	/** @var AppModel */
	protected $model;

	public function __construct() {
		$this->model = new SmstransactionsModel();
	}
	public function globalJoin() {
		$this->model->select('smstransactions .*,case
            when status = 1 then "Sent"
            when status = 2 then "Pending"
            else "Failed"
             end as statusName,
             case
            when message_type = 1 then "WhatsApp"
            when status = 2 then "SMS"
             end as message_typeName', false);

	}

	public function setEntity($d) {
		return new Smstransactions($d);
	}

}