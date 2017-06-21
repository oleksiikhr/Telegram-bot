<?php

namespace tlg\telegram\models;

use tlg\telegram\TLG;
use tlg\telegram\parse\PMessage;
use tlg\telegram\parse\types\PFrom;
use tlg\telegram\controllers\BasicController;

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
        TLG::sendMessage("Enter a nickname for your character");

        \QB::table(self::TABLE)->insert([
            'tlg_id' => PFrom::$id,
            'method' => 'registration'
        ]);
    }

    public static function registrationRepeat()
    {
        if ( ! preg_match('/^[a-z0-9-_]+$/ui', PMessage::$text) )
            TLG::sendMessage('Nickname should consist of English letters, numbers and underscore');

        else if ( \QB::table(self::TABLE)->where('name', '=', PMessage::$text)->first() )
            TLG::sendMessage('Nickname exists, please try again');

        else {
            $isUpdate = self::updateUser([
                'name' => PMessage::$text,
                'method' => null
            ]);

            if ($isUpdate)
            {
                TLG::sendMessage('You have successfully registered!');
                BasicController::home();
            }
            else
                TLG::sendMessage('An error occurred while registering!');
        }
    }

    public static function updateUser($data)
    {
        $data['update_time'] = date("Y-m-d H:i:s");
        return \QB::table(self::TABLE)->where('tlg_id', '=', self::$u->tlg_id)->update($data);
    }

    public static function getTlgId()
    {
        return self::$u->tlg_id;
    }

    public static function getName()
    {
        return self::$u->name;
    }

    public static function getMethod()
    {
        return self::$u->method;
    }

    public static function getRating()
    {
        return self::$u->rating;
    }

    public static function getExp()
    {
        return self::$u->exp;
    }

    public static function getClanId()
    {
        return self::$u->clans_id;
    }
}
