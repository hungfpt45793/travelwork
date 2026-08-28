<?php

namespace Tests\Feature;

use App\Entity\Category;
use App\Entity\Category_template_email;
use App\Entity\Employer;
use App\Entity\InformationService;
use App\Entity\Job;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\VoucherCategories;
use App\Transaction\List_product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminResourceRouteParametersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_job_list_renders_resource_edit_and_delete_links(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $job = Job::join('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->select('jobs.*')
            ->orderByDesc('jobs.job_id')
            ->firstOrFail();

        $response = $this->actingAs($admin)->get(route('job.index'));

        $response->assertOk();
        $response->assertSee(route('job.edit', ['job' => $job->job_id]), false);
        $response->assertSee(route('job.destroy', ['job' => $job->job_id]), false);

        $this->actingAs($admin)
            ->get(route('job.edit', ['job' => $job->job_id]))
            ->assertOk();
    }

    public function test_admin_can_update_job_without_losing_slug_or_optional_integrations(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $job = Job::join('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->select('jobs.*')
            ->orderByDesc('jobs.job_id')
            ->firstOrFail();
        $originalSlug = $job->slug;
        $originalImage = $job->image;
        $originalCampaign = $job->campain_candidate;
        $updatedTitle = 'Tin tuyển dụng đã cập nhật ' . uniqid();

        $response = $this->actingAs($admin)->put(route('job.update', [
            'job' => $job->job_id,
        ]), [
            'title' => $updatedTitle,
            'tags' => ['kiem-thu-cap-nhat'],
            'age_id' => $job->age_id,
            'description' => $job->description,
            'salary_id' => $job->salary_id,
            'experience_id' => $job->experience_id,
            'literacy_id' => $job->literacy_id,
            'deadline_submit_profile' => $job->deadline_submit_profile,
            'content' => $job->content,
            'welfare' => $job->welfare,
            'employer_id' => $job->employer_id,
            'number_recruit' => $job->number_recruit,
            'province' => $job->province,
            'district' => $job->district,
            'vip' => $job->vip,
            'position' => $job->position,
            'gender' => $job->gender,
            'date_end' => $job->date_end,
            'meta_title' => $job->meta_title,
            'meta_description' => $job->meta_description,
            'meta_keyword' => $job->meta_keyword,
            'sale_money' => $job->sale_money,
            'salePackages' => $job->sale_package_id,
            'software' => $job->software_id,
            'jobgroup_id' => $job->jobgroup_id,
            'career_category_id' => $job->career_category_id,
            'address' => $job->address_work,
        ]);

        $response->assertRedirect(route('job.index'));
        $response->assertSessionHas('success');

        $job->refresh();
        $this->assertSame($updatedTitle, $job->title);
        $this->assertSame($originalSlug, $job->slug);
        $this->assertSame($originalImage, $job->image);
        $this->assertSame($originalCampaign, $job->campain_candidate);
    }

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

    public function test_admin_category_list_displays_parent_title_and_slug_in_separate_columns(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $suffix = str_replace('.', '', uniqid('', true));
        $parent = Category::create([
            'title' => 'Danh mục cha test ' . $suffix,
            'slug' => 'danh-muc-cha-test-' . $suffix,
            'parent' => 0,
            'post_type' => 'post',
        ]);
        $child = Category::create([
            'title' => 'Danh mục con test ' . $suffix,
            'slug' => 'slug-khong-phai-danh-muc-cha-' . $suffix,
            'parent' => $parent->category_id,
            'post_type' => 'post',
        ]);

        $response = $this->actingAs($admin)->get(route('categories.index'));

        $response->assertOk();
        $response->assertSeeText($child->title);
        $response->assertSeeText($parent->title);
        $response->assertSeeText($child->slug);
        $response->assertSeeInOrder([
            '<th>Danh mục cha</th>',
            '<th>Slug</th>',
        ], false);
    }

    public function test_admin_legacy_resource_lists_render_with_laravel_11_route_parameters(): void
    {
        $admin = User::where('role', 4)->firstOrFail();
        $employer = Employer::orderByDesc('employer_id')->firstOrFail();
        $voucherCategory = VoucherCategories::orderBy('id_cate_voucher')->firstOrFail();
        $informationService = InformationService::orderBy('service_id')->firstOrFail();
        $product = List_product::orderBy('product_id')->firstOrFail();
        $emailCategory = Category_template_email::orderByDesc('id_cate_tem')->firstOrFail();

        $resources = [
            [
                'index' => route('employer.index'),
                'edit' => route('employer.edit', ['employer' => $employer->employer_id]),
                'destroy' => route('employer.destroy', ['employer' => $employer->employer_id]),
            ],
            [
                'index' => route('voucher-categories.index'),
                'edit' => route('voucher-categories.edit', ['voucher_category' => $voucherCategory->id_cate_voucher]),
                'destroy' => route('voucher-categories.destroy', ['voucher_category' => $voucherCategory->id_cate_voucher]),
            ],
            [
                'index' => route('information_service.index'),
                'edit' => route('information_service.edit', ['information_service' => $informationService->service_id]),
                'destroy' => route('information_service.destroy', ['information_service' => $informationService->service_id]),
            ],
            [
                'index' => route('list_product.index'),
                'edit' => route('list_product.edit', ['list_product' => $product->product_id]),
                'destroy' => route('list_product.destroy', ['list_product' => $product->product_id]),
            ],
            [
                'index' => route('category_template_email.index'),
                'edit' => route('category_template_email.edit', ['category_template_email' => $emailCategory->id_cate_tem]),
                'destroy' => route('category_template_email.destroy', ['category_template_email' => $emailCategory->id_cate_tem]),
            ],
        ];

        foreach ($resources as $resource) {
            $response = $this->actingAs($admin)->get($resource['index']);

            $response->assertOk();
            $response->assertSee($resource['edit'], false);
            $response->assertSee($resource['destroy'], false);

            $this->actingAs($admin)->get($resource['edit'])->assertOk();
        }
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
