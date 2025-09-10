<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comments;
use Illuminate\Http\Request;
use App\Mail\CommentAddedMail;
use App\Services\CommentService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function storeComment(Request $request, $post_id)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
            ], [
                'content.required' => 'required message ',
                'content.string' => 'message must be string',
                'content.max' => 'max of message is 1000 ',
            ]);
            $comment = $this->commentService->storeCommentService($request, $post_id);

            // Mail::to($comment->post->user->email)->send(new CommentAddedMail($comment));
            Mail::to($comment->post->user->email)->queue(new CommentAddedMail($comment));


            return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment added successfully!');
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('error', 'Error store comment');
        }
    }

    public function destroyComment(Comments $comment)
    {
        try {
            $this->authorize('delete', $comment);
            $comment->delete();

            return back()->with('success', 'comment deleted successfully');
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('error', 'Error getting posts');
        }
    }

    public function updateComment(Request $request, Comments $comment)
    {
        try {
            $this->authorize('update', $comment);
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);
            $comment->update([
                'content' => $request->content,
            ]);
            return back()->with('success', 'updated successfully');
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->with('error', 'Error getting posts');
        }
    }

}


