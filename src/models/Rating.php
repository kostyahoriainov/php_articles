<?php

class Rating extends Model
{

    public function add(int $user_id, int $article_id): bool
    {
        $sql = "INSERT INTO user_article_rating (`user_id`, `article_id`) VALUES ('$user_id', '$article_id')";

        $result = $this->insertData($sql);

        return $result;
    }

    public function remove(int $user_id, int $article_id): bool
    {
        $sql = "DELETE FROM user_article_rating WHERE `user_id` = '$user_id' AND `article_id` = '$article_id'";

        $result = $this->insertData($sql);

        return $result;
    }


    public function allById(int $id): array
    {
        $sql = "SELECT u.* FROM user_article_rating as u WHERE u.article_id = $id";

        $result = $this->fetchData($sql);

        return $result;
    }
}