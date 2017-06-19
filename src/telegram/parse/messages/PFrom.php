<?php

namespace tlg\telegram\parse\messages;

class PFrom
{
    public static $isFrom = false;

    public static $id;
    public static $username;
    public static $firstName;
    public static $languageCode;

    public static function set($data)
    {
        self::$isFrom = true;

        self::$id = isset($data->id) ? $data->id : null;
        self::$username = isset($data->username) ? $data->username : null;
        self::$firstName = isset($data->first_name) ? $data->first_name : null;
        self::$languageCode = isset($data->language_code) ? $data->language_code : null;
    }
}
