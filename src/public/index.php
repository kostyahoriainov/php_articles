<?php

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];

session_start();

switch ($uri) {
    default:
    {
        require_once '../index.phtml';
        break;
    }
}
