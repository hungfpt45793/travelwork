<?php

namespace App\Http\Controllers\Site\Exam;

use App\Support\SpreadsheetFile;
use App\Entity\MailConfig;
use App\Entity\Teacher_schools;
use App\Entity\User;
use App\Exam\Detail_result_school;
use App\Exam\DetailResultExam;
use App\Exam\Exam_school;
use App\Exam\Exam_school_question_school;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\Questions_school;
use App\Exam\Result_school;
use App\Exam\ResultRoomExam;
use App\Exam\Room_school;
use App\Exam\RoomExam;
use App\Exam\Student_school;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Room_schoolController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Auth::check()) {
                return redirect('/');
            }
            $this->id_user = Auth::user()->id;
            view()->share('menuTopsite', 'exam');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        try {
        $user = Auth::user();
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $listroom = $rooms->select('*')
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if (!empty($request->input('code_room'))) {
            $code_room = $request->input('code_room');
            $listroom = $listroom->where('code_room', 'like', '%' . $code_room . '%');
        }
        if (!empty($request->input('name_room'))) {
            $name_room = $request->input('name_room');
            $listroom = $listroom->where('name_room', 'like', '%' . $name_room . '%');
        }
        $total = $listroom->count();
        $listroom = $listroom->orderBy('id_room', 'desc')->paginate(10);
        $listroom->appends(request()->query());
        return view('site.exam_school.room.danh-sach-phong-thi', compact('listroom','user','total'));
//        } catch (\Exception $e) {
//            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
//        }
    }

    //danh sach phong thi co ket qua thi
    public function getAllRomResultExam(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $this->checkRoleUser();
        $rooms = new RoomExam();
        $listroom = $rooms->select(
            'rooms_exam.id_room',
            'rooms_exam.code_room',
            'rooms_exam.des_room',
            'rooms_exam.name_room',
            'rooms_exam.password_room',
            'rooms_exam.day_room',
            'rooms_exam.time_star_room',
            'rooms_exam.time_end_room',
            'rooms_exam.user_create_room',
            'rooms_exam.id_exam'
        )
            ->rightJoin('result_room_exam', 'result_room_exam.id_room', '=', 'rooms_exam.id_room')
            ->where('rooms_exam.user_create_room', $user_id)
            ->orderBy('rooms_exam.id_room', 'desc');
        if (!empty($request->input('code_room'))) {
            $code_room = $request->input('code_room');
            $listroom = $listroom->where('rooms_exam.code_room', 'like', '%' . $code_room . '%');
        }
        if (!empty($request->input('name_room'))) {
            $name_room = $request->input('name_room');
            $listroom = $listroom->where('rooms_exam.name_room', 'like', '%' . $name_room . '%');
        }
        $listroom = $listroom->groupBy(
            'rooms_exam.id_room',
            'rooms_exam.code_room',
            'rooms_exam.des_room',
            'rooms_exam.name_room',
            'rooms_exam.password_room',
            'rooms_exam.day_room',
            'rooms_exam.time_star_room',
            'rooms_exam.time_end_room',
            'rooms_exam.user_create_room',
            'rooms_exam.id_exam'
        );
        $total = 0;
        $listroom = $listroom->paginate(10);
        $total = $listroom->count('rooms_exam.id_room');
        $listroom->appends(request()->query());
        return View('site.exam_admin_site.room.danh-sach-phong-thi-ket-qua', compact('listroom','user','total'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $id = Auth::user()->id;
      $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
//        echo 1;die();
        return View('site.exam_school.room.them-phong-thi',compact('teacher_school'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        echo  $request->input('exam_rules');die();
//        try {
        $this->validate($request, [
            'name_room' => 'required', // i need that this hour
            'password_room' => 'required|min:5', // i need that this hour
            'day_room' => 'required', // i need that this hour
            'time_star_room' => 'required', // i need that this hour
            'time_end_room' => 'required', // i need that this hour
        ]);
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $id_room = $rooms->insertGetId([
            'code_room' => 0,
            'name_room' => $request->input('name_room'),
            'des_room' => $request->input('des_room'),
            'exam_rules' => $request->input('exam_rules'),
            'password_room' => $request->input('password_room'),
            'day_room' => $request->input('day_room'),
            'time_star_room' => $request->input('time_star_room'),
            'time_end_room' => $request->input('time_end_room'),
            'sub_id' => $request->input('sub_id'),
            'teacher_sc_id' => $teacher_school->teacher_sc_id,
            'created_at' => new \DateTime(),
        ]);
        $this->code_room($id_room);

        return redirect(route('settingRoom', ['room_id' => $id_room]));

//        } catch (\Exception $e) {
//            Error::setErrorMessage('Lỗi xảy ra khi thêm mới thành viên: dữ liệu không hợp lệ.');
//            Log::error('http->admin->UserController->store: Lỗi xảy ra trong quá trình thêm mới thành viên');
//        } finally {
//
//        }
    }

    public function code_room($id_room)
    {
        $id_room = intval($id_room);
        $code_room = 'PT' . ($id_room + 100);
        Room_school::where('id_room', $id_room)->update([
            'code_room' => $code_room,
        ]);
    }

    public function settingRoom(Request $request, $id_room)
    {

        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $room = $rooms->select('*')->where('id_room', $id_room)->first();


//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 0)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();

         $total_one = 0;
        $question_one = Questions_school::select('*')
            ->where('type_ques', 1)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_one = $question_one->count();

        $total_two = 0;
        $question_two = Questions_school::select('*')
            ->where('type_ques', 2)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_two = $question_two->count();

        $total_three = 0;
        $question_three = Questions_school::select('*')
            ->where('type_ques', 3)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_three = $question_three->count();

        $list_exam = Exam_school::select('*')
            ->where('id_class_school',$id_room)
            ->orderBy('id_exam','asc');
            $total_exam = $list_exam->count();
        $list_exam = $list_exam->paginate(20);



        return View('site.exam_school.room.cau-hinh-phong-thi', compact('room','total_zero','total_one','total_two','total_three','list_exam','total_exam'));
    }
    public function listExamRoom(Request $request, $id_room)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $room = $rooms->select('*')->where('id_room', $id_room)->first();


//        danh sach cau hoi dễ
        $total_zero = 0;
        $question_zero = Questions_school::select('*')
            ->where('type_ques', 0)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_zero = $question_zero->count();

        $total_one = 0;
        $question_one = Questions_school::select('*')
            ->where('type_ques', 1)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_one = $question_one->count();

        $total_two = 0;
        $question_two = Questions_school::select('*')
            ->where('type_ques', 2)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_two = $question_two->count();

        $total_three = 0;
        $question_three = Questions_school::select('*')
            ->where('type_ques', 3)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc');
        $total_three = $question_three->count();

        $list_exam = Exam_school::select('*')
            ->where('id_class_school',$id_room)
            ->orderBy('id_exam','asc');
        $total_exam = $list_exam->count();
        $list_exam = $list_exam->paginate(20);
        return View('site.exam_school.room.danh-sach-de-thi', compact('room','total_zero','total_one','total_two','total_three','list_exam','total_exam'));
    }

    public function create_exam_room(Request $request)
    {

//        return redirect()->back()->with('suscees', 'Tạo đề thi cho phòng thi thành công !');

        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $id_room = $request->input('id_room');
        $room = $rooms->select('*')->where('id_room', $id_room)->first();

        $question_zero = Questions_school::select('id_ques')
            ->where('type_ques', 0)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->inRandomOrder()
            ->get();

        $question_one = Questions_school::select('id_ques')
            ->where('type_ques', 1)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->inRandomOrder()
            ->get();

        $question_two = Questions_school::select('id_ques')
            ->where('type_ques', 2)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('id_ques', 'asc')
            ->inRandomOrder()->get();
        $question_three = Questions_school::select('id_ques')
            ->where('type_ques', 3)
            ->where('sub_id', $room->sub_id)
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->inRandomOrder()
            ->get();


        $total_exam = $request->input('total_exam');
        $total_time = $request->input('total_time');
        $total_zero = $request->input('total_zero');
        $total_one = $request->input('total_one');
        $total_two = $request->input('total_two');
        $total_three = $request->input('total_three');

        $array_question_zero = array();
        foreach($question_zero as $zero)
        {
            $array_question_zero[] = $zero->id_ques;
        }
        $array_question_one = array();
        foreach($question_one as $one)
        {
            $array_question_one[] = $one->id_ques;
        }
        $array_question_two = array();
        foreach($question_two as $two)
        {
            $array_question_two[] = $two->id_ques;
        }
        if(!empty($question_three))
        {
            $array_question_three = array();
            foreach($question_three as $three)
            {
                $array_question_three[] = $three->id_ques;
            }
        }
        //vong lap dau tien tao de thi
        for($i=1;$i<=$total_exam;$i++)
        {
            $insert_id_exam = Exam_school::insertGetId([
                'name_exam'=> 'DT'.$i,
                'time_exam'=> $total_time,
                'id_class_school'=>$id_room,
                'teacher_sc_id' => $teacher_school->teacher_sc_id,
                'created_at'=>new \DateTime()
            ]);

            //tao de cau hoi cho de thi de

            $random_keys=array_rand($array_question_zero,$total_zero);
            shuffle($random_keys);
            for($j=0;$j<$total_zero;$j++)
            {

                Exam_school_question_school::insert([
                    'id_exam' => $insert_id_exam,
                    'id_ques' =>$array_question_zero[$random_keys[$j]],
                    'teacher_sc_id' => $teacher_school->teacher_sc_id,
                    'created_at'=>new \DateTime()
                ]);
            }
            $random_keys1=array_rand($array_question_one,$total_one);
            shuffle($random_keys1);
            for($j1=0;$j1<$total_one;$j1++)
            {

               Exam_school_question_school::insert([
                    'id_exam' => $insert_id_exam,
                    'id_ques' =>$array_question_one[$random_keys1[$j1]],
                    'teacher_sc_id' => $teacher_school->teacher_sc_id,
                    'created_at'=>new \DateTime()
                ]);
            }
            $random_keys2=array_rand($array_question_two,$total_two);
            shuffle($random_keys2);
            for($j2=0;$j2<$total_two;$j2++)
            {

               Exam_school_question_school::insert([
                    'id_exam' => $insert_id_exam,
                    'id_ques' =>$array_question_two[$random_keys2[$j2]],
                    'teacher_sc_id' => $teacher_school->teacher_sc_id,
                    'created_at'=>new \DateTime()
                ]);
            }
            if(!empty($question_three) && $total_three > 0)
            {
                if($total_three == 1)
                {
//                    $random_keys3=array_rand($array_question_three,$total_three);
//                    shuffle($random_keys3);
                    for($j3=0;$j3<$total_three;$j3++)
                    {
                        Exam_school_question_school::insert([
                            'id_exam' => $insert_id_exam,
                            'id_ques' =>$array_question_three[$j3],
                            'teacher_sc_id' => $teacher_school->teacher_sc_id,
                            'created_at'=>new \DateTime()
                        ]);
                    }
                }
                else
                {
                    $random_keys3=array_rand($array_question_three,$total_three);
                    shuffle($random_keys3);
                    for($j3=0;$j3<$total_three;$j3++)
                    {
                        Exam_school_question_school::insert([
                            'id_exam' => $insert_id_exam,
                            'id_ques' =>$array_question_three[$random_keys3[$j3]],
                            'teacher_sc_id' => $teacher_school->teacher_sc_id,
                            'created_at'=>new \DateTime()
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('suscees', 'Tạo đề thi cho phòng thi thành công !');

    }
    public function show_exam($id_exam)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $exam = new Exam_school();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->first();
        $question = new Questions_school();

        $question_1 = $question->select('*')->leftJoin('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
            ->where('exam_school_question_school.id_exam', '=', $id_exam)
            ->where('exam_school_question_school.teacher_sc_id', $teacher_school->teacher_sc_id)
            ->orderBy('exam_school_question_school.exam_ques_id','asc')
            ->orderBy('questions_school.id_ques','asc')
            ->get();


        return view('site.exam_school.exam.danh-sach-cau-hoi', compact( 'exam','question_1'));
    }
    //cap nhat de thi cho phong thi

    public function delete_exam($id_exam)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $exam = new Exam_school();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->delete();
        $question = new Questions_school();

//        $question_1 = $question->select('*')->leftJoin('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
//            ->where('exam_school_question_school.id_exam', '=', $id_exam)
//            ->where('exam_school_question_school.teacher_sc_id', $teacher_school->teacher_sc_id)
//           ->delete();

        $question = Exam_school_question_school::where('exam_school_question_school.id_exam', '=', $id_exam)->delete();
        return redirect()->back()->with('suscees', 'Xóa đề thi thành công !');
    }
    public function updateExamRoom(Request $request)
    {
//        $this->validate($request, [
//            'examid' => 'required',
//        ]);
        $id_exams = $request->input('examid');
        $id_room = $request->input('id_room');
//        print_r($id_exams);die();

        $room_exam = RoomExam::select('*')->where('id_room', $id_room)->first();
        $id_exam = '';
        if (!empty($id_exams)) {
            foreach ($id_exams as $id => $exam) {
                $id_exam .= $exam . ',';
            }
        }
        $id_exam = rtrim($id_exam, ",");
//        $id_array = array_unique($id_array);
        RoomExam::where('id_room', $id_room)->update([
            'id_exam' => $id_exam,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id_room)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        try {
            $room = Room_school::select('*')
                ->where('id_room', $id_room)
                ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                ->first();
            if (empty($room)) {
                return redirect(route('room_school.index'))->with('erorr', 'Phòng thi không tồn tại');
            }
            return View('site.exam_school.room.sua-phong-thi', compact('room','teacher_school'));
        } catch (\Exception $e) {
            return redirect(route('room_school.index'))->with('erorr', 'Phòng thi không tồn tại');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_room)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $this->validate($request, [
            'name_room' => 'required', // i need that this hour
            'password_room' => 'required|min:5', // i need that this hour
            'day_room' => 'required', // i need that this hour
            'time_star_room' => 'required', // i need that this hour
            'time_end_room' => 'required', // i need that this hour
        ]);


        $rooms = new Room_school();
        $id_room = $rooms->where('id_room', $id_room)->update([
            'name_room' => $request->input('name_room'),
            'des_room' => $request->input('des_room'),
            'exam_rules' => $request->input('exam_rules'),
            'password_room' => $request->input('password_room'),
            'day_room' => $request->input('day_room'),
            'time_star_room' => $request->input('time_star_room'),
            'time_end_room' => $request->input('time_end_room'),
            'sub_id' => $request->input('sub_id'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('room_school.index'))->with('suscess', 'Cập nhật phòng thi thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_room)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $room = Room_school::select('*')
            ->where('teacher_sc_id',$teacher_school->teacher_sc_id)
            ->where('id_room', $id_room)
            ->delete();
        return redirect(route('room_school.index'))->with('suscess', 'Xóa phòng thi thành công !');
    }

    private function checkRoleUser()
    {
        $role = Auth::user()->role;
        if ($role == 2 or $role == 3 ) {

        }else
        {
            return redirect(route('showAllExam'))->with('erorr', 'Bạn không có quyền này');
        }
    }

//    danh sach ket qua ung vien phong thi
    public function getResultExam($id_room)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;
        $room_exams = new RoomExam();
        $room = $room_exams->select('*')->where('id_room', $id_room)->first();
        $list_user = $room_exams->select('*')->leftJoin('result_room_exam', 'result_room_exam.id_room', '=', 'rooms_exam.id_room')->where('result_room_exam.id_room', $id_room)->where('rooms_exam.user_create_room', $id_user)->get();
        $total = 0;
        $total = $list_user->count();
        return view('site.exam_admin_site.room.ket-qua-danh-sach-phong-thi', compact('list_user', 'room','user','total'));
    }

    public function getDetailResultExam($result_id)
    {
        try{
            $user = Auth::user();
            $id_user = Auth::user()->id;
            $result_room = new ResultRoomExam();
            $result_room = $result_room->select('*')
                ->where('id_result_room', $result_id)
                ->first();
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
//        câu hỏi trắc nghiệm
            $question_1 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 0)
                ->get();

            $question_2 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 1)
                ->get();
            $question_3 = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->where('type_ques', '=', 2)
                ->get();

            $userModel = new User();
            $user_room_exam = $userModel->select('*')->where('id',$result_room->user_exam_room)->first();
            if(!empty($user_room_exam))
            {
                return view('site.exam_admin_site.room.chi-tiet-ket-qua-phong-thi', compact('room', 'id_exam', 'id_user', 'result_id', 'result_room', 'question_1', 'question_2', 'question_3','user','user_room_exam'));
            }
            else
            {
                return redirect()->back()->with('erorr','Không tồn tại kết quả của phòng thi này');
            }
//            return redirect(route('showResult',['id_result' => $result_id]));

        }catch (\Exception $e)
        {
            return redirect()->back()->with('erorr','Không tồn tại kết quả của phòng thi này');
        }

    }

    private function checkUserCreateRoom($id_room)
    {
        $id = Auth::user()->id;
        $room = RoomExam::select('user_create_room')->where('id_room', $id_room)->first();
        if ($room['user_create_room'] != $id) {
            return redirect(route('room.index'))->with('erorr', 'Bạn không có quyền này');
        }
//        return $level;
    }
    public function list_student_room(Request $request)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();

        $day_date = date('Y/m/d');
        $time_day = date('H:i');
        $date_end = date('Y/m/d H:i');


        $rooms = new Room_school();
        $listroom = $rooms->select('*')
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if (!empty($request->input('code_room'))) {
            $code_room = $request->input('code_room');
            $listroom = $listroom->where('code_room', 'like', '%' . $code_room . '%');
        }
        if (!empty($request->input('name_room'))) {
            $name_room = $request->input('name_room');
            $listroom = $listroom->where('name_room', 'like', '%' . $name_room . '%');
        };
        $listroom = $listroom ->whereDate('day_room', '=', $day_date)
            ->whereTime('time_star_room', '<=', $time_day)
            ->whereTime('time_end_room', '>=', $time_day);
        $total = $listroom->count();
        $listroom = $listroom->orderBy('id_room', 'desc')
            ->paginate(10);
        $listroom->appends(request()->query());

        return View('site.exam_school.room.danh-sach-phong-thi-dang-thi', compact('listroom','user','total'));

    }
    public function list_status_student_room(Request $request ,$room_id)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $room = $rooms->select('*')
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->where('id_room',$room_id)
            ->first();
        $list_student = Result_school::select('result_school.*','student_school.*','exam_school.name_exam')
            ->join('exam_school','exam_school.id_exam','=','result_school.id_exam')
            ->leftJoin('student_school','student_school.student_id','=','result_school.id_student');

        if(!empty($request->input('student_code')))
        {
            $list_student = $list_student->where('student_school.student_code','like','%'.$request->input('student_code').'%');
        }
        if(!empty($request->input('student_name')))
        {
            $list_student = $list_student->where('student_school.student_name','like','%'.$request->input('student_name').'%');
        }
        if(!empty($request->input('class_primakey')))
        {
            $list_student = $list_student->where('student_school.class_primakey','like','%'.$request->input('class_primakey').'%');
        }
        if(!empty($request->input('class_section')))
        {
            $list_student = $list_student->where('student_school.class_section','like','%'.$request->input('class_section').'%');
        }

        $list_student = $list_student->where('result_school.id_room',$room_id);
        $list_student = $list_student->get();
        return View('site.exam_school.room.danh-sach-sinh-vien-dang-thi', compact('room','user','total','list_student'));
//
//        echo '<pre>';
//        print_r($list_student);
    }
    public function delete_student_room(Request $request ,$result_id)
    {
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();

        $result = Result_school::where('id_result',$result_id)->first();
        $delete_student = Student_school::where('student_id',$result->id_student)->delete();
        $delete = Result_school::where('id_result',$result_id)->delete();
        $delete_detail = DetailResultExam::where('id_result',$result_id)->delete();

        return redirect()->back()->with('success' ,'Bạn đã xóa kết thi của sinh viên thành công');
//
//        echo '<pre>';
//        print_r($list_student);
    }
    public function result_student_room(Request $request)
    {
        $id = Auth::user()->id;
        $user = Auth::user();
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $listroom = $rooms->select('*')
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id);
        if (!empty($request->input('code_room'))) {
            $code_room = $request->input('code_room');
            $listroom = $listroom->where('code_room', 'like', '%' . $code_room . '%');
        }
        if (!empty($request->input('name_room'))) {
            $name_room = $request->input('name_room');
            $listroom = $listroom->where('name_room', 'like', '%' . $name_room . '%');
        }
        $total = $listroom->count();
        $listroom = $listroom->orderBy('id_room', 'desc')->paginate(10);
        $listroom->appends(request()->query());


        return View('site.exam_school.room.ket-qua-cua-phong-thi', compact('listroom','user','total'));
    }
    public function detai_result_student_room(Request $request ,$room_id)
    {

//        $text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
//        echo strip_tags($text);   //output Test paragraph. Other text
//        echo $text;
//        die();
        $id = Auth::user()->id;
        $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
        $rooms = new Room_school();
        $room = $rooms->select('*')
            ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
            ->where('id_room',$room_id)
            ->first();

        $result_school = Result_school::select('result_school.*','student_school.*','exam_school.id_exam','exam_school.name_exam')
            ->leftJoin('student_school','student_school.student_id','=','result_school.id_student')
            ->leftJoin('exam_school','exam_school.id_exam','=','result_school.id_exam');

        if(!empty($request->input('student_code')))
        {
            $result_school = $result_school->where('student_school.student_code','like','%'.$request->input('student_code').'%');
        }
        if(!empty($request->input('student_name')))
        {
            $result_school = $result_school->where('student_school.student_name','like','%'.$request->input('student_name').'%');
        }
        if(!empty($request->input('class_primakey')))
        {
            $result_school = $result_school->where('student_school.class_primakey','like','%'.$request->input('class_primakey').'%');
        }
        if(!empty($request->input('class_section')))
        {
            $result_school = $result_school->where('student_school.class_section','like','%'.$request->input('class_section').'%');
        }
        $result_school =$result_school->where('result_school.id_room',$room_id);
         $result_school= $result_school->paginate(20);
        $result_school->appends(request()->query());
        $total = '';
//        echo '<pre>';
//        print_r($result_school);die();

        return View('site.exam_school.room.chi-tiet-ket-qua-cua-phong-thi', compact('room','total','result_school'));

    }
    public function check_detail_result(Request $request ,$room_id)
    {

//        $text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
//        echo strip_tags($text);   //output Test paragraph. Other text
//        echo $text;
//        die();





            $detail_result_room = new Detail_result_school();

            $list_result = Result_school::where('id_room',$room_id)->get();
            foreach($list_result as $result)
            {

                $detail_result = Detail_result_school::where('id_result',$result->id_result)->get();
                $total_true = 0;
                foreach ($detail_result as $id_ques => $correct) {
                    $question_school = \App\Exam\Questions_school::getIdQuestion($correct->id_ques ,3);
                    if(!empty($question_school['correct_answer']) && $question_school['correct_answer'] == $correct->user_correct_ques)
                    {
                        $total_true = $total_true + 1;
                    }
                }
                echo $total_true;
                echo '</br>';

                $result_true = Result_school::where('id_result', $result->id_result)->update(['correct_question' => $total_true]);
            }
//            echo '<pre>';
//            print_r($list_result);
//
            echo '</br>';










    }
    public function check_id_result(Request $request ,$id_result)
    {

//        $text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
//        echo strip_tags($text);   //output Test paragraph. Other text
//        echo $text;
//        die();



                $count = Detail_result_school::where('id_result','=' ,$id_result)->count();
                echo $id_result .'--tong co cau hoi '.$count;
                echo '</br>';

        echo '</br>';
        echo $id_result;
       die();


    }
    public function detai_result_student(Request $request ,$result_id)
    {
        $result = Result_school::where('id_result', $result_id)->first();
        $room = Room_school::where('id_room',$result->id_room)->first();
        $id_exam = $result->id_exam;
        $detail_result = Detail_result_school::select('*')->where('id_result',$result_id)->get();
        $question = new Questions_school();
//        câu hỏi trắc nghiệm
        $list_question = $question->select('questions_school.*','exam_school_question_school.id_ques','exam_school_question_school.id_exam')
            ->join('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
            ->where('exam_school_question_school.id_exam', '=', $id_exam);
        $total_question = $list_question->count();
        $list_question = $list_question->get();
        $result_id = $result->id_result;
        $exam = Exam_school::select('*')->join('exam_school_question_school','exam_school_question_school.id_exam','=','exam_school.id_exam')
            ->where('exam_school.id_exam', '=', $id_exam)
            ->first();
        $list_question_true = $question->select('*')
            ->join('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
            ->where('id_exam', '=', $id_exam);
        $list_question_true = $list_question_true->where('questions_school.type_ques','<',3);
        $total_choice = $list_question_true->count();
        $list_question_true = $list_question_true->get();
        $total_true = $result->correct_question;
        $student_school = Student_school::select('*')->where('student_id',$result->id_student)->first();
        $room_school = Room_school::select('teacher_sc_id','name_room','day_room','code_room')->where('id_room',$result->id_room)->first();
        $teacher_school = Teacher_schools::select('*')->where('teacher_sc_id',$room_school->teacher_sc_id)->first();

        return view('site.exam_school.room.hien-thi-ket-qua-phong-thi', compact('room', 'id_exam','result','detail_result','list_question','result_id','exam','total_question','total_true','total_choice','student_school','room_school'));
//        } catch (\Exception $e) {
//            return redirect(route('getRomAll'))->with('errorRoom', 'Bạn đã thi phòng thi này rồi !');
//        }

    }
    public function updateSchoolResultDetailRoom(Request $request)
    {
//        try {

        $id_room = $request->input('id_room');
        $id_result = $request->input('id_result');
        $id_exam = $request->input('id_exam');
        $correct_answer = $request->input('answer_teacher');

        $result = Result_school::where('id_result', $id_result)->first();

        $detail_result_room = new Detail_result_school();
        foreach ($correct_answer as $id_ques => $correct) {
            $update_detail_result_room = $detail_result_room->where('id_ques',$id_ques)
                ->where('id_result',$id_result)
                ->update([
                'teacher_correct' => $correct,
                'updated_at' => new \DateTime(),
            ]);
        }
        //gui kêt qua cau nhan xet cau tu luan cho sinh vien
        $student_school = Student_school::select('*')->where('student_id',$result->id_student)->first();
        $room_school = Room_school::select('teacher_sc_id','name_room','day_room','code_room')->where('id_room',$result->id_room)->first();
        $subject = 'Thông báo giáo viên đã nhận xét về kết quả bài thi tự luận của bạn ';
        $link_result = route('ViewShowResultStudent',['result_id'=>$id_result]);
        $content_string = '<p>'.'Giáo viên đã nhận xét về kết quả bài thi tự luận của bạn'.'</p>';
        $content_string .= '<p>'.'Tại phòng thi'.$room_school->name_room.'</p>';
        $content_string .= '<a href="'.$link_result.'">'.'<p>'.'Link xem kết quả tại đây'.'</p>'.'</a>';
//        $total_choice

        //gửi kết quả của sinh viên cho giáo viên
        $send_email = MailConfig::sendMail($student_school->student_email, $subject, $content_string);

        return redirect()->back()->with('suscess','Bạn đã nhận xét câu trả tự luận của sinh viên thành công ! Đã gửi email kết quả cho sinh viên');
    }

    public function export_room_excel(Request $request,$room_id)
    {
//        try {

            $id = Auth::user()->id;
            $teacher_school = Teacher_schools::select('*')->where('user_id',$id)->first();
            $rooms = new Room_school();
            $room = $rooms->select('*')
                ->where('teacher_sc_id', $teacher_school->teacher_sc_id)
                ->where('id_room',$room_id)
                ->first();
        $result_school = Result_school::select('result_school.*','student_school.*','exam_school.id_exam','exam_school.name_exam','exam_school.time_exam')
            ->leftJoin('student_school','student_school.student_id','=','result_school.id_student')
            ->leftJoin('exam_school','exam_school.id_exam','=','result_school.id_exam');
        if(!empty($request->input('student_code')))
        {
            $result_school = $result_school->where('student_school.student_code','like','%'.$request->input('student_code').'%');
        }
        if(!empty($request->input('student_name')))
        {
            $result_school = $result_school->where('student_school.student_name','like','%'.$request->input('student_name').'%');
        }
        if(!empty($request->input('class_primakey')))
        {
            $result_school = $result_school->where('student_school.class_primakey','like','%'.$request->input('class_primakey').'%');
        }
        if(!empty($request->input('class_section')))
        {
            $result_school = $result_school->where('student_school.class_section','like','%'.$request->input('class_section').'%');
        }
        $result_school =$result_school->where('result_school.id_room',$room_id)->get();
            $data[] = array(
                'STT',
                'Thông tin SV',
                'Lớp',
                'Thời gian làm bài',
                'Thông tin đề',
                'Kết quả điểm',
                'Nội dung tự luận câu 1',
                'Nội dung tự luận câu 2',
            );
            foreach ($result_school as $id=>$result){
                //lấy về tổng số câu hỏi trắc nghiệm
                $total_ques = Questions_school::leftJoin('exam_school_question_school','exam_school_question_school.id_ques','=','questions_school.id_ques')
                    ->where('exam_school_question_school.id_exam', '=', $result->id_exam)
                    ->where('questions_school.type_ques', '<', 3)
                    ->count();

                $detail_school = Detail_result_school::select('detail_result_school.*','questions_school.id_ques','questions_school.type_ques')
                    ->join('questions_school','questions_school.id_ques','=','detail_result_school.id_ques')
                    ->where('questions_school.type_ques',3)
                    ->where('detail_result_school.id_result',$result->id_result)
                    ->get();
                $reply1 = '';
                $reply2 = '';
                if(!empty($detail_school))
                {
                    foreach($detail_school as $id_sc=>$school)
                    {
                        if($id_sc == 0)
                        {
                            $reply1 = $school->user_correct_ques;
                        }
                        if($id_sc == 1)
                        {
                            $reply2 = $school->user_correct_ques;
                        }
                    }
                }
                $data[] = array(
                    $id + 1,
//                    [name_exam] => DT1
//                    [time_exam] => 5
                    'Mã SV : '.$result->student_code.';'.'Tên SV : '.$result->student_name,
                    'Lớp HC : '.$result->class_primakey.';'.'Lớp HP : '.$result->class_section,
                    date_format(date_create($result->star_time_submit),"d-m-Y H:i").';'.date_format(date_create($result->end_time_submit),"d-m-Y H:i"),
                    $result->name_exam.';'.$result->time_exam.' phút (thời gian làm bài)',
                    $result->correct_question.'/'.$total_ques,
                    $reply1,
                    $reply2,
                );
            }
//            echo '<pre>';
//            print_r($data);die();
//
            $date = new \DateTime();
            $title_excel = 'Kết quả của thí sinh phòng thi số'.$rooms->code_room;
            $fileName = "Ket-qua-phong-thi".$rooms->code_room.'-ngay-'.date_format(date_create($rooms->day_room),"d-m-y");

            return SpreadsheetFile::download($data, $fileName, [
                'widths' => [
                    'B' => 50,
                    'C' => 50,
                    'D' => 30,
                    'E' => 30,
                    'F' => 20,
                    'G' => 50,
                    'H' => 50,
                ],
                'heights' => [1 => 60],
                'wrap' => ['G'],
            ]);




//        } catch (\Exception $e) {
//            Error::setErrorMessage('Lỗi xảy ra khi export sản phẩm: dữ liệu không hợp lệ.');
//            Log::error('http->admin->productController->exportToExcel: Lỗi xảy ra trong quá trình export sản phẩm');
//
//            return null;
//        }
    }

    public function export_detai_result_student_excel(Request $request, $result_id)
    {


        $result = Result_school::where('id_result', $result_id)->first();
        $id_exam = $result->id_exam;
        $detail_result = Detail_result_school::select('*')->where('id_result', $result_id)->get();
        $question = new Questions_school();
//        câu hỏi trắc nghiệm
        $list_question = $question->select('*')
            ->join('exam_school_question_school', 'exam_school_question_school.id_ques', '=', 'questions_school.id_ques')
            ->join('detail_result_school', 'detail_result_school.id_ques', '=', 'questions_school.id_ques')
            ->where('exam_school_question_school.id_exam', '=', $id_exam)
            ->where('detail_result_school.id_result',$result_id);
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

        $total_true = $result->correct_question;
//        $total_true = 0;
//        foreach ($list_question_true as $question_true) {
//            $anser = \App\Exam\Detail_result_school::getAnswer($result_id, $question_true->id_ques);
//            if (!empty($anser)) {
//                if ($question_true->correct_answer == $anser->user_correct_ques) {
//                    $total_true = $total_true + 1;
//                }
//            }
//
//        }
//        $result_true = Result_school::where('id_result', $result_id)->update(['correct_question' => $total_true]);

        $student_school = Student_school::select('*')->where('student_id', $result->id_student)->first();
        $room_school = Room_school::select('teacher_sc_id', 'name_room', 'day_room', 'code_room')->where('id_room', $result->id_room)->first();
        $teacher_school = Teacher_schools::select('*')->where('teacher_sc_id', $room_school->teacher_sc_id)->first();


        $cenvertedTime = (strtotime($result['end_time_submit']) - strtotime($result['star_time_submit']));
        $minture_time = $cenvertedTime / 60;
//        $data[] = array(
//            'Thông tin sinh viên'=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//            ''=> '',
//        );
        $data[] = array(
            'Mã sinh viên :' => $student_school->student_code,
            'Tên sinh viên :' => $student_school->student_name,
            'Lớp hành chính :' => $student_school->class_primakey,
            'Lớp học phần :' => $student_school->class_section,
            'Đề thi :' => $exam->name_exam . ', kiểm tra ' . $exam->time_exam . ' phút',
            'Thời gian quy định :' => $exam->time_exam . ' phút',
            'Ngày thi :' => date_format(date_create($result->date_result), "d-m-Y"),
            'Thời gian làm bài :' => ceil($minture_time) . ' phút',
            'Kết quả thi :' => $result->correct_question . '/' . $total_choice,
        );
//        echo $total_question;
//        echo '<pre>';
//        print_r($list_question);die();

        $data[] = array(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        );
        $data[] = array(
            'Kết quả thi của sinh viên',
        );
        $data[] = array(
            'Câu hỏi',
            'Nội dung câu hỏi',
            'Đáp án đúng',
            'Câu trả lời',
            'Kết quả',
        );
        foreach ($list_question as $id => $question) {
            $answer = '';
            if ($question->correct_answer == 'answer1' && $question->type_ques < 3) {
                $answer = 'A';
            }
            if ($question->correct_answer == 'answer2' && $question->type_ques < 3) {
                $answer = 'B';
            }
            if ($question->correct_answer == 'answer3' && $question->type_ques < 3) {
                $answer = 'C';
            }
            if ($question->correct_answer == 'answer4' && $question->type_ques < 3) {
                $answer = 'D';
            }
            $user_answer = '';
            if ($question->user_correct_ques == 'answer1' && $question->type_ques < 3) {
                $user_answer = 'A';
            }
            if ($question->user_correct_ques == 'answer2' && $question->type_ques < 3) {
                $user_answer = 'B';
            }
            if ($question->user_correct_ques == 'answer3' && $question->type_ques < 3) {
                $user_answer = 'C';
            }
            if ($question->user_correct_ques == 'answer4' && $question->type_ques < 3) {
                $user_answer = 'D';
            }

            $show_question = '';
            if ($question->correct_answer == $question->user_correct_ques && $question->type_ques < 3) {
                $show_question = 'Đúng';
            }
            if ($question->correct_answer != $question->user_correct_ques && $question->type_ques < 3) {
                $show_question = 'Sai';
            }

            if ($question->type_ques < 3) {
                $data[] = array(
                    'Câu ' . ($id + 1) . ':',
                   (strip_tags(html_entity_decode($question->name_ques))),
                    $answer,
                    $user_answer,
                    $show_question,
                );
                $data[] = array(
                    'A',
                    $question->answer1,
                );
                $data[] = array(
                    'B',
                    $question->answer2,
                );
                $data[] = array(
                    'C',
                    $question->answer3,
                );
                $data[] = array(
                    'D',
                    $question->answer4,
                );
            }
            if ($question->type_ques == 3) {
                $data[] = array(
                    'Câu ' . ($id + 1) . '(tự luận):',
                    (strip_tags(html_entity_decode($question->name_ques))),
                    (strip_tags(html_entity_decode($question->user_correct_ques))) ,

                );
            }

        }

//            echo '<pre>';
//            print_r($data);die();
//
//        $date = new \DateTime();
//        $title_excel = 'Kết quả của thí sinh phòng thi số'.$rooms->code_room;
        $fileName = "Ket-qua-phong-thi-cua-sinh-vien-co-ma-" . $student_school->student_code . '-ngay-thi-'.date_format(date_create($result->date_result), "d-m-Y");
        return SpreadsheetFile::download($data, $fileName, [
            'widths' => [
                'A' => 30,
                'B' => 50,
                'C' => 30,
                'D' => 20,
                'E' => 25,
                'F' => 20,
                'G' => 20,
                'H' => 20,
                'I' => 20,
            ],
            'heights' => [1 => 60],
            'wrap' => ['B', 'C'],
            'center' => ['C', 'D', 'E', 'F', 'G', 'H', 'I'],
        ]);


    }

}
