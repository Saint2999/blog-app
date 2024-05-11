<?php

namespace app\Tests\ServiceTests;

use app\Services\ArticlesService;
use app\Tests\Fake\Repositories\FakeArticlesRepository;
use app\DTOs\ArticleDTO;
use app\Helpers\DTOHydrator;

final class ArticlesServiceTest
{
    public function __construct()
    {
        echo '<br>' . get_class($this) . ' <br>';

        $this->testStoreArticle();

        $this->testUpdateArticle();
    }

    public function testStoreArticle()
    {
        $service = new ArticlesService(new FakeArticlesRepository());

        $articleDTO = DTOHydrator::hydrate(
            [
                'id' => 2,
                'name' => 'article_2',
                'description' => 'description',
                'user_id' => 1
            ],
            new ArticleDTO()
        );

        try {
            $article = $service->storeArticle($articleDTO);
        } catch (\Throwable $e) {
            echo 'Test Store Article Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        if (
            $article->id != 2 ||
            $article->name != 'article_2' || 
            $article->description != 'description' ||
            $article->user_id != 1
        ) {
            echo 'Test Store Article Failure: Assert Failed <br>';

            return;
        }

        echo 'Test Store Article Success <br>';
    }

    public function testUpdateArticle()
    {
        $service = new ArticlesService(new FakeArticlesRepository());

        $oldArticle = clone $service->getArticleById(1);

        $articleDTO = DTOHydrator::hydrate(
            [
                'id' => 1,
                'name' => 'new_article_1',
                'description' => 'new_description',
                'user_id' => 1
            ],
            new ArticleDTO()
        );

        try {
            $newArticle = $service->updateArticle($articleDTO);
        } catch (\Throwable $e) {
            echo 'Test Update Article Failure: ';
            echo $e->getMessage() . ' <br>';

            return;
        }

        if ($newArticle->id != $oldArticle->id) {
            echo 'Test Update Article Failure: Wrong Article <br>';

            return;
        }

        if (
            $newArticle->name == $oldArticle->name || 
            $newArticle->description == $oldArticle->description
        ) {
            echo 'Test Update Article Failure: Old values remained <br>';

            return;
        }

        if (
            $newArticle->name != 'new_article_1'||
            $newArticle->description != 'new_description'
        ) {
            echo 'Test Update Article Failure: Wrong new values <br>';

            return;
        }

        echo 'Test Update Article Success <br>';
    }
}

new ArticlesServiceTest();