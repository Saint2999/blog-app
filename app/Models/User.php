<?php

namespace app\Models;

class User extends Model
{
    const table = 'users';

    public $id;
    public $name;
    public $password;
    public $created_at;

    public static function init($id, $name, $password, $created_at): User
    {
        $instance = new self();

        $instance->id = $id;
        $instance->name = $name;
        $instance->password = $password;
        $instance->created_at = $created_at;  
        
        return $instance;
    }
}