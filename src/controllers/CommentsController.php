<?php

class CommentsController extends Controller
{
    public function addCommentAction(): bool
    {
        $this->checkAuth();
        $this->checkBanned();

        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/detail?id=' . $request['article_id'] . '&empty');

        $result = (new Comments())->add($request);

        if ($result) {
            header('Location: /articles/detail?id=' . $request['article_id']);
        }
    }
}