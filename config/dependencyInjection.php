<?php

return [
    app\Controllers\AuthController::class => [
        'service' => app\Services\Interfaces\AuthServiceInterface::class
    ],
    app\Controllers\ArticlesController::class => [
        'articlesService' => app\Services\Interfaces\ArticlesServiceInterface::class,
        'commentsService' => app\Services\Interfaces\CommentsServiceInterface::class,
        'likesService' => app\Services\Interfaces\LikesServiceInterface::class
    ],
    app\Controllers\CommentsController::class => [
        'service' => app\Services\Interfaces\CommentsServiceInterface::class
    ],
    app\Controllers\LikesController::class => [
        'service' => app\Services\Interfaces\LikesServiceInterface::class
    ],

    app\Services\AuthService::class => [
        'repository' => app\Repositories\Interfaces\UsersRepositoryInterface::class
    ],
    app\Services\ArticlesService::class => [
        'repository' => app\Repositories\Interfaces\ArticlesRepositoryInterface::class
    ],
    app\Services\CommentsService::class => [
        'repository' => app\Repositories\Interfaces\CommentsRepositoryInterface::class
    ],
    app\Services\LikesService::class => [
        'repository' => app\Repositories\Interfaces\LikesRepositoryInterface::class
    ],

    app\Repositories\UsersRepository::class => [
    ],
    app\Repositories\ArticlesRepository::class => [
    ],
    app\Repositories\CommentsRepository::class => [
    ],
    app\Repositories\LikesRepository::class => [
    ],

    app\Services\Interfaces\AuthServiceInterface::class => app\Services\AuthService::class,
    app\Services\Interfaces\ArticlesServiceInterface::class => app\Services\ArticlesService::class,
    app\Services\Interfaces\CommentsServiceInterface::class => app\Services\CommentsService::class,
    app\Services\Interfaces\LikesServiceInterface::class => app\Services\LikesService::class,

    app\Repositories\Interfaces\UsersRepositoryInterface::class => app\Repositories\UsersRepository::class,
    app\Repositories\Interfaces\ArticlesRepositoryInterface::class => app\Repositories\ArticlesRepository::class,
    app\Repositories\Interfaces\CommentsRepositoryInterface::class => app\Repositories\CommentsRepository::class,
    app\Repositories\Interfaces\LikesRepositoryInterface::class => app\Repositories\LikesRepository::class,
];