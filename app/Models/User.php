<?php

namespace app\Models;

class User extends Model
{
    const table = 'users';

    public $id;
    public $name;
    public $password;
    public $created_at;
}