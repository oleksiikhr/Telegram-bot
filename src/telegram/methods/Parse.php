<?php

namespace tlg\telegram\methods;

class Parse
{
    public static $text;
    public static $messageID;

    public static $fromID;
    public static $fromUsername;
    public static $fromFirstName;

    public function __construct($data)
    {
        self::$text =          $data->message->text;
        self::$messageID =     $data->message->message_id;

        self::$fromID =        $data->message->from->id;
        self::$fromUsername =  $data->message->from->username;
        self::$fromFirstName = $data->message->from->first_name;

    }
}
