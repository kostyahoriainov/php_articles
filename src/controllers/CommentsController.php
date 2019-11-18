<?php

class CommentsController extends Controller
{
    public function addCommentAction(): bool
    {
        $this->checkAuth();

        $request = $this->getRequest();

        $this->checkRequestFields($request, '/articles/detail?id=' . $request['article_id'] . '&empty=1');

        $result = (new Comments())->add($request);

        if ($result) {
            header('Location: /articles/detail?id=' . $request['article_id']);
        }
    }
}