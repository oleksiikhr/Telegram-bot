<?php

namespace tlg\telegram\controllers;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\MethodHelpers;
use tlg\telegram\helpers\KeyboardHelpers;

class BasicController
{
    public static function identify()
    {
        if (PMessage::$text === '/home') {
            self::home();
            return;
        }

        switch (PMessage::$command) {
            case '/home': self::home(); break;
            case '/search': self::choose(); break;
            case '/about_me': self::aboutMe(); break;
        }
    }

    public static function home()
    {
        TLG::sendMessage('Home page', KeyboardHelpers::home());
    }

    public static function choose()
    {
        TLG::sendMessage('Choose a game', KeyboardHelpers::chooseGamePlayer());
        User::sqlUpdateMethod(MethodHelpers::GAME_CHOOSE);
    }

    public static function aboutMe()
    {
        TLG::sendMessage(
            "Name: " . User::getName(). "\n" .
            "Rating: " . User::getRating() . "\n" .
            "Kills: " . User::getKills()
        );
    }
}
