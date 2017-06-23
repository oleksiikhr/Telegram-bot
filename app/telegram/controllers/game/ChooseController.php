<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\KeyboardHelpers;

class ChooseController
{
    public static function identify()
    {
        // PMessage::$text - game
        echo 'ChooseController' . '<br>';

        if (PMessage::$command === '/home') {
            User::sqlUpdateMethod();
            TLG::sendMessage('Main menu', KeyboardHelpers::home());
            return;
        }

        if ( ! in_array(PMessage::$text, self::getAllModes()) ) {
            TLG::sendMessage('There is no such mode');
            return;
        }

        TLG::sendMessage('We find users..', KeyboardHelpers::searchGame());
        User::sqlUpdateMethod(PMessage::$text);
        PlayController::newGame();
    }

    public static function getAllModes()
    {
        return [
            'Deathmatch', 'Duel', 'Team Deathmatch'
        ];
    }
}
