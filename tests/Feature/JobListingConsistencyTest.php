<?php

namespace Tests\Feature;

use App\Entity\Job;
use App\Entity\Employer;
use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobListingConsistencyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_homepage_public_jobs_are_visible_in_job_list_for_guests_and_candidates(): void
    {
        $sourceJob = Job::firstOrFail();
        $suffix = str_replace('.', '', uniqid('', true));
        $homepageJobs = collect([
            $this->createPublicJobFrom($sourceJob, 'UV029 Tuyển gấp ' . $suffix, 1, $suffix . '-urgent'),
            $this->createPublicJobFrom($sourceJob, 'UV029 Việc làm mới ' . $suffix, 0, $suffix . '-new'),
        ]);

        $homepageResponse = $this->get(route('home'));
        $guestListResponse = $this->get(route('list_job_face'));

        $homepageResponse->assertOk();
        $guestListResponse->assertOk();

        foreach ($homepageJobs as $job) {
            $homepageResponse->assertSeeText($job->title);
            $guestListResponse->assertSeeText($job->title);
        }

        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $candidateListResponse = $this->actingAs($candidate)->get(route('list_job_face'));

        $candidateListResponse->assertOk();
        foreach ($homepageJobs as $job) {
            $candidateListResponse->assertSeeText($job->title);
        }
    }

    public function test_job_title_filter_requires_a_name_when_filter_button_is_used(): void
    {
        $url = route('seacrh_job_facebook', [
            'slug' => 'tuyen-ke-toan',
            'p' => 0,
            'c' => 0,
            'vip' => '',
            'word' => '',
            'search_by_title' => 1,
        ]);

        $response = $this->from($url)->get($url);

        $response->assertRedirect($url);
        $response->assertSessionHas('job_search_error', 'Vui lòng nhập việc theo tên');
    }

    public function test_job_filter_button_is_not_fixed_and_supports_current_query_names(): void
    {
        $suffix = str_replace('.', '', uniqid('', true));
        $job = $this->createPublicJobFrom(
            Job::firstOrFail(),
            'UV029 Tìm theo tên ' . $suffix,
            1,
            $suffix . '-filter'
        );
        $response = $this->get(route('seacrh_job_facebook', [
            'slug' => 'tuyen-ke-toan',
            'word' => $job->title,
            'vip' => $job->vip,
        ]));

        $response->assertOk();
        $response->assertSeeText($job->title);
        $response->assertDontSeeText('Chưa có việc phù hợp');
        $response->assertSee('id="job_title_filter_error"', false);
        $response->assertSee('name="search_by_title"', false);
        $response->assertDontSee('class="dsBlock mgt10 js_sd_fixel_bottom js_remove_fixel"', false);
    }

    public function test_job_search_displays_an_empty_state_when_no_jobs_match(): void
    {
        $missingTitle = 'UV029-khong-ton-tai-' . str_replace('.', '', uniqid('', true));

        $response = $this->get(route('seacrh_job_facebook', [
            'slug' => 'tuyen-ke-toan',
            'word' => $missingTitle,
            'search_by_title' => 1,
        ]));

        $response->assertOk();
        $response->assertSee('id="job_search_empty_state"', false);
        $response->assertSeeText('Chưa có việc phù hợp');
    }

    public function test_job_detail_builds_the_employer_link_with_the_slug_route_parameter(): void
    {
        $employer = Employer::whereNotNull('slug')
            ->where('slug', '<>', '')
            ->whereIn('employer_id', Job::select('employer_id'))
            ->firstOrFail();
        $job = Job::where('employer_id', $employer->employer_id)->firstOrFail();
        $job->update([
            'views' => 0,
            'active_job' => 1,
            'deadline_submit_profile' => now()->addWeek()->toDateString(),
        ]);

        $response = $this->get(route('job_detail', ['slug' => $job->slug]));

        $response->assertOk();
        $response->assertSee(
            route('detail_employer', ['slug' => $employer->slug]),
            false
        );
    }

    public function test_candidate_can_open_job_detail_with_valid_save_job_routes(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $employer = Employer::whereNotNull('slug')
            ->where('slug', '<>', '')
            ->whereIn('employer_id', Job::select('employer_id'))
            ->firstOrFail();
        $job = Job::where('employer_id', $employer->employer_id)->firstOrFail();
        $job->update([
            'views' => 0,
            'active_job' => 1,
            'deadline_submit_profile' => now()->addWeek()->toDateString(),
        ]);

        $response = $this->actingAs($candidate)->get(route('job_detail', [
            'slug' => $job->slug,
        ]));

        $response->assertOk();
        $response->assertSee(route('saveJob', [
            'id_job' => $job->job_id,
        ]), false);
        $response->assertSee(route('deletesaveJob', [
            'id_job' => $job->job_id,
        ]), false);
    }

    public function test_related_job_without_an_employer_uses_a_safe_company_name(): void
    {
        $job = Job::firstOrFail()->replicate();
        $job->job_code = 'QA-ORPHAN-' . str_replace('.', '', uniqid('', true));
        $job->slug = 'qa-related-job-without-employer-' . str_replace('.', '', uniqid('', true));
        $job->employer_id = PHP_INT_MAX;
        $job->save();

        $response = $this->view('site.jobs_site.item_job_new', [
            'job' => $job,
        ]);

        $response->assertSeeText('Nhà tuyển dụng đang cập nhật');
    }

    private function createPublicJobFrom(Job $sourceJob, string $title, int $vip, string $suffix): Job
    {
        $job = $sourceJob->replicate();
        $job->job_code = 'UV029-' . $suffix;
        $job->title = $title;
        $job->slug = 'uv029-' . $suffix;
        $job->vip = $vip;
        $job->active_job = 1;
        $job->deadline_submit_profile = now()->addWeek()->toDateString();
        $job->date_submit = now();
        $job->updated_at = now();
        $job->deleted_at = null;
        $job->save();

        return $job;
    }
}
