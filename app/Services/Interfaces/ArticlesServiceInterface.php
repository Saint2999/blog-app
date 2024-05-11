<?php

namespace app\Services\Interfaces;

use app\DTOs\ArticleDTO;

interface ArticlesServiceInterface 
{
    public function getArticlesForPage(string $page): array;

    public function getArticleCount(): int;

    public function getArticleCountOnPage(): int;

    public function getArticleById(string $id): object;

    public function storeArticle(ArticleDTO $articleDTO): object;

    public function updateArticle(ArticleDTO $articleDTO): object;

    public function destroyArticleById(string $id): void;
}