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
        $comment = $this ->repository->getCommentById($id);

        if (!$comment) {
            throw new \Exception("Comment not found", 404);
        }

        return $comment;
    }

    public function storeComment(CommentDTO $commentDTO): object
    {
        $comment = $this->repository->storeComment([
            'description' => $commentDTO->description,
            'article_id' => $commentDTO->article_id,
            'user_id' => SessionManager::get('id')
        ]);

        if (!$comment) {
            throw new \Exception("Comment could not be created", 500);
        }

        return $comment;
    }

    public function updateComment(CommentDTO $commentDTO): object
    {
        $comment = $this->repository->getCommentById($commentDTO->id);

        if (!$comment) {
            throw new \Exception("Comment not found", 404);
        }

        $comment = $this->repository->updateComment(
            ['description' => $commentDTO->description],
            $commentDTO->id
        );

        if (!$comment) {
            throw new \Exception("Comment could not be updated", 500);
        }

        return $comment;
    }

    public function destroyCommentById(string $id): void
    {
        $comment = $this->repository->getCommentById($id);

        if (!$comment) {
            throw new \Exception("Comment not found", 404);
        }

        if (!$this->repository->destroyCommentById($id)) {
            throw new \Exception("Comment could not be destroyed", 500);
        }
    }
}