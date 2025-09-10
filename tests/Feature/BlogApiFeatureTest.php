<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comments;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogApiFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_list_posts()
    {
        Sanctum::actingAs(User::factory()->create());
        Post::factory()->count(3)->create();

        $this->getJson('/api/posts')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /** @test */
    public function authenticated_user_can_create_post()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/posts', [
            'title' => 'My Test Post',
            'content' => 'Some content here',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'My Test Post']);

        $this->assertDatabaseHas('posts', [
            'title' => 'My Test Post',
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function authenticated_user_can_update_post()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ])->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    /** @test */
    public function authenticated_user_can_delete_post()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->deleteJson("/api/posts/{$post->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Post Deleted successfully']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function authenticated_user_can_add_comment_to_post()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $post = Post::factory()->create();

        $response = $this->postJson("/api/comments/store/{$post->id}", [
            'content' => 'This is a test comment',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['content' => 'This is a test comment']);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function authenticated_user_can_update_comment()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $comment = Comments::factory()->create(['user_id' => $user->id]);

        $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated Comment',
        ])->assertStatus(201) // برضو عندك بيرجع 201
            ->assertJsonFragment(['content' => 'Updated Comment']);

        $this->assertDatabaseHas('comments', ['content' => 'Updated Comment']);
    }

    /** @test */
    public function authenticated_user_can_delete_comment()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $comment = Comments::factory()->create(['user_id' => $user->id]);

        $this->deleteJson("/api/comments/{$comment->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'comment deleted successfully']);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
