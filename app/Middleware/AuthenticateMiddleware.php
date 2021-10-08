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
namespace App\Middleware;

use HyperfExt\Auth\Middlewares\AbstractAuthenticateMiddleware;
use Psr\Http\Server\MiddlewareInterface;

class AuthenticateMiddleware extends AbstractAuthenticateMiddleware implements MiddlewareInterface
{
    /**
     * Get guard names.
     *
     * @return string[]
     */
    protected function guards(): array
    {
        return ['api'];
    }
}
