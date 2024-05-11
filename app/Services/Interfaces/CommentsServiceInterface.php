<?php

namespace app\Services\Interfaces;

use app\DTOs\CommentDTO;

interface CommentsServiceInterface 
{
    public function getCommentsByArticleId(string $id): array;

    public function getCommentById(string $id): object;

    public function storeComment(CommentDTO $commentDTO): object;

    public function updateComment(CommentDTO $commentDTO): object;

    public function destroyCommentById(string $id): void;
}