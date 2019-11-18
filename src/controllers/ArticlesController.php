<?php

class ArticlesController extends Controller
{

    public function indexAction(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }
        require_once "../views/articles/index.phtml";
        die;
    }

}
