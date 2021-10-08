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
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class AuthRequest extends FormRequest
{
    protected $scenes = [
        'register' => [
            'account', 'email', 'password', 'confirm_password',
        ],
        'login' => [
            'account', 'password',
        ],
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getScene() === 'login') {
            return [
                'account' => 'required|min:6',
                'password' => 'required',
            ];
        }

        return [
            'account' => 'required|min:6|unique:users,account',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'account.required' => '請輸入帳號',
            'account.min' => '帳號至少輸入 :min 個字',
            'account.unique' => '帳號已存在',
            'email.required' => '請輸入電子信箱',
            'email.email' => '電子信箱格式不符',
            'email.unique' => '電子信箱已存在',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼至少輸入 :min 個字',
            'confirm_password.required' => '請再次輸入密碼',
            'confirm_password.same' => '請確認密碼是否一致',
        ];
    }
}
