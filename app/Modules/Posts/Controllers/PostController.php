<?php

namespace App\Modules\Posts\Controllers;

use Throwable;
use App\Models\Blog;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Posts\Dtos\PostDTO;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Modules\Posts\Requests\PostRequest;
use App\Modules\Posts\Requests\UpdatePostRequest;
use App\Modules\Posts\Resources\PostResource;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        try {
            $posts = Post::all();
            $posts = PostResource::collection($posts);
            return $this->success($posts, 200);
        } catch (Throwable $th) {
            logger('Posts Fetching Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $dto = new PostDTO($data);

            $post = Post::create($dto->toArray());

            DB::commit();

            $post_data =  new PostResource($post);

            return $this->success($post_data, 200);
        } catch (Throwable $th) {
            DB::rollback();

            logger('Create Post Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        try {
            $post = new PostResource($post->load('likes', 'comments'));
            return $this->success($post, 200);
        } catch (Throwable $th) {
            logger('Post Fetching Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $data['blog_id'] = $post->blog_id;

            // dd($data);
            $post->update($data);

            DB::commit();

            $post_data = new PostResource($post->fresh());

            return $this->success($post_data, 200);
        } catch (Throwable $th) {
            DB::rollback();

            logger('Update Post Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, Post $post)
    {
        try {
            $post->delete();
            return response()->json(null, 204);
        } catch (Throwable $th) {
            logger('Delete Posting Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }
}
