<?php

namespace tlg\telegram;

use tlg\Web;
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
     * @param int      $chat_id
     * @param string   $text
     * @param string   $parse_mode
     * @param int      $reply_to_message_id
     * @param Keyboard $reply_markup
     *
     * @return object
     */
    public static function sendMessage($chat_id, $text, $parse_mode = null, $reply_to_message_id = null, $reply_markup = null)
    {
        return self::send('sendMessage', [
            'chat_id'             => $chat_id,
            'text'                => $text,
            'parse_mode'          => $parse_mode,
            'reply_to_message_id' => $reply_to_message_id,
            'reply_markup'        => $reply_markup
        ], true);
    }
}
