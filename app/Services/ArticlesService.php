<?php

namespace app\Services;

use app\Repositories\ArticlesRepository;
use app\DTOs\ArticleDTO;

class ArticlesService
{
    private ArticlesRepository $repository;

    private int $articleCountOnPage = 10;

    public function __construct() 
    {
        $this->repository = new ArticlesRepository();
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
        return $this->repository->getArticleById($id);
    }

    public function storeArticle(ArticleDTO $articleDTO): void
    {
        $this->repository->storeArticle([
            'name' => $articleDTO->name,
            'description' => $articleDTO->description
        ]);
    }

    public function updateArticle(ArticleDTO $articleDTO, string $id): object
    {
        return $this->repository->updateArticle(
            [
                'name' => $articleDTO->name,
                'description' => $articleDTO->description
            ],
            $id
        );
    }

    public function destroyArticleById(string $id): void
    {
        $this->repository->destroyArticleById($id);
    }
}