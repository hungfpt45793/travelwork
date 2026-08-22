<?php

namespace App\Http\Controllers\Site\Exam;

use App\Entity\Category;
use App\Entity\Employer;
use App\Entity\Teacher_schools;
use App\Exam\CategoriesExam;
use App\Exam\DetailResultExam;
use App\Exam\DetailResultRoom;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\ResultExam;
use App\Exam\ResultRoomExam;
use App\Exam\Room_school;
use App\Exam\RoomExam;
use App\Exam\Student_school;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class RoomViewExamController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTopsite', 'exam');
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //hien thi phong thi theo ngay
    public function getRomAll(Request $request)
    {
        $day_date = date('Y/m/d');
        $time_day = date('H:i');

        $date_end = date('Y/m/d H:i');
        $rooms = New RoomExam();

        $listroom = $rooms->select('*')->whereDate('day_room', '=', $day_date)
            ->whereTime('time_star_room', '<=', $time_day)
            ->whereTime('time_end_room', '>=', $time_day);
        if (!empty($request->input('name_room'))) {
            $name_room = $request->input('name_room');
            $listroom = $listroom->where('name_room', 'like', '%' . $name_room . '%');
        }
        $listroom = $listroom->orderBy('day_room', 'asc')->paginate(10);
        $total = 0;
        $total = $listroom->count();
        $listroom->appends(request()->query());
        $user = auth()->user();
        if ($request->session()->has('id_room')) {
            $request->session()->forget('id_room');
        }

        $list_teacher_school = Teacher_schools::select('teacher_schools.*')
            ->join('room_school','room_school.teacher_sc_id','=','teacher_schools.teacher_sc_id')
            ->whereDate('room_school.day_room', '=', $day_date)
            ->whereTime('room_school.time_star_room', '<=', $time_day)
            ->whereTime('room_school.time_end_room', '>=', $time_day)
            ->orderBy('room_school.day_room', 'desc')
            ->distinct()
             ->paginate(10);
//        echo '<pre>';
//        print_R($list_teacher_school);die();


        return view('site.exam_site_room.show_room', compact('listroom', 'user', 'total','list_teacher_school'));
    }
    public function getRomAllTeacher(Request $request,$teacher_sc_id)
    {
        $day_date = date('Y/m/d');
        $time_day = date('H:i');

        $date_end = date('Y/m/d H:i');
        $rooms = New RoomExam();

        $teacher = Teacher_schools::select('teacher_schools.*')->where('teacher_schools.teacher_sc_id',$teacher_sc_id)->first();

        $list_teacher_school = Teacher_schools::select('teacher_schools.*','room_school.*')
            ->leftJoin('room_school','room_school.teacher_sc_id','=','teacher_schools.teacher_sc_id')
            ->whereDate('room_school.day_room', '=', $day_date)
            ->whereTime('room_school.time_star_room', '<=', $time_day)
            ->whereTime('room_school.time_end_room', '>=', $time_day)
            ->where('teacher_schools.teacher_sc_id',$teacher_sc_id)
            ->orderBy('room_school.day_room', 'desc')
             ->paginate(10);
//        echo '<pre>';
//        print_R($list_teacher_school);die();


        return view('site.exam_site_room.show_room_teacher', compact('list_teacher_school','teacher'));
    }

    // nhap mat khau de vao phong thi
    public function submitRoomPassword(Request $request)
    {
//        try {
        $id_user = Auth::user()->id;
        $password_room = $request->input('password_room');
        $id_room = $request->input('id_room');
        $result = $this->checkUserRoom($id_room, $id_user);
        if (!empty($result)) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }
        $checktime = $this->checkTime($id_room);
        if ($checktime == 2) {
            return redirect()->back()->with('errorRoom', 'Phòng thi đã kết thúc');
        }
        $rooms = new RoomExam();
        $room = $rooms->select('*')->where('id_room', $id_room)->where('password_room', $password_room)->first();
        if (!empty($room)) {
            if ($request->session()->has('id_room')) {
                $request->session()->forget('id_room');
            } else {
                $request->session()->put('id_room', $room->id_room);
            }
            return redirect(route('createResultRoom', ['id_room' => $room->id_room]));
        } else {
            return redirect()->back()->with('error_id_room', $id_room)->with('erorrRoomPassword', 'Mật khẩu phòng thi không đúng');
        }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('errorRoom', 'Lỗi phòng thi !');
//        }
    }

//tao ket qua de luu de thi cho user phong thi
    public function createResultRoom(Request $request, $id_room)
    {
        $value_id_room = $request->session()->get('id_room');
        $id_user = Auth::user()->id;
        if ($request->session()->has('id_room') && $value_id_room == $id_room) {
            $rooms = new RoomExam();
            $room = $rooms->select('*')->where('id_room', $id_room)->where('id_room', $id_room)->first();
            $array_id_exam = explode(',', $room->id_exam);
            $convat = array_rand($array_id_exam);
            $result_room = new ResultRoomExam();
            $result_room_exam = $result_room->select('*')
                ->where('result_room_exam.id_room', $id_room)->where('result_room_exam.user_exam_room', $id_user)->first();
            if (empty($result_room_exam)) {
                $id_result_room = $result_room->insertGetId([
                    'id_room' => $value_id_room,
                    'user_exam_room' => $id_user,
                    'id_exam' => $array_id_exam[$convat],
                    'time_user_star_room' => new \DateTime(),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            }
            return redirect(route('getExamRoom', ['id_room' => $id_room]));
        } else {
            return redirect()->back()->with('errorRoom', 'Phòng thi đã kết thúc');
        }
//
    }

    //hien thi de thi trong phong thi
    public function getExamRoom(Request $request, $id_room)
    {
        try {
            $value_id_room = $request->session()->get('id_room');
            $id_user = Auth::user()->id;
            $day_month_year_date = date('Y/m/d');
            if ($request->session()->has('id_room') && $value_id_room == $id_room) {
                $result_room = new ResultRoomExam();
                $result_room = $result_room->select('*')
                    ->whereDate('time_user_star_room', '=', $day_month_year_date)
                    ->where('id_room', '=', $value_id_room)
                    ->where('user_exam_room', '=', $id_user)
                    ->first();
                $room = new RoomExam();
                $room = $room->select('*')->where('id_room', '=', $result_room->id_room)->first();
                $exam = new Exam();
                $exam = $exam->select('*')
                    ->where('id_exam', '=', $result_room->id_exam)
                    ->first();

                return view('site.exam_site_room.exam_room', compact('exam', 'room'));
            } else {
                return redirect()->back()->with('errorRoom', 'Phòng thi đã kết thúc');
            }
        } catch (\Exception $e) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }
    }

    //hien thi cau hoi cua phong thi
    public function getQuestionRoom(Request $request, $id_room)
    {
        try {
            $value_id_room = $request->session()->get('id_room');
            $id_user = Auth::user()->id;
            $day_month_year_date = date('Y/m/d');
            if ($request->session()->has('id_room') && $value_id_room == $id_room) {
                $result_room = new ResultRoomExam();
                $result_room = $result_room->select('*')
                    ->whereDate('time_user_star_room', '=', $day_month_year_date)
                    ->where('id_room', '=', $value_id_room)
                    ->where('user_exam_room', '=', $id_user)
                    ->first();

                $room = new RoomExam();
                $room = $room->select('*')->where('id_room', '=', $result_room->id_room)->first();

                $exam = new Exam();
                $exam = $exam->select('*')
//            ->join('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
//            ->join('categories_exam','categories_exam.id_cate_exam','=','categories_join_exam.id_categories_exam')
                    ->where('exam.bank_exam', '=', 1)
                    ->where('exam.id_exam', '=', $result_room->id_exam)
                    ->first();

                $question = new Questions();
                $questions = $question->select('*')
                    ->where('id_exam', '=', $result_room->id_exam)
//            ->groupBy('')
                    ->orderBy('type_ques', 'asc')
                    ->get();
                $countQuestion = $question->select('*')
                    ->where('id_exam', '=', $result_room->id_exam)
                    ->count();
                if ($countQuestion <= 0) {
                    $url = redirect()->back()->getTargetUrl();
                    return redirect($url)->with('errorQuestion', 'Đề thi này chưa dc tạo câu hỏi');
                }
                return view('site.exam_site_room.show_question_room', compact('room', 'exam', 'categories_exams', 'questions', 'countQuestion'));
            } else {
                return redirect()->back()->with('errorRoom', 'Phòng thi đã kết thúc');
            }
        } catch (\Exception $e) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }

    }

    public function createResultDetailRoom(Request $request)
    {
//        try {
            $id_room = $request->input('id_room');
            $value_id_room = $request->session()->get('id_room');
            $id_user = Auth::user()->id;
            $day_month_year_date = date('Y/m/d');
            if ($request->session()->has('id_room') && $value_id_room == $id_room) {
                $result_room = new ResultRoomExam();
                $result_room = $result_room->select('*')
                    ->whereDate('time_user_star_room', '=', $day_month_year_date)
                    ->where('id_room', '=', $id_room)
                    ->where('user_exam_room', '=', $id_user)
                    ->first();
                $id_exam = $request->input('id_exam');
                $correct_answer = $request->input('answer');
                //luu cau tra loi
                $detail_result_room = new DetailResultRoom();
                $list_detail_result_room = $detail_result_room->select('*')->where('id_result_room', $result_room->id_result_room)->count();
                if ($list_detail_result_room <= 0) {
                    foreach ($correct_answer as $id_ques => $correct) {
                        $insert_detail_result_room = $detail_result_room->insert([
                            'id_result_room' => $result_room->id_result_room,
                            'id_ques' => $id_ques,
                            'user_correct_ques' => $correct,
                            'updated_at' => new \DateTime(),
                        ]);
                    }
                }
                $rom = RoomExam::select('user_create_room','id_room')->where('id_room',$result_room->id_room)->first();
                $employer = Employer::select('email','user_id')->where('user_id',$rom->user_create_room)->first();
                //gui email tai day
                $id_result_room = $result_room->id_result_room;
//                $send_mail = MailConfigController::show_exam_room($id_result_room,$employer->email);
                return redirect(route('showResultRoom', ['id_result' => $result_room->id_result_room]));
            } else {
                return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
            }
//        } catch (\Exception $e) {
//            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
//        }
    }


    public function showResultRoom(Request $request, $result_id)
    {
        try {
//            $id_user = Auth::user()->id;
            $result_room = new ResultRoomExam();
            $result_room = $result_room->select('*')
                ->where('id_result_room', $result_id)
//                ->where('user_exam_room', '=', $id_user)
                ->first();
            if ($request->session()->has('id_room')) {
                $request->session()->forget('id_room');
            }
            $day_month_year_date = date('Y/m/d');
            $room = new RoomExam();
            $room = $room->select('*')->where('id_room', '=', $result_room->id_room)->first();
            $exam = new Exam();

            $exam = $exam->select('*')
                ->join('result_room_exam', 'result_room_exam.id_exam', '=', 'exam.id_exam')
                ->where('result_room_exam.id_result_room', $result_id)
                ->first();
            $id_exam = $exam->id_exam;
            $question = new Questions();
            //câu hỏi trắc nghiệm
            $question_1 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 0)
                ->get();
            // câu hỏi đúng sai
            $question_2 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 1)
                ->get();
            //câu hỏi tự luận
            $question_3 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 2)
                ->get();
//            return redirect(route('showResult',['id_result' => $result_id]));
            return view('site.exam_site_room.show_result_room', compact('room', 'id_exam', 'result_id', 'question_1', 'question_2', 'question_3'));
        } catch (\Exception $e) {
            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
        }
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
        }
        catch (\Exception $e)
        {
            return response([
                'status' => 500,
            ])->header('Content-Type', 'text/plain');
        }
    }

    public function charEmployer($room_id)
    {
        $room_exam = new RoomExam();
        $room = $room_exam->select('*')->where('id_room',$room_id)->first();

        $result_room_exam = new ResultRoomExam();
        $result_room_exam = $result_room_exam->select('result_room_exam.*','exam.id_exam','exam.code_exam','exam.name_exam','employees.employee_id','employees.user_id','employees.employee_name')
            ->leftJoin('exam','exam.id_exam','=','result_room_exam.id_exam')
            ->leftJoin('employees','employees.user_id','=','result_room_exam.user_exam_room')
            ->where('result_room_exam.id_room',$room_id)
            ->get();
//        print_r($result_room_exam);die();

        return view('site.exam_site_room.char_employer',compact('room','result_room_exam'));
    }
    public function checkTime($id_room)
    {
        $day_month_year_date = date('Y/m/d');

        $day_date = date('H:i');
        $rooms = new RoomExam();
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


}
