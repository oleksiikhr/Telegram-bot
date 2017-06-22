<?php

namespace tlg\telegram\tables;

class Sessions
{
    const TABLE = 'sessions';

    public static function add($userID, $gameID, $posX, $posY, $team)
    {
        return \QB::table(self::TABLE)->insert([
            'Users_tlg_id' => $userID,
            'Games_id'     => $gameID,
            'pos_x'        => $posX,
            'pos_y'        => $posY,
            'team'         => $team
        ]);
    }
}
