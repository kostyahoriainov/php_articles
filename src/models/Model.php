<?php

class Model
{
    private function getConnection(string $database)
    {
        $db = DB_CONFIG['mysql'][$database];
        $connection = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database_name']);

        return $connection;
    }
}