<?php

namespace tlg\telegram\tables;

use tlg\telegram\TLG;
use tlg\telegram\parse\PMessage;
use tlg\telegram\commands\Commands;
use tlg\telegram\parse\messages\PFrom;

class User
{
    private static $u;

    const TABLE = 'users';

    // TODO: Add comments
    public static function checkAuth()
    {
        self::$u = \QB::table(self::TABLE)->where('tlg_id', '=', PFrom::$id)->first();

        if ( empty(self::$u) )
            self::registrationNew();

        else if (empty(self::getName()) || self::getMethod() === 'registration')
            self::registrationRepeat();
    }

    public static function registrationNew()
    {
        TLG::sendMessage("Введите ник для своего персонажа");

        \QB::table(self::TABLE)->insert([
            'tlg_id' => PFrom::$id,
            'method' => 'registration'
        ]);
    }

    public static function registrationRepeat()
    {
        if ( ! preg_match('/^[a-z0-9-_]+$/ui', PMessage::$text) )
            TLG::sendMessage('Ник должен состоять из английских букв, цифр и подчеркивания');

        else if ( \QB::table(self::TABLE)->where('name', '=', PMessage::$text)->first() )
            TLG::sendMessage('Ник существует, повторите попытку');

        else {
            $isUpdate = self::updateUser([
                'name' => PMessage::$text,
                'method' => 'complete_registration'
            ]);

            if ($isUpdate) {
                TLG::sendMessage('Вы успешно зарегистрировались!');
                TLG::sendMessage('Для успешного выживания..', null, null, null, Commands::getFullKeyboard());
            }
        }
    }

    public static function updateUser($data)
    {
//        $data['update_time'] = '';
        return \QB::table(self::TABLE)->where('tlg_id', '=', self::$u->tlg_id)->update($data);
    }

    public static function getId()
    {
        return self::$u->id;
    }

    public static function getTelegramId()
    {
        return self::$u->tlg_id;
    }

    public static function getName()
    {
        return self::$u->name;
    }

    public static function getHealth()
    {
        return self::$u->health;
    }

    public static function getMethod()
    {
        return self::$u->method;
    }

    public static function getShield()
    {
        return self::$u->shield;
    }

    public static function getBog()
    {
        return self::$u->bog;
    }

    public static function getMoney()
    {
        return self::$u->money;
    }

    public static function getFood()
    {
        return self::$u->food;
    }

    public static function getSleep()
    {
        return self::$u->sleep;
    }

    public static function getClansId()
    {
        return self::$u->clans_id;
    }

    public static function getMapsId()
    {
        return self::$u->maps_id;
    }

    public static function getWeaponsId()
    {
        return self::$u->weapons_id;
    }

    public static function getCreateTime()
    {
        return self::$u->create_time;
    }

    public static function getUpdateTime()
    {
        return self::$u->update_time;
    }
}
