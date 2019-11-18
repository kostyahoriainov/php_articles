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

}