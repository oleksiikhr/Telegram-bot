<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\models\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\KeyboardHelpers;

class ChooseGameController
{
    const MODE_TRAINING = 'Training';

    const MODE_BOT1 = 'Bot 1x1';
    /* TODO: Continue */

    public static function identify()
    {
        if (PMessage::$command === '/home') {
            User::updateUser(['method' => null]);
            KeyboardHelpers::home();
            return;
        }

        // Continue
    }

    public static function chooseGame()
    {
        KeyboardHelpers::chooseGame();
    }
}
