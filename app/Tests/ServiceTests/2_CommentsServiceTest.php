<?php

namespace app\Tests\ServiceTests;

use app\Services\CommentsService;
use app\Tests\Fake\Repositories\FakeCommentsRepository;
use app\DTOs\CommentDTO;
use app\Helpers\DTOHydrator;

final class CommentsServiceTest
{
    public function __construct()
    {
        echo '<br>' . get_class($this) . ' <br>';

        $this->testStoreComment();

        $this->testUpdateComment();
    }

    public function testStoreComment()
    {
        $service = new CommentsService(new FakeCommentsRepository());

        $commentDTO = DTOHydrator::hydrate(
            [
                'id' => 2,
                'description' => 'description',
                'article_id' => 1,
                'user_id' => 1
            ],
            new CommentDTO()
        );

        try {
            $comment = $service->storeComment($commentDTO);
        } catch (\Throwable $e) {
            echo 'Test Store Comment Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        if (
            $comment->id != 2 ||
            $comment->description != 'description' ||
            $comment->article_id != 1 ||
            $comment->user_id != 1
        ) {
            echo 'Test Store Comment Failure: Assert Failed <br>';

            return;
        }

        echo 'Test Store Comment Success <br>';
    }

    public function testUpdateComment()
    {
        $service = new CommentsService(new FakeCommentsRepository());

        $oldComment = clone $service->getCommentById(1);

        $commentDTO = DTOHydrator::hydrate(
            [
                'id' => 1,
                'description' => 'new_description',
                'article_id' => 1,
                'user_id' => 1
            ],
            new CommentDTO()
        );

        try {
            $newComment = $service->updateComment($commentDTO);
        } catch (\Throwable $e) {
            echo 'Test Update Comment Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        if ($newComment->id != $oldComment->id) {
            echo 'Test Update Comment Failure: Wrong Comment <br>';

            return;
        }

        if ($newComment->description == $oldComment->description) {
            echo 'Test Update Comment Failure: Old values remained <br>';

            return;
        }

        if ($newComment->description != 'new_description') {
            echo 'Test Update Comment Failure: Wrong new values <br>';

            return;
        }

        echo 'Test Update Comment Success <br>';
    }
}

new CommentsServiceTest();