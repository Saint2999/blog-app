<?php

namespace app\DTOs;

class CommentDTO
{
    public ?string $id;
    public string $description;
    public ?string $article_id;
    public ?string $user_id;
}