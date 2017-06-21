<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\models\Search;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\KeyboardHelpers;

class SearchController
{
    public static function identify()
    {
        switch (PMessage::$command) {
            case '/home': self::home(); break;
            case '/search': self::search(); break;
        }
    }

    public static function home()
    {
        TLG::sendMessage('Home page', null, null, null, KeyboardHelpers::home());
        User::updateUser([
            'method' => null
        ]);
    }

    public static function search()
    {
        TLG::sendMessage(Search::getCountWaitUsers());
    }
}
