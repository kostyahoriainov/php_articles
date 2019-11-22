<?php

class Model
{

    protected const BEETROOT_DATABASE = 'beetroot';

    private static $db_connection = array();

    protected static function getConnection(string $database): PDO
    {
        $db = DB_CONFIG['mysql'][$database];
        $dsn = "mysql:dbname=$database;host=mysql";
        try {
            if (!isset(self::$db_connection['mysql'])) {
                self::$db_connection['mysql'] = new PDO($dsn, $db['user'], $db['password']);
            }
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        $connection = self::$db_connection['mysql'];

        return $connection;
    }

    protected function fetchData(string $database, string $sql, array $params = []): array
    {
        $connection = $this->getConnection($database);

        $query = $connection->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $param) {
                $query->bindValue($key, $param);
            }
        }

        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    protected function insertData(string $database, string $sql, array $params = []): bool
    {
        $connection = $this->getConnection($database);

        $query = $connection->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $param) {
                $query->bindValue($key, $param);
            }
        }

        $result = $query->execute();

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
        setcookie('OLDSESSION', session_id(), time() + 60 * 60 * 24, '/');
    }
}