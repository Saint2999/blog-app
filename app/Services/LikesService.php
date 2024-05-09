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

    public function storeLike(LikeDTO $likeDTO): void
    {
        $check = $this->repository->checkIfLikeExists(
            $likeDTO->article_id,
            SessionManager::get('id')
        );

        if ($check) {
            throw new \Exception("Like already exists", 422);
        }

        $check = $this->repository->storeLike([
            'article_id' => $likeDTO->article_id,
            'user_id' => SessionManager::get('id')
        ]);

        if (!$check) {
            throw new \Exception("Like could not be created", 500);
        }
    }

    public function destroyLikeByArticleId(string $articleId): void
    {
        $check = $this->repository->checkIfLikeExists(
            $articleId,
            SessionManager::get('id')
        );

        if (!$check) {
            throw new \Exception("Like does not exist", 404);
        }

        $check = $this->repository->destroyLike($articleId, SessionManager::get('id'));
    
        if (!$check) {
            throw new \Exception("Like could not be destroyed", 500);
        }
    }
}