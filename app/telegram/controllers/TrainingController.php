<?php

namespace tlg\telegram\controllers;

use tlg\telegram\models\Map;
use tlg\telegram\TLG;
use tlg\telegram\models\User;
use tlg\telegram\models\Game;
use tlg\telegram\models\Search;
use tlg\telegram\models\Sessions;
use tlg\telegram\helpers\KeyboardHelpers;

class TrainingController
{
    public static function createGame($mapID, $game)
    {
        TLG::sendMessage('Welcome to the training!', KeyboardHelpers::game());
        User::updateMethod('training');
        Search::deleteUser();

        $createdGameID = Game::createNew($mapID, $game);
        Sessions::add(User::getTlgId(), $createdGameID, 0, 1);

        Map::setMap(1);
        TLG::sendMessage(Map::parseLayout());

        var_dump(Map::parseLayout());
    }
}
