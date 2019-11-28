<?php

class UserTypes extends Model
{
    public const TYPE_USER = 1;
    public const TYPE_ADMIN = 2;
    public const TYPE_MODERATOR = 3;

    public const ADMINISTRATION = [
        self::TYPE_ADMIN, self::TYPE_MODERATOR
    ];

    public function all(): array
    {
        $sql = "SELECT * FROM user_type";

        $result = $this->fetchData(self::BEETROOT_DATABASE, $sql);

        return $result;
    }
}