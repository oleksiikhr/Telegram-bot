<?php

namespace tlg\telegram\helpers;

use tlg\telegram\tables\Sessions;

class MapHelpers
{
    public static function getPosForPlayers()
    {
        return [0, 1, 2, 1, 0, 3, 2, 3];
    }

    public static function getMap($tlgID, $gameID)
    {
        // TODO: if not health => not add

        $map = [
            ['w', 'w', 'w', 'w', 'w'],
            ['w', 'w', 'w', 'b', 'w'],
            ['w', 'w', 'w', 'w', 'w']
        ];

        $myTeam = Sessions::getUserByTlgID($tlgID)->team;
        $users = Sessions::getAllByGamesID($gameID);

        shuffle($users);

        foreach ($users as $user) {
            if ($tlgID === $user->Users_tlg_id)
                $map[$user->pos_y][$user->pos_x] = self::fromAngleInSmile($user->angle);
            else
                $map[$user->pos_y][$user->pos_x] = $myTeam === $user->team ? SmileHelpers::FRIEND : SmileHelpers::ENEMY;
        }

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($map[$i][$j] === 'w')
                    $map[$i][$j] = SmileHelpers::WHITE;
                else if ($map[$i][$j] === 'b')
                    $map[$i][$j] = SmileHelpers::BLACK;
            }
        }

        // Complete map
        $out = "";
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $out .= $map[$i][$j];
            }
            $out .= "\n";
        }

        return $out;
    }

    public static function fromAngleInSmile($angle)
    {
        switch ($angle) {
            case 1: return SmileHelpers::TOP_RIGHT;
            case 2: return SmileHelpers::RIGHT;
            case 3: return SmileHelpers::BOT_RIGHT;
            case 4: return SmileHelpers::BOT;
            case 5: return SmileHelpers::BOT_LEFT;
            case 6: return SmileHelpers::LEFT;
            case 7: return SmileHelpers::TOP_LEFT;
            default: return SmileHelpers::TOP;
        }
    }
}
