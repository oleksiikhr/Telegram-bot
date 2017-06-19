<?php if ( isset($_GET['delete']) ) unlink(__FILE__);

require_once __DIR__ . '/main.php';

\QB::query('
	CREATE TABLE IF NOT EXISTS users (
		tlg_id  INT UNIQUE          NOT NULL,
		login   VARCHAR (30) UNIQUE NOT NULL,
		method  VARCHAR (255)       NOT NULL,
		money   INT DEFAULT 100     NOT NULL,
		rating  INT                 NOT NULL,
		clan_id INT                 NOT NULL
		/* And other.. */
	)
');
