<?php

namespace app\Repositories;

use app\Models\Like;

class LikesRepository 
{
    public function getLikeCountByArticleId(string $id): int 
    {
        return count(Like::where('article_id', $id));
    }

    public function storeLike(array $details): bool
    {
        $like = Like::create($details);

        if (!$like) {
            return false;
        }

        return true;
    }

    public function destroyLike(string $articleId, string $userId): bool
    {
        $likes = Like::whereAndWhere('article_id', $articleId, 'user_id', $userId);

        $like = reset($likes);

        if (!$like) {
            return false;
        }

        return Like::delete($like->id);
    }

    public function checkIfLikeExists(string $articleId, string $userId): bool 
    {
        $likes = Like::whereAndWhere('article_id', $articleId, 'user_id', $userId);

        $like = reset($likes);

        if (!$like) {
            return false;
        }
        
        return true;
    }
}