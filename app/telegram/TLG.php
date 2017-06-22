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
     * @param bool   $isPost
     * @param bool   $decode
     * @param array  $params
     * @param string $method
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
     * @param int      $chatID
     * @param string   $text
     * @param Keyboard $replyMarkup
     *
     * @return object
     */
    public static function sendMessage($text, $replyMarkup = null, $chatID = null)
    {
        if (empty($chatID))
            $chatID = PFrom::$id;

        return self::send('sendMessage', [
            'text'          => $text,
            'chat_id'       => $chatID,
            'reply_markup'  => $replyMarkup
        ], true);
    }
}
