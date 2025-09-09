<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CommentService{

    public function storeCommentService($request ,$post_id){

$post = Post::findOrFail($post_id);
    return Comments::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);
    }
    public function updateCommentService(){

    }
    public function destroyCommentService(){

    }
}
