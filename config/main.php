<?php

use tlg\DB;
use tlg\telegram\Telegram;

define('TLG_DIR', __DIR__ . '/../');
define('TLG_TOKEN', '321308703:AAEIkqIQnCQqyvAlMXiEMszwDNOt5lf1j94');

require_once TLG_DIR . '/vendor/autoload.php';

// Initialization.
$tlg = new Telegram(TLG_TOKEN);

// Connect to BD.
new DB();
