<?php

namespace tlg\telegram\tables;

class Game
{
    const TABLE = 'games';

    public static function createNew($game)
    {
        return \QB::table(self::TABLE)->insert([
            'game' => $game
        ]);
    }

    public static function deleteByID($gameID)
    {
        return \QB::table(self::TABLE)->where('id', '=' , $gameID)->delete();
    }
}
