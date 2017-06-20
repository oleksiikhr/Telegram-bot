<?php

namespace tlg\telegram\commands;

use tlg\telegram\Smiles;
use tlg\telegram\TLG;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KBtn;

class Basic
{
    public static function identify()
    {

    }

    public static function home()
    {
        $k = Keyboard::replyKeyboardMarkup([
            [KBtn::new(Smiles::FIND . ' Find a new game'), KBtn::new(Smiles::DIRECT_HIT . ' Training')],
            [KBtn::new(Smiles::WEAPON . ' Weapons'), KBtn::new(Smiles::GRENADE . ' Grenades')],
            [KBtn::new(Smiles::CHART . ' Statistics'), KBtn::new(Smiles::INFO . ' About the game')]
        ]);

        TLG::sendMessage('Home page', null, null, null, $k);
    }

    public static function training()
    {

    }

    public static function game($isCanFire = true)
    {
        $btnFireOrReload = KBtn::new($isCanFire ? Smiles::FIRE : Smiles::RELOAD);

        $k = Keyboard::replyKeyboardMarkup([
            [KBtn::new(Smiles::TOP_LEFT), KBtn::new(Smiles::TOP), KBtn::new(Smiles::TOP_RIGHT)],
            [KBtn::new(Smiles::LEFT), KBtn::new(Smiles::SKIP), KBtn::new(Smiles::RIGHT)],
            [KBtn::new(Smiles::BOT_LEFT), KBtn::new(Smiles::BOT), KBtn::new(Smiles::BOT_RIGHT)],
            [KBtn::new(Smiles::GRENADE), $btnFireOrReload, KBtn::new(Smiles::INFO)],
        ]);

        TLG::sendMessage('Select an action', null, null, null, $k);
    }
}
