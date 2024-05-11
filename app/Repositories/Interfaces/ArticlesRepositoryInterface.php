<?php

namespace app\Repositories\Interfaces;

use app\Models\Article;

interface ArticlesRepositoryInterface 
{
    public function getArticlesWithLimit(int $offset, int $count): array;

    public function getArticleCount(): int;

    public function getArticleById(string $id): ?Article;

    public function getArticleByName(string $name): ?Article;

    public function storeArticle(array $details): ?Article;

    public function updateArticle(array $details, string $id): ?Article;

    public function destroyArticleById(string $id): bool;
}