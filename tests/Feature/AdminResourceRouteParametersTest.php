<?php

namespace Tests\Feature;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Tests\TestCase;

class AdminResourceRouteParametersTest extends TestCase
{
    public function test_admin_post_list_renders_resource_edit_and_delete_links(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $post = Post::where('post_type', 'post')->orderByDesc('post_id')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('posts.index'));

        $response->assertOk();
        $response->assertSee(route('posts.edit', ['post' => $post->post_id]), false);
        $response->assertSee(route('posts.destroy', ['post' => $post->post_id]), false);

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
}
