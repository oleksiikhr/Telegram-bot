<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;

class SearchController
{
    public static function identify()
    {
        switch (PMessage::$command) {
            case '/search': self::search(); break;
        }
    }

    public static function search()
    {
        TLG::sendMessage(User::sqlGetUsersByMethod(null, true));
    }
}
