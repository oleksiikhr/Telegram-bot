<?php

require_once __DIR__ . '/../config/main.php';

\QB::query('
	CREATE TABLE IF NOT EXISTS Users(
		id    INT AUTO_INCREMENT NOT NULL,
		login VARCHAR (30)       NOT NULL,
		/* And other.. */
		PRIMARY KEY(ID)
	)
');

// unlink(__FILE__);
