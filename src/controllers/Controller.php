<?php

class Controller
{

    protected function getRequest(): array
    {
        return $_POST;
    }

    protected function isUserAuth(): bool
    {
        return isset($_SESSION['auth']);
    }

    protected function checkRequestFields(array $request, string $location): void
    {
        foreach ($request as $field) {
            if (empty(trim($field))) {
                header('Location: ' . $location);
                die;
            }
        }
    }

    protected function checkAuth(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }
    }

    protected function checkBanned(array $user = []): void
    {
        if (empty($user)) {
            $user_id = (new Model())->getAuthUserId();
            $user = (new Users())->getUserById($user_id);
        }
        if ($user['banned'] == Users::USER_IS_BANNED) {
            require_once "../views/banned/index.phtml";
            die;
        }
    }

}