<?php

namespace tlg\telegram\tables;

use tlg\telegram\TLG;
use tlg\telegram\parse\PMessage;
use tlg\telegram\commands\Tavern;
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

        die;
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
                TLG::sendMessage('Вы успешно завершили регистрацию!');
                Tavern::home();
            }
        }
    }

    public static function updateUser($data)
    {
//        $data['update_time'] = '';
        return \QB::table(self::TABLE)->where('tlg_id', '=', self::$u->tlg_id)->update($data);
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
}
