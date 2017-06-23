<?php

namespace tlg\telegram\controllers\game;

use tlg\telegram\TLG;
use tlg\telegram\tables\Game;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\tables\Sessions;
use tlg\telegram\helpers\MapHelpers;
use tlg\telegram\helpers\SmileHelpers;
use tlg\telegram\helpers\KeyboardHelpers;

class PlayController
{
    public static function newGame()
    {
        $users = User::sqlGetUsersByMethod(PMessage::$text);
        $count = count($users);

        if (PMessage::$text === 'Deathmatch' && $count < 4)
            return;

        if (PMessage::$text === 'Team Deathmatch' && $count < 4)
            return;

        if (PMessage::$text === 'Duel' && $count < 2)
            return;

        $gameID = Game::createNew(PMessage::$text);
        $pos = MapHelpers::getPosForPlayers();

        $maxPlayers = PMessage::$text === 'Duel' ? 2 : 4;
        $isTeam = PMessage::$text === 'Team Deathmatch';

        for ($i = 0, $j = 0; $j < $maxPlayers; $i += 2, $j++) {
            $rnd = mt_rand(0, 100);

            Sessions::add($users[$j]->tlg_id, $gameID, $pos[$i], $pos[$i + 1], ($isTeam ? $j % 2 : $j), $rnd);
            User::sqlUpdateMethod('played', $users[$j]->tlg_id);

            TLG::sendMessage(
                "The game started! You have 1 minute to move.\nChance to be the first: " . $rnd . "/100\n" .
                MapHelpers::getMap($users[$j]->tlg_id, $gameID),
                KeyboardHelpers::game(),
                $users[$j]->tlg_id
            );
        }
    }

    public static function move()
    {
        echo 'MOVE<br>';

        $user = Sessions::getUserByTlgID(User::getTlgId());

        if ( ! empty($user->action) ) {
            TLG::sendMessage('Expect to move other players');
            return;
        }

        if ( in_array(PMessage::$text, self::getMovesBtn()) ) {
            Sessions::updateByTlgID(User::getTlgId(), [
                'angle' => self::getKeyMovesBtn(PMessage::$text)
            ]);
            TLG::sendMessage(MapHelpers::getMap($user->Users_tlg_id, $user->Games_id), KeyboardHelpers::game());
            return;
        }

        switch (PMessage::$text) {
            case SmileHelpers::FIRE:   $action = 'fire'; break;
            case SmileHelpers::BLINK:  $action = 'blink'; break;
            case SmileHelpers::BLOCK:  $action = 'block'; break;
            case SmileHelpers::ATTACK: $action = 'attack'; break;
            default: TLG::sendMessage('Error action', KeyboardHelpers::game()); return;
        }

        Sessions::updateByTlgID(User::getTlgId(), [ 'action' => $action ]);
        TLG::sendMessage('Expect the players..');

        if (Sessions::isAllMoves($user->Games_id))
            self::nextRound($user->Games_id);
    }

    // SET cron
    public static function nextRound($gameID)
    {
        echo 'NEXT ROUND<br>';
        // Game time update
        // Check methods
        // Clear methods
        // if user is lose => self::endGame($gameID);
    }

    public static function endGame($gameID)
    {
        Sessions::deleteAllForGameID($gameID);
        Game::deleteByID($gameID);
    }

    public static function getKeyMovesBtn($needle)
    {
        return array_search($needle, self::getMovesBtn());
    }

    public static function getMovesBtn()
    {
        return [
            SmileHelpers::TOP, SmileHelpers::TOP_RIGHT, SmileHelpers::RIGHT,
            SmileHelpers::BOT_RIGHT, SmileHelpers::BOT, SmileHelpers::BOT_LEFT,
            SmileHelpers::LEFT, SmileHelpers::TOP_LEFT
        ];
    }
}
