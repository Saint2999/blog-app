<?php

namespace app\Tests\Fake\Repositories;

use app\Repositories\Interfaces\ArticlesRepositoryInterface;
use app\Models\Article;

final class FakeArticlesRepository implements ArticlesRepositoryInterface
{
    private array $articles = [];

    public function __construct()
    {
        $this->articles = [
            Article::init(
                1, 
                'article_1',
                'description',
                time(),
                1
            )
        ];
    }

    public function getArticlesWithLimit(int $offset, int $count): array
    {
        return $this->articles;
    }

    public function getArticleCount(): int
    {
        return count($this->articles);
    }

    public function getArticleById(string $id): ?Article
    {
        foreach ($this->articles as $article) {
            if ($article->id == $id) {
                return $article;
            }
        }

        return null;
    }

    public function getArticleByName(string $name): ?Article
    {
        foreach ($this->articles as $article) {
            if ($article->name == $name) {
                return $article;
            }
        }
        
        return null; 
    }

    public function storeArticle(array $details): ?Article
    {
        $id = count($this->articles) + 1;

        array_push(
            $this->articles,
            Article::init(
                $id, 
                $details['name'],
                $details['description'],
                time(),
                $details['user_id']
            )
        );

        return $this->getArticleById($id);
    }

    public function updateArticle(array $details, string $id): ?Article
    {
        foreach ($this->articles as $article) {
            if ($article->id == $id) {
                $article->name = $details['name'];
                
                $article->description = $details['description'];
            }
        }

        return $this->getArticleById($id);
    }

    public function destroyArticleById(string $id): bool
    {
        $found = false;

        $index = 0;

        foreach ($this->articles as $article) {
            if ($article->id == $id) {
                $found = true;

                break;
            }

            $index++;
        }

        if (!$found) {
            return false;
        }

        array_splice($this->articles, $index, 1);

        return true;
    }
}