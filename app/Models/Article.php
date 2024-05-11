<?php

namespace app\Models;

class Article extends Model
{
    const table = 'articles';

    public $id;
    public $name;
    public $description;
    public $created_at;
    public $user_id;

    public static function init($id, $name, $description, $created_at, $user_id): Article
    {
        $instance = new self();

        $instance->id = $id;
        $instance->name = $name;
        $instance->description = $description;
        $instance->created_at = $created_at;    
        $instance->user_id = $user_id;

        return $instance;
    }
}