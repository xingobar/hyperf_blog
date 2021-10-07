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
namespace App\Mail;

use HyperfExt\Contract\ShouldQueue;
use HyperfExt\Mail\Mailable;

class ConfirmEmail extends Mailable implements ShouldQueue
{
    public $queue = 'default';

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     */
    public function build(): void
    {
        $this->subject('信箱驗證信件')
            ->htmlBody('hello world');
    }
}
