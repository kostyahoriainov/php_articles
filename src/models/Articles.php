<?php

class Articles extends Model
{

    const STATUS_ACTIVE = 0;
    const STATUS_REMOVED = 1;

    public function all(): array
    {
        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id
                WHERE a.status = :status";

        $values = [
            ':status' => self::STATUS_ACTIVE
        ];

        $articles = $this->fetchData($sql, $values);

        return $articles;
    }

    public function add($request): bool
    {
        $values = [
            ':name' => trim($request['name']),
            ':text' => trim($request['text']),
            ':category_id' => trim($request['category_id']),
            ':user_id' => $this->getAuthUserId()
        ];

        $sql = "INSERT INTO articles (name, text, category_id, user_id) 
                VALUES (:name, :text, :category_id, :user_id)";

        $result = $this->insertData($sql, $values);

        return $result;
    }

    public function userArticles(): array
    {
        $values = [
            ':user_id' => $this->getAuthUserId(),
            ':status' => self::STATUS_ACTIVE
        ];

        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id 
                WHERE a.user_id = :user_id AND a.status = :status";

        $articles = $this->fetchData($sql, $values);

        return $articles;
    }

    public function articleById(int $id, bool $skipPermission = false): array
    {
        $values = [
            ':id' => $id
        ];

        $sql = "SELECT * FROM articles as a WHERE a.id = :id";

        $article = $this->fetchData($sql, $values)[0];

        if (!$skipPermission && !$this->checkUserPermission($article['user_id'])) {
            echo 'PERMISSION DENIED';
            die;
        }

        if (empty($article)) {
            header('Location: /not-found');
            die;
        }

        return $article;
    }

    public function remove(int $article_id): bool
    {
        $this->articleById($article_id);

        $values = [
            ':status' => self::STATUS_REMOVED,
            ':article_id' => $article_id
        ];

        $sql = "UPDATE articles SET status = :status WHERE id = :article_id;";


        $result = $this->insertData($sql, $values);

        return $result;
    }

    public function edit(array $request): bool
    {
        $values = [
            ':name' => trim($request['name']),
            ':text' => trim($request['text']),
            ':category_id' => trim($request['category_id']),
            ':id' => $request['id'],
        ];

        $sql = "UPDATE articles 
                SET name = :name, 
                    text = :text, 
                    category_id = :category_id 
                WHERE id = :id";

        $result = $this->insertData($sql, $values);

        return $result;
    }

    public function getDetailArticle(int $id): array
    {
        $values = [
            ':id' => $id
        ];

        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id 
                WHERE a.id = :id";

        $article = $this->fetchData($sql, $values);

        if (empty($article)) {
            header('Location: /not-found');
            die;
        }

        return $article;
    }

}