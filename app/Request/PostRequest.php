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

class PostRequest extends FormRequest
{
    public $scenes = [
        'update' => [
            'title', 'headline', 'description',
            'image', 'image_filename', 'price',
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
        return [
            'title' => 'required|max:150',
            'headline' => 'present|max:150',
            'description' => 'required|max:150',
            'image' => 'required',
            'image_filename' => 'required',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '請輸入文章標題',
            'title.max' => '標題最大字數為 :max 個字',
            'headline.present' => '請輸入副標題',
            'headline.max' => '副標題最大字數為 :max 個字',
            'description.required' => '請傳入說明的文字',
            'description.max' => '說明最大字數為 :max 個字',
            'image.required' => '請傳入圖片',
            'image_filename.required' => '請傳入圖片檔案名稱',
            'price.required' => '請傳入文章價格',
            'price.integer' => '價格型別有誤',
            'price.min' => '價格至少 :min 元',
        ];
    }
}
