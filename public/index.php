<?php

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;

require_once __DIR__ . '/main.php';

// Temporary
$input = TLG::send('getUpdates', ['offset' => file_get_contents('test.txt')]);

if (empty($input->result))
    die('empty');

$input = $input->result[0];

print_r($input);

PMessage::set( $input );
// END Temporary

//PMessage::set( json_decode( file_get_contents( 'php://input' ) ) );
User::checkAuth();


// |
// | START
// |

switch (PMessage::$text) {
    case '/home': \tlg\telegram\commands\Commands::home(); break;
    case '/me': \tlg\telegram\commands\Commands::me(); break;
    case '/top': \tlg\telegram\commands\Commands::goTop(); break;
}

file_put_contents('./test.txt', $input->update_id + 1);
