<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\UploadImage;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{

    use UploadImage , AuthorizesRequests  ;
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */

    //show main page

    public function home()
    {
        try {
            $posts = $this->postService->homeService();
            return view('home', compact('posts'));
        } catch (\Throwable $th) {
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('error', 'Error getting posts');
        }
    }
    //show my posts
    public function index()
    {
        try {
            $posts = $this->postService->indexService();

            return view('posts.index', compact('posts'));
        } catch (\Exception $th) {
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->route('home')->with('error', 'Could not get your posts');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
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
            // event(new PostCreatedEvent($post));
            DB::commit();
            return redirect()->route('home')->with('success', "added successfully");
            //  return to_route("posts.index")->with("success", "Post Created Successfully!");
        } catch (\Exception $th) {
            DB::rollBack();
            Log::channel("Posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->route('home')->with('Error', 'Failed Create Post');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $post = $this->postService->showService($id);
            return view('posts.show', compact('post'));
        } catch (\Exception $th) {
            Log::channel('posts')->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->route('home')->with('Error', 'Failed show Post');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        try {
            $this->authorize('update', $post);
            $post = $this->postService->updateService($post, $data, $request->file('image'));
            return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully');
        } catch (\Exception $th) {
            DB::rollBack();
            Log::channel('posts')->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('error', 'Failed to update post');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $this->authorize('delete', $post);
            $deleted = $this->postService->destroyService($id);
            if ($deleted) {
                return redirect()->route('home')->with('success', "Deleted successfully");
            }
            return redirect()->route('home')->with('Error', "Post could not be deleted");
        } catch (\Exception $th) {
            Log::channel("posts")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->route('home')->with('Error', 'Failed Create Post');
        }
    }
}
