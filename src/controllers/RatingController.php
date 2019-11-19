<?php

class RatingController extends Controller
{
    public function changeRatingAction(): void
    {
        $this->checkAuth();

        $user_id = (new Model())->getAuthUserId();

        $article_id = $_REQUEST['article_id'];

        $rating = (new Rating())->allById($article_id);

        $user_has_rated = false;

        foreach ($rating as $item) {
            if ($item['user_id'] == $user_id) {
                $user_has_rated = true;
                break;
            }
        }
        $result = $user_has_rated
            ? (new Rating())->remove($user_id, $article_id)
            : (new Rating())->add($user_id, $article_id);

        if ($result) {
            header('Location: /articles');
            die;
        }
    }
}