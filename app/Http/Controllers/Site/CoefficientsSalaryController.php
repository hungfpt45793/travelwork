<?php

namespace App\Http\Controllers\Site;

use App\Course\Category_course;
use App\Course\Course_feedback;
use App\Course\Courses;
use App\Entity\Business;
use App\Entity\Career;
use App\Entity\Category;
use App\Entity\Certificate;
use App\Entity\Coefficients_exp;
use App\Entity\Coefficients_salary;
use App\Entity\CommitCompany;
use App\Entity\Experience_business;
use App\Entity\Experience_postion;
use App\Entity\Input;
use App\Entity\LanguageLiteracy;
use App\Entity\Literacy;
use App\Entity\Office_information;
use App\Entity\Post;
use App\Entity\Province;
use App\Entity\SoftSkills;
use App\Entity\Software;
use App\Entity\TypeOfBusiness;
use App\Entity\WorkPressure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class CoefficientsSalaryController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($cate_slug, $slug_post)
    {
        $post = $this->getPostDetail($slug_post);
        if (empty($post)) {
            return redirect(route('home'));
        }
        $category = $this->getCategory($post);
        return view('site.default_site.single', compact('post', 'category', 'cate_slug'));
    }

    public function get_all_coe()
    {
        return view('site.default_site.get_all_coe', compact('post', 'category', 'cate_slug'));
    }

    public function post_sum_coe(Request $request)
    {
        $coe_model = new Coefficients_salary();
        $province_id = !empty($request->input('province_id')) ? $request->input('province_id') : 0;
        $province_salary = Province::where('province_id', !empty($province_id) ? $province_id : 0)->value('province_salary');

        $career_category_id = !empty($request->input('career_category_id')) ? $request->input('career_category_id') : 0;
        $career_category_salary = Career::where('career_category_id', !empty($career_category_id) ? $career_category_id : 0)->value('career_category_salary');
        $career_category_salary = !empty($career_category_salary) ? $career_category_salary : 0;

        $type_of_business_id = !empty($request->input('type_of_business_id')) ? $request->input('type_of_business_id') : 0;
        $type_of_business_salary = TypeOfBusiness::where('type_of_business_id', !empty($type_of_business_id) ? $type_of_business_id : 0)->value('type_of_business_salary');
        $type_of_business_salary = !empty($type_of_business_salary) ? $type_of_business_salary : 0;

        $business_type_id = !empty($request->input('business_type_id')) ? $request->input('business_type_id') : 0;
        $business_type_salary = Business::where('business_type_id', !empty($business_type_id) ? $business_type_id : 0)->value('business_type_salary');
        $business_type_salary = !empty($business_type_salary) ? $business_type_salary : 0;

        $literacy_id = !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0;
        $literacy_salary = Literacy::where('literacy_id', !empty($literacy_id) ? $literacy_id : 0)->value('literacy_salary');

        $office_id = !empty($request->input('office_id')) ? $request->input('office_id') : 0;
        $office_salary = Office_information::where('office_id', !empty($office_id) ? $office_id : 0)->value('office_salary');
        $office_salary = !empty($office_salary) ? $office_salary : 0;

        $exp_bus_id = !empty($request->input('exp_bus_id')) ? $request->input('exp_bus_id') : 0;
        $exp_bus_salary = Experience_business::where('exp_bus_id', !empty($exp_bus_id) ? $exp_bus_id : 0)->value('exp_bus_salary');
        $exp_bus_salary = !empty($exp_bus_salary) ? $exp_bus_salary : 0;

        $software_id = !empty($request->input('software_id')) ? $request->input('software_id') : 0;
        $software_salary = Software::where('software_id', !empty($software_id) ? $software_id : 0)->value('software_salary');
        $software_salary = !empty($software_salary) ? $software_salary : 0;

        $lang_id = !empty($request->input('lang_id')) ? $request->input('lang_id') : 0;
        $lang_salary = LanguageLiteracy::where('lang_id', !empty($lang_id) ? $lang_id : 0)->value('lang_salary');
        $lang_salary = !empty($lang_salary) ? $lang_salary : 0;

        $soft_id = !empty($request->input('soft_id')) ? $request->input('soft_id') : 0;
        $soft_salary = SoftSkills::where('soft_id', !empty($soft_id) ? $soft_id : 0)->value('soft_salary');
        $soft_salary = !empty($soft_salary) ? $soft_salary : 0;

        $cer_id = !empty($request->input('cer_id')) ? $request->input('cer_id') : 0;
        $cer_salary = Certificate::where('cer_id', !empty($cer_id) ? $cer_id : 0)->value('cer_salary');
        $cer_salary = !empty($cer_salary) ? $cer_salary : 0;

        $work_id = !empty($request->input('work_id')) ? $request->input('work_id') : 0;
        $work_salary = WorkPressure::where('work_id', !empty($work_id) ? $work_id : 0)->value('work_salary');
        $work_salary = !empty($work_salary) ? $work_salary : 0;

        $com_id = !empty($request->input('com_id')) ? $request->input('com_id') : 0;
        $com_salary = CommitCompany::where('com_id', !empty($com_id) ? $com_id : 0)->value('com_salary');
        $com_salary = !empty($com_salary) ? $com_salary : 0;

        $total_salary = $province_salary + $career_category_salary + $type_of_business_salary + $business_type_salary + $literacy_salary + $office_salary + $exp_bus_salary + $software_salary + $lang_salary + $soft_salary + $cer_salary + $work_salary + $com_salary;
//        echo $total_salary;die;
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
        $check_coe = $coe_model->where('ip', $ip)->first();
        if (!empty($check_coe)) {
            $coe_id = $check_coe->coe_id;
            $update = $coe_model->where('ip', $ip)->update([
                'user_id' => !empty(Auth::check()) ? Auth::user()->id : 0,
                'total_salary' => $total_salary,
                'career_category_id' => $career_category_id, //danh mục ngành nghề
                'career_category_salary' => $career_category_salary,
                'type_of_business_id' => $type_of_business_id, //loại hình doanh nghiệp
                'type_of_business_salary' => $type_of_business_salary,
                'business_type_id' => $business_type_id, //	loại hình kinh doanh
                'business_type_salary' => $business_type_salary,
                'literacy_id' => $literacy_id, //trình dodjd học vấn
                'literacy_salary' => $literacy_salary,
                'office_id' => $office_id, //	tin học văn phòng
                'office_salary' => $office_salary,
//            'exp_id', //kinh nghiệm vị trí khác
//            'exp_salary',
                'exp_bus_id' => $exp_bus_id, //	kinh nghiệm loại hình doanh nghiệp
                'exp_bus_salary' => $exp_bus_salary,
                'software_id' => $software_id, //phần mềm kê toán
                'software_salary' => $software_salary,
                'lang_id' => $lang_id, //trình độ ngoại ngữ
                'lang_salary' => $lang_salary,
                'soft_id' => $soft_id, //kỹ năng mềm
                'soft_salary' => $soft_salary,
                'cer_id' => $cer_id, //chứng chỉ nghề nghiệp
                'cer_salary' => $cer_salary,
                'work_id' => $work_id, //khả năng chịu áp lực
                'work_salary' => $work_salary,
                'province_id' => $province_id, //thành phố
                'province_salary' => $province_salary,
                'com_id' => $com_id, //cam kết gắn bó với công ty
                'com_salary' => $com_salary,
                'created_at' => new \DateTime()
            ]);
            //chon nhieu
            $exp_id = $request->input('exp_id');
            if (!empty($exp_id)) {
                $exp_salary = 0;
                //xoa du tri cu
                $delete_exp = Coefficients_exp::where('coe_id',$coe_id)->delete();
                foreach ($exp_id as $ex) {
                    $exp_salary = Experience_postion::where('exp_id', $ex)->value('exp_salary');
                    Coefficients_exp::insert([
                        'coe_id' => $coe_id,
                        'exp_id' => $ex,
                        'exp_salary' => $exp_salary,
                        'created_at' => new \DateTime()
                    ]);
                    $exp_salary += $exp_salary;
                }
                $update_salary = $coe_model->where('coe_id', $coe_id)->update([
                    'total_salary' => $total_salary + $exp_salary,
                ]);
            }

        } else {
            $coe_id = $coe_model->insertGetId([
                'ip' => $ip,
                'user_id' => !empty(Auth::check()) ? Auth::user()->id : 0,
                'total_salary' => $total_salary,
                'career_category_id' => $career_category_id, //danh mục ngành nghề
                'career_category_salary' => $career_category_salary,
                'type_of_business_id' => $type_of_business_id, //loại hình doanh nghiệp
                'type_of_business_salary' => $type_of_business_salary,
                'business_type_id' => $business_type_id, //	loại hình kinh doanh
                'business_type_salary' => $business_type_salary,
                'literacy_id' => $literacy_id, //trình dodjd học vấn
                'literacy_salary' => $literacy_salary,
                'office_id' => $office_id, //	tin học văn phòng
                'office_salary' => $office_salary,
//            'exp_id', //kinh nghiệm vị trí khác
//            'exp_salary',
                'exp_bus_id' => $exp_bus_id, //	kinh nghiệm loại hình doanh nghiệp
                'exp_bus_salary' => $exp_bus_salary,
                'software_id' => $software_id, //phần mềm kê toán
                'software_salary' => $software_salary,
                'lang_id' => $lang_id, //trình độ ngoại ngữ
                'lang_salary' => $lang_salary,
                'soft_id' => $soft_id, //kỹ năng mềm
                'soft_salary' => $soft_salary,
                'cer_id' => $cer_id, //chứng chỉ nghề nghiệp
                'cer_salary' => $cer_salary,
                'work_id' => $work_id, //khả năng chịu áp lực
                'work_salary' => $work_salary,
                'province_id' => $province_id, //thành phố
                'province_salary' => $province_salary,
                'com_id' => $com_id, //cam kết gắn bó với công ty
                'com_salary' => $com_salary,
                'created_at' => new \DateTime()
            ]);
            //chon nhieu
            $exp_id = $request->input('exp_id');
            if (!empty($exp_id)) {
                $exp_salary = 0;
                foreach ($exp_id as $ex) {
                    $exp_salary = Experience_postion::where('exp_id', $ex)->value('exp_salary');
                    Coefficients_exp::insert([
                        'coe_id' => $coe_id,
                        'exp_id' => $ex,
                        'exp_salary' => $exp_salary,
                        'created_at' => new \DateTime()
                    ]);
                    $exp_salary += $exp_salary;
                }
                $update_salary = $coe_model->where('coe_id', $coe_id)->update([
                    'total_salary' => $total_salary + $exp_salary,
                ]);
            }
        }
        $career_category_id = Coefficients_salary::where('coe_id',$coe_id)->value('career_category_id');
        $career_category_slug  = Career::where('career_category_id',$career_category_id)->value('career_category_slug');

        return redirect(route('total_get_all_coe', ['career_category_slug' => $career_category_slug,'coe_id' => $coe_id]));
//        $office_salary = Office_information::where('office_id',!empty($office_id) ? $office_id : 0)->value('office_salary');
    }

    public function total_get_all_coe($career_category_slug,$coe_id)
    {
        $cate_course = new Category_course();
        $course_categorise = $cate_course->select(
            'category_course_id',
            'category_course_title',
            'category_course_slug',
            'category_course_desc'
        )
            ->limit(12)
            ->get();

        $all_cate = [
            'category_course_id' => -1,
            'category_course_title' => 'Tất cả',
            'category_course_slug' => 'tat-ca-khoa-hoc',
            'category_course_desc' => 'tất cả danh mục'
        ];

        $all_course = Courses::getCourse_category_slug($all_cate['category_course_slug']);
        $list_course[$all_cate['category_course_slug']] = $all_course;
        $courseFeedbackModel = new Course_feedback();
        foreach ($course_categorise as $course_cate) {
            $courses = Courses::getCourse_category_slug($course_cate['category_course_slug']);
            $list_course[$course_cate['category_course_slug']] = $courses;
        }

//        return view('site.course_site.list_course', compact('course_categorise', 'all_cate', 'list_course'));

//        echo $coe_id;die();
        $coe_model = new Coefficients_salary();
        $coe = $coe_model->where('coe_id', $coe_id)->first();
        return view('site.default_site.total_get_all_coe', compact('coe', 'course_categorise', 'all_cate', 'list_course','career_category_slug'));

    }

}
