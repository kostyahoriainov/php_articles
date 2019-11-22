<?php

class Comments extends Model
{
    public function add(array $request): bool
    {
        $values = [
            ':article_id' => $request['article_id'],
            ':user_id' => $this->getAuthUserId(),
            ':text' => trim($request['text'])
        ];

        $sql = "INSERT INTO comments (article_id, user_id, text) VALUES (:article_id, :user_id, :text)";

        $result = $this->insertData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function getCommentById(int $id): array
    {
        $values = [
            ':id' => $id
        ];

        $sql = "SELECT c.*, u.first_name, u.last_name FROM comments as c
                LEFT JOIN users as u ON c.user_id = u.id
                WHERE c.article_id = :id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }
}