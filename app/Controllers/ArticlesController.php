<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\SessionManager;
use app\Services\ArticlesService;
use app\Validation\Validator;
use app\Validation\Rules\NotNull;
use app\Validation\Rules\StringLength;
use app\DTOs\ArticleDTO;
use app\Helpers\DTOHydrator;
use app\Helpers\Redirector;

class ArticlesController
{
    private ArticlesService $service;

    public function __construct()
    {
        $this->service = new ArticlesService();
    }

    public function index(Request $request): Response
    {
        $page = $request->getParam('page');

        $articles = $this->service->getArticlesForPage($page);

        $articleCount = $this->service->getArticleCount();

        $articleCountOnPage = $this->service->getArticleCountOnPage();

        return new Response(
            'articles/index', 
            [
                'articles' => $articles,
                'articleCount' => $articleCount,
                'articleCountOnPage' => $articleCountOnPage
            ]
        );
    }

    public function create(Request $request): Response
    {
        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'articles/store', 
            ['csrfToken' => SessionManager::get('csrf-token')]
        );
    }

    public function store(Request $request): ?Response
    {
        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                'articles/store', 
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
                'articles/store', 
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

        $this->service->storeArticle($articleDTO);

        Redirector::redirect('/articles');
    }

    public function show(Request $request): Response
    {
        $article = $this->service->getArticleById($request->getParam('id'));
    
        return new Response(
            'articles/show', 
            ['article' => $article]
        );
    }

    public function edit(Request $request): Response
    {
        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'articles/update', 
            ['csrfToken' => SessionManager::get('csrf-token')]
        );
    }

    public function update(Request $request): ?Response
    {
        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                'articles/update', 
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
                'articles/update', 
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

        $article = $this->service->updateArticle($articleDTO, $request->getParam('id'));

        return new Response(
            'articles/show', 
            ['article' => $article]
        );
    }

    public function destroy(Request $request): ?Response
    {
        $this->service->destroyArticleById($request->getParam('id'));
    
        Redirector::redirect('/articles');
    }
}