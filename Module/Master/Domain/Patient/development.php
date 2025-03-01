<?php

/*
|--------------------------------------------------------------------------
| ERROR DISPLAY
|--------------------------------------------------------------------------
| In development, we want to show as many errors as possible to help
| make sure they don't make it to production. And save us hours of
| painful debugging.
 */
error_reporting(-1);
ini_set('display_errors', '1');

/*
|--------------------------------------------------------------------------
| DEBUG BACKTRACES
|--------------------------------------------------------------------------
| If true, this constant will tell the error screens to display debug
| backtraces along with the other error information. If you would
| prefer to not see this, set this value to false.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| DEBUG MODE
|--------------------------------------------------------------------------
| Debug mode is an experimental flag that can allow changes throughout
| the system. This will control whether Kint is loaded, and a few other
| items. It can always be used within your own application too.
 */
defined('CI_DEBUG') || define('CI_DEBUG', true);
define('HOST_NAME', "103.83.81.68");
define('DB_USERNAME', 'ssamtorg_admin');
define('DB_PASSWORD', 'vinoth.27');
define('MASTER_DB_NAME', 'ssamtorg_avadi');
define('MAIL_HOST', 'mail.gemsbihar.online');
define('MAIL_USER', 'no-reply@dental.online');
define('MAIL_FROM_USER', 'no-reply@dental.online');
define('MAIL_FROM_USER_NAME', 'Dental Admin');
define('MAIL_PASSWORD', 'pmX4esk!Adw1');
define('MAIL_PORT', 465);
define('MAIL_PROTOCOL', 'smtp');
define('TEST_EMAIL', 'agooTesting@gmail.com');
define('WHATSAPP', '918903489173');
define('SMS_ACCESS_TOKEN', '9oNTFIp8iUG1IIehix2xAg');
define('SMS_API_URL', 'https://www.smsgatewayhub.com/api/mt/SendSMS');
define('WHATSAPP_API_URL', "https://acs.agoo.in/api/create-message");
define('SMS_SENDER_ID', 'SIDENT');

define('PORT', "8090");