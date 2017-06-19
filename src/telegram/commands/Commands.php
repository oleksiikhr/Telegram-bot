<?php

namespace tlg\telegram\commands;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\methods\keyboard\Keyboard;
use tlg\telegram\methods\keyboard\types\KBtn;

class Commands
{
    public static function getFullKeyboard()
    {
        return Keyboard::replyKeyboardMarkup([
            [KBtn::new('/me'), KBtn::new('/top'), KBtn::new('/clan')],
            [KBtn::new('/left'), KBtn::new('/bot'), KBtn::new('/right')]
        ]);
    }

    public static function getReturnKeyboard()
    {
        return Keyboard::replyKeyboardMarkup([
            [KBtn::new('/home')]
        ]);
    }

    public static function home()
    {
        TLG::sendMessage('Подсказка #1: Незабываем о еде', null, null, null, self::getFullKeyboard());
    }

    public static function me()
    {
        TLG::sendMessage(
            "Имя: " . User::getName() . "\n" .
            "Жизни: " . User::getHealth() . "\n" .
            "Броня: " . User::getShield() . "\n" .
            "Еда: " . User::getFood() . "\n" .
            "Сон: " . User::getSleep() . "\n" .
            "Деньги: " . User::getMoney() . "\n" .
            "Номер клана: " . User::getClansId() . "\n" .
            "Номер клетки: " . User::getMapsId() . "\n" .
            "Номер оружия: " . User::getWeaponsId()
        );
    }

    public static function goTop()
    {
        $q = \QB::table('maps')->where(User::getId(), '=', 'users_id')->get();

        var_dump($q);
    }
}
