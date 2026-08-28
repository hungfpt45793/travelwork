<?php

namespace Tests\Feature;

use App\Entity\Employee;
use App\Entity\User;
use App\Http\Controllers\Site\EmployeeController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployeeCvUploadTest extends TestCase
{
    use DatabaseTransactions;

    public function test_cv_notification_generates_missing_employee_slug_before_building_profile_url(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $employee = Employee::where('user_id', $candidate->id)->firstOrFail();
        $employee->update([
            'employee_slug' => null,
            'province' => '__cv_slug_regression_test__',
        ]);

        $controller = app(EmployeeController::class);
        $controller->note_update_profile($employee->fresh());

        $employee->refresh();
        $expectedSlug = (Str::slug((string) $employee->employee_name) ?: 'ung-vien')
            . '-' . $employee->employee_id;

        $this->assertSame($expectedSlug, $employee->employee_slug);
        $this->assertSame(
            url('/thong-tin-ung-vien/' . $expectedSlug),
            route('detail_employee_show', ['employee_slug' => $employee->employee_slug])
        );
    }
}
