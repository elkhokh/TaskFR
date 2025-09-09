<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        try {
            $posts = $this->postService->homeService();
            return ApiResponse::success( PostsResource::collection($posts), "all Posts retrieved successfully", 200);
            // return ApiResponse::success($posts, "all Posts retrieved successfully", 200);
        } catch (\Exception $e) {
            return ApiResponse::error("Failed to retrieve all posts", $e->getMessage(), 500);
        }
    }
    public function index()
    {
        try {
            $posts = $this->postService->indexService();
            return ApiResponse::success(PostsResource::collection($posts), " retrieved my posts successfully", 200);
            // return ApiResponse::success($posts, " retrieved my posts successfully", 200);
        } catch (\Exception $th) {
            return ApiResponse::error("Failed to retrieve all posts", $th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $post = $this->postService->storeService($data, $request->file('image'));
            DB::commit();
            // return ApiResponse::success($post, "Post added successfully", 201);
            return ApiResponse::success(new PostsResource($post), "Post added successfully", 201);

        } catch (\Exception $th) {
            DB::rollBack();
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            // return ApiResponse::error("Failed Create Post", $th->getMessage(), 500);
            return ApiResponse::error("Failed Create Post", [], 500);
        }
    }
    /**
     * Display the specified resource.
     */

    //show post with comments
    public function show(string $id)
    {
        try {
            $post = $this->postService->showService($id);
            return ApiResponse::success(new PostsResource($post), "Post retrieved successfully", 200);
            // return ApiResponse::success($post, "Post retrieved successfully", 200);
        } catch (\Exception $th) {
            Log::channel('posts')->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Failed show Post", $th->getMessage(), 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        try {
            $this->authorize('update', $post);
            $post = $this->postService->updateService($post, $data, $request->file('image'));
            return ApiResponse::success($post, "Post updated successfully", 200);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::channel('posts')->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Failed update Post", [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
              $post = Post::findOrFail($id);
            $this->authorize('delete', $post);
            $deleted = $this->postService->destroyService($id);
            if ($deleted) {
                // return redirect()->route('home')->with('success', "Deleted successfully");
                return ApiResponse::success(null, "Post Deleted successfully", 200);
            }
            return ApiResponse::error("Post could not be deleted", [], 500);
        } catch (\Exception $th) {
            Log::channel("posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Failed delete Post", $th->getMessage(), 500);
        }
    }
}
