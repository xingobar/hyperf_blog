<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/mail.
 *
 * @link     https://github.com/hyperf-ext/mail
 * @contact  eric@zhu.email
 * @license  https://github.com/hyperf-ext/mail/blob/master/LICENSE
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
        //
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
