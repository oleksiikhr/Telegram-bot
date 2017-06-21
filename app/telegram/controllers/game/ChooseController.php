<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\models\Search;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\MethodHelpers;
use tlg\telegram\helpers\KeyboardHelpers;

class ChooseController
{
    public static function identify()
    {
        echo 'ChooseController' . '<br>';

        if (PMessage::$command === '/home') {
            User::updateMethod(null);
            TLG::sendMessage('Main menu', KeyboardHelpers::home());
            return;
        }

        if ( ! in_array(PMessage::$text, self::getAllModes()) ) {
            TLG::sendMessage('There is no such mode');
            return;
        }

        Search::addUser(PMessage::$text === 'All modes (without training)' ? 'All modes' : PMessage::$text);
        User::updateMethod(MethodHelpers::SEARCH_GAME);
        TLG::sendMessage('Number of users in search: ' . Search::getCountWaitUsers(), KeyboardHelpers::searchGame());
    }

    public static function chooseGame()
    {
        KeyboardHelpers::chooseGame();
    }

    public static function getAllModes()
    {
        return [
            'Training', 'All modes (without training)',
            'HvsB 1x1', 'HvsB 2x2', 'HvsB 3x3', 'HvsB 4x4',
            'HvsH 1x1', 'HvsH 2x2', 'HvsH 3x3', 'HvsH 4x4'
        ];
    }
}
