<?php

use tlg\telegram\Telegram;
use tlg\telegram\methods\Parse;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KeyboardButton;

require_once __DIR__ . '/../config/main.php';

$data = json_decode( file_get_contents( 'php://input' ) );
//$data = json_decode('{"message":{"message_id":1,"from":{"id":182767170,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0435\u0439","username":"Alexeykhr"},"chat":{"id":182767170,"first_name":"\u0410\u043b\u0435\u043a\u0441\u0435\u0439","username":"Alexeykhr","type":"private"},"date":1491658175,"text":"/start"}}');

// Initialization
$tlg = new Telegram(TOKEN);
$tlg->run($data);

// Connect to BD
//new tlg\DB();

if (Parse::$text === '/start') {
	// For add new row a database and other.
	// If user not found => create

	// \QB::table('users')->insert([
	// 	'name' => Parse::$fromUsername
	// ]);

    $k = Keyboard::replyKeyboardMarkup([ [KeyboardButton::new('One btn'), KeyboardButton::new('Two btn')], [KeyboardButton::new('Three btn')] ]);
	$tlg->sendMessage(Parse::$fromID, "Выберите ник для своего персонажа", null, null, $k);

	// Если ник занят, последнее сообщение в БД => /start
}
else {
	$tlg->sendMessage(Parse::$fromID, Parse::$text);
}
