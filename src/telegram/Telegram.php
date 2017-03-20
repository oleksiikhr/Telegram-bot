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
     *
     * @return object
     */
    public function send($method, $params, $typeMethod = 'GET')
    {
        if ($typeMethod !== 'POST') {
            $query = $this->request( self::API_URL . 'bot' . $this->_token . '/'
                . $method . '?' . http_build_query($params), true );
        } else {
            $query = $this->request( self::API_URL . 'bot' . $this->_token . '/'
                . $method, true, 'POST', http_build_query($params) );
        }

        return $query;
    }
}
