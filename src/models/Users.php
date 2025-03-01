<?php

class Users extends Model
{

    public const USER_NOT_BANNED = 0;
    public const USER_IS_BANNED = 1;

    public function all(): array
    {
        $sql = "SELECT * FROM users";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql);

        return $result;
    }


    public function authUser(string $login, string $password): bool
    {
        $values = [
            ':login' => $login,
            ':password' => md5($password)
        ];

        $sql = "SELECT id FROM users WHERE login = :login AND password = :password";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        if (empty($result)) {
            return false;
        }

        if (!isset($_SESSION['auth'])) {
            $_SESSION['auth'] = $result[0]['id'];
        }

        return true;
    }

    public function createNewUser(array $request): bool
    {
        $values = [
            ':first_name' => trim($request['first_name']),
            ':last_name' => trim($request['last_name']),
            ':email' => trim($request['email']),
            ':login' => trim($request['login']),
            ':password' => md5(trim($request['password']))
        ];

        $sql = "INSERT INTO users (first_name, last_name, email, login, password)
                VALUES (:first_name, :last_name, :email, :login, :password)";

        $result = $this->insertData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function getUserById(int $id): array
    {
        $values = [
            ':id' => $id
        ];

        $sql = "SELECT * FROM users WHERE id = :id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result[0];
    }

    public function addBlockUser(int $user_id): array
    {
        $values = [
            ':banned' => Users::USER_IS_BANNED,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE users SET banned = :banned WHERE id = :user_id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function removeBlockUser(int $user_id): array
    {
        $values = [
            ':banned' => Users::USER_NOT_BANNED,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE users SET banned = :banned WHERE id = :user_id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function addModerateUser(int $user_id): array
    {
        $values = [
            ':user_type_id' => UserTypes::TYPE_MODERATOR,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE users SET user_type_id = :user_type_id WHERE id = :user_id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function removeModerateUser(int $user_id): array
    {
        $values = [
            ':user_type_id' => UserTypes::TYPE_USER,
            ':user_id' => $user_id
        ];

        $sql = "UPDATE users SET user_type_id = :user_type_id WHERE id = :user_id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }
}