<?php
namespace App\Modules\Likes\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class LikeRequest extends FormRequest
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
        ];
    }
}