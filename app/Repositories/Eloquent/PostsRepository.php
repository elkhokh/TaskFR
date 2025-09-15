<?php
namespace App\Repositories\Eloquent;


//binding when you want to not use appserviceprovider 

// use App\Repositories\Interfaces\PostsInterface;
// use Illuminate\Contracts\Container\Binding;

// #[Binding(PostsInterface::class)]

use App\Models\Post;
use App\Repositories\Interfaces\PostsInterface;

class PostsRepository implements PostsInterface
{
    protected int $paginate = 3;

    public function getAll(int $paginate)
    {
        return Post::with('user')->orderBy('id', 'desc')->paginate($paginate);
    }

    public function getByUser(int $userId, int $paginate)
    {
        return Post::where('user_id', $userId)->latest()->paginate($paginate);
    }

    public function store(array $data)
    {

        // $post = Post::create([
        //     'title' => $data['title'],
        //     'content' => $data['content'],
        //     'user_id' => $data['user_id'],
        //     'image' => $data['image'] ?? null,
        // ]);

        // return $post;
        return Post::create($data);
    }

    public function findById(int $id)
    {
        return Post::with(['comments.user'])->findOrFail($id);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function delete(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }
}
