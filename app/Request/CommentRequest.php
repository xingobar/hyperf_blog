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
use HyperfExt\Auth\Exceptions\AuthenticationException;

class CommentRequest extends FormRequest
{
    protected $scenes = [
        'create' => [
            'title', 'body',
        ],
        'update' => [
            'title', 'body',
        ],
    ];

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
        if ($this->getScene() === 'update') {
            return $this->getUpdateRule();
        }

        return [
            'title' => 'required',
            'body' => 'required|min:10',
        ];
    }

    /**
     * 設定更新規則.
     * @return array
     */
    public function getUpdateRule()
    {
        $rules = [];
        if ($this->has('title')) {
            $rules['title'] = 'required';
        }

        if ($this->has('body')) {
            $rules['body'] = 'required|min:10';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => '請輸入標題',
            'body.required' => '請輸入留言內容',
            'body.min' => '留言內容至少 :min 個字',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthenticationException('尚未登入');
    }
}
