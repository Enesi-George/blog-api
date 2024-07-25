<?php

namespace App\Modules\Blogs\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class BlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
