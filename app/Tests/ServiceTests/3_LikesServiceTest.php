<?php

namespace app\Tests\ServiceTests;

use app\Services\LikesService;
use app\Tests\Fake\Repositories\FakeLikesRepository;
use app\DTOs\LikeDTO;
use app\Helpers\DTOHydrator;

final class LikesServiceTest
{
    public function __construct()
    {
        echo '<br>' . get_class($this) . ' <br>';

        $this->testStoreLike();

        $this->testDestroyLike();
    }

    public function testStoreLike()
    {
        $service = new LikesService(new FakeLikesRepository());

        $oldLikeCount = $service->getLikeCountByArticleId(1);

        $likeDTO = DTOHydrator::hydrate(
            [
                'id' => 2,
                'article_id' => 1,
                'user_id' => 2
            ],
            new LikeDTO()
        );

        try {
            $service->storeLike($likeDTO);
        } catch (\Throwable $e) {
            echo 'Test Store Like Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        $newLikeCount = $service->getLikeCountByArticleId(1);

        if ($newLikeCount != ($oldLikeCount + 1)) {
            echo 'Test Store Like Failure: Assert Failed <br>';

            return;
        }

        echo 'Test Store Like Success <br>';
    }

    public function testDestroyLike()
    {
        $service = new LikesService(new FakeLikesRepository());

        $oldLikeCount = $service->getLikeCountByArticleId(1);

        $likeDTO = DTOHydrator::hydrate(
            [
                'article_id' => 1,
                'user_id' => 1
            ],
            new LikeDTO()
        );
        
        try {
            $service->destroyLike($likeDTO);
        } catch (\Throwable $e) {
            echo 'Test Destroy Like Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        $newLikeCount = $service->getLikeCountByArticleId(1);

        if ($newLikeCount != ($oldLikeCount - 1)) {
            echo 'Test Destroy Like Failure: Assert Failed <br>';

            return;
        }

        echo 'Test Destroy Like Success <br>';
    }
}

new LikesServiceTest();