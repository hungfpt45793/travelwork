<?php

namespace Tests\Feature;

use App\Entity\User;
use Tests\TestCase;

class SalaryCoefficientPageTest extends TestCase
{
    public function test_salary_coefficient_page_opens_without_undefined_view_data(): void
    {
        $response = $this->get(route('get_all_coe'));

        $response->assertOk();
        $response->assertSeeText('Bảng phân tích mức lương theo năng lực');
    }

    public function test_candidate_sidebar_contains_salary_coefficient_link(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();

        $response = $this->actingAs($candidate)->get(route('list_employee_follow_employer'));

        $response->assertOk();
        $response->assertSee(route('get_all_coe'), false);
        $response->assertSeeText('Tính hệ số lương');
    }
}
