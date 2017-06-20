<?php

namespace tlg\telegram\parse\messages;

class PEntities
{
    public static $isEntities = false;

    // TODO: Add code
    public static function set($data)
    {
        self::$isEntities = true;
    }
}
