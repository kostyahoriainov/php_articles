<?php

class ArticlesController extends Controller
{

    public function indexAction(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        $location = 'all';
        $articles = (new Articles())->all();

        require_once "../views/articles/index.phtml";
        die;
    }

    public function showNewArticleForm(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $categories = (new Categories())->all();

        require_once "../views/articles/add/index.phtml";
    }

    public function addArticleAction(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/add?empty=1');

        $result = (new Articles())->add($request);

        if ($result) {
            header('Location: /articles');
            die;
        }
    }

    public function showUserArticles(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        $edit_on = true;
        $location = 'user';
        $articles = (new Articles())->userArticles();

        require_once "../views/articles/index.phtml";
        die;
    }

    public function removeArticle(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        $article_id = $_REQUEST['id'];

        $result = (new Articles())->remove($article_id);

        if ($result) {
            header('Location: /articles/user-articles');
            die;
        }
    }

    public function showEditArticle(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $article_id = $_REQUEST['id'];

        $article = (new Articles())->articleById($article_id);
        $categories = (new Categories())->all();

        require_once "../views/articles/edit/index.phtml";
        die;
    }

    public function editArticleAction(): void
    {
        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/edit?id=' . $request['id'] . '&empty=1');

        $result = (new Articles())->edit($request);

        if ($result) {
            header('Location: /articles/user-articles');
            die;
        }
    }

}
