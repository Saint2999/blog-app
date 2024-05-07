<?php

namespace app\DTOs;

class ArticleDTO
{
    public ?string $id;
    public string $name;
    public string $description;
    public ?string $user_id;
}