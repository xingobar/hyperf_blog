<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    \App\Contracts\Service\UserServiceInterface::class => \App\Service\UserService::class,
    \Hyperf\Database\Model\Factory::class => \App\Service\ModelFactory::class,
    \App\Contracts\Service\PostServiceInterface::class => \App\Service\PostService::class,
    \App\Contracts\Service\CategoryServiceInterface::class => \App\Service\CategoryService::class,
    \App\Contracts\Service\CommentServiceInterface::class => \App\Service\CommentService::class,
];
