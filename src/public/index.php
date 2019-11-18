<?php

require_once "../controllers/Controller.php";
require_once "../controllers/ArticlesController.php";
require_once "../controllers/CategoriesController.php";
require_once "../controllers/NotFoundController.php";
require_once "../controllers/UsersController.php";
require_once "../models/Model.php";
require_once "../models/Articles.php";
require_once "../models/Categories.php";
require_once "../models/Users.php";
require_once "../helpers/index.php";

session_start();

define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));
define('DB_CONFIG', require_once '../config/database_config.php');

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];

switch ($uri) {
    case '/user/login':
        (new UsersController())->loginAction();
        break;
    case '/user/sign-up':
        (new UsersController())->showSignFormAction();
        break;
    case '/user/sign-up/action':
        (new UsersController())->signUpAction();
        break;
    case '/user/logout':
        (new UsersController())->logoutAction();
        break;
    case '/articles':
        (new ArticlesController())->indexAction();
        break;
    case '/':
        (new UsersController())->indexAction();
        break;
    default:
        (new NotFoundController())->indexAction();
        break;
}


