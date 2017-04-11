<?php if ( isset($_GET['delete']) ) unlink(__FILE__);

use tlg\DB;

require_once __DIR__ . '/../vendor/autoload.php';

new DB();

\QB::query('
	CREATE TABLE IF NOT EXISTS ' . DB::TABLE_USERS . '(
		id      INT AUTO_INCREMENT NOT NULL,
		login   VARCHAR (30)       NOT NULL,
		message VARCHAR (255)      NOT NULL,
		/* And other.. */
		PRIMARY KEY(ID)
	)
');
