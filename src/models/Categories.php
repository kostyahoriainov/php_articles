<?php

class Categories extends Model
{
    public function all(): array
    {
        $sql = "SELECT * FROM categories";

        $categories = $this->fetchData($sql);

        return $categories;
    }
}
