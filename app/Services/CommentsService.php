<?php

namespace app\Services;

use app\Core\SessionManager;
use app\Repositories\CommentsRepository;
use app\DTOs\CommentDTO;

class CommentsService
{
    private CommentsRepository $repository;

    public function __construct() 
    {
        $this->repository = new CommentsRepository();
    }

    public function getCommentsByArticleId(string $id): array
    {
        return $this->repository->getCommentsByArticleId($id);
    }

    public function getCommentById(string $id): object
    {
        return $this->repository->getCommentById($id);
    }

    public function storeComment(CommentDTO $commentDTO): object
    {
        return $this->repository->storeComment([
            'description' => $commentDTO->description,
            'article_id' => $commentDTO->article_id,
            'user_id' => SessionManager::get('id')
        ]);
    }

    public function updateComment(CommentDTO $commentDTO): object
    {
        return $this->repository->updateComment(
            ['description' => $commentDTO->description],
            $commentDTO->id
        );
    }

    public function destroyCommentById(string $id): void
    {
        $this->repository->destroyCommentById($id);
    }
}