<?php

namespace tlg\telegram\parse\messages;

class PEntities
{
    public static $isEntities = false;

    public static function set($data)
    {
        self::$isEntities = true;
    }
}
