<?php

namespace app\Models;

class Comment extends Model
{
    const table = 'comments';

    public $id;
    public $description;
    public $created_at;
    public $article_id;
    public $user_id;

    public static function init($id, $description, $created_at, $article_id, $user_id): Comment
    {
        $instance = new self();

        $instance->id = $id;
        $instance->description = $description;
        $instance->created_at = $created_at;    
        $instance->article_id = $article_id;
        $instance->user_id = $user_id;

        return $instance;
    }
}