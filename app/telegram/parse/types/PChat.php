<?php

namespace tlg\telegram\parse\types;

class PChat
{
    public static $isChat = false;

    public static $id;
    public static $type;
    public static $username;
    public static $firstName;

    public static function set($data)
    {
        self::$isChat = true;

        self::$id = isset($data->id) ? $data->id : null;
        self::$type = isset($data->type) ? $data->type : null;
        self::$username = isset($data->username) ? $data->username : null;
        self::$firstName = isset($data->first_name) ? $data->first_name : null;
    }
}
