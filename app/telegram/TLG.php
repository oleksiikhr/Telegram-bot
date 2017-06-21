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
     * @param Keyboard $replyMarkup
     *
     * @return object
     */
    public static function sendMessage($text, $replyMarkup = null)
    {
        return self::send('sendMessage', [
            'text'          => $text,
            'chat_id'       => PFrom::$id,
            'reply_markup'  => $replyMarkup
        ], true);
    }
}
