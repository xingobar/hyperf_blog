<?php


namespace App\Exception\Handler;


use App\Exception\InvalidRequestException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class FromValidateExceptionHandler extends ExceptionHandler
{

    /**
     * Handle the exception, and return the specified result.
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof ValidationException) {
            // 格式化輸出
            $data = json_encode([
                'code' => 400,
                'message' => $throwable->validator->errors()->first(),
            ], JSON_UNESCAPED_UNICODE);

            // 阻止異常冒泡
            $this->stopPropagation();
            return $response->withStatus(400)->withBody(new SwooleStream($data));
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