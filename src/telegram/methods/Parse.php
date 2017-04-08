<?php

namespace tlg\telegram\methods;

class Parse
{
    public static $messageID;
    public static $text;

    public static $fromID;
    public static $fromUsername;
    public static $fromFirstName;

    public function __construct($data)
    {
        self::$messageID = $data->message->message_id;
        self::$text = $data->message->text;

        self::$fromID = $data->message->from->id;
        self::$fromFirstName = $data->message->from->first_name;
        self::$fromUsername = $data->message->from->username;

    }
}
