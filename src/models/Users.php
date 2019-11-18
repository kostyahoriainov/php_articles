<?php

class Users extends Model
{

    public function authUser(string $login, string $password): bool
    {
        $hashed_password = md5($password);

        $sql = "SELECT id FROM users WHERE login = '$login' AND password = '$hashed_password'";

        $result = $this->fetchData($sql);

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
        $first_name = trim($request['first_name']);
        $last_name = trim($request['last_name']);
        $login = trim($request['login']);
        $password = md5(trim($request['password']));
        $email = trim($request['email']);


        $sql = "INSERT INTO users (`first_name`, `last_name`, `email`, `login`, `password`)
                VALUES ('$first_name', '$last_name', '$email', '$login', '$password')";

        $result = $this->insertData($sql);

        return $result;
    }
}