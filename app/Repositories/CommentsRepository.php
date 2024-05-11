<?php

namespace app\Repositories;

use app\Repositories\Interfaces\CommentsRepositoryInterface;
use app\Models\Comment;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function getCommentsByArticleId(string $id): array
    {
        return Comment::whereAndOrderBy('article_id', $id, 'created_at', 'ASC');
    }

    public function getCommentById(string $id): ?Comment
    {
        return Comment::find($id);
    }

    public function storeComment(array $details): ?Comment
    {
        return Comment::create($details);
    }

    public function updateComment(array $details, string $id): ?Comment
    {
        return Comment::update($details, $id);
    }

    public function destroyCommentById(string $id): bool
    {
        return Comment::delete($id);
    }
}