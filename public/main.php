<?php

require_once TLG_DIR . '/vendor/autoload.php';

$config = require TLG_DIR . '/config/db.php';
new Pixie\Connection($config['driver'], $config, 'QB');
