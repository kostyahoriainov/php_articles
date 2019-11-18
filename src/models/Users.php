<?php

class Users extends Model
{

    public function authUser(string $login, string $password): bool
    {
        $hashed_password = md5($password);

        $connection = $this->getConnection($this->BEETROOT_DATABASE);

        $sql = "SELECT id FROM users WHERE login = '$login' AND password = '$hashed_password'";

        $result = $connection->query($sql);

        $connection->close();
        if (!$result->num_rows) {
            return false;
        }

        if (!isset($_SESSION['auth'])) {
            $_SESSION['auth'] = mysqli_fetch_assoc($result)['id'];
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

        $connection = $this->getConnection($this->BEETROOT_DATABASE);

        $sql = "INSERT INTO users (`first_name`, `last_name`, `email`, `login`, `password`)
                VALUES ('$first_name', '$last_name', '$email', '$login', '$password')";

        $result = $connection->query($sql);
        $connection->close();

        return $result;
    }
}