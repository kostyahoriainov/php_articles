<?php

class UsersController
{

    public function indexAction(): void
    {
        require_once '../views/login/index.phtml';
        die;
    }

    public function loginAction(): void
    {
        var_dump($_POST); die;
    }
}