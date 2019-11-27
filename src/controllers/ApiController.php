<?php

class ApiController extends Controller
{
    public function getArticles(): void
    {
        $this->checkAuth();
        $this->checkBanned();

        $articles = (new Articles())->all();

        sleep(1);

        echo json_encode($articles);
    }
}