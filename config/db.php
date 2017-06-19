<?php

/**
 * Configuration local for bd.
 *
 * NOTE: Uncomment this lines for local dev.
 */

return [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'tlg',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
];

/**
 * Configuration Heroku for bd. 
 *
 * NOTE: These credentials are not permanent.
 */

//return [
//    'driver'   => 'pgsql',
//    'host'     => 'ec2-54-225-242-74.compute-1.amazonaws.com',
//    'database' => 'ddlmlukbiduagb',
//    'username' => 'sklhxruujniuwz',
//    'password' => '87825ad5266206271da51a71f87120358a7e4a7b18e08895ce78afccde965468',
//    'charset'  => 'utf8',
//    'prefix'   => '',
//    'schema'   => 'public',
//];
