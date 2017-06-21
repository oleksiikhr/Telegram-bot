<?php

namespace tlg\telegram\models;

use tlg\telegram\helpers\SmileHelpers;

class Map
{
    const TABLE = 'maps';

    public static $map;

    public static function setMap($isOne, $isTwo = 0, $isThree = 0, $isFour = 0)
    {
        $query = \QB::table(self::TABLE);

        if ($isOne)
            $query->orWhere('isForOne', '=', 1);

        if ($isTwo)
            $query->orWhere('isForTwo', '=', 1);

        if ($isThree)
            $query->orWhere('isForThree', '=', 1);

        if ($isFour)
            $query->orWhere('isForFour', '=', 1);

        $query = $query->get();

        self::$map = $query[array_rand($query, 1)];
    }

    public static function parseLayout()
    {
        $layout = explode('/', self::$map->layout);
        $out = "";

        for ($i = 0; $i < self::$map->len_x; $i++) {
            for ($j = 0; $j < self::$map->len_y; $j++) {
                $out .= $layout[$i]{$j} == 0 ? SmileHelpers::WHITE : SmileHelpers::BLACK;
            }
            $out .= "\n";
        }

        return $out;
    }
}
