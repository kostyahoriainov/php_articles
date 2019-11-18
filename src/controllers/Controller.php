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

}