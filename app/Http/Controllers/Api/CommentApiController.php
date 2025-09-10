<?php

namespace App\Http\Controllers\Api;

use App\Models\Comments;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Mail\CommentAddedMail;
use App\Services\CommentService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CommentsResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentApiController extends Controller
{
    use AuthorizesRequests;
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

            // $owner_post = "yahyaw889@gmail.com";
            $owner_post = $comment->post->user->email;
            Mail::to($owner_post)->queue(new CommentAddedMail($comment));

            return ApiResponse::success(new CommentsResource($comment), "comment added successfully", 201);
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Error store comment", [], 500);
        }
    }

    public function destroyComment(Comments $comment)
    {
        try {
            $this->authorize('delete', $comment);
            $comment->delete();
            return ApiResponse::success(new CommentsResource($comment), "comment deleted successfully", 200);
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("Error delete comment", [], 500);
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
            return ApiResponse::success(new CommentsResource($comment), "comment updated successfully", 201);
        } catch (\Throwable $th) {
            Log::channel("comments")->error($th->getMessage() . $th->getFile() . $th->getLine());
            return ApiResponse::error("error to edit the comment", [], 500);
        }
    }
}
