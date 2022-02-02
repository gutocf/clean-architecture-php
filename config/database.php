<?php

abstract class Database
{
    private static $config = [
        'default' => [
            'database' => 'ca',
            'username' => 'root',
            'password' => ''
        ]
    ];

    public static function getConfig($name = 'default')
    {
        return self::$config[$name] ?? null;
    }
}
