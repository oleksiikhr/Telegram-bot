<?php

use tlg\telegram\Telegram;
use tlg\telegram\methods\Parse;

require_once __DIR__ . '/../config/main.php';

// $data = json_decode( file_get_contents( 'php://input' ) );

// Example data
$data = json_decode('{"message":{"message_id":1,"from":{"id":182767170,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0435\u0439","username":"Alexeykhr"},"chat":{"id":182767170,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0435\u0439","username":"Alexeykhr","type":"private"},"date":1491658175,"text":"/start"}}');

// Initialization
$tlg = new Telegram(TOKEN);
$tlg->run($data);

if (Parse::$text === '/start') {
	// For add new row a database and other.
	// If user not found => create

	// \QB::table('users')->insert([
	// 	'name' => Parse::$fromUsername
	// ]);

	$tlg->sendMessage(Parse::$fromID, "Выберите ник для своего персонажа", null, Parse::$messageID);
}
else {
	$tlg->sendMessage(Parse::$fromID, Parse::$text,);
}
