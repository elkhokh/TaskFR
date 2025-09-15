<?php
namespace App\Services;

use App\Models\Post;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostService
{

    use UploadImage;
    protected int $paginate = 3;
//show main page
    public function homeService()
    {
        return Post::with('user')->orderBy('id', 'desc')->paginate($this->paginate);
    }
//show my posts
    public function indexService()
    {
        $user = auth()->user();
        return $user->posts()->latest()->paginate($this->paginate);
    }

    //store post
    public function storeService(array $data, $image = null)
    {
        if ($image) {
            $data['image'] = $this->storeImage($image, 'posts');
        }

        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        // $post = Post::create([
        //     'title' => $data['title'],
        //     'content' => $data['content'],
        //     'user_id' => $data['user_id'],
        //     'image' => $data['image'] ?? null,
        // ]);
        return $post;
    }

    public function showService($id)
    {
        // $post = Post::with('user')->findOrFail($id);
        $post = Post::with(['comments.user'])->findOrFail($id);
        return $post;
    }
    public function updateService(Post $post, array $data, $image = null)
    {
        DB::beginTransaction();

        if ($image) {
            $data['image'] = $this->updateImage($image, $post->image, 'posts');
        } else {
            $data['image'] = $post->image;
        }

        $post->update($data);

        DB::commit();
        return $post;

    }

    public function destroyService(int $id)
    {
        $post = Post::findOrFail($id);

        $this->deleteImage($post->image);
    
        $post->delete();
        return $post;
    }

}
