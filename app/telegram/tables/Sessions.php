<?php

namespace tlg\telegram\tables;

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

    public static function getAllByGamesID($gamesID, $inMove = false)
    {
        $q = \QB::table(self::TABLE)->where('Games_id', '=', $gamesID);

        return $inMove ? $q->where('health', '>', 0)->orderBy('rnd', 'DESC')->get() : $q->get();
    }

    public static function getUserByTlgID($tlgID)
    {
        return \QB::table(self::TABLE)->where('Users_tlg_id', '=', $tlgID)->first();
    }

    public static function isAllMoves($gameID)
    {
        return \QB::table(self::TABLE)
            ->where('Games_id', '=', $gameID)
            ->whereNull('action')
            ->count() == 0;
    }

    public static function updateByTlgID($tlgID, $data)
    {
        $data['update_time'] = date("Y-m-d H:i:s");
        \QB::table(self::TABLE)->where('Users_tlg_id', '=', $tlgID)->update($data);
    }
}
