<?php

namespace App\Http\Controllers\Site\Exam;


use App\Entity\MailConfig;
use App\Entity\Teacher_schools;
use App\Exam\Detail_result_school;
use App\Exam\Exam_school;
use App\Exam\Exam_school_question_school;
use App\Exam\Questions_school;
use App\Exam\Result_school;
use App\Exam\ResultRoomExam;
use App\Exam\Room_school;
use App\Exam\RoomExam;
use App\Exam\Student_school;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomViewSchoolController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTopsite', 'exam');
            return $next($request);
        });
    }

    public function detail_room(Request $request, $id_room)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($request->session()->has('id_room')) {
            $request->session()->forget('id_room');
        }
        if ($request->session()->has('student_id')) {
            $request->session()->forget('student_id');
        }
        $room = Room_school::where('id_room', $id_room)->first();
//        echo '<pre>';
//        print_r($room);die;
        $teacher_school = Teacher_schools::where('teacher_sc_id', $room->teacher_sc_id)->first();
        if (Auth::check() && !empty($teacher_school)) {
            return redirect()->back()->with('errorRoom', 'Giáo viên không được vào phòng thi');
        } else {
            return view('site.exam_site_room_school.detail_room', compact('room', 'teacher_school'));
        }
        return view('site.exam_site_room_school.detail_room', compact('room', 'teacher_school'));

    }


    // nhap mat khau de vao phong thi
    public function createStudentRoom(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'student_code' => 'required',
            'student_name' => 'required',
            'student_email' => 'required|email',
            'student_phone' => 'required',
            'password_room' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'student_code.required' => 'Mã sinh viên không được để trống',
            'student_name.required' => 'Tên sinh viên không được để trống',
            'student_email.required' => 'Email sinh viên không được để trống',
            'student_phone.email' => 'Vui lòng nhập đúng định dạng email',
            'password_room.required' => 'Mật khẩu không được để trống.',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Không thể vào phòng thi !')
                ->withInput();
        }
        try {
            $id_room = $request->input('id_room');
            $password_room = $request->input('password_room');
            $room_school = Room_school::where('id_room', $id_room)->first();

            $check_student = Student_school::where('student_code', $request->input('student_code'));
            $check_student = $check_student->where('id_room', $id_room);
            $check_student = $check_student->whereDate('date_ip', '=', date('Y-m-d'));
            $check_student = $check_student->first();

            if (!empty($check_student)) {
                return redirect()->back()->with('errorRoomschool', 'Bạn đã hoàn thành bài bài thi của minh rồi ! nếu muốn làm lại vui lòng liên hệ với giáo viên ra đề !');
            }
            $student_id = Student_school::insertGetId([
                'student_code' => $request->input('student_code'),
                'student_name' => $request->input('student_name'),
                'id_room' => $id_room,
                'student_email' => $request->input('student_email'),
                'student_phone' => $request->input('student_phone'),
                'class_primakey' => $request->input('class_primakey'),
                'class_section' => $request->input('class_section'),
                'student_pass' => $password_room,
                'created_at' => new \DateTime(),
                'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                'date_ip' => new \DateTime(),
            ]);
            $rooms = new Room_school();
            $room = $rooms->select('*')->where('id_room', $id_room)->where('password_room', $password_room)->first();
            if (empty($room)) {
                return redirect()->back()->with('errorRoomschool', 'Mật khẩu vào phòng thi không đúng ! Vui lòng thử lại');
            }
            if (!empty($room) && $student_id > 0) {

                $request->session()->put('id_room', $id_room);
                $request->session()->put('student_id', $student_id);
                return redirect(route('createResultSchool', ['id_room' => $room->id_room]));
            } else {
                return redirect(route('createResultSchool', ['id_room' => $room->id_room]));
            }
            return redirect(route('createResultSchool', ['id_room' => $room->id_room]));
        } catch (\Exception $e) {
            return redirect()->back()->with('errorRoomschool', 'Lỗi phòng thi !');
        }
    }

    public function updateStudent(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'student_name' => 'required',
            'student_email' => 'required|email',
            'student_phone' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'student_name.required' => 'Tên sinh viên không được để trống',
            'student_email.required' => 'Email sinh viên không được để trống',
            'student_phone.email' => 'Vui lòng nhập đúng định dạng email',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Không thể vào phòng thi !')
                ->withInput();
        }
        try {
            $student_code = $request->input('student_code');
            $student_id = Student_school::where('student_code', $student_code)
                ->where('id_room', $request->input('id_room'))
                ->whereDate('date_ip', '=', date('Y-m-d'))
                ->update([
                    'student_name' => $request->input('student_name'),
                    'student_email' => $request->input('student_email'),
                    'student_phone' => $request->input('student_phone'),
                    'class_primakey' => $request->input('class_primakey'),
                    'class_section' => $request->input('class_section'),
                    'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                    'date_ip' => new \DateTime(),
                ]);
            return redirect()->back()->with('succes', 'Sửa thông tin sinh viên thành công !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sửa thông tin sinh viên thất bại !');
        }
    }

//tao ket qua de luu de thi cho user phong thi
    public function createResultSchool(Request $request, $id_room)
    {
//        try
//        {
        $value_id_room = $request->session()->get('id_room');
        $value_student_id = $request->session()->get('student_id');

        if ($request->session()->has('id_room') && $value_id_room == $id_room) {
            $rooms = new Room_school();
            $room = $rooms->select('*')->where('id_room', $id_room)->first();
//                $list_exam = Exam_school::select('id_exam','id_class_school')
//                    ->where('id_class_school',$value_id_room);
//
//                $total_exam = $list_exam->count();
//                $list_exam = $list_exam->inRandomOrder()->get();
//                $array_exam = array();
//                foreach($list_exam as $exam)
//                {
//                    $array_exam[] = $exam->id_exam;
//                }
//                $k = array_rand($array_exam);
//
//
//
//
//                $result_school_id = Result_school::insertGetId([
//                    'id_room'=> $value_id_room,
//                    'id_exam' => $array_exam[$k],
//                    'id_student' => $value_student_id,
//                    'date_result' => new \DateTime(),
//                    'created_at' => new \DateTime(),
//                ]);

            $total_result = Result_school::where('id_room', $value_id_room)->count();
            $limit = 0;
            $list_exam = Exam_school::select('id_exam', 'id_class_school')
                ->where('id_class_school', $value_id_room);
            $total_exam = $list_exam->count();

            if ($total_result == 0 or $total_result == $total_exam) {
                $exam = Exam_school::select('id_exam', 'id_class_school')
                    ->where('id_class_school', $value_id_room)->offset(0)
                    ->limit(1)
                    ->first();
                $result_school_id = Result_school::insertGetId([
                    'id_room' => $value_id_room,
                    'id_exam' => $exam['id_exam'],
                    'id_student' => $value_student_id,
                    'date_result' => new \DateTime(),
                    'created_at' => new \DateTime(),
                ]);
                return redirect(route('getSchoolExamRoom', ['id_room' => $id_room]));
            }
            if ($total_result > 0 && $total_result < $total_exam) {
                $limit = $total_result;
                $exam = Exam_school::select('id_exam', 'id_class_school')
                    ->where('id_class_school', $value_id_room)->offset($limit)
                    ->limit(1)
                    ->first();
                $result_school_id = Result_school::insertGetId([
                    'id_room' => $value_id_room,
                    'id_exam' => $exam['id_exam'],
                    'id_student' => $value_student_id,
                    'date_result' => new \DateTime(),
                    'created_at' => new \DateTime(),
                ]);
                return redirect(route('getSchoolExamRoom', ['id_room' => $id_room]));
            }
            if ($total_result > $total_exam) {
                $limit = ($total_result % $total_exam);
//                    echo $limit;die();
                $exam = Exam_school::select('id_exam', 'id_class_school')
                    ->where('id_class_school', $value_id_room)->offset($limit)
                    ->limit(1)
                    ->first();
                $result_school_id = Result_school::insertGetId([
                    'id_room' => $value_id_room,
                    'id_exam' => $exam['id_exam'],
                    'id_student' => $value_student_id,
                    'date_result' => new \DateTime(),
                    'created_at' => new \DateTime(),
                ]);
                return redirect(route('getSchoolExamRoom', ['id_room' => $id_room]));
            }
            return redirect(route('getSchoolExamRoom', ['id_room' => $id_room]));
        } else {
            return redirect()->back()->with('errorRoom', 'Phòng thi đã kết thúc');
        }
//        }catch (\Exception $e)
//        {
//            return redirect()->back()->with('errorRoom', 'Phòng thi này chưa tạo đề thi');
//        }

//
    }

    public function getSchoolExamRoom(Request $request, $id_room)
    {
        try {

            $value_id_room = $request->session()->get('id_room');
            $value_student_id = $request->session()->get('student_id');

            $result_school = Result_school::where('id_room', $value_id_room)->where('id_student', $value_student_id)->first();
            $check_result_school = Detail_result_school::where('id_result', $result_school->id_result)->count();
            if ($check_result_school > 0) {
                return redirect()->back()->with('errorRoomschool', 'Bạn đã hoàn thành bài bài thi của minh rồi ! nếu muốn làm lại vui lòng liên hệ với giáo viên ra đề !');
            }
            $room = Room_school::select('*')->where('id_room', $id_room)->first();
            $result = Result_school::where('id_room', $value_id_room)->where('id_student', $value_student_id)->first();
            $exam = Exam_school::where('id_exam', $result->id_exam)->first();

            $student_school = Student_school::select('*')->where('student_id', $value_student_id)->first();

            return view('site.exam_site_room_school.exam_room', compact('exam', 'room', 'student_school'));
        } catch (\Exception $e) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }
    }

    //hien thi cau hoi cua phong thi
    public function getSchoolQuestionRoom(Request $request, $id_room)
    {
//        try {
//        echo 1;die();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $value_id_room = $request->session()->get('id_room');
        $value_student_id = $request->session()->get('student_id');
        if ($request->session()->has('id_room') && $request->session()->has('student_id')) {
            //
            $room = Room_school::select('*')->where('id_room', $value_id_room)->first();
            $result = Result_school::where('id_room', $value_id_room)->where('id_student', $value_student_id)->first();
            $exam = Exam_school::where('id_exam', $result->id_exam)->first();

            $question = new Questions_school();
            $question = $question->select('*')->leftJoin('exam_school_question_school', 'exam_school_question_school.id_ques', '=', 'questions_school.id_ques')
                ->where('exam_school_question_school.id_exam', '=', $result->id_exam)
                ->orderBy('exam_school_question_school.exam_ques_id', 'asc')
                ->orderBy('questions_school.id_ques', 'asc');
            $countQuestion = $question->count();
            $questions = $question->get();

            $result_school = Result_school::where('id_room', $value_id_room)->where('id_student', $value_student_id)->first();

            $update_star_time_submit = Result_school::where('id_room', $value_id_room)->where('id_student', $value_student_id)->update([
                'star_time_submit' => new \DateTime(),
            ]);
            $check_result_school = Detail_result_school::where('id_result', $result_school->id_result)->first();

            if (!empty($check_result_school)) {
                return redirect()->back()->with('errorRoomschool', 'Bạn đã hoàn thành bài bài thi của minh rồi ! nếu muốn làm lại vui lòng liên hệ với giáo viên ra đề !');
            }
            return view('site.exam_site_room_school.show_question_room_school', compact('room', 'exam', 'categories_exams', 'questions', 'countQuestion', 'result', 'value_student_id'));
        } else {
            $url = redirect()->back()->getTargetUrl();
            return redirect($url)->with('errorExam', 'Bạn đã thi đề thi này rồi');
        }

//        } catch (\Exception $e) {
//            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
//        }

    }

    public function createSchoolResultDetailRoom(Request $request)
    {

//        try {

        $id_result = $request->input('id_result');

        $correct_answer = $request->input('answer');
        $result_school = Result_school::where('id_result', $id_result)->first();
        $detail_result_room = new Detail_result_school();

        $list_exam_question = Exam_school_question_school::select('*')->where('id_exam',$result_school->id_exam)->get();

//        DB::beginTransaction();
//        echo '<pre>';
//            print_r($correct_answer);
//            die();
//        DB::rollback();
        $update_star_time_submit = Result_school::where('id_result', $id_result)->update([
            'end_time_submit' => new \DateTime(),
        ]);
        $total_true = 0;
        foreach ($correct_answer as $id_ques => $correct) {
            $insert_detail_result_room = $detail_result_room->insert([
                'id_result' => $id_result,
                'id_ques' => $id_ques,
                'user_correct_ques' => $correct,
                'updated_at' => new \DateTime(),
            ]);
            $question_school = \App\Exam\Questions_school::getIdQuestion($id_ques ,3);
            if(!empty($question_school['correct_answer']) && $question_school['correct_answer'] == $correct)
            {
                $total_true = $total_true + 1;
            }
        }
        $result_true = Result_school::where('id_result', $id_result)->update(['correct_question' => $total_true]);
        $request->session()->forget('id_room');
        $request->session()->forget('student_id');
//        $request->session()->flush();

        return redirect(route('showSchoolResultRoom', ['id_result' => $id_result]));
//        DB::rollback();

    }


    public function showSchoolResultRoom(Request $request, $result_id)
    {
//        echo $result_id;die();
        try {
            $result = Result_school::where('id_result', $result_id)->first();
            if ($request->session()->has('id_room')) {
                $request->session()->forget('id_room');
            }
            if ($request->session()->has('student_id')) {
                $request->session()->forget('student_id');
            }
            $id_exam = $result->id_exam;
            $total_true = $result->correct_question;
            $total_question = Exam_school_question_school::join('questions_school', 'questions_school.id_ques', '=', 'exam_school_question_school.id_ques')
                ->where('exam_school_question_school.id_exam', $id_exam)
                ->where('questions_school.type_ques', '<', 3)
                ->count();
            $total_choice = Exam_school_question_school::join('questions_school', 'questions_school.id_ques', '=', 'exam_school_question_school.id_ques')
                ->where('exam_school_question_school.id_exam', $id_exam)
                ->where('questions_school.type_ques', '=', 3)
                ->count();
            $exam = Exam_school::select('*')->where('id_exam', $id_exam)->first();
//             $room_school = Room_school::select('teacher_sc_id','name_room','day_room')->where('id_room',$result->id_room)->first();
//             $teacher_school = Teacher_schools::select('*')->where('teacher_sc_id',$room_school->teacher_sc_id)->first();
//             $subject = 'Kết quả thi trắc nghiệm của sinh viên tại sàn kế toán';
//        $content_string = '<p>'.'Kết quả thi của sinh viên thi tại phòng thi  :'.$room_school->name_room.'</p>';
//        $content_string .= '<p>'.'Kết quả thi của sinh viên có mã sinh viên :'.$student_school->student_code.'</p>';
//        $content_string .= '<p>'.'Kết quả thi của sinh viên có tên sinh viên :'.$student_school->student_name.'</p>';
//        $content_string .= '<p>'.'Kết quả thi phần thi trắc nghiệm :'.$result_true.'/'.$total_question.'(đúng/tổng số câu trắc nghi)'.'</p>';
//        $content_string .= '<p>'.'Chi tiết xem tại sanketoan.vn'.'</p>';
//        $total_choice

            //gửi kết quả của sinh viên cho giáo viên
//            $send_email = MailConfig::sendMail($teacher_school->teacher_sc_email, $subject, $content_string);
//            echo '<pre>';print_r($list_question);die();


            return view('site.exam_site_room_school.hien-thi-ket-qua', compact('exam', 'total_question', 'total_true', 'total_choice', 'result_id'));
        } catch (\Exception $e) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }
    }

    public function showDetailResult($result_id)
    {
        $result = Result_school::where('id_result', $result_id)->first();
        $id_exam = $result->id_exam;
        $total_true = $result->correct_question;
        $total_question = Exam_school_question_school::join('questions_school', 'questions_school.id_ques', '=', 'exam_school_question_school.id_ques')
            ->where('exam_school_question_school.id_exam', $id_exam)
            ->where('questions_school.type_ques', '<', 3)
            ->count();
        $total_choice = Exam_school_question_school::join('questions_school', 'questions_school.id_ques', '=', 'exam_school_question_school.id_ques')
            ->where('exam_school_question_school.id_exam', $id_exam)
            ->where('questions_school.type_ques', '=', 3)
            ->count();
        $exam = Exam_school::select('*')->where('id_exam', $result->id_exam)->first();
        $result_id = $result->result_id;
        $list_question = Questions_school::select(
            'questions_school.id_ques',
            'questions_school.name_ques',
            'questions_school.type_ques',
            'questions_school.status_ques',
            'questions_school.show_answer_ques',
            'questions_school.type_answer',
            'questions_school.answer1',
            'questions_school.answer2',
            'questions_school.answer3',
            'questions_school.answer4',
            'questions_school.correct_answer')
            ->join('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
            ->where('exam_school_question_school.id_exam', $result->id_exam)
            ->get();


//        echo '<pre>';
//        print_r($list_question);die();
        return view('site.exam_site_room_school.hien-thi-chi-tiet-ket-qua', compact('list_question', 'exam', 'total_question', 'total_true', 'total_choice', 'result_id', 'result'));
//        return view('site.exam_site_room_school.hien-thi-chi-tiet-ket-qua2', compact('list_question', 'exam', 'total_question', 'total_true', 'total_choice', 'result_id', 'result'));
    }
//    public function showResultRoomEmail(Request $request, $result_id)
//    {
//        try {
//            $id_user = $request->input('user_id');
//            $result_room = new ResultRoomExam();
//            $result_room = $result_room->select('*')
//                ->where('id_result_room', $result_id)
//                ->where('user_exam_room', '=', $id_user)
//                ->first();
//            if ($request->session()->has('id_room')) {
//                $request->session()->forget('id_room');
//            }
//            $day_month_year_date = date('Y/m/d');
//            $room = new RoomExam();
//            $room = $room->select('*')->where('id_room', '=', $result_room->id_room)->first();
//            $exam = new Exam();
//
//            $exam = $exam->select('*')
//                ->join('result_room_exam', 'result_room_exam.id_exam', '=', 'exam.id_exam')
//                ->where('result_room_exam.id_result_room', $result_id)
//                ->first();
//            $id_exam = $exam->id_exam;
//            $question = new Questions();
//            //câu hỏi trắc nghiệm
//            $question_1 = $question->select('*')
//                ->where('id_exam', '=', $id_exam)
//                ->where('type_ques', '=', 0)
//                ->get();
//            // câu hỏi đúng sai
//            $question_2 = $question->select('*')
//                ->where('id_exam', '=', $id_exam)
//                ->where('type_ques', '=', 1)
//                ->get();
//            //câu hỏi tự luận
//            $question_3 = $question->select('*')
//                ->where('id_exam', '=', $id_exam)
//                ->where('type_ques', '=', 2)
//                ->get();
////            return redirect(route('showResult',['id_result' => $result_id]));
//            return view('site.exam_site_room.show_result_room', compact('room', 'id_exam', 'id_user', 'result_id', 'question_1', 'question_2', 'question_3'));
//        } catch (\Exception $e) {
//            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
//        }
//    }
    public function update_question_showResultRoom(Request $request)
    {
        try {
            $id_result_room = $request->input('id_result_room');
            $question_1 = $request->input('question_1');
            $question_2 = $request->input('question_2');
            $question_3 = $request->input('question_3');

            $result_room = new ResultRoomExam();
            $result_room = $result_room->where('id_result_room', $id_result_room)->update([
                'correct_question_1' => $question_1,
                'correct_question_2' => $question_2,
                'correct_question_3' => $question_3,
            ]);
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response([
                'status' => 500,
            ])->header('Content-Type', 'text/plain');
        }
    }

    public function charEmployer($room_id)
    {
        $room_exam = new RoomExam();
        $room = $room_exam->select('*')->where('id_room', $room_id)->first();

        $result_room_exam = new ResultRoomExam();
        $result_room_exam = $result_room_exam->select('result_room_exam.*', 'exam.id_exam', 'exam.code_exam', 'exam.name_exam', 'employees.employee_id', 'employees.user_id', 'employees.employee_name')
            ->leftJoin('exam', 'exam.id_exam', '=', 'result_room_exam.id_exam')
            ->leftJoin('employees', 'employees.user_id', '=', 'result_room_exam.user_exam_room')
            ->where('result_room_exam.id_room', $room_id)
            ->get();
//        print_r($result_room_exam);die();

        return view('site.exam_site_room.char_employer', compact('room', 'result_room_exam'));
    }

    public function checkTime($id_room)
    {
        $day_month_year_date = date('Y/m/d');

        $day_date = date('H:i');
        $rooms = new Room_school();
        $room = $rooms->select('*')->where('id_room', $id_room)->first();

        $star_date = date_create($room->time_star_room);
        $end_date = date_create($room->time_end_room);
        $day_room = date_create($room->day_room);

        $fomat_star_date = date_format($star_date, "H:i");
        $fomat_end_date = date_format($end_date, "H:i");
        $fomat_day_room = date_format($day_room, "Y/m/d");
        $star_minute = \App\Ultility\ExchangeDate::getMinute($fomat_star_date);
        $end_minute = \App\Ultility\ExchangeDate::getMinute($fomat_end_date);
        $day_time = \App\Ultility\ExchangeDate::getMinute($day_date);
        if ($day_time >= $star_minute && $day_time <= $end_minute && $day_month_year_date = $fomat_day_room) {
            return 1;
        } else {
            return 2;
        }
    }

    private function checkUserRoom($id_room, $id_user)
    {
        $result_room_exam = ResultRoomExam::select('*')->join('detail_result_room', 'detail_result_room.id_result_room', '=', 'result_room_exam.id_result_room')
            ->where('result_room_exam.id_room', $id_room)->where('result_room_exam.user_exam_room', $id_user)->count();
        return $result_room_exam;
    }

    public function ViewShowResultStudent(Request $request, $result_id)
    {
//        echo $result_id;die();
//        try {


        $result = Result_school::where('id_result', $result_id)->first();
        //xoa session
        $id_exam = $result->id_exam;
        $detail_result = Detail_result_school::select('*')->where('id_result', $result_id)->get();
        $question = new Questions_school();
//        câu hỏi trắc nghiệm
        $list_question = $question->select('*')
            ->join('exam_school_question_school', 'exam_school_question_school.id_ques', '=', 'questions_school.id_ques')
            ->where('id_exam', '=', $id_exam);
        $total_question = $list_question->count();
        $list_question = $list_question->get();
        $result_id = $result->id_result;
        $exam = Exam_school::select('*')->join('exam_school_question_school', 'exam_school_question_school.id_exam', '=', 'exam_school.id_exam')
            ->where('exam_school.id_exam', '=', $id_exam)
            ->first();

        $list_question_true = $question->select('*')
            ->join('exam_school_question_school', 'exam_school_question_school.id_ques', '=', 'questions_school.id_ques')
            ->where('id_exam', '=', $id_exam);
        $list_question_true = $list_question_true->where('questions_school.type_ques', '<', 3);
        $total_choice = $list_question_true->count();
        $list_question_true = $list_question_true->get();
        $total_true = 0;
        foreach ($list_question_true as $question_true) {
            $anser = \App\Exam\Detail_result_school::getAnswer($result_id, $question_true->id_ques);
            if (!empty($anser)) {
                if ($question_true->correct_answer == $anser->user_correct_ques) {
                    $total_true = $total_true + 1;
                }
            }

        }
        $result_true = Result_school::where('id_result', $result_id)->update(['correct_question' => $total_true]);


        $student_school = Student_school::select('*')->where('student_id', $result->id_student)->first();
        $room_school = Room_school::select('teacher_sc_id', 'name_room', 'day_room')->where('id_room', $result->id_room)->first();
        $teacher_school = Teacher_schools::select('*')->where('teacher_sc_id', $room_school->teacher_sc_id)->first();


        return view('site.exam_school.room.chi-tiet-ket-qua-thi-cua-sinh-vien', compact('room', 'id_exam', 'result', 'detail_result', 'list_question', 'result_id', 'exam', 'total_question', 'total_true', 'total_choice', 'room_school', 'student_school'));
//        } catch (\Exception $e) {
//            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
//        }
    }
    public function deleteRoom($id_room)
    {
        $result = Result_school::where('id_room',$id_room)->get();
        //lay ra ket qua can xoa
        foreach($result as $re)
        {
            $exam_question = Exam_school_question_school::select('*')->where('id_exam',$re->id_exam)->get();
            foreach($exam_question as $res)
            {
                $detail = Detail_result_school::select('*')->where('id_result',$re->id_result)->where('id_ques',$res->id_ques);
                $total = $detail->count();
                $detail = $detail->first();
               if(!empty($detail) && $total > 1)
               {
                   $delete = Detail_result_school::where('id_result',$re->id_result)
                       ->where('id_ques',$res->id_ques)
                       ->where('id_detail_result','!=', $detail->id_detail_result)
                       ->delete();
               }
            }
        }
        echo 'thanh cong';


    }
    public function deleteRoomResult($id_result)
    {
        $result = Result_school::where('id_result',$id_result)->first();
        //lay ra ket qua can xoa
        $exam_question = Exam_school_question_school::select('*')->where('id_exam',$result->id_exam)->get();
//        lay ra dnah sach cau hoi thuoc dew thi
//        echo '<pre>';
//        print_r($exam_question);die();
        foreach($exam_question as $res)
        {
            $detail = Detail_result_school::select('*')->where('id_result',$id_result)->where('id_ques',$res->id_ques)->first();


            $delete = Detail_result_school::where('id_result',$id_result)
                ->where('id_ques',$res->id_ques)
                ->where('id_detail_result','!=', $detail->id_detail_result)
                ->delete();
        }

        $lisst_detail = Detail_result_school::select('*')->where('id_result',$result)->get();
                echo 'thanh công';die();


    }

}
