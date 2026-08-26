<?php

namespace Tests\Feature;

use App\Entity\Coin_apply_employee;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Invite;
use App\Entity\Job;
use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmployerInviteCandidateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_employer_can_invite_candidate_to_owned_active_unexpired_job(): void
    {
        Mail::fake();

        $user = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $employer = Employer::where('user_id', $user->id)->firstOrFail();
        $employeeId = Employee::where('email', 'qa.employee@travelwork.test')->value('employee_id');
        $job = Job::whereNotNull('career_category_id')->firstOrFail();

        $employer->update([
            'employer_coin' => 1000,
            'total_employer_coin' => 1000,
        ]);
        $job->update([
            'employer_id' => $employer->employer_id,
            'active_job' => 1,
            'deadline_submit_profile' => now()->addWeek()->toDateString(),
        ]);

        Coin_apply_employee::where([
            'employer_id' => $employer->employer_id,
            'employee_id' => $employeeId,
            'job_id' => $job->job_id,
        ])->forceDelete();
        Invite::where([
            'employer_id' => $employer->employer_id,
            'employee_id' => $employeeId,
            'job_id' => $job->job_id,
        ])->delete();

        $response = $this->actingAs($user)->from('/thong-tin-ung-vien/qa-candidate')->post(
            route('send_job_employer'),
            [
                'job_ids' => [$job->job_id],
                'employee_id' => $employeeId,
            ]
        );

        $response->assertRedirect('/thong-tin-ung-vien/qa-candidate');
        $response->assertSessionHas('success', 'Mời ứng viên ứng tuyển thành công');
        $this->assertDatabaseHas('coin_apply_employee', [
            'employer_id' => $employer->employer_id,
            'employee_id' => $employeeId,
            'job_id' => $job->job_id,
        ]);
        $this->assertDatabaseHas('invite', [
            'employer_id' => $employer->employer_id,
            'employee_id' => $employeeId,
            'job_id' => $job->job_id,
            'status' => 0,
        ]);
    }

    public function test_employer_cannot_invite_candidate_to_expired_job(): void
    {
        Mail::fake();

        $user = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $employer = Employer::where('user_id', $user->id)->firstOrFail();
        $employeeId = Employee::where('email', 'qa.employee@travelwork.test')->value('employee_id');
        $job = Job::whereNotNull('career_category_id')->firstOrFail();

        $job->update([
            'employer_id' => $employer->employer_id,
            'active_job' => 1,
            'deadline_submit_profile' => now()->subDay()->toDateString(),
        ]);

        $response = $this->actingAs($user)->from('/thong-tin-ung-vien/qa-candidate')->post(
            route('send_job_employer'),
            [
                'job_ids' => [$job->job_id],
                'employee_id' => $employeeId,
            ]
        );

        $response->assertRedirect('/thong-tin-ung-vien/qa-candidate');
        $response->assertSessionHas('error', 'Tin tuyển dụng không thuộc tài khoản, chưa được hiển thị hoặc đã hết hạn');
    }

    public function test_candidate_can_open_received_invitation_list(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $employerUser = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $employer = Employer::where('user_id', $employerUser->id)->firstOrFail();
        $employeeId = Employee::where('user_id', $candidate->id)->value('employee_id');
        $job = Job::whereNotNull('career_category_id')->firstOrFail();

        $job->update([
            'employer_id' => $employer->employer_id,
            'active_job' => 1,
            'deadline_submit_profile' => now()->addWeek()->toDateString(),
        ]);
        Invite::firstOrCreate([
            'employer_id' => $employer->employer_id,
            'employee_id' => $employeeId,
            'job_id' => $job->job_id,
        ], [
            'status' => 0,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($candidate)->get(route('job_invited_manage'));

        $response->assertOk();
        $response->assertSee('Lời mời ứng tuyển');
        $response->assertSee($job->title);
    }
}
