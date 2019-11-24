<?php

class Comments extends Model
{

    public const STATUS_ACTIVE = 0;
    public const STATUS_REMOVED = 1;

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

    public function remove(int $comment_id): array
    {
        $values = [
            ':id' => $comment_id,
            ':status' => self::STATUS_REMOVED
        ];

        $sql = "UPDATE comments SET status = :status WHERE id = :id";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }

    public function getCommentById(int $id, string $field): array
    {
        $values = [
            ':id' => $id,
            ':status' => self::STATUS_ACTIVE
        ];

        $sql = "SELECT c.*, u.first_name, u.last_name FROM comments as c
                LEFT JOIN users as u ON c.user_id = u.id
                WHERE c.$field = :id AND c.status = :status";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql, $values);

        return $result;
    }
}