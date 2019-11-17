<?php

const CATEGORIES_FILE_NAME = 'categories.txt';

function allCategories(): array
{
    $categories = file_get_contents(ROOT . "/../data/" . CATEGORIES_FILE_NAME);

    $categories_array = explode(PHP_EOL, $categories);

    foreach ($categories_array as &$cat) {
        $cat = unserialize($cat);
        $cat = ucfirst($cat);
    }

    return $categories_array;
}

function categoryById($id): ?string
{
    $categories = getAllCategories();

    $category = null;

    foreach ($categories as $key => $cat) {
        if ((int) $key === (int) $id) {
            $category = $cat;
            break;
        }
    }

    return $category;
}