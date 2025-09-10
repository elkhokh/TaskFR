<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comments;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email']
                ]
            ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /** @test */
    public function user_can_login_and_get_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'user'
                ]
            ]);
    }

    /** @test */
    public function user_can_logout()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'logged out successfully ']); // زي ما مكتوب في AuthController
    }

    /** @test */
    public function user_can_create_post()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'content']
            ]);
    }

    /** @test */
    public function user_can_list_posts()
    {
        Sanctum::actingAs(User::factory()->create());
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /** @test */
    public function user_can_add_comment_to_post()
    {
        Sanctum::actingAs(User::factory()->create());
        $post = Post::factory()->create();

        $response = $this->postJson("/api/comments/store/{$post->id}", [
            'content' => 'Nice Post!'
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['content' => 'Nice Post!']);
    }

    /** @test */
    public function user_can_update_comment()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $comment = Comments::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated Comment'
        ]);

        $response->assertStatus(201) // عندك الـ controller بيرجع 201 مش 200
            ->assertJsonFragment(['content' => 'Updated Comment']);
    }

    /** @test */
    public function user_can_delete_comment()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $comment = Comments::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'comment deleted successfully']);
    }
}
