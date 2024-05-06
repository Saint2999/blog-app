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
}