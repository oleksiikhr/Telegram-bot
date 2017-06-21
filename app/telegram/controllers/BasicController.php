<?php

namespace tlg\telegram\controllers;

use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\MethodHelpers;
use tlg\telegram\helpers\KeyboardHelpers;

class BasicController
{
    public static function identify()
    {
        echo 'Basic';

        if (PMessage::$text === '/home') {
            self::home();
            return;
        }

        switch (PMessage::$command) {
            case '/home': self::home(); break;
            case '/search': self::search(); break;
            case '/about_me': self::aboutMe(); break;
        }
    }

    // For register and others
    public static function home()
    {
        TLG::sendMessage('Home page', KeyboardHelpers::home());
    }

    public static function search()
    {
        TLG::sendMessage('Choose a game', KeyboardHelpers::chooseGame());
        User::updateMethod(MethodHelpers::CHOOSE_GAME);
    }

    public static function aboutMe()
    {
        TLG::sendMessage(
            "Name: " . User::getName(). "\n" .
            "Exp: " . User::getExp() . "\n" .
            "Rating: " . User::getRating()
        );
    }
}
