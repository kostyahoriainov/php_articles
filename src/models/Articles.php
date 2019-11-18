<?php

class Articles extends Model
{
    public function all(): array
    {
        $articles = [];

        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id";

        $articles = $this->fetchData($sql);

        return $articles;
    }

    public function add($request): bool
    {
        $user_id = $this->getAuthUserId();

        $name = trim($request['name']);
        $text = trim($request['text']);
        $category_id = trim($request['category_id']);


        $sql = "INSERT INTO articles (`name`, `text`, `category_id`, `user_id`) 
                VALUES ('$name', '$text', '$category_id', '$user_id')";

        $result = $this->insertData($sql);

        return $result;
    }

    public function userArticles(): array
    {
        $user_id = $this->getAuthUserId();

        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id 
                WHERE a.user_id = $user_id";

        $articles = $this->fetchData($sql);

        return $articles;
    }

    public function articleById(int $id, bool $skipPermission = false): array
    {
        $sql = "SELECT * FROM articles as a WHERE a.id = $id";

        $article = $this->fetchData($sql)[0];

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

        $sql = "DELETE FROM articles WHERE id = $article_id";

        $result = $this->insertData($sql);

        return $result;
    }

    public function edit(array $request): bool
    {
        $id = $request['id'];
        $name = trim($request['name']);
        $text = trim($request['text']);
        $category_id = trim($request['category_id']);

        $sql = "UPDATE articles 
                SET `name` = '$name', 
                    `text` = '$text', 
                    `category_id` = '$category_id' 
                WHERE `id` = '$id'";

        $result = $this->insertData($sql);

        return $result;
    }

    public function getDetailArticle(int $id): array
    {
        $sql = "SELECT a.*, c.name as category_name FROM articles as a 
                LEFT JOIN categories as c ON a.category_id = c.id 
                WHERE a.id = $id";

        $article = $this->fetchData($sql);

        if (empty($article)) {
            header('Location: /not-found');
            die;
        }

        return $article;
    }

}