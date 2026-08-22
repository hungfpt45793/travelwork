<?php

namespace App\Entity;

use App\Course\Course_employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Site\CkedittorController;
use PDF;
use App\Entity\EmployeeActiveCv;
use PDFMerger;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

class Employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'employee_id',
        'employee_code',
        'employee_name',
        'employee_slug',
        'employee_image',
        'phone',
        'email',
        'province',
        'district',
        'address',
        'file_cv',
        'career_category_id',
        'salary_id',
        'information_verifier',
        'status', //trang thai lam viec
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'gender', //gioi tinh
        'birthday',
        'marry', //ket hon
        'school',
        'majors',
        'cmt',
        'cmt_date',
        'cmt_local',
        'address_stay',
        'my_facebook',
        'status_employees_experience',
        'day_status_employees_experience',
        'status_employee_degree',
        'day_status_employee_degree',
        'status_post',
        'employee_level_id',
        'experience_id',
        'code_intro',
        'profile',
        'views',
        'status_employee', //trang thai ung vien da duyet
        'user_id_handling',
        'day_handling',
        'time_to_work',
        'show_hidden_profile',
        'show_hidden_cv',
        'show_hidden_syll',
    ];

    public static function getNewCV($count = 5)
    {
        try {
            $getNewCV = new Employee();

            $newCVs = $getNewCV
                ->select(
                    'employees.*'
                )
                ->orderBy('employees.employee_id', 'desc')
                ->offset(0)
                ->limit($count)->distinct()->get();
            return $newCVs;

        } catch (\Exception $e) {
            Log::error('Entity->Employee->getNewCV: Lấy CV Ứng viên Mới');
            return array();
        }

    }

    public static function getEmployee_id($id_user)
    {
        $employee = new Employee();
        $employee = $employee->select('employee_id', 'user_id', 'employee_name', 'employee_image', 'phone', 'email', 'address')->where('user_id', $id_user)->first();
        return $employee;
    }

    public static function get_link_cv($id_user)
    {
        $employee = new Employee();
        $employee = $employee->where('user_id', $id_user)->value('file_cv');
        return $employee;
    }

    public static function getEmployee_ids($id_user)
    {
        $employee = new Employee();
        $employee = $employee->select('*')->where('user_id', $id_user)->first();
        return $employee;
    }

    public static function getIdEmployee($employee_id)
    {
        $employee = new Employee();
        $employee = $employee->select('employee_id', 'user_id', 'employee_name', 'employee_image', 'phone', 'email', 'province', 'district')->where('employee_id', $employee_id)->first();
        return $employee;
    }

    public static function get_detail_id($employee_id)
    {
        $employee = new Employee();
        $employee = $employee->select('*')->where('employee_id', $employee_id)->first();
        return $employee;
    }

    public static function get_submit_employee_job($job_id, $status_job)
    {
        $employee = new Employee();
        $employee = $employee->select(
            'employees.employee_id',
            'employees.user_id',
            'employees.employee_name',
            'employees.address',
            'employees.province',
            'employees.district',
            'employee_submit_job_facebook.id_job_fb',
            'employee_submit_job_facebook.status_job',
            'employee_submit_job_facebook.employee_id',
            'employee_submit_job_facebook.id_status_submit_job')
            ->rightJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.employee_id', '=', 'employees.employee_id')
            ->where('employee_submit_job_facebook.id_job_fb', $job_id)
            ->where('employee_submit_job_facebook.status_job', $status_job)
            ->get();
        return $employee;
    }

    public static function get_employee_id_Profile($employee_id)
    {
//        $employee_model = new Employee();
//        $employee = $employee_model->select('*')
//            ->where('employee_id', $employee_id)->first();
//        $profile = 20;
//        if (!empty($employee['employee_image'])) {
//            $profile = $profile + 2;
//        }
//        if (!empty($employee['address'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['salary_id'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['employee_level_id'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['experience_id'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['information_verifier'])) {
//            $profile = $profile + 1;
//        }
//        if (isset($employee['gender'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['my_facebook'])) {
//            $profile = $profile + 1;
//        }
//        if (isset($employee['marry'])) {
//            $profile = $profile + 1;
//        }
//
//        $check_status_account = User::where('id', $employee)->where('status_email_account', 1)->count();
//        if (!empty($check_status_account)) {
//            $profile = $profile + 10;
//        }
//        $check_cv = Cv_employee::where('employee_id', $employee->employee_id)->count();
//        if (!empty($check_cv)) {
//            $profile = $profile + 50;
//        }
//        $check_syll = Employee_curriculum::where('employee_id', $employee->employee_id)->count();
//        if (!empty($check_syll)) {
//            $profile = $profile + 10;
//        }
//
//        $update = $employee_model->where('user_id', $employee->user_id)->update([
//            'profile' => $profile
//        ]);
        return true;
    }

    public static function get_user_id_Profile($user_id)
    {
//        $employee_model = new Employee();
//        $employee = $employee_model->select('*')
//            ->where('user_id', $user_id)->first();
//        $profile = 20;
//        if (!empty($employee['employee_image'])) {
//            $profile = $profile + 2;
//        }
//        if (!empty($employee['time_to_work'])) {
//            $profile = $profile + 2;
//        }
//        if (!empty($employee['address'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['salary_id'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['employee_level_id'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['birthday'])) {
//            $profile = $profile + 1;
//        }
//        if (!empty($employee['gender'])) {
//            $profile = $profile + 1;
//        }
//        if (isset($employee['marry'])) {
//            $profile = $profile + 1;
//        }
//
//        $check_status_account = User::where('id', $user_id)->where('status_email_account', 1)->count();
//        if (!empty($check_status_account)) {
//            $profile = $profile + 10;
//        }
//        $check_cv = Cv_employee::where('employee_id', $employee->employee_id)->count();
//        if (!empty($check_cv)) {
//            $profile = $profile + 50;
//        }
//        $check_syll = Employee_curriculum::where('employee_id', $employee->employee_id)->count();
//        if (!empty($check_syll)) {
//            $profile = $profile + 10;
//        }
//
//        $update = $employee_model->where('user_id', $user_id)->update([
//            'profile' => $profile
//        ]);
        return true;
    }

    public static function get_total_career_province_id($province, $district, $array_career, $array_salary)
    {
        $employee = new Employee();
        $total = $employee->select('province', 'district', 'career_category_id', 'salary_id');
        if (!empty($province)) {
            $total = $total->where('province', $province);
        }
        if (!empty($district)) {
            $total = $total->where('district', $district);
        }
        if (!empty($array_career)) {
            $total = $total->where('career_category_id', $array_career);
        }
        if (!empty($array_salary)) {
            $total = $total->where('salary_id', $array_salary);
        }
        $total = $total->count();
        return $total;
    }

    public static function get_total_frofile($province, $district, $profile)
    {
        $employee = new Employee();
        $total = $employee->select('province', 'district', 'career_category_id', 'salary_id');
        if (!empty($province)) {
            $total = $total->where('province', $province);
        }
        if (!empty($district)) {
            $total = $total->where('district', $district);
        }
        if ($profile) {
            $array_profile = explode(",", $profile);
            $total = $total->whereBetween('profile', [$array_profile[0], $array_profile[1]]);
        }
        $total = $total->count();
        return $total;
    }

    public static function get_total_status($province, $district, $status)
    {
        $employee = new Employee();
        $total = $employee->select('province', 'district', 'status');
        if (!empty($province)) {
            $total = $total->where('province', $province);
        }
        if (!empty($district)) {
            $total = $total->where('district', $district);
        }
        if (isset($status)) {
            $total = $total->where('status', $status);
        }
        $total = $total->count();
        return $total;
    }

    public static function get_total_province($province)
    {
        $employee = new Employee();
        $total = $employee->select('province');
        $total = $total->where('province', $province);
        $total = $total->count();
        return $total;
    }

    public static function get_total_career_id($career_category_id)
    {
        $employee = new Employee();
        $total = $employee->select('career_category_id');
        $total = $total->where('career_category_id', $career_category_id);
        $total = $total->count();
        return $total;
    }

    public static function get_count()
    {
        $employee = new Employee();
        $total = $employee->count();
        return $total;
    }

    public static function get_profile($id)
    {
        $employee = new Employee();
        $emplo = $employee->select('user_id', 'profile')->where('user_id', $id)->first();
        return $emplo;
    }

    public static function check_info_profile($user_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->where('user_id', $user_id)->first();
        $check_info_profile = 0;
        if (!empty($employee['employee_image'])) {
            $check_info_profile = $check_info_profile + 2;
        }
        if (!empty($employee['time_to_work'])) {
            $check_info_profile = $check_info_profile + 2;
        }
        if (!empty($employee['address'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        if (!empty($employee['salary_id'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        if (!empty($employee['employee_level_id'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        if (!empty($employee['birthday'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        if (!empty($employee['gender'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        if (isset($employee['marry'])) {
            $check_info_profile = $check_info_profile + 1;
        }
        $check_info = '';
        if ($check_info_profile >= 10) {
            $check_info = 1;
        }
        return $check_info;
    }

    public static function total_info_profile($user_id)
    {
//        //ti le hoan thien hồ sơ lấy trên 10
//        $employee_model = new Employee();
//        $employee = $employee_model->select('*')
//            ->where('user_id', $user_id)->first();
//        $check_info_profile = 0;
//        if (!empty($employee['employee_image'])) {
//            $check_info_profile = $check_info_profile + 20;
//        }
//        if (!empty($employee['time_to_work'])) {
//            $check_info_profile = $check_info_profile + 20;
//        }
//        if (!empty($employee['address'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        if (!empty($employee['salary_id'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        if (!empty($employee['employee_level_id'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        if (!empty($employee['birthday'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        if (!empty($employee['gender'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        if (isset($employee['marry'])) {
//            $check_info_profile = $check_info_profile + 10;
//        }
//        return $check_info_profile;
    }

    public static function get_syll_employee($employee_id)
    {
        $employee = new Employee();
        $emplo = $employee->select('employee_id', 'profile', 'show_hidden_syll')->where('employee_id', $employee_id)->first();
        return $emplo;

    }

    public static function get_total_time_word($province, $district, $time_to_work)
    {
        $employee = new Employee();
        $date_home = date_create();
        $date_home_year = date_format($date_home, "Y");

        $time_ex = $date_home_year - $time_to_work;
        $list_employee = $employee->select('employee_id', 'time_to_work', 'province', 'district');
//            echo $time_ex;die();
        if (!empty($province)) {
            $list_employee = $list_employee->where('province', $province);
        }
        if (!empty($district)) {
            $list_employee = $list_employee->where('district', $district);
        }
        if ($time_to_work >= 6) {
            $list_employee = $list_employee->where('time_to_work', '<=', $time_ex);
            $list_employee = $list_employee->where('time_to_work', '>', 0);
        } else {
            $list_employee = $list_employee->where('time_to_work', '=', $time_ex);
            $list_employee = $list_employee->where('time_to_work', '>', 0);
        }
        $list_employee = $list_employee->count();
        return $list_employee;
    }


    public function get_profile_employee_new($user_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->where('user_id', $user_id)->first();
        $status_email_account = User::where('id', $user_id)->value('status_email_account');
        $profile = 0;
        //thông tin hồ sơ khoảng 20 điểm
        $profile_info = $this->get_profile_info($user_id);
        //thông tin cv khoảng 40 điểm
        $profile_cv = $this->get_profile_cv($user_id);
        //nhân viên sàn kế toán đánh giá 15 điểm
        $profile_staff = $this->get_staff_rating($user_id);
        //10 điểm đánh giá quay lại(cái này lúc nào show ra thì so sanh với thời gian hiện tai)
        //tham giá khóa học được thêm 10 điểm
        $profile_course = $this->get_profile_course($user_id);
        //điểm trung bình nhà tuyển dụng đánh giá khoảng 5 điểm
        $profile_avg = $this->get_profile_rating_employee($user_id);

        $profile = $profile_info + $profile_cv + $profile_staff + $profile_course + $profile_avg;

        $employee_profile = Employee_profile::select('*')
            ->where('employee_id', $employee->employee_id)
            ->first();
        if (empty($employee_profile)) {
            $insert = Employee_profile::insert([
                'employee_id' => $employee->employee_id,
                'profile_info' => $profile_info,
                'profile_cv' => $profile_cv,
                'profile_staff' => $profile_staff,
                'profile_course' => $profile_course,
                'profile_avg' => $profile_avg,
                'created_at' => new \DateTime()

            ]);
        } else {
            $profile_update = $employee->profile - ($employee_profile->profile_info) + $profile;
            $update_profile = Employee_profile::where('employee_id', $employee->employee_id)
                ->update([
                    'profile_info' => $profile_info,
                    'profile_cv' => $profile_cv,
                    'profile_staff' => $profile_staff,
                    'profile_course' => $profile_course,
                    'profile_avg' => $profile_avg,
                    'updated_at' => new \DateTime()
                ]);
        }
        return $profile;
//        return $check_info;
    }

    public static function get_profile_info($user_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->where('user_id', $user_id)->first();
        $profile = 0;
        if (!empty($employee)) {
            $status_email_account = User::where('id', $user_id)->value('status_email_account');
            if (!empty($status_email_account)) {
                $profile = $profile + 5;
            }
            if (!empty($employee['employee_name'])) {
                $profile = $profile + 2;
            }
            if (!empty($employee['employee_image'])) {
                $profile = $profile + 2;
            }
            if (!empty($employee['phone'])) {
                $profile = $profile + 2;
            }
            if (!empty($employee['email'])) {
                $profile = $profile + 2;
            }
            if (!empty($employee['address'])) {
                $profile = $profile + 1;
            }
            if (!empty($employee['salary_id'])) {
                $profile = $profile + 1;
            }
        }
        //check chon cong việc
        $check_carre = Employee_career_categories::where('employee_id', $employee->employee_id)->count();
        $check_district = Employee_district::where('employee_id', $employee->employee_id)->count();
        $check_business = Employee_business_type::where('employee_id', $employee->employee_id)->count();
        if (!empty($check_carre)) {
            $profile = $profile + 1;
        }
        if (!empty($check_district)) {
            $profile = $profile + 2;
        }
        if (!empty($check_business)) {
            $profile = $profile + 2;
        }
//        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
//        if(!empty($employee_profile->profile_cv))
//        {
//            $profile = $profile + 40;
//        }
        return $profile;
    }

    public function get_profile_cv($user_id)
    {
        $employee_model = new Employee();
        $employee_id = $employee_model->where('user_id', $user_id)->value('employee_id');
        $profile = 0;
        if (!empty($employee_id)) {
            $check_active_employee = Cv_employee::where('employee_id', $employee_id)
                ->first();
            if (!empty($check_active_employee)) {
                $profile = 40;
            }
        }
        return $profile;
    }

    public static function check_profile_cv($user_id)
    {
        $employee_model = new Employee();
        $employee_id = $employee_model->select('employee_id', 'profile')->where('user_id', $user_id)->value('employee_id');

        $cv_employee = Cv_employee::where('employee_id', $employee_id)->first();
        $check_employee = Cv_employee::where('employee_id', $employee_id)->count();
        if (empty($check_employee)) {
            return 0;
        }
        $profile = 20;
        //bên trái = 5
        $career_goal = !empty($cv_employee->cv_career_goal) ? 1 : 0;
        $prize = !empty($cv_employee->cv_prize) ? 1 : 0;
        $card = !empty($cv_employee->cv_card) ? 1 : 0;
        $interests = !empty($cv_employee->cv_interests) ? 1 : 0;

        $cv_skills = Cv_skills::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $skills = 0;
        if (!empty($cv_skills->cv_skill_title) || !empty($cv_skills->cv_skill_value)) {
            $skills = 1;
        }
        // bên phải  = 15
        $cv_experience = Cv_experience::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $experience = 0;
        if (!empty($cv_experience->cv_ex_title) || !empty($cv_experience->cv_ex_name) || !empty($cv_experience->cv_ex_desc)) {
            $experience = 5;
        }
        $cv_specialize = Cv_specialize::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $specialize = 0;
        if (!empty($cv_specialize->cv_spec_title) || !empty($cv_specialize->cv_spec_name) || !empty($cv_specialize->cv_spec_desc)) {
            $specialize = 5;
        }
        $cv_work = Cv_work::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $work = 0;
        if (!empty($cv_work->cv_work_title) || !empty($cv_work->cv_work_name) || !empty($cv_work->cv_work_desc)) {
            $work = 2;
        }
        $cv_project = Cv_project::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $project = 0;
        if (!empty($cv_project->cv_project_title) || !empty($cv_project->cv_project_name) || !empty($cv_project->cv_project_des)) {
            $project = 2;
        }

        $cv_info = Cv_info::where('cv_id', $cv_employee->cv_id)->orderBy('cv_id', 'asc')->first();
        $info = 0;
        if (!empty($cv_info->cv_info_title) || !empty($cv_info->cv_info_name) || !empty($cv_info->cv_info_des)) {
            $info = 1;
        }
        $profile_cv = $profile + $career_goal + $prize + $card + $interests + $skills + $experience + $specialize + $work + $project + $info;
        return $profile_cv;
    }

    //đánh giá do nhân viên sanketoan cho điểm
    public function get_staff_rating($user_id)
    {
        $employee_model = new Employee();
        $employee_id = $employee_model->where('user_id', $user_id)->value('employee_id');
        $profile = 0;
        if (!empty($employee_id)) {
            $coin_employee = Interactive_history_employee::select('coin')
                ->where('employee_id', $employee_id)
                ->orderBy('id', 'desc')
                ->first();
            if (!empty($coin_employee)) {
                $profile = $coin_employee->coin;
            }
        }
        return $profile;
    }

    //nếu ứng viên tham gia khóa học thì cộng thêm điểm 10
    public function get_profile_course($user_id)
    {
        $employee_model = new Employee();
        $employee_id = $employee_model->where('user_id', $user_id)->value('employee_id');
        $profile = 0;
        if (!empty($employee_id)) {
            $check_active_course = Course_employee::where('employee_id', $employee_id)
                ->first();
            if (!empty($check_active_course)) {
                $profile = 10;
            }
        }
        return $profile;
    }

    public function get_profile_rating_employee($user_id)
    {
        $employee_model = new Employee();
        $employee_id = $employee_model->where('user_id', $user_id)->value('employee_id');
        $profile = 0;
        if (!empty($employee_id)) {
            $employer_rating_model = new Employer_rating_employee();
            $employer_rating = $employer_rating_model->where('employee_id', $employee_id)->first();
            if (!empty($employer_rating)) {
                $profile = $employer_rating_model->where('employee_id', $employee_id)->avg('rating_start');
            }
        }
        return $profile;
    }

    //30 ngày quay lại cập nhật hồ sơ thì cộng thêm 10
    public static function get_profile_update_at($user_id)
    {
        $employee_model = new Employee();
        $employee = $employee_model->where('user_id', $user_id)->first();

        $date_update = date_create($employee->updated_at);
        $date = date($date_update, "Y/m/d");
        $newdate = strtotime('+1 month', strtotime($date));
        $newdate = date('Y-m-j', $newdate);
        return $newdate;
    }

    public static function getTotal0To20()
    {
        $total = Employee::whereBetween('employees.profile', [0, 20])->where('employees.status_employee', 0)->pluck('employee_id')->toArray();
        return count($total);
    }


    public static function getTotal20To40()
    {
        $total = Employee::whereBetween('employees.profile', [20, 40])->where('employees.status_employee', 0)->pluck('employee_id')->toArray();
        return count($total);
    }

    public static function getTotal40To60()
    {
        $total = Employee::whereBetween('employees.profile', [40, 60])->where('employees.status_employee', 0)->pluck('employee_id')->toArray();
        return count($total);
    }

    public static function getTotal60ToMax()
    {
        $total = Employee::where('employees.profile', '>=', 60)->where('employees.status_employee', 0)->pluck('employee_id')->toArray();
        return count($total);
    }

    public static function getTotalEmployee()
    {
        $total = Employee::pluck('employee_id')->toArray();

        if (empty($total)) {
            $total = 0;
        }
        return count($total);
    }

    public static function getTotalEmployeeApproved()
    {
        $total = Employee::where('employees.status_employee', 1)->pluck('employee_id')->toArray();

        if (empty($total)) {
            $total = 0;
        }
        return count($total);
    }

    public static function getTotalEmployeeNoApproved()
    {
        $total = Employee::where('employees.status_employee', 0)->pluck('employee_id')->toArray();

        if (empty($total)) {
            $total = 0;
        }
        return count($total);
    }

    // check xem ung vien da xacc thuc tai khoanr chua
    public static function checkEmployeeCertain($employee_id)
    {
        $user_id = Employee::where('employee_id', $employee_id)->value('user_id');
        $user = User::findOrFail($user_id);
        if ($user->status_email_account == 1) {
            return true;
        }
        return false;
    }
    public static function get_employee($count)
    {
        $employees = new Employee();
        //sap xep theo so tien
        $list_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.profile',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.status_employee', 1)
            ->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->orderBy('employees.updated_at', 'desc')
            ->limit($count)
            ->get();
        return $list_employee;
    }
}
