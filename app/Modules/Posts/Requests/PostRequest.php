<?php

namespace App\Modules\Posts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'blog_id' => 'required|exists:blogs,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|url'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['blog_id'] = 'required|exists:blogs,id';
            $rules['title'] = 'nullable|string';
            $rules['content'] = 'nullable|string';
            $rules['image'] = [
                'nullable',
                'url',
            ];
        }
        return $rules;
    }
}
