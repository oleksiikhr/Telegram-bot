<?php

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\controllers\MethodController;
use tlg\telegram\controllers\BasicController;

require_once __DIR__ . '/main.php';

$arr = ['move', '2', '4'];
echo json_encode($arr); die;

// Temporary
    $input = TLG::send('getUpdates', ['offset' => file_get_contents('test.txt')]);

    if (empty($input->result))
        die('empty');

    $input = $input->result[0];

    print_r($input); echo '<br><br>';

    PMessage::set( $input );
    file_put_contents('./test.txt', $input->update_id + 1);
// END Temporary

//PMessage::set( json_decode( file_get_contents( 'php://input' ) ) );
User::checkAuth();

if ( ! empty(User::getMethod()) && User::getMethod() === 'played' )
{
    \tlg\telegram\controllers\game\PlayController::move();
    return;
}


// | ---------------------------------

if ( ! empty(User::getMethod()) )
    MethodController::identify();
else
    BasicController::identify();
