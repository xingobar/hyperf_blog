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
namespace App\Exception;

use Hyperf\Server\Exception\ServerException;
use Throwable;

class NotFoundException extends ServerException
{
    public function __construct($message = '找不到資料', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
