<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\SessionManager;
use app\Services\ArticlesService;
use app\Services\CommentsService;
use app\Validation\Validator;
use app\Validation\Rules\NotNull;
use app\Validation\Rules\StringLength;
use app\DTOs\ArticleDTO;
use app\Helpers\DTOHydrator;
use app\Helpers\Redirector;

class ArticlesController
{
    private ArticlesService $articlesService;
    private CommentsService $commentsService;

    public function __construct()
    {
        $this->articlesService = new ArticlesService();
        $this->commentsService = new CommentsService();
    }

    public function index(Request $request): Response
    {
        $page = $request->getParam('page') ?? '1';

        $articles = $this->articlesService->getArticlesForPage($page);

        $articleCount = $this->articlesService->getArticleCount();

        $articleCountOnPage = $this->articlesService->getArticleCountOnPage();

        return new Response(
            'articles/index', 
            [
                'articles' => $articles,
                'page' => $page,
                'articleCount' => $articleCount,
                'articleCountOnPage' => $articleCountOnPage
            ]
        );
    }

    public function create(Request $request): Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'articles/store', 
            ['csrfToken' => SessionManager::get('csrf-token')]
        );
    }

    public function store(Request $request): ?Response
    {
        return $this->updateOrStore($request, 'store');
    }

    public function show(Request $request): Response
    {        
        $article = $this->articlesService->getArticleById($request->getParam('id'));

        $comments = $this->commentsService->getCommentsByArticleId($article->id);

        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'articles/show', 
            [
                'article' => $article,
                'comments' => $comments,
                'csrfToken' => SessionManager::get('csrf-token')
            ]
        );
    }

    public function edit(Request $request): Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('id');

        if ($request->getParam('user_id') != SessionManager::get('id')) {
            Redirector::redirect("/articles/show?id=$articleId");
        }

        $article = $this->articlesService->getArticleById($articleId);

        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'articles/update', 
            [
                'article' => $article,
                'csrfToken' => SessionManager::get('csrf-token')
            ]
        );
    }

    public function update(Request $request): ?Response
    {
        return $this->updateOrStore($request, 'update');
    }

    public function destroy(Request $request): ?Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('id');

        if ($request->getParam('user_id') != SessionManager::get('id')) {
            Redirector::redirect("/articles/show?id=$articleId");
        }

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                'articles/destroy', 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Invalid form submission']
                ]
            );
        }
        
        $this->articlesService->destroyArticleById($articleId);
        
        Redirector::redirect('/articles');
    }

    private function updateOrStore(Request $request, string $type): ?Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('id');

        if ($type == 'update' && $request->getParam('user_id') != SessionManager::get('id')) {
            Redirector::redirect("/articles/show?id=$articleId");
        }

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                "articles/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Invalid form submission']
                ]
            );
        }

        $validator = new Validator([
            'name' => [(new StringLength())->min(3)->max(255), new NotNull()],
            'description' => [new NotNull()]
        ]);

        if (!$validator->validate($request->getParams())) {
            return new Response(
                "articles/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => $validator->getErrors()
                ]
            );
        }

        $articleDTO = DTOHydrator::hydrate(
            $request->getParams(),
            new ArticleDTO()
        );

        $article = null;

        try {
            switch ($type) {
                case 'update':
                    $article = $this->articlesService->updateArticle($articleDTO);
                    
                    break;
                
                case 'store':
                    $article = $this->articlesService->storeArticle($articleDTO);
                    
                    break;
            }
        } catch (\Exception $e) {
            return new Response(
                "articles/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => [$e->getMessage()]
                ]
            );
        }

        Redirector::redirect("/articles/show?id=$article->id");
    }
}