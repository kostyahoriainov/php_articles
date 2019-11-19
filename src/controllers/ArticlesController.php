<?php

class ArticlesController extends Controller
{

    public function indexAction(): void
    {
        $this->checkAuth();

        $location = 'all';
        $user_id = (new Model())->getAuthUserId();
        $articles = (new Articles())->all();


        foreach ($articles as &$article) {
            $article['rating'] = (new Rating())->allById($article['id']);
            $article['rating_cnt'] = count($article['rating']);
            $article['user_has_rated'] = false;
            foreach ($article['rating'] as $item) {
                if ($item['user_id'] == $user_id) {
                    $article['user_has_rated'] = true;
                    break;
                }
            }
        }

        require_once "../views/articles/index.phtml";
        die;
    }

    public function showNewArticleForm(): void
    {
        $this->checkAuth();

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $categories = (new Categories())->all();

        require_once "../views/articles/add/index.phtml";
    }

    public function addArticleAction(): void
    {
        $this->checkAuth();

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
        $this->checkAuth();

        $edit_on = true;
        $location = 'user';
        $articles = (new Articles())->userArticles();

        require_once "../views/articles/index.phtml";
        die;
    }

    public function removeArticle(): void
    {
        $this->checkAuth();

        $article_id = $_REQUEST['id'];

        $result = (new Articles())->remove($article_id);

        if ($result) {
            header('Location: /articles/user-articles');
            die;
        }
    }

    public function showEditArticle(): void
    {
        $this->checkAuth();

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

    public function showDetailArticle(): void
    {
        $this->checkAuth();

        $id = $_REQUEST['id'];

        $article = (new Articles())->getDetailArticle($id, true)[0];

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $comments = (new Comments())->getCommentById($id);

        require_once "../views/articles/detail/index.phtml";
        die;
    }

}
