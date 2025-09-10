<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\WithFaker;
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comments;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $post->id), [
                'content' => 'Test Comment',
            ])
            ->assertRedirect(route('posts.show', $post->id));

        $this->assertDatabaseHas('comments', [
            'content' => 'Test Comment',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_user_can_delete_comment()
    {
        $user = User::factory()->create();
        $comment = Comments::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('comments.destroy', $comment->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}

