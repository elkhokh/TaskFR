<?php
namespace App\Repositories\Interfaces;

use App\Models\Post; 

interface PostsInterface
{
    // public function homeRepository();
    // public function indexRepository();
    // public function storeRepository(array $data, $image = null);
    // public function showRepository($id);
    // public function updateRepository(Post $post, array $data, $image = null);
    // public function destroyRepository(int $id);

    public function getAll(int $paginate);
    public function getByUser(int $userId, int $paginate);
    public function store(array $data);
    public function findById(int $id);
    public function update(Post $post, array $data);
    public function delete(int $id);
}
