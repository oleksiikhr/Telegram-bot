<?php

namespace tlg\telegram;

use tlg\Web;
use tlg\telegram\parse\types\PFrom;
use tlg\telegram\methods\keyboard\Keyboard;

class TLG extends Web
{
    const API_URL = 'https://api.telegram.org/';

    /**
     * Send request to telegram.
     *
     * @param string $method
     * @param array  $params
     * @param bool   $isPost
     * @param bool   $decode
     *
     * @return object
     */
    public static function send($method, $params = [], $isPost = false, $decode = true)
    {
        if ($isPost)
            return self::request( self::API_URL . 'bot' . TLG_TOKEN . '/'
                . $method . '?' . http_build_query($params), $decode );

        return self::request( self::API_URL . 'bot' . TLG_TOKEN . '/'
            . $method, $decode, 'POST', http_build_query($params) );
    }

    /**
     * Send message.
     *
     * @param string   $text
     * @param int      $chatID
     * @param string   $parseMode
     * @param Keyboard $replyMarkup
     * @param int      $replyToMsgID
     *
     * @return object
     */
    public static function sendMessage($text, $chatID = null, $parseMode = null, $replyToMsgID = null, $replyMarkup = null)
    {
        return self::send('sendMessage', [
            'text'                => $text,
            'chat_id'             => empty($chatID) ? PFrom::$id : $chatID,
            'parse_mode'          => $parseMode,
            'reply_to_message_id' => $replyToMsgID,
            'reply_markup'        => $replyMarkup
        ], true);
    }
}
