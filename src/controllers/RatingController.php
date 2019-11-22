<?php

class RatingController extends Controller
{
    public function changeRatingAction(): void
    {
        $this->checkAuth();

        $user_id = (new Model())->getAuthUserId();

        $article_id = $_REQUEST['article_id'];

        $rating_model = new Rating();

        $all_rating = $rating_model->allById($article_id);

        $user_has_rated = false;

        foreach ($all_rating as $item) {
            if ($item['user_id'] == $user_id) {
                $user_has_rated = true;
                break;
            }
        }
        $result = $user_has_rated
            ? $rating_model->remove($user_id, $article_id)
            : $rating_model->add($user_id, $article_id);

        header('Location: /articles');
        die;
    }
}