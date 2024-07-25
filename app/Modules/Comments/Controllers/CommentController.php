<?php

namespace App\Modules\Comments\Controllers;

use Throwable;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Modules\Comments\CommentRequest;
use App\Modules\Comments\CommentResource;

class CommentController extends ApiController
{
    public function store(CommentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            // dd($data);

            $comment = Comment::create($data);

            DB::commit();

            $comment_data = new CommentResource($comment);

            return $this->success($comment_data, 201);
        } catch (Throwable $th) {
            DB::rollback();

            logger('Creating Comment Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }
}
