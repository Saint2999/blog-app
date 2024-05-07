<?php

namespace app\Models;

class Like extends Model
{
    const table = 'likes';

    public $id;
    public $article_id;
    public $user_id;
}