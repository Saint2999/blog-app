<?php

namespace app\Tests\Fake\Repositories;

use app\Repositories\Interfaces\LikesRepositoryInterface;
use app\Models\Like;

final class FakeLikesRepository implements LikesRepositoryInterface
{
    private array $likes = [];

    public function __construct()
    {
        $this->likes = [
            Like::init(
                1, 
                1,
                1
            )
        ];
    }

    public function getLikeCountByArticleId(string $id): int
    {
        $count = 0;

        foreach ($this->likes as $like) {
            if ($like->article_id == $id) {
                $count++;
            }
        }

        return $count;
    }

    public function storeLike(array $details): bool
    {
        array_push(
            $this->likes,
            Like::init(
                count($this->likes) + 1, 
                $details['article_id'],
                $details['user_id']
            )
        );

        return true;
    }

    public function destroyLike(string $articleId, string $userId): bool
    {
        $found = false;

        $index = 0;

        foreach ($this->likes as $like) {
            if (
                $like->article_id == $articleId &&
                $like->user_id == $userId
            ) {
                $found = true;

                break;
            }

            $index++;
        }

        if (!$found) {
            return false;
        }

        array_splice($this->likes, $index, 1);

        return true;
    }

    public function checkIfLikeExists(string $articleId, string $userId): bool
    {
        $found = false;

        $index = 0;

        foreach ($this->likes as $like) {
            if (
                $like->article_id == $articleId &&
                $like->user_id == $userId
            ) {
                $found = true;

                break;
            }

            $index++;
        }

        return $found;
    }
}