<?php

namespace app\Repositories;

use app\Models\Article;

class ArticlesRepository 
{
    public function getArticlesWithLimit(string $offset, string $count): array
    {
        return Article::allWithLimit($offset, $count);
    }

    public function getArticleCount(): int
    {
        return Article::count();
    }

    public function getArticleById(string $id): ?Article
    {
        return Article::find($id);
    }

    public function storeArticle(array $details): ?Article
    {
        return Article::create($details);
    }

    public function updateArticle(array $details, string $id): ?Article
    {
        return Article::update($details, $id);
    }

    public function destroyArticleById(string $id): bool
    {
        return Article::delete($id);
    }
}