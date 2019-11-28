<?php

function trimTextarea(string $str, string $search, string $replace): string
{
    $str = str_replace ($search, $replace, $str);
    return $str;
}