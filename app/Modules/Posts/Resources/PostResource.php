<?php

namespace App\Modules\Posts\Resources;

use Illuminate\Http\Request;
use App\Modules\Comments\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'blog_id' => $this->blog_id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'likes' => $this->whenLoaded('likes', function () {
                return $this->likes->map(function ($like) {
                    $data = [
                        'id' => $like->id,
                        'user_id' => $like->user_id,
                    ];
                    return $data;
                });
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return $this->comments->map(function ($comment) {
                    $data = [
                        'id' => $comment->id,
                        'user_id' => $comment->user_id,
                        'content' => $comment->content,
                    ];
                    return $data;
                });
            }),
        ];
    }
}
