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
}