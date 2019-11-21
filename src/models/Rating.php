<?php

class Rating extends Model
{

    public function add(int $user_id, int $article_id): bool
    {
        $values = [
            ':user_id' => $user_id,
            ':article_id' => $article_id
        ];

        $sql = "INSERT INTO user_article_rating (user_id, article_id) VALUES (:user_id, :article_id)";

        $result = $this->insertData($sql, $values);

        return $result;
    }

    public function remove(int $user_id, int $article_id): bool
    {
        $values = [
            ':user_id' => $user_id,
            ':article_id' => $article_id
        ];

        $sql = "DELETE FROM user_article_rating WHERE user_id = :user_id AND article_id = :article_id";

        $result = $this->insertData($sql, $values);

        return $result;
    }


    public function allById(int $id): array
    {
        $values = [
            ':id' => $id
        ];

        $sql = "SELECT u.* FROM user_article_rating as u WHERE u.article_id = :id";

        $result = $this->fetchData($sql, $values);

        return $result;
    }
}