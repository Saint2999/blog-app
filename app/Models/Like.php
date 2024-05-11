<?php

namespace app\Models;

class Like extends Model
{
    const table = 'likes';

    public $id;
    public $article_id;
    public $user_id;

    public static function init($id, $article_id, $user_id): Like
    {
        $instance = new self();

        $instance->id = $id;   
        $instance->article_id = $article_id;
        $instance->user_id = $user_id;

        return $instance;
    }
}