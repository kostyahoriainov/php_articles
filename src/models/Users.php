<?php

class Users extends Model
{

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
}