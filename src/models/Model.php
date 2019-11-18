<?php

class Model
{

    protected $BEETROOT_DATABASE = 'beetroot';

    protected function getConnection(string $database)
    {
        $db = DB_CONFIG['mysql'][$database];
        $connection = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database_name']);

        return $connection;
    }
}