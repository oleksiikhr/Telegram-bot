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

        $arrRand = [];

        for ($i = 0, $j = 0; $j < $maxPlayers; $i += 2, $j++) {
            $arrRand[] = mt_rand(0, 100);

            Sessions::add($users[$j]->tlg_id, $gameID, $pos[$i], $pos[$i + 1], ($isTeam ? $j % 2 : $j), $arrRand[$j]);
            User::sqlUpdateMethod('played', $users[$j]->tlg_id);
        }

        for ($i = 0; $i < $maxPlayers; $i++) {
            TLG::sendMessage(
                "The game started! You have 1 minute to move.\nChance to be the first: " . $arrRand[$i] . "/100\n" .
                MapHelpers::getMap($users[$i]->tlg_id, $gameID),
                KeyboardHelpers::game(),
                $users[$i]->tlg_id
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

    // TODO: !!! VERY-VERY BIG AND BAD CODE METHOD !!!
    public static function nextRound($gameID)
    {
        echo 'NEXT ROUND<br><br><br>';

        $users = Sessions::getAllByGamesID($gameID, true);
        $msg = "";
        $k = 0;

        foreach ($users as $user) {
            $name = User::sqlGetUserByTlgId($user->Users_tlg_id)->name;
            $k++;
            $msg .= "#{$k}. ";

            // TODO: Life is removed depending on the angle.
            if ($user->action === 'attack') {
                list($x, $y) = self::direct($user->angle);
                $x += $user->pos_x;
                $y += $user->pos_y;

                if ($x === 3 && $y === 1) {
                    Sessions::updateByTlgID($user->Users_tlg_id, [
                        'health' => $user->health - 5
                    ]);

                    $msg .= "{$name} crashed into the wall [-5hp]";
                }
                // TODO: out cart.. else if ()
                else {
                    $isAttacked = false;

                    foreach ($users as $temp) {
                        if ($temp->health <= 0) { // TODO: check
                            unset($temp);
                            continue;
                        }

                        if ($x == $temp->pos_x && $y == $temp->pos_y) {
                            Sessions::updateByTlgID($temp->Users_tlg_id, [
                                'health' => $temp->health - 10
                            ]);

                            $users[$k - 1]->health = $temp->health - 10;
                            $enemyName = User::sqlGetUserByTlgId($temp->Users_tlg_id)->name;
                            $msg .= "{$name} hit {$enemyName} [-10hp]";
                            $isAttacked = true;
                            break;
                        }
                    }

                    if (!$isAttacked) {
                        Sessions::updateByTlgID($user->Users_tlg_id, [
                            'pos_x'  => $x,
                            'pos_y'  => $y
                        ]);
                        $users[$k - 1]->pos_x = $x;
                        $users[$k - 1]->pos_x = $y;

                        $msg .= "{$name} go to {$x}:{$y}";
                    }
                }
            }
            // END action - ATTACK

            // TODO: another action..
            $msg .= "\n";
        }

        foreach ($users as $user) {
            $rnd = rand(0, 100);

            Sessions::updateByTlgID($user->Users_tlg_id, [
                'action' => null,
                'rnd'    => $rnd
            ]);

            TLG::sendMessage(
                "$msg\n" . MapHelpers::getMap($user->Users_tlg_id, $user->Games_id) . "\n\nChance to be the first: {$rnd}",
                KeyboardHelpers::game(), $user->Users_tlg_id
            );
        }

        // TODO: if user is the lose => self::endGame($gameID);
    }

    // Out x, y
    public static function direct($angle)
    {
        switch ($angle) {
            case 0: return [0, -1];
            case 1: return [1, -1];
            case 2: return [1, 0];
            case 3: return [1, 1];
            case 4: return [0, 1];
            case 5: return [-1, 1];
            case 6: return [-1, 0];
            case 7: return [-1, -1];
            default: return [0, 0];
        }
    }

    public static function endGame($gameID)
    {
        $users = Sessions::getAllByGamesID($gameID);

        foreach ($users as $user) {
            User::sqlUpdateUser(['method' => null], $user->Users_tlg_id);
        }

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
