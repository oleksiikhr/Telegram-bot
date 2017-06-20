<?php

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\commands\Game;
use tlg\telegram\commands\Basic;
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

//if (User::getMethod())
//    Basic::identify();
//else
//    Game::identify();

switch (PMessage::$text) {
    case '/home': Basic::home(); break;
    case '/game': Basic::game(); break;
    case '/training': Basic::training(); break;
}

file_put_contents('./test.txt', $input->update_id + 1);
