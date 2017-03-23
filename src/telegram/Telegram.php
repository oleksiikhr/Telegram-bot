<?php

namespace tlg\telegram;

use tlg\Web;

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
        if ( empty($token) ) {
            throw new TelegramException("Token is empty");
        }

        $this->_token = $token;
    }

    /**
     * Send request to.
     *
     * @param string $method
     * @param array $params
     * @param string $typeMethod
     * @param bool $decode
     *
     * @return object
     */
    public function send($method, $params, $typeMethod = 'GET', $decode = true)
    {
        if ( mb_strtoupper($typeMethod) !== 'POST' ) {
            return $this->request( self::API_URL . 'bot' . $this->_token . '/'
                . $method . '?' . http_build_query($params), $decode );
        }

        return $this->request( self::API_URL . 'bot' . $this->_token . '/'
            . $method, $decode, 'POST', http_build_query($params) );
    }
}
