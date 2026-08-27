<?php

namespace Tests\Feature;

use App\Entity\Category;
use App\Entity\User;
use App\Exam\Exam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmployerExamListTest extends TestCase
{
    use DatabaseTransactions;

    public function test_employer_can_open_empty_personal_exam_list(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();

        $response = $this->actingAs($employer)->get(route('showExam'));

        $response->assertOk();
        $response->assertSee('ĐỀ thi của bạn');
        $response->assertSee('Chưa có đề thi nào');
    }

    public function test_employer_can_open_exam_bank(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();

        $response = $this->actingAs($employer)->get(route('showAllExam'));

        $response->assertOk();
        $response->assertSee('Ngân hàng đề thi');
    }

    public function test_personal_exam_list_handles_nullable_exam_fields(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $exam = Exam::create([
            'code_exam' => null,
            'name_exam' => 'Đề thi kiểm thử dữ liệu null',
            'intro_exam' => null,
            'id_cate_exam' => null,
            'time_exam' => null,
            'status_exam' => null,
            'id_user' => $employer->id,
            'bank_exam' => 0,
        ]);

        $response = $this->actingAs($employer)->get(route('showExam'));

        $response->assertOk();
        $response->assertSee($exam->name_exam);
    }

    public function test_exam_header_uses_safe_links_when_optional_categories_are_missing(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        Category::whereIn('slug', ['cuoc-thi-trac-nghiem', 'huong-dan-trac-nghiem'])->delete();

        $response = $this->actingAs($employer)->get(route('showExam'));

        $response->assertOk();
        $response->assertSee('Cuộc thi trắc nghiệm');
        $response->assertSee('Hướng dẫn trắc nghiệm');
    }

    public function test_public_test_exam_category_page_can_be_opened(): void
    {
        $response = $this->get(route('getTestAllExam'));

        $response->assertOk();
        $response->assertSee('Đề thi thử');
    }

    public function test_public_test_exam_category_uses_safe_links_when_optional_categories_are_missing(): void
    {
        Category::whereIn('slug', ['cuoc-thi-trac-nghiem', 'huong-dan-trac-nghiem'])->delete();

        $response = $this->get(route('getTestAllExam'));

        $response->assertOk();
        $response->assertSee('Cuộc thi');
        $response->assertSee('Hướng dẫn');
    }
}
