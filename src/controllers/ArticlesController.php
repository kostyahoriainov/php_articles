<?php

function indexArticlesAction(): void
{
    $categories = getAllCategories();
    $all_articles = getAllArticles();

    include_once '../views/index.phtml';
}

function addArticleAction(): void
{
    if (empty(trim($_POST['article_name'])) || empty(trim($_POST['article']))) {
        header('Location: /?empty=1');
        die;
    }

    $article = trimTextarea(trim($_POST['article']), "\r\n", "<br>");

    addNewArticle($article, $_POST['article_name'], $_POST['category_id']);

    header('Location: /articles');
    die;
}

function removeArticleAction(): void
{
    $id = $_REQUEST['id'];

    removeArticleById($id);

    header('Location: /articles');
    die;
}

function showArticleAction(): void
{
    $article_id = $_REQUEST['id'];

    $article =  getArticleById($article_id);

    if ($article === null) {
        header('Location: /NotFound.php');
        die;
    }

    $article['article'] = trimTextarea($article['article'], "<br>", "\r\n");

    $categories = getAllCategories();

    require_once '../views/article_edit.phtml';
    die;
}

function saveArticleAction(): void
{
    if (empty($_POST['article']) || empty($_POST['article_name'])) {
        header("Location: /article/show?id=" . $_POST['id'] . "&empty=1");
        die;
    }

    $edited_article = getArticleById((int) $_POST['id']);

    $article = trimTextarea(trim($_POST['article']), "\r\n", "<br>");

    $edited_article['article_name'] = trim($_POST['article_name']);
    $edited_article['article'] = $article;
    $edited_article['category_id'] = $_POST['category_id'];
    $edited_article['updated_at'] = date('d-m-Y H:i');

    editArticle($edited_article);

    header('Location: /articles');
    die;
}

function getAllArticles(bool $append_categories = false): array
{
    $articles = allArticles($append_categories);

    return $articles;
}

function showArticles(): void
{
    $all_articles = getAllArticles(true);

    if (empty($all_articles[0])) {
        header('Location: /');
        die;
    }

    require_once '../views/articles.phtml';
    die;
}