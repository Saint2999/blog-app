<?php

namespace app\Services\Interfaces;

use app\DTOs\LikeDTO;

interface LikesServiceInterface 
{
    public function getLikeCountByArticleId(string $id): int;

    public function storeLike(LikeDTO $likeDTO): void;

    public function destroyLike(LikeDTO $likeDTO): void;
}