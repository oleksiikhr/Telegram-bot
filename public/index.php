<?php

use tlg\telegram\Telegram;
use tlg\telegram\methods\Parse;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KeyboardButton;

require_once __DIR__ . '/main.php';

Parse::run( json_decode( file_get_contents( 'php://input' ) ) );

/**
 * |---------------------------------------------------
 * | Start app.
 * |---------------------------------------------------
 */

//if (Parse::$text === '/start')
//{
//	// If user not found => send message, create a new row in DB
//    // If user found and login failed => send message, again
//    // If ..
//
//	// \QB::table(DB::TABLE_USERS)->insert([
//	// 	'name'    => Parse::$fromID,
//	// 	'message' => Parse::$text
//	// ]);
//
//	$tlg->sendMessage(Parse::$fromID, "Введите ник для своего персонажа");
//
//	// Если ник занят, последнее сообщение в БД => /start
//}
//else
//{
//    $k = Keyboard::replyKeyboardMarkup([
//        [KeyboardButton::new(Parse::$text . '-1'), KeyboardButton::new(Parse::$text . '-2')],
//        [KeyboardButton::new(Parse::$text . '-3')]
//    ]);
//
//	$tlg->sendMessage(Parse::$fromID, Parse::$text, null, null, $k);
//}
