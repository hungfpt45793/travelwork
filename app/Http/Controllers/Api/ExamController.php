<?php

namespace App\Http\Controllers\Api;

use App\Exam\DetailResultExam;
use App\Exam\Exam;
use App\Exam\Questions;
use App\Exam\ResultExam;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\Upload_FileController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExamController extends Controller
{
    public function list_exam(Request $request)
    {
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'exam.code_exam',
//            'exam.slug_exam',
            'exam.name_exam',
            'exam.intro_exam',
//            'exam.id_cate_exam',
            'exam.time_exam',
            'exam.view_exam',
            'exam.status_exam',
            'exam.exam_type_id',
            'type_of_business.type_of_business_name',
            'exam.exam_local_job_id',
            'career_categories.career_category_name',
            'exam.created_at'
//            'created_at'
        )
//        $exams = $exams->select('exam.*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'exam.exam_type_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'exam.exam_local_job_id')
            ->where('exam.bank_exam', '=', 1);

        if (!empty($request->input('type_of_business_id'))) {
            $exams = $exams->where('exam.exam_type_id', $request->input('type_of_business_id'));
        }
        if (!empty($request->input('career_category_id'))) {
            $exams = $exams->where('exam.exam_local_job_id', $request->input('career_category_id'));
        }
        $exams = $exams->distinct('exam.id_exam');
//        $total = 0;
//        $total = $exams->count('exam.id_exam');
//        $exams = $exams->groupBy(
//            'exam.id_exam',
//            'code_exam',
//            'slug_exam',
//            'name_exam',
//            'intro_exam',
//            'id_cate_exam',
//            'time_exam',
//            'view_exam',
//            'exam_type_id',
//            'exam_local_job_id',
//            'created_at'
//        );

        $exams = $exams->orderBy('exam.id_exam','desc');
        $exams = $exams->paginate(20);
        $exams->appends(request()->query());

        foreach ($exams as $id => $ex) {
//             $total_q = \App\Exam\Questions::countQuestion($ex['id_exam']);
            $total_q = Questions::countQuestion($ex['id_exam']);
//            $check_exam = !empty($ex->status_exam) ? 'check_exam' : 'exam';
            $message_exam = !empty($ex->status_exam) ? 'Đề thi thử' : 'Đề thi';
            $exams[$id]['total_question'] = $total_q;
//            $exams[$id]['check_exam'] = $check_exam;
            $exams[$id]['message_exam'] = $message_exam;
        }
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đề thi',
            'list_exams' => $exams
        ], 200);


    }
    public function search_exam(Request $request)
    {
        $word =
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'exam.code_exam',
//            'exam.slug_exam',
            'exam.name_exam',
            'exam.intro_exam',
//            'exam.id_cate_exam',
            'exam.time_exam',
            'exam.view_exam',
            'exam.status_exam',
            'exam.exam_type_id',
            'type_of_business.type_of_business_name',
            'exam.exam_local_job_id',
            'career_categories.career_category_name',
            'exam.created_at'
//            'created_at'
        )
//        $exams = $exams->select('exam.*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'exam.exam_type_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'exam.exam_local_job_id')
            ->where('exam.bank_exam', '=', 1);

        if (!empty($request->input('type_of_business_id'))) {
            $exams = $exams->where('exam.exam_type_id', $request->input('type_of_business_id'));
        }
        if (!empty($request->input('career_category_id'))) {
            $exams = $exams->where('exam.exam_local_job_id', $request->input('career_category_id'));
        }
        $word = $request->input('word');
        if(!empty($word))
        {
            $exams = $exams->where('exam.name_exam','like','%'.$word.'%');
        }

        $exams = $exams->distinct('exam.id_exam');
//        $total = 0;
//        $total = $exams->count('exam.id_exam');
//        $exams = $exams->groupBy(
//            'exam.id_exam',
//            'code_exam',
//            'slug_exam',
//            'name_exam',
//            'intro_exam',
//            'id_cate_exam',
//            'time_exam',
//            'view_exam',
//            'exam_type_id',
//            'exam_local_job_id',
//            'created_at'
//        );
        $exams = $exams->orderBy('exam.id_exam','desc');
        $exams = $exams->paginate(20);
        $exams->appends(request()->query());

        foreach ($exams as $id => $ex) {
//             $total_q = \App\Exam\Questions::countQuestion($ex['id_exam']);
            $total_q = Questions::countQuestion($ex['id_exam']);
//            $check_exam = !empty($ex->status_exam) ? 'check_exam' : 'exam';
            $message_exam = !empty($ex->status_exam) ? 'Đề thi thử' : 'Đề thi';
            $exams[$id]['total_question'] = $total_q;
//            $exams[$id]['check_exam'] = $check_exam;
            $exams[$id]['message_exam'] = $message_exam;
        }
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đề thi',
            'word' => $word,
            'list_exams' => $exams
        ], 200);


    }

    public function detail_exam($id_exam, Request $request)
    {
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'exam.code_exam',
//            'exam.slug_exam',
            'exam.name_exam',
            'exam.intro_exam',
//            'exam.id_cate_exam',
            'exam.time_exam',
            'exam.view_exam',
            'exam.status_exam',
            'exam.exam_type_id',
            'type_of_business.type_of_business_name',
            'exam.exam_local_job_id',
            'exam.content_exam',
            'career_categories.career_category_name',
            'exam.created_at'
//            'created_at'
        )
//        $exams = $exams->select('exam.*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'exam.exam_type_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'exam.exam_local_job_id')
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.id_exam', '=', $id_exam);
//
        if (!empty($request->input('type_of_business_id'))) {
            $exams = $exams->where('exam.exam_type_id', $request->input('type_of_business_id'));
        }
        if (!empty($request->input('career_category_id'))) {
            $exams = $exams->where('exam.exam_local_job_id', $request->input('career_category_id'));
        }
        $exams = $exams->first();

        //cong them luot xem
        $update_exam = Exam::where('exam.id_exam', '=', $id_exam)->update([
            'view_exam' => $exams->view_exam + 1
        ]);

        if (empty($exams)) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy đề thi này!'
            ], 400);
        }
        $total_q = Questions::countQuestion($exams['id_exam']);
//        $check_exam = !empty($exams->status_exam) ? 'check_exam' : 'exam';
        $message_exam = !empty($exams->status_exam) ? 'Đề thi thử' : 'Đề thi';
        $exams['total_question'] = $total_q;
//        $exams['check_exam'] = $check_exam;
        $exams['message_exam'] = $message_exam;
        if (empty($exams->status_exam)) {
            try {
                $user = JWTAuth::toUser($request->token);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng đăng nhập để làm đè thi này'
                ], 400);
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Chi tiết đề thi',
            'exam' => $exams
        ], 200);
    }

    public function list_question_exam($id_exam, Request $request)
    {
        $exams = new Exam();
        $exams = $exams->select(
            'exam.id_exam',
            'exam.code_exam',
//            'exam.slug_exam',
            'exam.name_exam',
            'exam.intro_exam',
//            'exam.id_cate_exam',
            'exam.time_exam',
            'exam.view_exam',
            'exam.status_exam',
            'exam.exam_type_id',
            'type_of_business.type_of_business_name',
            'exam.exam_local_job_id',
            'exam.content_exam',
            'career_categories.career_category_name',
            'exam.created_at'
//            'created_at'
        )
//        $exams = $exams->select('exam.*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
            ->leftJoin('type_of_business', 'type_of_business.type_of_business_id', '=', 'exam.exam_type_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'exam.exam_local_job_id')
            ->where('exam.bank_exam', '=', 1)
            ->where('exam.id_exam', '=', $id_exam);
//
        if (!empty($request->input('type_of_business_id'))) {
            $exams = $exams->where('exam.exam_type_id', $request->input('type_of_business_id'));
        }
        if (!empty($request->input('career_category_id'))) {
            $exams = $exams->where('exam.exam_local_job_id', $request->input('career_category_id'));
        }
        $exams = $exams->first();
        if (empty($exams)) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy đề thi này!'
            ], 400);
        }
//
        if (empty($exams->status_exam)) {
            try {
                $user = JWTAuth::toUser($request->token);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng đăng nhập để làm đè thi này'
                ], 400);
            }
        }

        $total_q = Questions::countQuestion($exams['id_exam']);
//        $check_exam = !empty($exams->status_exam) ? 'check_exam' : 'exam';
        $message_exam = !empty($exams->status_exam) ? 'Đề thi thử' : 'Đề thi';
        $exams['total_question'] = $total_q;
//        $exams['check_exam'] = $check_exam;
        $exams['message_exam'] = $message_exam;

        $list_question = Questions::select(
            'id_ques',
            'name_ques',
            'type_ques',
            'show_answer_ques',
            'type_answer',
            'answer1',
            'answer2',
            'answer3',
            'answer4'
        )->where('id_exam', $id_exam)
            ->orderBy('type_ques', 'asc')
            ->get();
        foreach ($list_question as $id => $question) {
            $message_show_question = 'Chia đều 2 cột';
            if (!empty($question->show_answer_ques)) {
                $message_show_question = ($question->show_answer_ques == 1) ? 'Các đáp án trên 1 dòng' : 'Mỗi đáp án trên 1 dòng';
            }
            $list_question[$id]['message_show_question'] = $message_show_question;
            $message_show_type = 'Trắc nghiệm 4 đáp án';
            if (!empty($question->type_ques)) {
                $message_show_type = ($question->type_ques == 1) ? 'Trắc nghiệm 2 đáp án' : 'Câu hỏi tự luận';
            }
            $list_question[$id]['message_show_type'] = $message_show_type;
//            $hien_thi_cau_hoi = $question->show_answer_ques;
        }
        $exams['list_question'] = $list_question;
        return response()->json([
            'status' => 200,
            'message' => 'Chi tiết đề thi',
            'exam' => $exams
        ], 200);
    }

    public function submit_question_exam(Request $request)
    {
        $id_exam = $request->input('id_exam');
        $exams = new Exam();
        $exams = $exams->select('status_exam')
            ->where('exam.id_exam', '=', $id_exam);
        $exams = $exams->first();
        if (empty($exams)) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy đề thi này!'
            ], 400);
        }
        $id_user = '';
        if (empty($exams->status_exam)) {
            try {
                $user = JWTAuth::toUser($request->token);
                $id_user = $user->id;
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng đăng nhập để làm đề thi này'
                ], 400);
            }
        }
        $question = new Questions();
        $detail_result = new DetailResultExam();
        $results = new ResultExam();
        $result_id = $results->insertGetId([
            'id_exam' => $id_exam,
            'id_user' => $id_user,
            'date_result' => new \DateTime(),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        $list_question = Questions::where('id_exam', $id_exam)->get();
        $correct_answer = $request->input('answer');
        $correct_answer0 = 0;
        $correct_answer1 = 0;
        $correct_answer2 = 0;
        foreach ($correct_answer as $id_ques => $correct) {
            $detal_result = $detail_result->insert([
                'id_result' => $result_id,
                'id_ques' => $id_ques,
                'user_correct_ques' => $correct,
                'updated_at' => new \DateTime(),
            ]);
            if (!empty($correct)) {
                $question = Questions::where('id_ques', $id_ques)
                    ->first();
                if ($question->type_ques == 0) {
                    $correct_answer0 += $correct_answer0 + ($question->correct_answer == $correct) ? 1 : 0;
                    continue;
                }
                if ($question->type_ques == 1) {
                    $correct_answer1 += $correct_answer1 + ($question->correct_answer == $correct) ? 1 : 0;
                    continue;
                }
                if ($question->type_ques == 2) {
                    $correct_answer2 = $correct_answer2 + 1;
                    continue;
                }
            }
        }
        $update_result = $results->where('id_result', $result_id)->update([
            'correct_question_1' => $correct_answer0,
            'correct_question_2' => $correct_answer1,
            'correct_question_3' => $correct_answer2,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Nộp bài thi trắc nghiệm thành công',
            'id_result' => $result_id
        ], 200);

    }

    //xem ket qua thi result_id
    public function list_correct_answer_question($result_id)
    {
        $results = new ResultExam();
        $result = $results->where('id_result', $result_id)->first();

        $exam = new Exam();
        $exam = $exam->select('exam.id_exam',
            'exam.code_exam',
//            'exam.slug_exam',
            'exam.name_exam',
            'exam.intro_exam',
//            'exam.id_cate_exam',
            'exam.time_exam',
            'exam.view_exam',
            'exam.status_exam',
            'exam.exam_type_id',
            'exam.exam_local_job_id',
            'exam.content_exam',
            'exam.created_at')
            ->where('exam.id_exam', $result->id_exam)
            ->first();
        $list_question = Questions::select(
            'id_ques',
            'name_ques',
            'type_ques', //kiểu câu hỏi 0-trắc nghiêm , 1 -đúng sai 2-tự luận
            'show_answer_ques', //	hiển thị đáp án 0 là chia đều 2 cột , 1 các đáp án trên 1 dòng , 2 mỗi đáp án trên 1 dòng	null là câu hỏi tự luận
            'id_exam',
            'type_answer', //	kiểu đáp án
            'answer1',
            'answer2',
            'answer3',
            'answer4',
            'correct_answer', //	đáp án đúng
            'explain_answer', //giải đáp án đúng
            'created_at'
        )->where('id_exam', $result->id_exam)->orderBy('type_ques', 'asc');
        $total_question = $list_question->count();
        $list_question = $list_question->get();

        $total_result = DetailResultExam::where('id_result', $result_id)->count();

        $result['tong-so-cau'] = $total_question;
        $result['so-cau-dung'] = $result->correct_question_1 + $result->correct_question_2;
        $result['so-cau-sai'] = $total_result - ($result->correct_question_1 + $result->correct_question_2 + $result->correct_question_3);
        $result['so-cau-tu-luan'] = $result->correct_question_3;
        $result['so-cau-chua-lam'] = $total_question - $total_result;

        foreach ($list_question as $id => $question) {

            $message_show_question = 'Chia đều 2 cột';
            if (!empty($question->show_answer_ques)) {
                $message_show_question = ($question->show_answer_ques == 1) ? 'Các đáp án trên 1 dòng' : 'Mỗi đáp án trên 1 dòng';
            }
            $list_question[$id]['message_show_question'] = $message_show_question;
            $message_show_type = 'Trắc nghiệm 4 đáp án';
            if (!empty($question->type_ques)) {
                $message_show_type = ($question->type_ques == 1) ? 'Trắc nghiệm 2 đáp án' : 'Câu hỏi tự luận';
            }
            $list_question[$id]['message_show_type'] = $message_show_type;
            $user_correct = DetailResultExam::where('id_result', $result_id)->where('id_ques', $question->id_ques)->value('user_correct_ques');
            $list_question[$id]['user_corect'] = $user_correct;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Kết quả bài thi',
            'result' => $result,
            'list_question' => $list_question
        ], 200);

    }


    public function create_employer(Request $request)
    {
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateEmployer($request);

        if ($validation->fails()) {
            return response()->json([
                'status' => 404,
                'descript' => 'Dữ liệu không hợp lệ',
                'validation' => $validation->errors(),
            ], 404);
        }
        try {
            DB::beginTransaction();
            // Tạo dữ liệu cho bảng user với role = 2 để đăng nhập nhà tuyển dụng
            $userWithPhone = $this->createUser($request);
            // Lưu thông tin nhà tuyển dụng vào bảng employer.
            $createEmployer = $this->createNewEmployer($request, $userWithPhone);
            // Đẩy thông tin lên getfly
//            $this->addNewCampaignGetfly($request);
            if ($createEmployer) {
                $email = $userWithPhone->email;
                // gui email thong bao
                MailConfigController::send_email_employer_confirm($userWithPhone);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'descript' => 'Bạn đã đăng kí tài khoản nhà tuyển dụng thành công',
                ], 200);
            }
            return false;


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'descript' => 'Bạn đã đăng kí tài khoản nhà tuyển dụng thất bại',
            ], 400);
        }
    }


}
