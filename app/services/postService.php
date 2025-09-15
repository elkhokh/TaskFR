<?php

namespace App\Services;

use App\Models\Post;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\PostsInterface;

class PostService
{
    use UploadImage;

    protected int $paginate = 3;
    protected PostsInterface $postRepository;

    public function __construct(PostsInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function homeService()
    {
        return $this->postRepository->getAll($this->paginate);
    }

    public function indexService()
    {
        return $this->postRepository->getByUser(Auth::id(), $this->paginate);
    }

    public function storeService(array $data, $image = null)
    {
        if ($image) {
            $data['image'] = $this->storeImage($image, 'posts');
        }
        $data['user_id'] = Auth::id();

        return $this->postRepository->store($data);
    }

    // public function showService($id)
    // {
    //     return $this->postRepository->findById($id);
    // }
    public function showService($id)
    {
        return Cache::store('redis')->remember("post_{$id}_with_comments", 60, function () use ($id) {
            return $this->postRepository->findById($id);
        });
    }

    public function updateService(Post $post, array $data, $image = null)
    {
        return DB::transaction(function () use ($post, $data, $image) {
            if ($image) {
                $data['image'] = $this->updateImage($image, $post->image, 'posts');
            } else {
                $data['image'] = $post->image;
            }

            return $this->postRepository->update($post, $data);
        });
    }

    public function destroyService(int $id)
    {
        $post = $this->postRepository->findById($id);

        $this->deleteImage($post->image);

        return $this->postRepository->delete($id);
    }
}
