<?php

namespace tlg\telegram\controllers;

use tlg\telegram\TLG;
use tlg\telegram\tables\Game;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\tables\Sessions;
use tlg\telegram\helpers\MapHelpers;

class PlayController
{
    public static function connectPlayers()
    {
        $users = User::sqlGetUsersByMethod(PMessage::$text);
        $count = count($users);

        if (PMessage::$text === 'Deathmatch' && $count != 4)
            return;

        if (PMessage::$text === 'Team Deathmatch' && $count != 4)
            return;

        if (PMessage::$text === 'Duel' && $count != 2)
            return;

        $gameID = Game::createNew(PMessage::$text);
        $pos = MapHelpers::getPosForPlayers();
        $i = 0;
        $team = 0;
        $isTeam = PMessage::$text === 'Team Deathmatch';

        foreach ($users as $user) {
            var_dump($user); echo '<br><br>';
            User::sqlUpdateMethod('played', $user->tlg_id);
            Sessions::add($user->tlg_id, $gameID, $pos[$i], $pos[$i + 1], ($isTeam ? $team % 2 : $team));
            $i += 2;
        }
    }

    public static function currentGame()
    {
        
    }
}
