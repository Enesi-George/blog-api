<?php
namespace App\Modules\Comments;

use Illuminate\Foundation\Http\FormRequest;

final class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:255',
        ];
    }
}