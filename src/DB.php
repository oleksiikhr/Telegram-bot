<?php

namespace tlg;

use Pixie\Connection;
use tlg\telegram\TelegramException;

class DB
{
    protected $db;

    public static const TABLE_USERS = 'users';

    static protected $db_inst = null;

    /**
     * DB constructor.
     *
     * @throws TelegramException
     *
     * @see https://github.com/usmanhalalit/pixie
     */
    public function __construct()
    {
        if ( is_null(self::$db_inst) ) {
            if ( ! file_exists(TLG_DIR . '/config/db.php') )
                throw new TelegramException('File db.php not found');

            $config = require TLG_DIR . '/config/db.php';

            self::$db_inst = new Connection($config['driver'], $config, 'QB');
        }

        $this->db = self::$db_inst;
    }

    /**
     * DB destructor.
     */
    public function __destruct()
    {
        $this->db = null;
        self::$db_inst = null;
    }
}
