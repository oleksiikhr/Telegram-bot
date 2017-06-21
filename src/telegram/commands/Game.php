<?php

namespace tlg\telegram\commands;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;

class Game
{
    public static function identify()
    {
        switch (PMessage::$command) {
            case '/home': self::home(); break;
        }
    }

    public static function home()
    {
        TLG::sendMessage('Home page', null, null, null, Keyboards::home());
        User::updateUser([
            'method' => null
        ]);
    }
}
