<?php

namespace app\Repositories;

use app\Repositories\Interfaces\ArticlesRepositoryInterface;
use app\Models\Article;

class ArticlesRepository implements ArticlesRepositoryInterface
{
    public function getArticlesWithLimit(int $offset, int $count): array
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

    public function getArticleByName(string $name): ?Article
    {
        $articles = Article::where('name', $name);

        $article = reset($articles);

        if (!$article) {
            return null;
        }

        return $article; 
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