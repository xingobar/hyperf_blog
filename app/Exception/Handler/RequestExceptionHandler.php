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
namespace App\Exception\Handler;

use App\Exception\AccessDeniedException;
use App\Exception\NotFoundException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use HyperfExt\Auth\Exceptions\AuthenticationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class RequestExceptionHandler extends ExceptionHandler
{
    /**
     * Handle the exception, and return the specified result.
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof NotFoundException) {
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            $this->stopPropagation();

            return $response->withStatus(404)->withBody(new SwooleStream($data));
        }
        if ($throwable instanceof AuthenticationException) {
            $data = json_encode([
                'code' => 401,
                'message' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            $this->stopPropagation();

            return $response->withStatus(401)->withBody(new SwooleStream($data));
        }

        if ($throwable instanceof AccessDeniedException) {
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            $this->stopPropagation();

            return $response->withStatus(403)->withBody(new SwooleStream($data));
        }

        return $response;
    }

    /**
     * Determine if the current exception handler should handle the exception,.
     *
     * @return bool
     *              If return true, then this exception handler will handle the exception,
     *              If return false, then delegate to next handler
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
