<?php

namespace Tests\Feature;

use App\Entity\Job;
use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StaffDashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_is_redirected_instead_of_crashing_on_staff_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error_login');
    }

    public function test_staff_dashboard_renders_with_existing_local_assets(): void
    {
        $staff = User::where('role', 5)->firstOrFail();

        $response = $this->actingAs($staff)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee(asset('assets/css/bootstrap.min.css'), false);
        $response->assertSee(asset('assets/css/d-public.css'), false);
        $response->assertSee(asset('assets/css/cssNghia.css'), false);
        $response->assertSee(asset('assets/image/new/Logo.png'), false);
        $response->assertDontSee('href="public/', false);
        $response->assertDontSee('src="public/', false);

        $this->assertFileExists(public_path('assets/css/bootstrap.min.css'));
        $this->assertFileExists(public_path('assets/css/d-public.css'));
        $this->assertFileExists(public_path('assets/css/cssNghia.css'));
        $this->assertFileExists(public_path('assets/image/new/Logo.png'));
    }

    public function test_staff_job_list_renders_employer_edit_link_with_resource_parameter(): void
    {
        $staff = User::where('role', 5)->firstOrFail();
        $job = Job::join('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->select('jobs.*')
            ->orderByDesc('jobs.job_id')
            ->firstOrFail();
        $employerEditUrl = route('staff_employer.edit', [
            'staff_employer' => $job->employer_id,
        ]);

        $response = $this->actingAs($staff)->get(route('staff_job-ntd.index', [
            'job_id' => $job->job_id,
        ]));

        $response->assertOk();
        $response->assertSee($employerEditUrl, false);
        $this->actingAs($staff)
            ->get($employerEditUrl)
            ->assertOk()
            ->assertSee(route('employer_update_with_staff_admin', [
                'id' => $job->employer_id,
            ]), false);
    }
}
