<?php

namespace tlg\telegram\models;

class Sessions
{
    const TABLE = 'sessions';

    public static function add($userID, $gameID, $posX, $posY)
    {
        return \QB::table(self::TABLE)->insert([
            'Users_tlg_id' => $userID,
            'Games_id'     => $gameID,
            'pos_x'        => $posX,
            'pos_y'        => $posY
        ]);
    }
}
