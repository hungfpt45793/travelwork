<?php

namespace Tests\Feature;

use App\Entity\Employee;
use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DesiredJobFlowTest extends TestCase
{
    use DatabaseTransactions;

    public function test_candidate_can_save_desired_job_filters_and_see_success_message(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $employee = Employee::where('user_id', $candidate->id)->firstOrFail();

        $response = $this->actingAs($candidate)->post(route('check_job_desired'), [
            'province' => 0,
            'district' => [],
            'salary_id' => [],
            'career_category_id' => [],
        ]);

        $response->assertRedirect(route('job_desired_employee'));
        $response->assertSessionHas(
            'success_job_desired',
            'Đã lưu thông tin việc làm mong muốn'
        );
        $this->assertDatabaseHas('job_desired', [
            'employee_id' => $employee->employee_id,
            'province_id' => 0,
            'district_id' => '',
            'salary_id' => '',
            'career_category_id' => '',
        ]);

        $page = $this->get(route('job_desired_employee'));

        $page->assertOk();
        $page->assertSee('id="job_desired_success_message"', false);
        $page->assertSeeText('Đã lưu thông tin việc làm mong muốn');
    }
}
