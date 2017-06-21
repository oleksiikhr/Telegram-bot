<?php

use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\controllers\GameController;
use tlg\telegram\controllers\BasicController;

require_once __DIR__ . '/main.php';

// Temporary
    $input = TLG::send('getUpdates', ['offset' => file_get_contents('test.txt')]);

    if (empty($input->result))
        die('empty');

    $input = $input->result[0];

    print_r($input); echo '<br><br>';

    PMessage::set( $input );
// END Temporary

//PMessage::set( json_decode( file_get_contents( 'php://input' ) ) );
User::checkAuth();


// | ---------------------------------


if ( !empty(User::getMethod()) )
    GameController::identify();
else
    BasicController::identify();

file_put_contents('./test.txt', $input->update_id + 1);
