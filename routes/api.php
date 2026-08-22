<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['namespace' => 'Api'], function () {
    // Đăng nhập

//    dung cho website vệ tinh
    Route::post('/login', 'LoginController@index');

    // Thông tin tài khoản
    Route::get('/infor-user', 'LoginController@getAuthUser');
    Route::get('/check-user', 'LoginController@checkAuthUser');

    // Lấy tất cả các công việc
    Route::get('/cong-viec', 'JobController@getAllJob');

    // Lấy chi tiết công việc
    Route::get('/chi-tiet-cong-viec/{jobID}', 'JobController@detailJob');

    // Lấy thông tin nhà tuyển dụng
    Route::get('/thong-tin-ntd', 'EmployerController@inforEmployer');

    // Lấy tất cả các tỉnh thành, lương
    Route::get('/tinh-thanh', 'JobController@getAllProvince');
    Route::get('/luong', 'JobController@getAllSalary');

    // Thông tin ứng viên


    // Tìm kiếm công việc
    // Route::get('/tim-kiem-cong-viec','JobController@search');

    // Quản lý công việc của NTD (Có thể dùng để mời ứng viên)
    //Route::get('/moi-ung-vien','EmployerController@invite');

    // Quản lý ứng viên đã mời
    //Route::get('/ung-vien-da-moi','EmployerController@invited_candidates');


    Route::get('/danh-sach-kho-tai-lieu', 'VoucherController@show_voucher');
    Route::get('/cong-thuc-tap', 'EmployerController@list_intership');

//jobs công việc đã kiểm duyệt api cho 2 website ve tinh
    Route::get('web/viec-lam-da-kiem-duyet/{limit}', 'JobsController@web_category_jobs');
    Route::get('web/danh-sach-ung-vien/{limit}', 'EmployeeController@web_list_employee');

//    dung cho app
//    api sanketoan/

    //dang ki
//    Route::get('/thong-tin-ung-vien', 'EmployeeController@editEmployee');
    Route::get('/thong-bao/yeu-cau-cap-nhap-ho-so', 'EmployeeController@noti_updateEmployee');

//    Route::post('/cap-nhat-thong-tin-ung-vien', 'EmployeeController@updateEmployee');


    //check token luc đăng nhập

    Route::get('/chi-tiet-ung-vien/{employee_id}', 'EmployeeController@detail_employee');
    Route::post('/dang-ky-nha-tuyen-dung', 'EmployerController@create_employer');

    Route::get('/ma-so-thue/{tax_code}', 'EmployeeController@tax_code');
    Route::post('/dang-ky-ung-vien', 'EmployeeController@create_employee');
    Route::post('/quen-mat-khau', 'RegisterController@send_email_password');






    Route::post('/xoa-thong-bao/cong-viec-moi-mong-muon', 'NotiCareerCategoryIdController@delete_noti_post');

    Route::get('/thong-bao/danh-sach-cong-viec-moi-mong-muon', 'NotiCareerCategoryIdController@list_noti_carrer');
    Route::get('/thong-bao/cong-viec-moi-mong-muon', 'NotiCareerCategoryIdController@noti_carrer');
    Route::get('/thong-bao/ung-vien-nop-ho-so-nha-tuyen-dung', 'NotificationEmployerController@noti_job');
    Route::get('/thong-bao/danh-sach-ung-vien-nop-ho-so-nha-tuyen-dung', 'NotificationEmployerController@list_noti_job');
    Route::get('/cap-nhat-thong-bao/ung-vien-nop-ho-so-nha-tuyen-dung/{noti_id}', 'NotificationEmployerController@update_view_noti');

    //thông báo trên sanketoan.vn -11-8-2022
    Route::get('/thong-bao/tin-tuc-moi', 'NotificationPostController@list_noti_post');
    Route::get('/thong-bao/viec-lam', 'NotificationEmployerController@list_noti_employer_job');
    Route::post('cap-nhat/thong-bao-da-xem', 'NotificationEmployerController@update_user_noti');

    //check thời gian user đã xem thông báo
    Route::get('/thong-bao/xem-thong-bao', 'NotificationEmployerController@user_noti_date');
    Route::get('/thong-bao/check-thong-bao', 'NotificationEmployerController@check_user_noti');
    Route::get('/thong-bao/lay-danh-sach-podcast', 'NotificationEmployerController@list_podcast');
    Route::get('/thong-bao/xoa-thong-bao', 'NotificationEmployerController@delete_noti');

    Route::post('/xoa-thong-bao/ung-vien-nop-ho-so', 'NotificationEmployerController@delete_noti_job');
    Route::post('post_token', 'NotificationMobileController@post_token');
    Route::get('test-thong-bao', 'NotificationMobileController@testPushNotification');
    Route::get('tin-tuc/{slug_post}', 'PostController@getPost');
    Route::get('danh-muc/{slug}', 'PostController@getCategory');
//    Route::get('danh-muc/{slug}','PostController@getCategory');

//    APi kế toán thuế

    Route::get('/chuyen-tai-khoan-qua-api/chia-se-ung-vien', 'Employee_saleController@copy_employee_to_sanketoan')->name('copy_employee_to_sanketoan');
    Route::get('/get-thong-tin/ung-vien/{employee_id}', 'EmployeeController@get_info_employee')->name('get_info_employee');
//    Route::get('/tim-kiem-thanh-pho/{province_name}','ProvinceController@search_province');
//    Route::get('/danh-sach-quan-huyen','DistrictController@list_district');
//    Route::get('/tim-kiem-quan-huyen/{distrcit_name}','DistrictController@search_district');
//    Route::get('/tim-kiem-quan-huyen-theo-thanh-pho/{pronvice_id}/{distrcit_name}','DistrictController@search_district_province');

    Route::post('giao-vien/dang-nhap', 'TeacherController@loginTeacher');
    Route::get('thong-tin-giao-vien-dang-nhap/{user_id}', 'TeacherController@getInfoTeacher');

    Route::get('giao-vien/{local_area}', 'TeacherController@getListTeacher');
    Route::get('chi-tiet-giao-vien/{slug_teacher}', 'TeacherController@getDetail');
    Route::get('tim-kiem-giao-vien', 'TeacherController@searchTeacher');

    Route::get('linh-vuc-doanh-nghiep', 'TypeOfBusinessController@getType');


//  api  chuyển tài khoản giáo viên từ sanketoan sang ketoanthue
//  api lấy thông tin giáo viên

    Route::get('tai-khoan-giao-vien/{user_id}', 'TeacherController@getAcount');
    Route::get('thong-tin-giao-vien/{teacher_id}', 'TeacherController@getInfo');
    Route::get('trinh-do-giao-vien/{teacher_id}', 'TeacherController@getSpecialize');
    Route::get('kinh-nghiem-giao-vien/{teacher_id}', 'TeacherController@getExperience');
    Route::get('trang-thai-giao-vien/{teacher_id}', 'TeacherController@getAcouting');

    Route::post('update_agency', 'List_teacher_agencyController@update_teacher_agency');


    //api bo sung
    Route::get('/danh-sach-tinh-thanh-pho', 'ProvinceController@list_province');
    Route::get('/danh-sach-quan-huyen-theo-thanh-pho/{pronvice_id}', 'DistrictController@list_district_province');
    Route::get('/danh-sach-cong-viec-can-tim', 'CareerController@list_carrer_category'); //vi tri cong viec
    Route::get('/tim-kiem-cong-viec-can-tim/{carrer_category_name}', 'CareerController@search_carrer_category');

    Route::get('/tim-kiem-thanh-pho/{province_name}', 'ProvinceController@search_province');
    Route::get('/danh-sach-quan-huyen', 'DistrictController@list_district');
    Route::get('/tim-kiem-quan-huyen/{distrcit_name}', 'DistrictController@search_district');
    Route::get('/tim-kiem-quan-huyen-theo-thanh-pho/{pronvice_id}/{distrcit_name}', 'DistrictController@search_district_province');
    Route::get('/danh-sach-muc-luong', 'SalaryController@list_salary');
    Route::get('/danh-sach-kinh-nghiem', 'ExperienceController@list_experience');
    Route::get('/danh-sach-trinh-do', 'LiteracyController@list_literacy');
    Route::get('/loai-hinh-doanh-nghiep', 'LiteracyController@list_type_of_business_id');
    Route::get('/linh-vuc-kinh-doanh', 'LiteracyController@list_business');
    Route::get('/danh-sach-diem-ho-so', 'LiteracyController@list_profile');
    Route::get('/trang-thai-lam-viec', 'LiteracyController@list_status');
    Route::get('/kinh-nghiem-ung-vien', 'LiteracyController@list_time_to_work');
    //employer_select_response
    Route::get('/danh-sach-phan-hoi-cua-ung-vien', 'LiteracyController@list_employer_select_response');

    //dang nhap
    Route::post('/dang-nhap', 'LoginController@login');
    Route::get('/dang-nhap-san-dev', 'LoginController@login_sandev');

    Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
    Route::get('/callback/{provider}', 'SocialController@callback');

    Route::get('/dang-xuat', 'LoginController@logout');

    //gui mã xac thuc otp
    Route::post('gui-ma-otp', 'EmployeeController@send_otp');
    //nhap ma xac thuc otp
    Route::post('dang-ky-tai-khoan', 'ResgisterController@resgister_account');
    Route::post('chon-tai-khoan', 'ResgisterController@select_option_user');
    Route::get('thong-tin-nha-tuyen-dung', 'EmployerController@get_info_employer_user');
    Route::get('chi-tiet-nha-tuyen-dung/{employer_slug}', 'EmployerController@detail_employer_jobs');
    Route::post('cap-nhat-thong-tin-nha-tuyen-dung', 'EmployerController@update_employer_user');
    Route::get('thong-tin-ung-vien', 'EmployeeController@get_info_employee_user');
    Route::post('cap-nhat-thong-tin-ung-vien', 'EmployeeController@update_employee_user');
    Route::post('cap-nhat-thong-tin-cv', 'EmployeeController@update_employee_cv');

    Route::post('/quen-mat-khau', 'RegisterController@send_email_password');
    Route::post('/doi-mat-khau', 'RegisterController@update_password');


    //việc làm tab ung vien
    //jobs công việc đã kiểm duyệt
    Route::get('/viec-lam-da-kiem-duyet/{slug}', 'JobsController@jobs_detail');
    //luu hồ sơ
    Route::get('/viec-lam-da-luu', 'JobsController@list_save_jobs');
    //nop ho sơ
    Route::get('/ung-vien-ung-tuyen/{job_id}/{status}', 'EmployeeController@submitEmployee');
    Route::post('/ung-vien/luu-viec-lam', 'EmployeeController@employee_save_jobs');
    Route::post('/ung-vien/huy-luu-viec-lam', 'EmployeeController@remove_employee_save_jobs');

    Route::get('/viec-lam-da-kiem-duyet', 'JobsController@category_jobs');
    Route::get('/tim-kiem-viec-lam-da-kiem-duyet', 'JobsController@search_jobs');

    Route::get('/viec-lam-chua-kiem-duyet/{slug}', 'JobFaceBookController@job_facebook_detail');
    Route::get('/viec-lam-chua-kiem-duyet', 'JobFaceBookController@category_job_facebook');
    Route::get('/tim-kiem-viec-lam-chua-kiem-duyet', 'JobFaceBookController@search_job_facebook');
    //them moi viec làm

//    danh cho ntd
    Route::get('/viec-lam-da-dang', 'JobsController@list_employer_jobs');
    Route::post('/them-moi-viec-lam-da-kiem-duyet', 'JobsController@create_jobs');
    Route::get('/sua-viec-lam/{job_id}', 'JobsController@detail_jobs');
    Route::get('/danh-sach-ung-vien-nop-ho-so/{job_id}', 'JobsController@list_Job_Candidate_Employee');
    Route::post('/cap-nhat-viec-lam', 'JobsController@update_jobs');
    Route::post('/day-tin-viec-lam', 'JobsController@update_dealine_jobs');
    Route::post('/xoa-viec-lam', 'JobsController@delete_jobs');
    Route::get('/trang-thai-ung-vien', 'JobsController@list_status_employee');
    Route::post('/cap-nhat-trang-thai-ung-vien', 'JobsController@update_id_status_job');

    Route::get('/viec-lam-da-nop-ho-so', 'JobUserSubmitController@get_job_file_submit');



    //ứng viên
    Route::get('/danh-sach-ung-vien', 'EmployeeController@list_employee');
    Route::get('/tim-kiem-ung-vien', 'EmployeeController@search_employee');
    Route::get('/chi-tiet-ung-vien/{employee_id}', 'EmployeeController@detail_employee');
    Route::get('/chi-tiet-ung-vien-da-ung-tuyen/{employee_id}', 'EmployeeController@detail_employee_submit');
    Route::post('/xem-ho-so-day-du', 'EmployeeController@show_info_detail_employee');
    Route::post('/bao-cao-thong-tin-sai', 'EmployeeController@report_info_employee');





    //cau hoi trac nghiem

    Route::get('/loai-hinh-doanh-nghiep-trac-nghiem', 'LiteracyController@list_type_of_business_id_exam');

    Route::get('/danh-sach-cong-viec-can-tim-trac-nghiem', 'CareerController@list_carrer_category_exam'); //vi tri cong viec


    Route::get('/danh-sach-de-thi', 'ExamController@list_exam');
    Route::get('/tim-kiem-de-thi', 'ExamController@search_exam');
    Route::get('/chi-tiet-de-thi/{id_exam}', 'ExamController@detail_exam');
    Route::get('/bat-dau-lam-bai/{id_exam}', 'ExamController@list_question_exam');
    Route::post('/nop-bai-trac-nghiem', 'ExamController@submit_question_exam');
    Route::get('/xem-ket-qua-bai-thi/{id_result}', 'ExamController@list_correct_answer_question');



//    more/bang-gia
    Route::get('/danh-sach-bang-gia', 'ListPriceController@list_price');
    Route::get('/chi-tiet-bang-gia/{service_id}', 'ListPriceController@detail_list_price');
    Route::post('/dat-mua-dich-vu', 'ListPriceController@pay_employer_price');

    Route::get('/more/ung-vien-da-xem', 'EmployerController@list_coin_user_show_employee');
    Route::get('/more/ung-vien-da-ung-tuyen', 'EmployerController@list_coin_user_show_employee');
    Route::post('/more/tao-cv', 'EmployeeController@more_update_cv');


    Route::get('/more/thong-tin-ung-vien', 'EmployeeController@more_detail_employee');
    Route::post('/more/cap-nhat-tai-khoan-ung-vien', 'EmployeeController@more_update_employee');
    Route::post('/more/cap-nhat-trang-thai-ung-vien', 'EmployeeController@more_status_employee');

    Route::post('/more/cap-nhat-trang-thai-lam-viec-ung-vien', 'EmployeeController@status_employee');

    Route::post('/more/xoa-tai-khoan', 'EmployeeController@delete_user');

});
?>