<?php

namespace App\Modules\Likes\Controllers;

use Throwable;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Modules\Likes\Requests\LikeRequest;

class LikeController extends ApiController
{
    public function store(LikeRequest $request, Post $post)
    {
        try {
            $validated_data = $request->validated();

            DB::beginTransaction();
                        
            Like::create($validated_data);

            DB::commit();

            return $this->success('thumbs up', 201);
        } catch (Throwable $th) {

            DB::rollback();

            logger('Updating Blog Error: ', [$th]);

            return $this->error('An error has occur. Pleae contact the administrator', 500);
        }
    }
}
