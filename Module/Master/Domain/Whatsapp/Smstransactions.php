<?php
namespace App\Domain\Whatsapp;

use CodeIgniter\Entity;

class Smstransactions extends Entity {
	protected $attributes = ['mobile_no' => null, 'message_type' => null, 'message' => null, 'status' => null, 'file' => null,
	];
}
?>