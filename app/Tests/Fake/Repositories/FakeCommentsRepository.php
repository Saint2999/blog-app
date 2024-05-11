<?php

namespace app\Tests\Fake\Repositories;

use app\Repositories\Interfaces\CommentsRepositoryInterface;
use app\Models\Comment;

final class FakeCommentsRepository implements CommentsRepositoryInterface
{
    private array $comments = [];

    public function __construct()
    {
        $this->comments = [
            Comment::init(
                1, 
                'description',
                time(),
                1,
                1
            )
        ];
    }

    public function getCommentsByArticleId(string $id): array
    {
        return $this->comments;
    }

    public function getCommentById(string $id): ?Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->id == $id) {
                return $comment;
            }
        }

        return null;
    }

    public function storeComment(array $details): ?Comment
    {
        $id = count($this->comments) + 1;

        array_push(
            $this->comments,
            Comment::init(
                $id, 
                $details['description'],
                time(),
                $details['article_id'],
                $details['user_id']
            )
        );

        return $this->getCommentById($id);
    }

    public function updateComment(array $details, string $id): ?Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->id == $id) {                
                $comment->description = $details['description'];
            }
        }

        return $this->getCommentById($id);
    }

    public function destroyCommentById(string $id): bool
    {
        $found = false;

        $index = 0;

        foreach ($this->comments as $comment) {
            if ($comment->id == $id) {
                $found = true;

                break;
            }

            $index++;
        }

        if (!$found) {
            return false;
        }

        array_splice($this->comments, $index, 1);

        return true;
    }
}