<?php

namespace tlg\telegram\controllers;

use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\parse\PMessage;
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
            case '/search': self::searchGame(); break;
            case '/training': self::training(); break;
            case '/i': self::i(); break;
        }
    }

    // For register
    public static function home()
    {
        TLG::sendMessage('Home page', null, null, null, KeyboardHelpers::home());
    }

    public static function training()
    {
        TLG::sendMessage('Select an action', null, null, null, KeyboardHelpers::game());
    }

    public static function searchGame()
    {
        TLG::sendMessage('Choose a game', null, null, null, KeyboardHelpers::chooseGame());
        User::updateUser(['method' => 'choose_game']);
    }

    public static function i()
    {
        TLG::sendMessage(
            "Name: " . User::getName(). "\n" .
            "Exp: " . User::getExp() . "\n" .
            "Rating: " . User::getRating() . "\n" .
            "Clan ID: " . User::getClanID()
        );
    }
}
