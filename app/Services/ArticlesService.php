<?php

namespace app\Services;

use app\Core\SessionManager;
use app\Services\Interfaces\ArticlesServiceInterface;
use app\Repositories\Interfaces\ArticlesRepositoryInterface;
use app\DTOs\ArticleDTO;

class ArticlesService implements ArticlesServiceInterface
{
    private ArticlesRepositoryInterface $repository;

    private int $articleCountOnPage = 10;

    public function __construct(ArticlesRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    public function getArticlesForPage(string $page): array
    {
        $offset = $this->articleCountOnPage * ((int)$page - 1); 

        return $this->repository->getArticlesWithLimit($offset, $this->articleCountOnPage);
    }

    public function getArticleCount(): int
    {
        return $this->repository->getArticleCount();
    }

    public function getArticleCountOnPage(): int
    {
        return $this->articleCountOnPage;
    }

    public function getArticleById(string $id): object
    {
        $article = $this->repository->getArticleById($id);

        if (!$article) {
            throw new \Exception("Article not found", 404);
        }

        return $article;
    }

    public function storeArticle(ArticleDTO $articleDTO): object
    {
        $article = $this->repository->getArticleByName($articleDTO->name);

        if ($article) {
            throw new \Exception("Article already exists", 422);
        }

        $article = $this->repository->storeArticle([
            'name' => $articleDTO->name,
            'description' => $articleDTO->description,
            'user_id' => SessionManager::get('id') ?? $articleDTO->user_id 
        ]);

        if (!$article) {
            throw new \Exception("Article could not be created", 500);
        }

        return $article;
    }

    public function updateArticle(ArticleDTO $articleDTO): object
    {
        $article = $this->repository->getArticleById($articleDTO->id);

        if (!$article) {
            throw new \Exception("Article not found", 404);
        }

        $article = $this->repository->updateArticle(
            [
                'name' => $articleDTO->name,
                'description' => $articleDTO->description
            ],
            $articleDTO->id
        );

        if (!$article) {
            throw new \Exception("Article could not be updated", 500);
        }

        return $article;
    }

    public function destroyArticleById(string $id): void
    {
        $article = $this->repository->getArticleById($id);

        if (!$article) {
            throw new \Exception("Article not found", 404);
        }

        if (!$this->repository->destroyArticleById($id)) {
            throw new \Exception("Article could not be destroyed", 500);
        }
    }
}