<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\SessionManager;
use app\Core\RateLimiter;
use app\Services\Interfaces\CommentsServiceInterface;
use app\Validation\Validator;
use app\Validation\Rules\NotNull;
use app\DTOs\CommentDTO;
use app\Helpers\DTOHydrator;
use app\Helpers\Redirector;

class CommentsController
{
    private CommentsServiceInterface $service;

    public function __construct(CommentsServiceInterface $service)
    {
        $this->service = $service;
    }

    public function create(Request $request): Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'comments/store', 
            [
                'article_id' => $request->getParam('article_id'),
                'csrfToken' => SessionManager::get('csrf-token')
            ]
        );
    }

    public function store(Request $request): ?Response
    {
        return $this->updateOrStore($request, 'store');
    }

    public function edit(Request $request): Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        if ($request->getParam('user_id') != SessionManager::get('id')) {
            $articleId = $request->getParam('article_id');

            Redirector::redirect("/articles/show?id=$articleId");
        }

        $comment = $this->service->getCommentById($request->getParam('id'));

        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'comments/update', 
            [
                'comment' => $comment,
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

        $articleId = $request->getParam('article_id');

        if ($request->getParam('user_id') != SessionManager::get('id')) {
            Redirector::redirect("/articles/show?id=$articleId");
        }

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                'comments/destroy', 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Invalid form submission']
                ]
            );
        }
        
        $this->service->destroyCommentById($request->getParam('id'));
        
        Redirector::redirect("/articles/show?id=$articleId");
    }

    private function updateOrStore(Request $request, string $type): ?Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('article_id');

        if ($type == 'update' && $request->getParam('user_id') != SessionManager::get('id')) {
            Redirector::redirect("/articles/show?id=$articleId");
        }

        if (RateLimiter::checkIfRequestWasRunIn(60, $request)) {
            return new Response(
                "comments/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Too Many Requests']
                ]
            );
        }

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                "comments/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Invalid form submission']
                ]
            );
        }

        $validator = new Validator([
            'description' => [new NotNull()]
        ]);

        if (!$validator->validate($request->getParams())) {
            return new Response(
                "comments/$type", 
                [
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => $validator->getErrors()
                ]
            );
        }

        $commentDTO = DTOHydrator::hydrate(
            $request->getParams(),
            new CommentDTO()
        );

        try {
            switch ($type) {
                case 'update':
                    $this->service->updateComment($commentDTO);
                    
                    break;
                
                case 'store':
                    $this->service->storeComment($commentDTO);
                    
                    break;
            }
        } catch (\Throwable $e) {
            switch ($type) {
                case 'update':
                    return new Response(
                        "comments/update", 
                        [
                            'comment' => $commentDTO,
                            'csrfToken' => SessionManager::get('csrf-token'),
                            'errors' => [$e->getMessage()]
                        ]
                    );
                
                case 'store':
                    return new Response(
                        "comments/store", 
                        [
                            'csrfToken' => SessionManager::get('csrf-token'),
                            'errors' => [$e->getMessage()]
                        ]
                    );                    
            }
        }

        Redirector::redirect("/articles/show?id=$articleId");    
    }
}