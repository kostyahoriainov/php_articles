<?php

class Comments extends Model
{
    public function add(array $request): bool
    {
        $user_id = $this->getAuthUserId();
        $article_id = $request['article_id'];
        $text = trim($request['text']);

        $sql = "INSERT INTO comments (article_id, user_id, text) VALUES (:article_id, :user_id, :text)";

        $values = [
            ':article_id' => $article_id,
            ':user_id' => $user_id,
            ':text' => $text
        ];

        $result = $this->insertData($sql, $values);

        return $result;
    }

    public function getCommentById(int $id): array
    {
        $sql = "SELECT c.*, u.first_name, u.last_name FROM comments as c
                LEFT JOIN users as u ON c.user_id = u.id
                WHERE c.article_id = :id";

        $values = [
            ':id' => $id
        ];

        $result = $this->fetchData($sql, $values);

        return $result;
    }
}