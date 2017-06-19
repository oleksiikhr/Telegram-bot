<?php

namespace tlg\telegram\commands;

use tlg\telegram\tables\User;
use tlg\telegram\TLG;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KBtn;

class Tavern
{
    public static function home()
    {
        $k = Keyboard::replyKeyboardMarkup([
            [KBtn::new('/home'), KBtn::new('/adventure'), KBtn::new('/arena')],
            [KBtn::new('/mine'), KBtn::new('/shop'), KBtn::new('clan')],
            [KBtn::new('/me')]
        ]);

        TLG::sendMessage('Вы прибыли в столицу.', null, null, null, $k);
    }

    public static function me()
    {
        TLG::sendMessage(
            "Имя: " . User::getName() . "\n"
            . "Жизни: " . User::getHealth() . "\n"

        );
    }
}
