<?php

namespace app\Services;

use app\Core\SessionManager;
use app\Repositories\LikesRepository;
use app\DTOs\LikeDTO;

class LikesService
{
    private LikesRepository $repository;

    public function __construct() 
    {
        $this->repository = new LikesRepository();
    }
    
    public function getLikeCountByArticleId(string $id): int
    {
        return $this->repository->getLikeCountByArticleId($id);
    }

    public function storeLike(LikeDTO $likesDTO): void
    {
        $this->repository->storeLike([
            'article_id' => $likesDTO->article_id,
            'user_id' => SessionManager::get('id')
        ]);
    }

    public function destroyLikeByArticleId(string $articleId): void
    {
        $this->repository->destroyLike($articleId, SessionManager::get('id'));
    }
}