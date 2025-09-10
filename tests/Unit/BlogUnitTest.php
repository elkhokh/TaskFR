<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comments;
use App\Mail\CommentAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_have_posts()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->posts->contains($post));
    }

    /** @test */
    public function user_can_have_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comments::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->assertTrue($user->comments->contains($comment));
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function can_send_comment_added_email()
    {
        Mail::fake(); // Fake mail, no real email sent

        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comments::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'Test Comment'
        ]);

        // Simulate sending email
        Mail::to($post->user->email)->send(new CommentAddedMail($comment));

        // Assert that the email was sent
        Mail::assertSent(CommentAddedMail::class, function ($mail) use ($comment) {
            return $mail->comment->id === $comment->id;
        });
    }

    /** @test */
    public function post_belongs_to_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $post->user->id);
    }

    /** @test */
    public function comment_belongs_to_post_and_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comments::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->assertEquals($user->id, $comment->user->id);
        $this->assertEquals($post->id, $comment->post->id);
    }
}
