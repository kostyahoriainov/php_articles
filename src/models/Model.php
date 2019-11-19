<?php

class Model
{

    protected const BEETROOT_DATABASE = 'beetroot';

    protected function getConnection(string $database)
    {
        $db = DB_CONFIG['mysql'][$database];
        $connection = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database_name']);

        return $connection;
    }

    protected function fetchData(string $sql): array
    {
        $data = [];

        $connection = $this->getConnection(self::BEETROOT_DATABASE);

        $result = $connection->query($sql);

        $connection->close();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    protected function insertData(string $sql): bool
    {
        $connection = $this->getConnection(self::BEETROOT_DATABASE);

        $result = $connection->query($sql);

        $connection->close();

        return $result;
    }

    public function getAuthUserId(): int
    {
        return (int) $_SESSION['auth'];
    }

    protected function checkUserPermission(int $article_user_id): bool
    {
        $user_id = $this->getAuthUserId();

        if ($article_user_id != $user_id) {
            return false;
        }

        return true;
    }

    public function saveSessionId(): void
    {
        setcookie('OLDSESSION', session_id(), time() + 3600, '/');
    }
}