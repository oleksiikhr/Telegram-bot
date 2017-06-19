<?php

namespace tlg;

use tlg\telegram\TLG;
use tlg\telegram\parse\PMessage;
use tlg\telegram\parse\messages\PFrom;

class User
{
    public static $u;

    const TABLE = 'users';

    public static function checkAuth()
    {
        self::$u = \QB::table(self::TABLE)->where('tlg_id', '=', PFrom::$id)->first();

        if ( empty(self::$u) )
            self::registrationNew();

        else if (empty(self::$u->login) || self::$u->method === 'registration')
            self::registrationRepeat();
    }

    public static function registrationNew()
    {
        TLG::sendMessage(PFrom::$id, "Введите ник для своего персонажа");

        \QB::table(self::TABLE)->insert([
            'tlg_id' => PFrom::$id,
            'method' => 'registration'
        ]);

        die;
    }

    public static function registrationRepeat()
    {
        echo 4;

        if ( ! preg_match('/^[a-z0-9-_]+$/ui', PMessage::$text) )
            TLG::sendMessage(PFrom::$id, 'Ник должен состоять из английских букв, цифр и подчеркивания');

        else if ( \QB::table(self::TABLE)->where('login', '=', PMessage::$text)->first() )
            TLG::sendMessage(PFrom::$id, 'Ник существует, повторите попытку');

        else {
            self::updateUser([
                'login' => PMessage::$text,
                'method' => 'complete_registration'
            ]);

            TLG::sendMessage(PFrom::$id, 'Вы успешно завершили регистрацию');
        }
    }

    public static function updateUser($data)
    {
        \QB::table(self::TABLE)->where('tlg_id', '=', self::$u->tlg_id)->update($data);
    }
}
