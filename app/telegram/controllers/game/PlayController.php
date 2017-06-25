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
        $user = Sessions::getUserByTlgID(User::getTlgId());

        // Temporary
        if ( $user->health <= 0 ) {
            TLG::sendMessage('You are dead, wait for the end of the game');
            return;
        }

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

    // TODO: VERY-VERY BIG METHOD
    public static function nextRound($gameID)
    {
        $users = Sessions::getAllByGamesID($gameID, true);
        $count = count($users);
        $msg = "";

        for ($i = 0; $i < $count; $i++) {
            $name = User::sqlGetUserByTlgId($users[$i]->Users_tlg_id)->name;
            $msg = "{$i}. ";

            if ($users[$i] == null || $users[$i]->health <= 0) {
                $msg .= "{$name} misses a move because of a lack of lives";
                continue;
            }

            // START : ACTION - ATTACK AND BLINK
            if ($users[$i]->action === 'attack' || $users[$i]->action === 'blink') {
                list($x, $y) = self::direct($users[$i]->angle);
                $x += $users[$i]->pos_x;
                $y += $users[$i]->pos_y;

                if ($users[$i]->action === 'blink') {
                    list($px, $py) = self::direct($users[$i]->angle);
                    $x += $px;
                    $y += $py;
                }

                if ( ! self::actionInWall($users[$i]->Users_tlg_id, $users[$i]->health, $x, $y) ) {
                    $msg .= "{$name} crashed into the wall [-5hp]\n";
                    $users[$i]->health -= 5;
                    continue;
                }

                $moved = true;

                for ($j = 0; $j < $count; $j++) {
                    if ($i == $j || $users[$j]->health <= 0)
                        continue;

                    if ($users[$i]->team == $users[$j]->team) {
                        $msg .= "{$name} the user did not hit a friend on command\n";
                        $moved = false;
                        break;
                    }

                    if ($x == $users[$j]->pos_x && $y == $users[$j]->pos_y) {
                        $power = self::impactForce($users[$i]->angle, $users[$j]->angle);
                        Sessions::updateByTlgID($users[$j]->Users_tlg_id, [ 'health' => $users[$j]->health - $power ]);

                        if ($users[$j]->health - $power <= 0) {
                            $curUser = User::sqlGetUserByTlgId($users[$j]->Users_tlg_id);
                            User::sqlUpdateUser(['kills' => $curUser->kills + 1], $users[$j]->Users_tlg_id);
                        }

                        $users[$j]->health -= $power;
                        $enemyName = User::sqlGetUserByTlgId($users[$j]->Users_tlg_id)->name;
                        $msg .= "{$name} hit {$enemyName} [-{$power}hp]\n";
                        $moved = false;
                        break;
                    }
                }

                if ($moved) {
                    Sessions::updateByTlgID($users[$i]->Users_tlg_id, [ 'pos_x'  => $x, 'pos_y'  => $y ]);
                    $users[$i]->pos_x = $x;
                    $users[$i]->pos_x = $y;

                    $msg .= "{$name} go to {$x}:{$y}\n";
                }
            }
            // END : ACTION - ATTACK

            // TODO: another action..
        }

        // TODO: If team is dead - endGame

        foreach ($users as $user) {
            if ($user->health <= 0) {
                TLG::sendMessage("You were killed\n\n" .
                    "$msg\n" . MapHelpers::getMap($user->Users_tlg_id, $user->Games_id),
                    KeyboardHelpers::home(), $user->Users_tlg_id);

                Sessions::deleteUser($user->Users_tlg_id);
                User::sqlUpdateMethod(null, $user->Users_tlg_id);

                continue;
            }

            $rnd = rand(0, 100);

            Sessions::updateByTlgID($user->Users_tlg_id, [
                'action' => null,
                'rnd'    => $rnd
            ]);

            TLG::sendMessage(
                "$msg\n" . MapHelpers::getMap($user->Users_tlg_id, $user->Games_id)
                    . "\nChance to be the first: {$rnd}/100\nYou have lives: {$user->health}",
                KeyboardHelpers::game(), $user->Users_tlg_id
            );
        }
    }

    public static function actionInWall($tlgID, $health, $x, $y)
    {
        if (($x === 3 && $y === 1) || $x > MapHelpers::getLenX() || $y > MapHelpers::getLenY() || $x < 0 || $y < 0) {
            Sessions::updateByTlgID($tlgID, [
                'health' => $health - 5
            ]);

            return false;
        }

        return true;
    }

    public static function impactForce($angleOne, $angleTwo)
    {
        $clockwise = abs($angleOne - $angleTwo);
        $anti = abs($clockwise - 7);
        $power = $clockwise > $anti ? $anti : $clockwise;

        return ($power + 1) * 10;
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
