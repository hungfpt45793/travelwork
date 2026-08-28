<?php

namespace Tests\Feature;

use App\Entity\Category;
use App\Entity\User;
use App\Exam\Exam;
use App\Exam\Questions;
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

    public function test_regular_exam_card_links_directly_to_question_route(): void
    {
        $exam = Exam::create([
            'code_exam' => 'QA-DIRECT-REGULAR',
            'name_exam' => 'Đề thi chính kiểm thử route làm bài',
            'slug_exam' => 'qa-direct-regular-exam',
            'intro_exam' => 'Kiểm thử liên kết làm bài trực tiếp',
            'time_exam' => 5,
            'status_exam' => 0,
            'bank_exam' => 1,
        ]);

        $response = $this->get(route('getAllExam'));

        $response->assertOk();
        $response->assertSee(route('getQuestion', [
            'slug_exam' => $exam->slug_exam,
        ]), false);
        $response->assertDontSee(route('getExam', [
            'slug_exam' => $exam->slug_exam,
        ]), false);
    }

    public function test_test_exam_card_links_directly_to_test_question_route(): void
    {
        $exam = Exam::create([
            'code_exam' => 'QA-DIRECT-TEST',
            'name_exam' => 'Đề thi thử kiểm thử route làm bài',
            'slug_exam' => 'qa-direct-test-exam',
            'intro_exam' => 'Kiểm thử liên kết thi thử trực tiếp',
            'time_exam' => 5,
            'status_exam' => 1,
            'bank_exam' => 1,
        ]);

        $response = $this->get(route('getTestAllExam'));

        $response->assertOk();
        $response->assertSee(route('getTestQuestion', [
            'slug_exam' => $exam->slug_exam,
        ]), false);
        $response->assertDontSee(route('getTestExam', [
            'slug_exam' => $exam->slug_exam,
        ]), false);
    }

    public function test_private_regular_exam_displays_a_message_instead_of_throwing_an_exception(): void
    {
        $candidate = User::where('email', 'qa.employee@travelwork.test')->firstOrFail();
        $exam = Exam::create([
            'code_exam' => 'QA-PRIVATE-REGULAR',
            'name_exam' => 'Đề thi riêng tư kiểm thử',
            'slug_exam' => 'qa-private-regular-exam',
            'status_exam' => 0,
            'bank_exam' => 0,
        ]);

        $response = $this->actingAs($candidate)->get(route('getQuestion', [
            'slug_exam' => $exam->slug_exam,
        ]));

        $response->assertRedirect(route('getAllExam'));
        $response->assertSessionHas(
            'errorExam',
            'Đề thi không tồn tại hoặc chưa được công khai'
        );
    }

    public function test_missing_test_exam_displays_a_message_instead_of_throwing_an_exception(): void
    {
        $response = $this->get(route('getTestQuestion', [
            'slug_exam' => 'qa-missing-test-exam',
        ]));

        $response->assertRedirect(route('getTestAllExam'));
        $response->assertSessionHas(
            'errorExam',
            'Đề thi không tồn tại hoặc chưa được công khai'
        );
    }

    public function test_employer_can_open_all_question_lists_with_existing_questions(): void
    {
        $employer = User::where('email', 'qa.employer@travelwork.test')->firstOrFail();
        $exam = Exam::create([
            'name_exam' => 'Đề thi kiểm thử danh sách câu hỏi',
            'id_user' => $employer->id,
            'bank_exam' => 0,
        ]);

        $questions = [];
        foreach ([0, 1, 2] as $type) {
            $questions[$type] = Questions::create([
                'name_ques' => 'Câu hỏi kiểm thử loại '.$type,
                'type_ques' => $type,
                'show_answer_ques' => $type === 2 ? null : 0,
                'id_exam' => $exam->id_exam,
                'answer1' => $type === 2 ? null : 'Đáp án A',
                'answer2' => $type === 2 ? null : 'Đáp án B',
                'correct_answer' => $type === 2 ? null : 'answer1',
            ]);
        }

        $routes = [
            'getAllQuestionsZero',
            'getAllQuestionsOne',
            'getAllQuestionsTwo',
        ];

        foreach ($routes as $type => $routeName) {
            $response = $this->actingAs($employer)->get(route($routeName, [
                'id_exam' => $exam->id_exam,
            ]));

            $response->assertOk();
            $response->assertSee(route('site_question.destroy', [
                'site_question' => $questions[$type]->id_ques,
            ]), false);
        }
    }
}
