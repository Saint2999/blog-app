<?php

namespace app\Services;

use app\Core\SessionManager;
use app\Services\Interfaces\LikesServiceInterface;
use app\Repositories\Interfaces\LikesRepositoryInterface;
use app\DTOs\LikeDTO;

class LikesService implements LikesServiceInterface
{
    private LikesRepositoryInterface $repository;

    public function __construct(LikesRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }
    
    public function getLikeCountByArticleId(string $id): int
    {
        return $this->repository->getLikeCountByArticleId($id);
    }

    public function storeLike(LikeDTO $likeDTO): void
    {
        $check = $this->repository->checkIfLikeExists(
            $likeDTO->article_id,
            SessionManager::get('id') ?? $likeDTO->user_id
        );

        if ($check) {
            throw new \Exception("Like already exists", 422);
        }

        $check = $this->repository->storeLike([
            'article_id' => $likeDTO->article_id,
            'user_id' => SessionManager::get('id') ?? $likeDTO->user_id
        ]);

        if (!$check) {
            throw new \Exception("Like could not be created", 500);
        }
    }

    public function destroyLike(LikeDTO $likeDTO): void
    {
        $check = $this->repository->checkIfLikeExists(
            $likeDTO->article_id,
            SessionManager::get('id') ?? $likeDTO->user_id
        );

        if (!$check) {
            throw new \Exception("Like does not exist", 404);
        }

        $check = $this->repository->destroyLike(
            $likeDTO->article_id, 
            SessionManager::get('id') ?? $likeDTO->user_id
        );
    
        if (!$check) {
            throw new \Exception("Like could not be destroyed", 500);
        }
    }
}