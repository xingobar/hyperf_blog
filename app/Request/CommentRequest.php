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

class CommentRequest extends FormRequest
{
    protected $scenes = [
        'create' => [
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
        return [
            'title' => 'required',
            'body' => 'required|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '請輸入標題',
            'body.required' => '請輸入留言內容',
            'body.min' => '留言內容至少 :min 個字',
        ];
    }
}
