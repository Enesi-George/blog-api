<?php

namespace App\Modules\Blogs\Controllers;

use Throwable;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use App\Modules\Blogs\Dtos\BlogDTO;
use App\Http\Controllers\ApiController;
use App\Modules\Blogs\Requests\BlogRequest;
use App\Modules\Blogs\Resources\BlogResource;

class BlogController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $blogs = Blog::all(); 

            $all_blog = BlogResource::collection($blogs);

            return $this->success($all_blog, 200);
        } catch (Throwable $th) {
            logger('Fetching Blog Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $validatedData = $request->validated();

            DB::beginTransaction();

            $blogData = new BlogDTO($validatedData);

            $blog = Blog::create($blogData->toArray());
            
            DB::commit();

            return $this->success(new BlogResource($blog), 201);
        } catch (Throwable $th) {
            DB::rollback();

            logger('Creating Blog Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try {
            $blog->load('posts');

            return $this->success(new BlogResource($blog), 200);
        } catch (Throwable $th) {
            logger('Error getting specific blog', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $validatedData = $request->validated(); 

            DB::beginTransaction();

            $blogData = new BlogDTO($validatedData);

            $blog->update($blogData->toArray());

            DB::commit();

            return $this->success(new BlogResource($blog), 200);
        } catch (Throwable $th) {
            DB::rollback();

            logger('Updating Blog Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            return $this->success('Blog deleted successfully', 204);
        } catch (Throwable $th) {
            logger('Deleting Blog Error: ', [$th]);

            return $this->error('An error has occurred. Please contact the administrator.', 500);
        }
    }
}
