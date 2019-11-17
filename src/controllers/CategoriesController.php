<?php

function indexCategoriesAction(): void
{

}

function getAllCategories(): array
{
    $categories = allCategories();

    return $categories;
}

function getCategoryById(int $id): string
{
    $category = categoryById($id);

    return $category;
}