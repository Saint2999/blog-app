<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\SessionManager;
use app\Services\Interfaces\LikesServiceInterface;
use app\DTOs\LikeDTO;
use app\Helpers\DTOHydrator;
use app\Helpers\Redirector;

class LikesController
{
    private LikesServiceInterface $service;

    public function __construct(LikesServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(Request $request): ?Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('article_id');

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            Redirector::redirect("/articles/show?id=$articleId");
        }

        $likeDTO = DTOHydrator::hydrate(
            $request->getParams(),
            new LikeDTO()
        );

        $this->service->storeLike($likeDTO);

        Redirector::redirect("/articles/show?id=$articleId"); 
    }

    public function destroy(Request $request): ?Response
    {
        if (!SessionManager::has('authenticated')) {
            Redirector::redirect('/auth/login');
        }

        $articleId = $request->getParam('article_id');

        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            Redirector::redirect("/articles/show?id=$articleId");
        }

        $likeDTO = DTOHydrator::hydrate(
            $request->getParams(),
            new LikeDTO()
        );
        
        $this->service->destroyLike($likeDTO);
        
        Redirector::redirect("/articles/show?id=$articleId");
    }
}