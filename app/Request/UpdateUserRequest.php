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

use App\Model\User;
use Hyperf\Validation\Request\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $array = [];
        if ($this->has('email')) {
            $array['email'] = 'required|email|unique:users,email,' . auth()->user()->id;
        }

        if ($this->has('gender')) {
            $array['gender'] = 'required|in:' . implode(',', array_keys(User::$genderMap));
        }

        if ($this->has('password')) {
            $array['password'] = 'required|min:6';
            $array['confirm_password'] = 'required|same:password';
        }

        if ($this->has('avatar')) {
            $array['avatar'] = 'required';
        }

        return $array;
    }

    public function messages(): array
    {
        return [
            'email.required' => '請輸入電子信箱',
            'email.email' => '電子信箱格式不符',
            'email.unique' => '電子信箱已存在',
            'gender.required' => '請輸入性別',
            'gender.in' => '傳入的性別有誤',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼至少 :min 位',
            'confirm_password.required' => '請輸入確認密碼',
            'confirm_password.same' => '密碼不一致',
            'avatar.required' => '請傳入大頭貼',
        ];
    }
}
