<?php

namespace tlg\telegram\tables;

use tlg\telegram\parse\types\PFrom;

class Sessions
{
    const TABLE = 'sessions';

    public static function add($userID, $gameID, $posX, $posY, $team, $rnd)
    {
        return \QB::table(self::TABLE)->insert([
            'Users_tlg_id' => $userID,
            'Games_id'     => $gameID,
            'pos_x'        => $posX,
            'pos_y'        => $posY,
            'team'         => $team,
            'rnd'          => $rnd
        ]);
    }

    public static function deleteAllForGameID($gameID)
    {
        return \QB::table(self::TABLE)->where('Games_id', '=', $gameID)->delete();
    }

    public static function getAllByGamesID($gamesID)
    {
        return \QB::table(self::TABLE)->where('Games_id', '=', $gamesID)->get();
    }

    public static function getUserByTlgID($tlgID)
    {
        return \QB::table(self::TABLE)->where('Users_tlg_id', '=', $tlgID)->first();
    }

    public static function isAllMoves($gameID)
    {
        return \QB::table(self::TABLE)
            ->where('Games_id', '=', $gameID)
            ->where('action', '=', null)
            ->count() == 0;
    }

    public static function updateByTlgID($tlgID, $data)
    {
        $data['update_time'] = date("Y-m-d H:i:s");
        \QB::table(self::TABLE)->where('Users_tlg_id', '=', $tlgID)->update($data);
    }
}
