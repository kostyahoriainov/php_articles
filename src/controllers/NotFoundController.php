<?php

class NotFoundController
{
    public function indexAction(): void
    {
        require_once '../views/not-found/index.phtml';
        die;
    }
}