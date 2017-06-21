<?php

namespace tlg\telegram\commands;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;

class Basic
{
    public static function identify()
    {
        switch (PMessage::$command) {
            case '/search_game': self::searchGame(); break;
            case '/training': self::training(); break;
        }
    }

    // For register
    public static function home()
    {
        TLG::sendMessage('Home page', null, null, null, Keyboards::home());
    }

    public static function training()
    {
        TLG::sendMessage('Select an action', null, null, null, Keyboards::game());
    }

    public static function searchGame()
    {
        TLG::sendMessage('Waiting for players..', null, null, null, Keyboards::searchGame());
        User::updateUser([
            'method' => 'search_game'
        ]);
    }
}
