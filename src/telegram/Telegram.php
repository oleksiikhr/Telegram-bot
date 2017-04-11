<?php

namespace tlg\telegram;

use tlg\Web;
use tlg\telegram\methods\Parse;
use tlg\telegram\methods\keyboard\Keyboard;

class Telegram extends Web
{
    private $_token;

    const API_URL = 'https://api.telegram.org/';

    /**
     * Telegram constructor.
     *
     * @param string $token
     *
     * @throws TelegramException
     * @see https://core.telegram.org/bots/api
     */
    public function __construct($token)
    {
        if ( empty($token) )
            throw new TelegramException("Token is empty");

        $this->_token = $token;
    }

    /**
     * Send request to.
     *
     * @param string $method
     * @param array $params
     * @param bool $isPost
     * @param bool $decode
     *
     * @return object
     */
    public function send($method, $params, $isPost = false, $decode = true)
    {
        if ($isPost)
            return $this->request( self::API_URL . 'bot' . $this->_token . '/'
                . $method . '?' . http_build_query($params), $decode );

        return $this->request( self::API_URL . 'bot' . $this->_token . '/'
            . $method, $decode, 'POST', http_build_query($params) );
    }

    /**
     * Initial launch.
     *
     * @param object $data
     *
     * @return void
     */
    public function run($data)
    {
        new Parse($data);
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
    public function sendMessage($chat_id, $text, $parse_mode = null, $reply_to_message_id = null, $reply_markup = null)
    {
        return $this->send('sendMessage', [
            'chat_id'             => $chat_id,
            'text'                => $text,
            'parse_mode'          => $parse_mode,
            'reply_to_message_id' => $reply_to_message_id,
            'reply_markup'        => $reply_markup
        ], true);
    }
}
