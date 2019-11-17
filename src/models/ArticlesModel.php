<?php

require_once 'CategoriesModel.php';

const ARTICLE_FILE_NAME = 'articles.txt';

function allArticles(bool $append_category = false): array
{
    $all_articles = file_get_contents(ROOT . "/../data/" . ARTICLE_FILE_NAME);

    $all_articles_array = explode(PHP_EOL, trim($all_articles));

    foreach ($all_articles_array as &$article) {
        $article = unserialize($article);
        if (isset($article['category_id']) && $append_category) {
            $article['category'] = ucfirst(getCategoryById($article['category_id']));
        }
    }

    return $all_articles_array;
}

function getArticleById($id): ?array
{
    $article = null;
    $all_articles = getAllArticles();

    foreach ($all_articles as $item) {
        if ((int)$item['id'] === (int)$id) {
            return $item;
        }
    }

    return $article;
}

function addNewArticle(string $article, string $article_name, int $category_id): void
{
    $all_articles = allArticles();

    $new_article = [
        'id' => time(),
        'article_name' => trim($article_name),
        'article' => $article,
        'category_id' => $category_id,
        'created_at' => date('d-m-Y H:i'),
        'updated_at' => date('d-m-Y H:i')
    ];

    if (empty($all_articles[0])) {
        file_put_contents(ROOT . "/../data/articles.txt", serialize($new_article));
    } else {
        array_push($all_articles, $new_article);

        foreach ($all_articles as &$article) {
            $article = serialize($article);
        }

        file_put_contents(ROOT . "/../data/" . ARTICLE_FILE_NAME, implode(PHP_EOL, $all_articles));
    }
}

function editArticle(array $new_article): void
{
    $all_articles = getAllArticles();

    foreach ($all_articles as &$article) {
        if ((int)$article['id'] === (int)$new_article['id']) {
            $article = $new_article;
        }
        $article = serialize($article);
    }

    file_put_contents(ROOT . "/../data/" . ARTICLE_FILE_NAME, implode(PHP_EOL, $all_articles));
}

function removeArticleById(int $id): void
{
    $all_articles = getAllArticles();

    foreach ($all_articles as $key => &$article) {
        if ((int)$article['id'] === $id) {
            unset($all_articles[$key]);
            continue;
        }
        $article = serialize($article);
    }
    file_put_contents(ROOT . "/../data/" . ARTICLE_FILE_NAME, implode(PHP_EOL, $all_articles));
}