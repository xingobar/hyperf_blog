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
    \App\Contracts\UserServiceInterface::class => \App\Service\UserService::class,
    \Hyperf\Database\Model\Factory::class => \App\Service\ModelFactory::class,
    \App\Contracts\PostServiceInterface::class => \App\Service\PostService::class,
    \App\Contracts\CategoryServiceInterface::class => \App\Service\CategoryService::class,
];
