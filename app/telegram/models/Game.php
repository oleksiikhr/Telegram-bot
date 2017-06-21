<?php

namespace tlg\telegram\models;

class Game
{
    const TABLE = 'games';

    public static function createNew($mapID, $game)
    {
        return \QB::table(self::TABLE)->insert([
            'Maps_id' => $mapID,
            'game'    => $game
        ]);
    }
}
