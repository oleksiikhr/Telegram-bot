<?php

namespace tlg\telegram\models;

use tlg\telegram\helpers\SmileHelpers;

class Map
{
    const TABLE = 'maps';

    public static $map;
    public static $layout;

    public static function run($players)
    {
        self::setMap($players);
        self::parseLayout();
        self::addPlayers($players);
    }

    public static function setMap($players)
    {
        $query = \QB::table(self::TABLE)
            ->where('players', '=', $players)
            ->orWhere('players', '=', $players + 1);

        $query = $query->get();

        self::$map = $query[array_rand($query, 1)];
    }

    public static function parseLayout()
    {
        // TODO add users on map
//        $users = Sessions::
        $layout = explode('/', self::$map->layout);
        $out = "";

        for ($i = 0; $i < self::$map->len_x; $i++) {
            for ($j = 0; $j < self::$map->len_y; $j++) {
                $out .= $layout[$i]{$j} == 0 ? SmileHelpers::WHITE : SmileHelpers::BLACK;
            }
            $out .= "\n";
        }

        self::$layout = $out;
    }

    public static function getSpawns()
    {
        return explode('/', self::$map->layout);
    }
}
