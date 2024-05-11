<?php

namespace app\Repositories\Interfaces;

interface LikesRepositoryInterface 
{
    public function getLikeCountByArticleId(string $id): int;

    public function storeLike(array $details): bool;

    public function destroyLike(string $articleId, string $userId): bool;

    public function checkIfLikeExists(string $articleId, string $userId): bool;
}