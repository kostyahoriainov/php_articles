<?php

class ArticlesController extends Controller
{

    public function indexAction(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $location = 'all';
        $user_id = (new Model())->getAuthUserId();

        $auth_user = (new Users())->getUserById($user_id);

        $articles = (new Articles())->all();

        foreach ($articles as $key => $article) {
            $articles[$key] = $this->getArticleRating($article, $user_id);
        }

        require_once "../views/articles/index.phtml";
        die;
    }

    public function addArticleAction(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/add?empty');
        $action = $request['action'];

        $result = $action === 'add'
            ? (new Articles())->add($request)
            : (new Articles())->draft($request);

        if ($result) {
            header('Location: /articles');
            die;
        }
    }

    public function removeArticleAction(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $article_id = $_REQUEST['id'];

        $result = (new Articles())->remove($article_id);

        if ($result) {
            header('Location: /articles/user');
            die;
        }
    }

    public function restoreArticleAction(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $article_id = $_REQUEST['id'];

        $result = (new Articles())->restore($article_id);

        if ($result) {
            header('Location: /articles/user');
            die;
        }
    }

    public function editArticleAction(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/edit?id=' . $request['id'] . '&empty');

        $result = (new Articles())->edit($request);

        if ($result) {
            header('Location: /articles/user');
            die;
        }
    }

    public function showNewArticleForm(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $user_id = (new Model())->getAuthUserId();
        $auth_user = (new Users())->getUserById($user_id);

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $categories = (new Categories())->all();

        require_once "../views/articles/add/index.phtml";
    }

    public function showUserArticles(?int $status = null): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $location = 'user';

        $user_id = (new Model())->getAuthUserId();
        $auth_user = (new Users())->getUserById($user_id);

        require_once "../views/articles/articles-app.phtml";
        die;
    }

    public function showEditArticle(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $article_id = $_REQUEST['id'];

        $article = (new Articles())->articleById($article_id);
        $categories = (new Categories())->all();

        $user_id = (new Model())->getAuthUserId();
        $auth_user = (new Users())->getUserById($user_id);

        require_once "../views/articles/edit/index.phtml";
        die;
    }

    public function showDetailArticle(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $user_id = (new Model())->getAuthUserId();
        $auth_user = (new Users())->getUserById($user_id);

        $id = $_REQUEST['id'];

        $article = (new Articles())->detailArticle($id);

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        $article = $this->getArticleRating($article, $user_id);

        $comments = (new Comments())->getCommentById($id, 'article_id');

        require_once "../views/articles/detail/index.phtml";
        die;
    }

    private function getArticleRating(array $article, int $user_id): array
    {
        $article['rating'] = (new Rating())->allById($article['id']);
        $article['rating_cnt'] = count($article['rating']);
        $article['user_has_rated'] = false;
        foreach ($article['rating'] as $item) {
            if ($item['user_id'] == $user_id) {
                $article['user_has_rated'] = true;
                break;
            }
        }

        return $article;
    }

}
