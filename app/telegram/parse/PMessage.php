<?php

namespace tlg\telegram\parse;

use tlg\telegram\parse\types\PChat;
use tlg\telegram\parse\types\PFrom;
use tlg\telegram\helpers\SmileHelpers;
use tlg\telegram\parse\types\PEntities;

class PMessage
{
    public static $isMessage = false;

    public static $text;
    public static $date;
    public static $messageID;

    public static $command;

    public static function set($data)
    {
        if ( empty($data->message) )
            return;

        $message = $data->message;
        self::$isMessage = true;

        self::$text = isset($message->text) ? $message->text : null;
        self::$date = isset($message->date) ? $message->date : null;
        self::$messageID = isset($message->message_id) ? $message->message_id : null;

        if ( isset($message->from) )
            PFrom::set($message->from);

        if ( isset($message->chat) )
            PChat::set($message->chat);

        if ( isset($message->entities) )
            PEntities::set($message->entities);

        self::$command = self::whichCommand();
    }

    public static function whichCommand()
    {
        switch (mb_substr(self::$text, 0, 1)) {
            case SmileHelpers::ABOUT_ME: return '/about_me';
            case SmileHelpers::SEARCH: return '/search';
            case SmileHelpers::HOME: return '/home';
            default: return '';
        }
    }
}
