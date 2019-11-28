<?php

class ApiController extends Controller
{
    public function getArticles(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $user_id = (new Model())->getAuthUserId();
        $articles = (new Articles())->userArticles(null, $user_id);

        sleep(1);

        echo json_encode($articles);
    }

    public function removeArticle(): void
    {
        $request = $this->getRequestParams();

        $result = (new Articles())->remove($request->article_id);
        $articles = $this->getArticles();

        echo $articles;
        die;
    }

    public function restoreArticle(): void
    {
        $request = $this->getRequestParams();

        $result = (new Articles())->restore($request->article_id);
        $articles = $this->getArticles();

        echo $articles;
        die;
    }

    public function getCategories(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $categories = (new Categories())->all();

        echo json_encode($categories);
        die;
    }

}