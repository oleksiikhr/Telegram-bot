<?php

namespace tlg\telegram\models;

class Search
{
    const TABLE = 'search';

    public static function getCountWaitUsers()
    {
        return \QB::table(self::TABLE)->where('game', '=', self::getGame())->count();
    }

    public static function getGame()
    {
        return \QB::table(self::TABLE)->where('Users_tlg_id', '=', User::getTlgId())->first();
    }

    public static function deleteUser()
    {
        return \QB::table(self::TABLE)->where('Users_tlg_id', '=', User::getTlgId())->delete();
    }

    public static function addUser($game)
    {
        return \QB::table(self::TABLE)->insert([
            'Users_tlg_id' => User::getTlgId(),
            'game'         => $game
        ]);
    }
}
