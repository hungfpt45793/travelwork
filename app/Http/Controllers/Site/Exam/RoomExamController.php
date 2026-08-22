<?php

namespace App\Http\Controllers\Site\Exam;

use App\Entity\Category;
use App\Entity\User;
use App\Exam\CategoriesExam;
use App\Exam\DetailResultExam;
use App\Exam\Questions;
use App\Exam\Exam;
use App\Exam\CategoriesJoinExam;
use App\Entity\Input;
use App\Entity\Post;
use App\Exam\ResultExam;
use App\Exam\ResultRoomExam;
use App\Exam\RoomExam;
use App\Http\Controllers\Site\SiteController;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Yajra\DataTables\DataTables;

class RoomExamController extends SiteController
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
        $user_id = Auth::user()->id;
        $this->checkRoleUser();
        $rooms = new RoomExam();
        $listroom = $rooms->select('*')
            ->where('user_create_room', $user_id);
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
        return View('site.exam_admin_site.room.danh-sach-phong-thi', compact('listroom','user','total'));
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

        $user = Auth::user();
        $user_id = Auth::user()->id;
        $this->checkRoleUser();
//        echo 1;die();
        return View('site.exam_admin_site.room.them-phong-thi',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        try {
        $this->validate($request, [
            'name_room' => 'required', // i need that this hour
            'password_room' => 'required|min:5', // i need that this hour
            'day_room' => 'required', // i need that this hour
            'time_star_room' => 'required', // i need that this hour
            'time_end_room' => 'required', // i need that this hour
        ]);
        $user_id = Auth::user()->id;
        $this->checkRoleUser();
        $rooms = new RoomExam();
        $id_room = $rooms->insertGetId([
            'code_room' => 0,
            'name_room' => $request->input('name_room'),
            'des_room' => $request->input('des_room'),
            'password_room' => $request->input('password_room'),
            'day_room' => $request->input('day_room'),
            'time_star_room' => $request->input('time_star_room'),
            'time_end_room' => $request->input('time_end_room'),
            'id_exam' => 0,
            'user_create_room' => $user_id,
            'type_exam' => $request->input('type_exam'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        $this->code_room($id_room);
        return redirect(route('getRomExam', ['id_room' => $id_room]));
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
        RoomExam::where('id_room', $id_room)->update([
            'code_room' => $code_room,
        ]);
    }

    public function getRomExam(Request $request, $id_room)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $exams = new Exam();
//        [DB::RAW('DISTINCT(my_column)')]'
        $categies = new CategoriesExam();
        $categies = $categies->select('*');
        $id_categories = '';
        if (!empty($request->input('category'))) {
            $id_categories = $request->input('category');
            $categies = $categies->where('parent_cate_exam', '=', $id_categories);
        }
        $categies = $categies->orWhere('id_cate_exam', '=', $id_categories)
            ->get();
        $id_categorys = '';
        if (!is_array($categies)) {
            foreach ($categies as $category) {
                $id_categorys .= $category['id_cate_exam'] . ',';
            }
        }
        $id_category = rtrim($id_categorys, ",");
        $cate_join_exam = new CategoriesJoinExam();
        $cate_join = $cate_join_exam->select('*')->whereIn('id_categories_exam', [$id_category])
            ->get();
        $id_exams = '';
        if (!is_array($cate_join)) {
            foreach ($cate_join as $cate) {
                $id_exams .= $cate['id_exam'] . ',';
            }
        }
        $id_exam = rtrim($id_exams, ",");
//            echo $id_exam;
        $id_category = rtrim($id_category, ',');
        $exams = new Exam();
        $list_exam = $exams->select('*');
        if (!empty($request->input('category'))) {
            $list_exam = $list_exam->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam');
            $list_exam = $list_exam->whereIn('categories_join_exam.id_categories_exam', [$id_category]);
        }
        if (!empty($request->input('exam'))) {
            $exam = $request->input('exam');
//            ->where('name', 'like', 'T%')
//            $list_exam = $list_exam->orWhere('exam.code_exam','like','%'.$exam.'%');
            $list_exam = $list_exam->where('exam.name_exam', 'like', '%' . $exam . '%');
        }
//            ->where('exam.bank_exam', '=', 1)
        $list_exam = $list_exam->where('exam.id_user', '=', $user_id);
        $list_exam = $list_exam->orderBy('exam.id_exam', 'desc');
        $list_exam = $list_exam->distinct('exam.code_exam')->paginate(10);
        $list_exam->appends(request()->query());

        $list_bank_exam = $exams->select('*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
//            ->where('exam.bank_exam', '=', 1)
            ->whereIn('categories_join_exam.id_categories_exam', [$id_category])
            ->paginate(3);
//        print_r($list_exam);die();


        $rooms = new RoomExam();
        $room = $rooms->select('*')->where('id_room', $id_room)->first();

        return View('site.exam_admin_site.room.chon-tu-de-thi-cua-ban', compact('list_exam', 'id_room', 'room','user'));
    }

    public function getBankRomExam(Request $request, $id_room)
    {
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $exams = new Exam();
//        [DB::RAW('DISTINCT(my_column)')]'
        $categies = new CategoriesExam();
        $categies = $categies->select('*');
        $id_categories = '';
        if (!empty($request->input('category'))) {
            $id_categories = $request->input('category');
            $categies = $categies->where('parent_cate_exam', '=', $id_categories);
        }
        $categies = $categies->orWhere('id_cate_exam', '=', $id_categories)
            ->get();
        $id_categorys = '';
        if (!is_array($categies)) {
            foreach ($categies as $category) {
                $id_categorys .= $category['id_cate_exam'] . ',';
            }
        }
        $id_category = rtrim($id_categorys, ",");
        $cate_join_exam = new CategoriesJoinExam();
        $cate_join = $cate_join_exam->select('*')->whereIn('id_categories_exam', [$id_category])
            ->get();
        $id_exams = '';
        if (!is_array($cate_join)) {
            foreach ($cate_join as $cate) {
                $id_exams .= $cate['id_exam'] . ',';
            }
        }
        $id_exam = rtrim($id_exams, ",");
//            echo $id_exam;
        $id_category = rtrim($id_category, ',');
        $exams = new Exam();
        $list_exam = $exams->select('*');
        if (!empty($request->input('category'))) {
            $list_exam = $list_exam->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam');
            $list_exam = $list_exam->whereIn('categories_join_exam.id_categories_exam', [$id_category]);
        }
        if (!empty($request->input('exam'))) {
            $exam = $request->input('exam');
//            ->where('name', 'like', 'T%')
//            $list_exam = $list_exam->orWhere('exam.code_exam','like','%'.$exam.'%');
            $list_exam = $list_exam->where('exam.name_exam', 'like', '%' . $exam . '%');
        }
//            ->where('exam.bank_exam', '=', 1)
        $list_exam = $list_exam->where('exam.bank_exam', '=', 1);
        $list_exam = $list_exam->orderBy('exam.id_exam', 'desc');
        $list_exam = $list_exam->distinct('exam.code_exam')->paginate(10);
        $list_exam->appends(request()->query());

        $list_bank_exam = $exams->select('*')
            ->leftJoin('categories_join_exam', 'categories_join_exam.id_exam', '=', 'exam.id_exam')
//            ->where('exam.bank_exam', '=', 1)
            ->whereIn('categories_join_exam.id_categories_exam', [$id_category])
            ->paginate(3);
//        print_r($list_exam);die();


        $rooms = new RoomExam();
        $room = $rooms->select('*')->where('id_room', $id_room)->first();

        return View('site.exam_admin_site.room.chon-tu-ngan-hang-de-thi', compact('list_exam', 'id_room', 'room','user'));
    }

    //cap nhat de thi cho phong thi
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
        return redirect()->back();

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
        $this->checkUserCreateRoom($id_room);
        try {
            $user = Auth::user();
            $user_id = Auth::user()->id;
            $room = RoomExam::select('*')
                ->where('id_room', $id_room)
                ->where('user_create_room', $user_id)
                ->first();
            if (empty($room)) {
                return redirect(route('room.index'))->with('erorr', 'Phòng thi không tồn tại');
            }
            return View('site.exam_admin_site.room.sua-phong-thi', compact('room','user'));
        } catch (\Exception $e) {
            return redirect(route('room.index'))->with('erorr', 'Phòng thi không tồn tại');
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
        $this->checkUserCreateRoom($id_room);
        $this->validate($request, [
            'name_room' => 'required', // i need that this hour
            'password_room' => 'required|min:5', // i need that this hour
            'day_room' => 'required', // i need that this hour
            'time_star_room' => 'required', // i need that this hour
            'time_end_room' => 'required', // i need that this hour
        ]);
        $user_id = Auth::user()->id;
        $this->checkRoleUser();
        $rooms = new RoomExam();
        $id_room = $rooms->where('id_room', $id_room)->update([
            'name_room' => $request->input('name_room'),
            'des_room' => $request->input('des_room'),
            'password_room' => $request->input('password_room'),
            'day_room' => $request->input('day_room'),
            'time_star_room' => $request->input('time_star_room'),
            'time_end_room' => $request->input('time_end_room'),
            'type_exam' => $request->input('type_exam'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('room.index'))->with('suscess', 'Cập nhật phòng thi thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_room)
    {
        $this->checkUserCreateRoom($id_room);
        $room = RoomExam::select('*')->where('id_room', $id_room)->delete();
        return redirect(route('room.index'))->with('suscess', 'Xóa phòng thi thành công !');
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
}
