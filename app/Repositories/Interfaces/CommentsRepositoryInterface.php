<?php

namespace app\Repositories\Interfaces;

use app\Models\Comment;

interface CommentsRepositoryInterface 
{
    public function getCommentsByArticleId(string $id): array;

    public function getCommentById(string $id): ?Comment;

    public function storeComment(array $details): ?Comment;

    public function updateComment(array $details, string $id): ?Comment;

    public function destroyCommentById(string $id): bool;
}