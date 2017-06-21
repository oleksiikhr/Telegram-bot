<?php

namespace tlg\telegram\commands;

use tlg\telegram\Smiles;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KBtn;

class Keyboards
{
    public static function game()
    {
        return Keyboard::replyKeyboardMarkup([
            [KBtn::new(Smiles::TOP_LEFT), KBtn::new(Smiles::TOP), KBtn::new(Smiles::TOP_RIGHT)],
            [KBtn::new(Smiles::LEFT), KBtn::new(Smiles::AROUND), KBtn::new(Smiles::RIGHT)],
            [KBtn::new(Smiles::BOT_LEFT), KBtn::new(Smiles::BOT), KBtn::new(Smiles::BOT_RIGHT)],
            [KBtn::new(Smiles::DIRECT_HIT), KBtn::new(Smiles::BLOCK), KBtn::new(Smiles::BLINK)],
        ]);
    }

    public static function home()
    {
        return Keyboard::replyKeyboardMarkup([
            [KBtn::new(Smiles::SEARCH . ' Find a new game'), KBtn::new(Smiles::TRAINING . ' Training')],
            [KBtn::new(Smiles::I . ' I'), KBtn::new(Smiles::INFO . ' About the game')]
        ]);
    }

    public static function searchGame()
    {
        return Keyboard::replyKeyboardMarkup([
            [KBtn::new(Smiles::HOME . ' Return')]
        ]);
    }
}
