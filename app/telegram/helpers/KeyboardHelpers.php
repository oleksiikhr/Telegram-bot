<?php

namespace tlg\telegram\helpers;

use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\BTN;

class KeyboardHelpers
{
    // TODO angle, activate..
    public static function game()
    {
        return Keyboard::replyKeyboardMarkup([
            [BTN::new(SmileHelpers::TOP_LEFT), BTN::new(SmileHelpers::TOP), BTN::new(SmileHelpers::TOP_RIGHT)],
            [BTN::new(SmileHelpers::LEFT), BTN::new(SmileHelpers::ATTACK), BTN::new(SmileHelpers::RIGHT)],
            [BTN::new(SmileHelpers::BOT_LEFT), BTN::new(SmileHelpers::BOT), BTN::new(SmileHelpers::BOT_RIGHT)],
            [BTN::new(SmileHelpers::FIRE), BTN::new(SmileHelpers::BLOCK), BTN::new(SmileHelpers::BLINK)],
        ]);
    }

    public static function home()
    {
        return Keyboard::replyKeyboardMarkup([
            [BTN::new(SmileHelpers::SEARCH . ' Find a new game')],
            [BTN::new(SmileHelpers::ABOUT_ME . ' About me')],
            [BTN::new(SmileHelpers::INFO . ' About the game')]
        ]);
    }

    public static function searchGame()
    {
        return Keyboard::replyKeyboardMarkup([
            [BTN::new(SmileHelpers::SEARCH . ' Number of users in search')],
            [BTN::new(SmileHelpers::HOME . ' Return to main menu')]
        ]);
    }

    public static function chooseGamePlayer()
    {
        return Keyboard::replyKeyboardMarkup([
            [BTN::new('Duel'), BTN::new('Deathmatch'), BTN::new('Team Deathmatch')],
            [BTN::new(SmileHelpers::HOME . ' Return to main menu')]
        ]);
    }
}
