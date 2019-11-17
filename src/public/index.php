<?php

require_once "../controllers/ArticlesController.php";
require_once "../controllers/CategoriesController.php";
require_once "../controllers/NotFoundController.php";
require_once "../models/ArticlesModel.php";
require_once "../models/CategoriesModel.php";
require_once "../helpers/index.php";

define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];

switch ($uri) {
    case '/articles/add':
        addArticleAction();
        break;
    case '/articles/remove':
        removeArticleAction();
        break;
    case '/article/show':
        showArticleAction();
        break;
    case '/article/save':
        saveArticleAction();
        break;
    case '/articles':
        showArticles();
        break;
    case '/':
        indexArticlesAction();
        break;
    default:
        notFoundAction();
        break;
}


