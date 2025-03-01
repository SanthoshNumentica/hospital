<?php
namespace App\Domain\Settings;

use CodeIgniter\Entity;

class Settings extends Entity {
	protected $attributes = ['companyName' => null, 'logo' => null, 'logo_white' => null, 'address' => null, 'address_1' => null, 'address_2' => null, 'mobile_no' => null, 'alt_mobile_no' => null, 'master_passcode' => null, 'allow_notification' => null, 'idl_timeout' => null, 'email_id' => null, 'website_url' => null, 'logo_water_mark' => null,'theme_color'=>null
	];
}
?>