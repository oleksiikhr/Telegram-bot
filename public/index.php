<?php

use tlg\User;
use tlg\telegram\TLG;
use tlg\telegram\parse\PMessage;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KeyboardButton;

require_once __DIR__ . '/main.php';

//PMessage::set( json_decode( file_get_contents( 'php://input' ) ) );

$input = TLG::send('getUpdates', ['offset' => file_get_contents('test.txt')])->result[0];
print_r($input); echo '<br><br>';
PMessage::set( $input );
User::checkAuth();

//if (User::$u->method === 'complete_registration') {
//
//}

file_put_contents('./test.txt', $input->update_id + 1);
