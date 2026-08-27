<?php

namespace Tests\Feature;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminResourceRouteParametersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_post_list_uses_only_datatable_pagination(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $post = Post::where('post_type', 'post')->orderByDesc('post_id')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('posts.index'));

        $response->assertOk();
        $response->assertSee('id="posts"', false);
        $response->assertDontSee('class="pagination"', false);
        $response->assertDontSee('?page=2', false);

        $this->actingAs($admin)
            ->get(route('posts.edit', ['post' => $post->post_id]))
            ->assertOk();
    }

    public function test_admin_category_list_renders_resource_edit_and_delete_links(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $category = Category::where('post_type', 'post')
            ->where('parent', 0)
            ->orderBy('category_id')
            ->firstOrFail();

        $response = $this->actingAs($admin)->get(route('categories.index'));

        $response->assertOk();
        $response->assertSee(route('categories.edit', ['category' => $category->category_id]), false);
        $response->assertSee(route('categories.destroy', ['category' => $category->category_id]), false);

        $this->actingAs($admin)
            ->get(route('categories.edit', ['category' => $category->category_id]))
            ->assertOk();
    }

    public function test_admin_can_soft_delete_a_post_without_querying_a_missing_comments_column(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $post = Post::where('post_type', 'post')->orderByDesc('post_id')->firstOrFail();

        $response = $this->actingAs($admin)->delete(route('posts.destroy', [
            'post' => $post->post_id,
        ]));

        $response->assertRedirect('admin/posts');
        $this->assertSoftDeleted('posts', ['post_id' => $post->post_id]);
        $this->assertSame('', session('errorMessage', ''));
    }

    public function test_admin_post_datatable_returns_json_when_searching(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $post = Post::where('post_type', 'post')
            ->where('sale_money', 0)
            ->orderByDesc('post_id')
            ->firstOrFail();

        $response = $this->actingAs($admin)->getJson(route('datatable_post', [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'title' => $post->title,
            'sale_money' => '0',
            'search' => ['value' => '', 'regex' => 'false'],
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);

        $row = collect($response->json('data'))->firstWhere('post_id', $post->post_id);
        $this->assertNotNull($row);
        $this->assertStringContainsString(
            route('posts.edit', ['post' => $post->post_id]),
            $row['action']
        );
        $this->assertStringContainsString(
            route('posts.destroy', ['post' => $post->post_id]),
            $row['action']
        );
    }
}
