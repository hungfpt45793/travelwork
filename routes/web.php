<?php

use Illuminate\Support\Facades\Route;
use App\Entity\Category_tag;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require('admin.php');
//dang nhap
//require_once('ctv.php');
//require_once('agency.php');
require('staff.php');
require('forum.php');
Route::group(['namespace' => 'Site', 'middleware' => 'HtmlMifier'], function () {
    Route::get('test/quet-luu-cv', 'HomeController@testSaveCv');

    // route Ajax thêm mới từ khóa
    Route::get('them-tu-khoa-ajax','CategoryTagController@them_tu_khoa_ajax')->name('them_tu_khoa_ajax');

    //    Route::get('/', 'HomeController@index')->name('home');
    Route::get('home_site', 'HomeController@home_site')->name('home_site');
    Route::get('home_new', 'HomeController@home_new')->name('home_new');
    Route::get('home_test_login', 'HomeController@home_test_site')->name('home_test_site');


    Route::get('gui-mail', 'HomeController@mail');
    Route::get('home', 'SiteController@home')->name('site_home');

    // lấy danh sách tag bằng file json
    Route::get('autocompleteTag', 'CategoryTagController@autocompleteTag')->name('autocompleteTag');



    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/videotest', 'EmployeeController@videotest')->name('videotest');
    //    Route::get('/hot-deal', 'ProductCategoryController@index');
    //Route::get('/cua-hang/{cate_slug}', 'ProductCategoryController@index')->name('site_category_product');
    Route::get('/nhom-viec-lam/{jobGroupSlug}', 'JobGroupController@index')->name('site_job_group');
    // google map
    Route::get('/map', 'JobGroupController@getMap')->name('view_map');


    Route::get('/tim-kiem', 'ProductCategoryController@search')->name('search_product');
    Route::get('/tim-kiem-ajax', 'ProductCategoryController@searchAjax')->name('search_product_ajax');
    Route::get('rating', 'ProductController@Rating')->name('rating');

    Route::get('/bo-sung/{sub_post_slug}', 'SubPostController@index');
    //show register

    Route::get('/nha-tuyen-dung-dang-ky', 'RegisterController@showEmployerRegistrationForm')->name('employer_register');
    Route::get('/check-ma-so-thue', 'RegisterController@check_tax_code')->name('check_tax_code');
    Route::get('/ung-vien-dang-ky', 'RegisterController@showEmployeeRegistrationForm')->name('employee_register');
    Route::get('/giao-vien-dang-ky', 'RegisterController@showTeacherRegistrationForm')->name('teacher_register');


    //    validate kiem tra email
    Route::get('kiem-tra-email-ung-vien-dang-ky', 'ValidateformController@check_email_employee')->name('check_email_employee');
    Route::get('kiem-tra-ma-sinh-vien', 'ValidateformController@check_student_code')->name('check_student_code');
    Route::get('kiem-tra-mat-khau-phong-thi', 'ValidateformController@check_password')->name('check_password');
    Route::get('kiem-tra-email-nha-tuyen-dung-dang-ky', 'ValidateformController@check_email_employer')->name('check_email_employer');
    Route::get('kiem-tra-email-giao-vien-dang-ky', 'ValidateformController@check_email_teacher')->name('check_email_teacher');


    Route::get('/dang-ky', 'RegisterController@showRegistrationForm')->name('register');
    Route::get('/quen-mat-khau', 'RegisterController@reset_passwrod')->name('reset_passwrod');

    Route::post('/gui-email-ma-xac-thuc', 'RegisterController@send_email')->name('send_email');
    Route::post('/otp-email/doi-mat-khau', 'RegisterController@change_otp_email')->name('change_otp_email');


    Route::post('/thay-doi-dia-chi-email-moi', 'RegisterController@change_email_confirm')->name('change_email_confirm');
    Route::get('/kich-hoat-mat-khau-moi/{link}', 'RegisterController@active_password')->name('active_password');
    Route::post('/dang-ky', 'EmployeeController@createEmployee')->name('createEmployee');

    Route::get('/kich-hoat-tai-khoan-ung-vien/{link}', 'EmployeeController@link_confirm_account')->name('link_confirm_account');

    Route::get('tai-khoan/xac-thuc-email', 'RegisterController@confrirm_email')->name('confrirm_email');
    Route::get('tai-khoan/quan-ly-tai-khoan', 'RegisterController@management_account')->name('management_account');
    //gui bằng ajax kich hoat
    Route::get('tai-khoan/gui-email-kich-hoat-tai-khoan', 'MailConfigController@ajax_send_email_confirm')->name('ajax_send_email_confirm');
    //    giao vien
    Route::post('/dang-ky-giao-vien', 'TeacherController@createTeacher')->name('createTeacher');
    Route::post('/quen-mat-khau', 'PersonController@forgetPassword')->name('forget_password');
    Route::post('/dang-nhap', 'LoginController@login')->name('login_home');
    Route::post('/dang-nhap-kiem-tien', 'LoginController@login_money')->name('login_money');
    Route::get('dang-xuat', 'LoginController@logout');
    Route::get('dang-xuat/tai-khoan', 'LoginController@get_logout')->name('get_logout_page');
    Route::post('dang-xuat', 'LoginController@logout')->name('logoutHome');
    Route::post('dang-xuat/tai-khoan', 'LoginController@get_logout')->name('get_logout');
    Route::get('cblogin', 'LoginController@callbackLogin');

    // Ajax lấy tỉnh thàng
    Route::get('/ajax-district/{province}', 'SearchController@ajaxProvince');
    Route::get('/ajax-district_radio/{province}', 'SearchController@ajaxProvince_radio');
    Route::get('/district-provinces/{province}', 'SearchController@ajaxDistrictSearch');
    // Employder Login
    Route::get('login/google', 'LoginController@redirectToProvider')->name('google_login');
    Route::get('login/google/callback', 'LoginController@handleProviderCallback');
    Route::get('/thong-tin-ca-nhan', 'InfomationController@index')->name('member_infomation');
    Route::post('/thong-tin-ca-nhan', 'PersonController@store');
    Route::get('/doi-mat-khau', 'PersonController@resetPassword')->name('get_reset');
    Route::post('/doi-mat-khau', 'PersonController@storeResetPassword')->name('post_reset');
    Route::get('/don-hang-ca-nhan', 'PersonController@orderPerson')->name('orderPerson');
    //Trang thông tin cá nhân nhà tuyển dụng
    Route::get('/thong-tin-nha-tuyen-dung', 'InfomationController@index')->name('employer_information');
    Route::post('/thong-tin-nha-tuyen-dung', 'InfomationController@store');
    // Trang quản lý thông tin việc làm của nhà tuyển dụng
    Route::get('/{slug}/quan-ly-tin-tuyen-dung', 'InfomationController@jobManagement')->name('job_management');
    // trả về trang tạo job
    Route::get('/create-job', 'InfomationController@showCreateJob')->name('show_create_job');
    Route::post('/create-job', 'InfomationController@createJob')->name('create_job');
    // ntd Mời ứng viên
    //sửa thông tin ntd
    //    Route::post('/edit-employer', 'InfomationController@updateEmployer')->name('update_employer');
    // Sửa job
    Route::get('/cap-nhat-tin-tuyen-dung/{slug}', 'InfomationController@edit')->name('edit_job');
    Route::put('/cap-nhat-tin-tuyen-dung/{slug}', 'InfomationController@update')->name('update_job');
    // Xóa job
    Route::delete('xoa-tin-tuyen-dung/{slug}', 'InfomationController@destroy')->name('delete_job');
    //Add note
    Route::get('note-order/content', 'OrderController@note')->name('add-note-order');

    // ntd quản lý ứng viên
    Route::get('/quan-ly-ung-vien', 'CandidateApplyController@index')->name('show_candidate_apply');
    Route::get('/xoa-ung-vien/{id}', 'CandidateApplyController@delete');
    Route::get('/sua-ung-vien/{id}', 'CandidateApplyController@edit');
    Route::post('/updateApply/{id}', 'CandidateApplyController@update')->name('update_candidate_apply');
    Route::post('/search-candidate', 'CandidateApplyController@search')->name('search_candidate');

    Route::post('/danhgia/{id}', 'CandidateApplyController@evaluate');

    // Quản lý ứng viên đã mời
    Route::get('/{slug}/ung-vien-da-moi', 'EmployerController@employeeManagement')->name('management_employee');
    Route::post('/update-employee', 'EmployeeController@update')->name('update_employee');
    Route::get('cap-nhat/ho-so-ung-vien', 'EmployeeController@update_profile_employee')->name('update_profile_employee');
    //show detail employer

    Route::get('/nha-tuyen-dung/{slug}', 'EmployerController@detailEmployer')->name('detail_employer');
    Route::get('/dai-ly/{slug}', 'EmployerController@detail_agency')->name('detail_agency');

    // Nhà tuyển dụng đã mời ứng viên
    Route::get('/cong-viec-duoc-moi', 'EmployeeController@showJob')->name('job_invited_manage');

    //    Theo dõi tin tư nhà tuyển dụng
    Route::get('theo-doi/tin-tuyen-dung', 'EmployeeController@ajax_employee_follow_employer')->name('ajax_employee_follow_employer');
    Route::get('xoa-theo-doi/tin-tuyen-dung', 'EmployeeController@ajax_delete_employee_follow_employer')->name('ajax_delete_employee_follow_employer');

    Route::get('/ung-tuyen/{jobId}', 'EmployeeController@acceptJob')->name('accept_job');

    //Tim kiếm công việc trang chủ
    Route::get('tim-kiem', 'SearchController@search')->name('search_index');


    Route::get('/cong-viec-da-ung-tuyen', 'EmployeeController@showJobRecruitment')->name('job_recruitment_manage');

    //    Route::get('/moi-ung-vien/{employee}/', 'EmployerController@inviteCandidates')->name('invite_candidate');
    Route::get('/moi-ung-vien', 'InfomationController@showCandidates')->name('show_candidates');
    Route::get('/them-ung-vien-duoc-moi', 'InfomationController@inviteCandidate')->name('invite_candidates');
    Route::delete('/xoa-ung-vien-duoc-moi/{employee}/{job}', 'InfomationController@deleteInvite')->name('delete_invite');

    Route::get('/lien-he', 'ContactController@index')->name('site_contact');
    Route::post('submit/contact', 'ContactController@submit')->name('sub_contact');

    Route::get('/binh-luan', 'CommentController@index')->name('comment');
    Route::get('/xoa-binh-luan', 'CommentController@delete')->name('delete_comment');
    Route::get('/sua-binh-luan', 'CommentController@edit')->name('edit_comment');
    Route::get('/binh-luan-moi', 'CommentController@virtural')->name('virtural_comment');

    Route::get('loc-san-pham', 'ProductCategoryController@filter');

    Route::get('/tags', 'SubPostController@tags')->name('tags_product');

    /* ========== Đăng ký Làm nhà tuyển dụng ============*/
    Route::post('dang-ky/ntd', 'EmployerController@createEmployer')->name('createEmployer');

    /*===== đặt hàng  ===== */
    Route::post('/dat-hang', 'OrderController@addToCart')->name('addToCart');
    Route::get('/gio-hang', 'OrderController@order')->name('order');

    Route::get('/xoa-don-hang', 'OrderController@deleteItemCart')->name('deleteItemCart');

    Route::post('/gui-don-hang', 'OrderController@send')->name('send');

    Route::get('/xoa-job-invited/{id}', 'OrderController@deleteJobInvited')->name('delete_job_invited');


    /*===== subcribe email   ===== */
    Route::post('subcribe-email', 'SubcribeEmailController@index')->name('subcribe_email');

    //    Route::get('sitemap.xml', 'SitemapsController@index');
    Route::get('trang/{post_slug}', 'PageController@index')->name('page');

    // công việc
//    Route::get('/ung-tuyen-ngay/{jobId}', 'JobController@applyNow')->name('apply_now');

    Route::get('/tang-luot-xem', 'JobController@increaseView')->name('increase_view');

    Route::post('/luu-ho-so-ung-tuyen-ngay', 'JobController@updateApplyNow')->name('update_apply_now');

    Route::get('/cong-viec/{slug}', 'JobController@index')->name('job_detail');
    Route::get('/nhom-viec-lam/{jobGroupSlug}', 'JobGroupController@index')->name('site_job_group');
    Route::get('/thanh-pho/{cityId}', 'JobGroupController@city')->name('site_job_city');
    Route::get('/tim-kiem-viec-lam', 'JobGroupController@search')->name('site_job_search');
    Route::get('/viec-lam-tinh-thanh/{province-id}', 'JobGroupController@province')->name('job_list_province');

    Route::get('/ung-tuyen-ngay/{slug}', 'JobController@apply_job')->name('apply_job');
    Route::get('/ung-tuyen-ngay-viec-lam-moi/{slug}', 'JobController@apply_job_fb')->name('apply_job_fb');


    Route::post('/ung-tuyen-ngay/job_now', 'JobController@apply_job_now')->name('apply_job_now');

    //    Trắc nghiệm

    //    quan trị Trắc nghiệm
    //   danh sách đề thi
    Route::get('danh-sach-de-thi', 'Exam\ExamController@showExam')->name('showExam');
    Route::get('exam-data-show', 'Exam\ExamController@show_dataTable_Exam')->name('show_dataTable_Exam');
    Route::get('ngan-hang-de-thi', 'Exam\ExamController@showAllExam')->name('showAllExam');

    //  tìm kiếm đề thi
    Route::get('/tim-kiem-de-thi-cua-ban', 'Exam\ExamController@searchExamAjax')->name('searchExamAjax');
    Route::get('/tim-kiem-de-thi-ngan-hang', 'Exam\ExamController@searchExamBankAjax')->name('searchExamBankAjax');
    Route::get('/ajax-danh-sach-de-thi', 'Exam\ExamController@ajaxGetAllExamDatatables')->name('ajaxGetAllExamDatatables');
    Route::get('/ajax-ngan-hang-de-thi', 'Exam\ExamController@ajaxBankExamDatatables')->name('ajaxBankExamDatatables');
    Route::post('/cap-nhat-de-thi', 'Exam\RoomExamController@updateExamRoom')->name('updateExamRoom');

    //    copy đề thi
    Route::get('/copy-de-thi/{id_exam}', 'Exam\ExamController@showcopyExam')->name('showcopyExam');
    Route::post('/copy-de-thi', 'Exam\ExamController@copyExam')->name('copyExam');
    //    kết quả đề thi
    Route::post('/ket-qua-de-thi', 'Exam\ResultExamController@createResult')->name('createResult');


    Route::get('/hien-thi-ket-qua-de-thi/{id_result}', 'Exam\ResultExamController@showResult')->name('showResult');
    Route::post('/ajax-de-thi/luu-ket-qua/de-thi', 'Exam\ResultExamController@update_question_showResult')->name('update_question_showResult');


    Route::post('/ket-qua-de-thi-thu', 'Exam\ResultAuditionsExamController@createTestResult')->name('createTestResult');
    Route::get('/hien-thi-ket-qua-de-thi-thu/{id_result}', 'Exam\ResultAuditionsExamController@showTestResult')->name('showTestResult');

    //    tao phong thi va cau hinh phong thi admin_site
    Route::resource('room', 'Exam\RoomExamController');
    Route::get('/chon-tu-de-thi-cua-ban/{id_room}', 'Exam\RoomExamController@getRomExam')->name('getRomExam');
    Route::get('/chon-tu-ngan-hang-de-thi/{id_room}', 'Exam\RoomExamController@getBankRomExam')->name('getBankRomExam');
    Route::get('/danh-sach-phong-thi-ket-qua', 'Exam\RoomExamController@getAllRomResultExam')->name('getAllRomResultExam');
    Route::get('/danh-sach-ket-qua-phong-thi-cua-ung-vien/{id_room}', 'Exam\RoomExamController@getResultExam')->name('getResultExam');
    Route::get('/chi-tiet-ket-qua-phong-thi-cua-ung-vien/{id_result}', 'Exam\RoomExamController@getDetailResultExam')->name('getDetailResultExam');

    //  check quyen dang nhap vao quan ly de thi
    Route::resource('site_exam', 'Exam\ExamController');
    Route::resource('site_question', 'Exam\QuestionController');
    Route::resource('comment_exam', 'Exam\CommentStarController');
    Route::resource('star_exam', 'Exam\StarExamController');

    //cau hoi trac nghiem
    Route::get('/danh-sach-cau-hoi-trac-nghiem/{id_exam}', 'Exam\QuestionController@getAllQuestionsZero')->name('getAllQuestionsZero');
    //cau hoi dung sai
    Route::get('/danh-sach-cau-hoi-dung-sai/{id_exam}', 'Exam\QuestionController@getAllQuestionsOne')->name('getAllQuestionsOne');
    //    cau hoi tu luan
    Route::get('/danh-sach-cau-hoi-tu-luan/{id_exam}', 'Exam\QuestionController@getAllQuestionsTwo')->name('getAllQuestionsTwo');
    //view hiển thị câu hỏi them sua copy cau hoi
    Route::get('/them-moi-cau-hoi/{id_exam}', 'Exam\QuestionController@createQuestion')->name('createQuestion');
    Route::get('/sua-cau-hoi/{id_ques}', 'Exam\QuestionController@editQuestion')->name('editQuestion');
    Route::get('/copy-cau-hoi/{id_ques}', 'Exam\QuestionController@copyQuestion')->name('copyQuestion');


    //    site trắc nghiệm
    Route::get('danh-muc/tat-ca-de-thi-ke-toan', 'Exam\ExamViewController@getAllExam')->name('getAllExam');
    Route::get('danh-muc/tim-kiem-de-thi-ke-toan', 'Exam\ExamViewController@submit_category_Exam')->name('submit_category_Exam');
    Route::get('tim-kiem-de-thi/{slug}', 'Exam\ExamViewController@search_category_Exam')->name('search_category_Exam');
    Route::get('danh-muc/de-thi-thu', 'Exam\ExamViewAuditionsController@getTestAllExam')->name('getTestAllExam');
    Route::get('/danh-muc-con-de-thi/{id_cate_exam}', 'Exam\ExamViewController@getchildrenExam')->name('getchildrenExam');
    Route::get('/danh-muc-chau-de-thi/{id_cate_exam}', 'Exam\ExamViewController@getchildren2Exam')->name('getchildren2Exam');



    Route::get('/hien-thi-de-thi/{slug_exam}', 'Exam\ExamViewController@getExam')->name('getExam');
    Route::get('/hien-thi-de-thi-thu/{slug_exam}', 'Exam\ExamViewAuditionsController@getTestExam')->name('getTestExam');
    Route::get('/tim-kiem-de-thi', 'Exam\ExamViewController@searchExam')->name('searchExam');

    Route::get('/lam-bai-thi/{slug_exam}', 'Exam\ExamViewController@getQuestion')->name('getQuestion');

    //khong can dang nhap
    Route::get('/lam-bai-thi-thu/{slug_exam}', 'Exam\ExamViewAuditionsController@getTestQuestion')->name('getTestQuestion');
    //    Route::get('/hien-thi-cau-hoi-thi-thu/{id_exam}', 'Exam\ExamViewAuditionsController@getTestQuestion')->name('getTestQuestion');
    //hien thi phong thi tai trang chu
    Route::get('/danh-sach-phong-thi', 'Exam\RoomViewExamController@getRomAll')->name('getRomAll');
    Route::get('/danh-sach-phong-thi-cua-giang-vien/{teacher_sc_id}', 'Exam\RoomViewExamController@getRomAllTeacher')->name('getRomAllTeacher');
    Route::post('/nhap-mat-khau/', 'Exam\RoomViewExamController@submitRoomPassword')->name('submitRoomPassword');
    Route::get('/luu-de-thi-cho-phong-thi/{id_room}', 'Exam\RoomViewExamController@createResultRoom')->name('createResultRoom');
    Route::get('/hien-thi-de-thi-cua-phong-thi/{id_room}', 'Exam\RoomViewExamController@getExamRoom')->name('getExamRoom');
    Route::get('/hien-thi-cau-hoi-cua-phong-thi/{id_room}', 'Exam\RoomViewExamController@getQuestionRoom')->name('getQuestionRoom');
    Route::post('/ket-qua-de-thi-phong-thi', 'Exam\RoomViewExamController@createResultDetailRoom')->name('createResultDetailRoom');

    Route::get('/hien-thi-ket-qua-de-thi-phong-thi/{id_result}', 'Exam\RoomViewExamController@showResultRoom')->name('showResultRoom');

    Route::post('/ajax-phong-thi/luu-ket-qua/phong-thi', 'Exam\RoomViewExamController@update_question_showResultRoom')->name('update_question_showResultRoom');

    Route::get('/phong-thi/bieu-do-so-diem/{room_id}', 'Exam\RoomViewExamController@charEmployer')->name('charEmployer');


    //Tạo đề thi cho giảng viên
    //    school
    Route::get('giao-vien/danh-sach-cau-hoi-de', 'Exam\Question_schoolController@list_question_school_zero')->name('list_question_school_zero');

    Route::get('giao-vien/chuyen-cau-hoi/{type_ques}', 'Exam\Question_schoolController@list_type_question_school')->name('list_type_question_school');

    Route::post('giao-vien/chuyen-cau-hoi', 'Exam\Question_schoolController@ajax_change_type_question')->name('ajax_change_type_question');

    Route::get('giao-vien/danh-sach-cau-hoi-trung-binh', 'Exam\Question_schoolController@list_question_school_one')->name('list_question_school_one');
    Route::get('giao-vien/danh-sach-cau-hoi-kho', 'Exam\Question_schoolController@list_question_school_two')->name('list_question_school_two');
    Route::get('giao-vien/danh-sach-cau-hoi-tu-luan', 'Exam\Question_schoolController@list_question_school_three')->name('list_question_school_three');

    Route::get('giao-vien/them-moi-cau-hoi/{type_question}', 'Exam\Question_schoolController@create_question_school')->name('create_question_school');
    Route::post('giao-vien/luu-cau-hoi', 'Exam\Question_schoolController@store_question_school')->name('store_question_school');
    Route::get('giao-vien/sua-cau-hoi/{ques_id}', 'Exam\Question_schoolController@edit_question_school')->name('edit_question_school');
    Route::post('giao-vien/cap-nhat-cau-hoi/{ques_id}', 'Exam\Question_schoolController@update_question_school')->name('update_question_school');
    Route::post('giao-vien/xoa-cau-hoi/{ques_id}', 'Exam\Question_schoolController@delete_question')->name('delete_question');

    Route::resource('room_school', 'Exam\Room_schoolController');
    Route::get('danh-sach/phong-thi-dang-thi', 'Exam\Room_schoolController@list_student_room')->name('list_student_room');
    Route::get('danh-sach-sinh-vien-dang-thi/{room_id}', 'Exam\Room_schoolController@list_status_student_room')->name('list_status_student_room');
    Route::post('xoa-ket-thi-cua-sinh-vien/{result_id}', 'Exam\Room_schoolController@delete_student_room')->name('delete_student_room');
    Route::get('danh-sach/ket-qua-cua-phong-thi', 'Exam\Room_schoolController@result_student_room')->name('result_student_room');
    Route::get('chi-tiet-ket-thi-cua-sinh-vien/{result_id}', 'Exam\RoomViewSchoolController@ViewShowResultStudent')->name('ViewShowResultStudent');

    Route::get('danh-sach/chi-tiet-ket-qua-cua-phong-thi/{room_id}', 'Exam\Room_schoolController@detai_result_student_room')->name('detai_result_student_room');


    Route::get('phong-thi/kiem-tra-phong-thi/{room_id}', 'Exam\Room_schoolController@check_detail_result')->name('check_detail_result');
    Route::get('phong-thi/kiem-tra-ket-qua/{id_result}', 'Exam\Room_schoolController@check_id_result')->name('check_id_result');


    Route::get('xuat-excel/ket-qua-phong-thi/{room_id}', 'Exam\Room_schoolController@export_room_excel')->name('export_room_excel');
    Route::get('xuat-excel/ket-qua-thi-ung-vien/{result_id}', 'Exam\Room_schoolController@export_detai_result_student_excel')->name('export_detai_result_student_excel');


    Route::get('danh-sach/ket-qua-thi-cua-sinh-vien/{result_id}', 'Exam\Room_schoolController@detai_result_student')->name('detai_result_student');

    Route::post('giao-vien/cap-nhat-ket-qua-cho-sinh-vien', 'Exam\Room_schoolController@updateSchoolResultDetailRoom')->name('updateSchoolResultDetailRoom');

    Route::get('cau-hinh-phong-thi/{room_id}', 'Exam\Room_schoolController@settingRoom')->name('settingRoom');
    Route::get('danh-sach-de-thi/{room_id}', 'Exam\Room_schoolController@listExamRoom')->name('listExamRoom');
    Route::post('tao-de-thi/cho-phong-thi', 'Exam\Room_schoolController@create_exam_room')->name('create_exam_room');
    Route::get('xem-de-thi/{id_exam}', 'Exam\Room_schoolController@show_exam')->name('show_exam');
    Route::post('xoa-de-thi/{id_exam}', 'Exam\Room_schoolController@delete_exam')->name('delete_exam');

    Route::get('vao-phong-thi/{id_room}', 'Exam\RoomViewSchoolController@detail_room')->name('detail_room');
    Route::post('vao-phong-thi/nhap-mat-khau/', 'Exam\RoomViewSchoolController@createStudentRoom')->name('createStudentRoom');
    Route::post('cap-nhat/thong-tin-sinh-vien', 'Exam\RoomViewSchoolController@updateStudent')->name('updateStudent');
    Route::get('giao-vien/luu-de-thi-cho-phong-thi/{id_room}', 'Exam\RoomViewSchoolController@createResultSchool')->name('createResultSchool');
    Route::get('giao-vien/hien-thi-de-thi-cua-phong-thi/{id_room}', 'Exam\RoomViewSchoolController@getSchoolExamRoom')->name('getSchoolExamRoom');
    Route::get('giao-vien/hien-thi-cau-hoi/{id_room}', 'Exam\RoomViewSchoolController@getSchoolQuestionRoom')->name('getSchoolQuestionRoom');

    Route::post('giao-vien/ket-qua-de-thi-phong-thi', 'Exam\RoomViewSchoolController@createSchoolResultDetailRoom')->name('createSchoolResultDetailRoom');


    Route::get('giao-vien/xoa-chi-tiet-phong-thi/{id_room}', 'Exam\RoomViewSchoolController@deleteRoom')->name('deleteRoom');
    Route::get('giao-vien/xoa-chi-tiet-trung/{id_result}', 'Exam\RoomViewSchoolController@deleteRoomResult')->name('deleteRoomResult');

    Route::get('giao-vien/hien-thi-ket-qua-de-thi-phong-thi/{id_result}', 'Exam\RoomViewSchoolController@showSchoolResultRoom')->name('showSchoolResultRoom');
    Route::get('giao-vien/hien-thi-chi-tiet-ket-qua-de-thi-phong-thi/{id_result}', 'Exam\RoomViewSchoolController@showDetailResult')->name('showDetailResult');


    //user
    //    Route::get('sua-thong-tin', 'UserController@show_edit_user')->name('show_edit_user');
    //    Route::post('update-thong-tin', 'UserController@editUser')->name('editUser');
    //    Route::get('doi-mat-khau', 'UserController@show_pass_user')->name('show_pass_user');
    //    Route::post('update-mat-khau', 'UserController@changPassword')->name('changPassword');
    //    createResultRoom
    //    End Trắc nghiệm

    //    site khóa học showCourse -tam dung
    Route::resource('course', 'Course\CourseController');
    Route::get('/dang-ki-khoa-hoc/{course_id}', 'Course\CourseViewController@regedit_course')->name('regedit_course');
    //list course
    Route::get('khoa-hoc/danh-sach-khoa-hoc', 'Course\CoursesController@index')->name('course_index');
    Route::get('khoa-hoc/danh-sach-khoa-hoc/{category_slug}', 'Course\CoursesController@categoryCourse')->name('course_categoryCourse');

    Route::get('khoa-hoc/khoa-hoc-cua-toi','Course\CoursesController@myCourse')->name('course_myCourse');
    Route::get('khoa-hoc-dang-hoc/{course_slug}/{chapter_id}/{content_id}','Course\CoursesController@learingCourse')->name('course_learingCourse');
    Route::post('ajax-them-voucher-status','Course\CoursesController@ajax_post_voucher_status')->name('ajax_post_voucher_status');
    Route::post('ajax-xoa-voucher-status','Course\CoursesController@ajax_delete_voucher_status')->name('ajax_delete_voucher_status');
    Route::post('ajax-dat-cau-hoi-khoa-hoc','Course\CoursesController@ajax_add_question')->name('ajax_add_question');
    Route::post('ajax-danh-gia-khoa-hoc','Course\CoursesController@ajax_add_feedback')->name('ajax_add_feedback');
    Route::post('khoa-hoc/nop-bai','Course\CoursesController@result_question_course')->name('result_question_course');
    Route::post('khoa-hoc/nop-bai/cau-hoi','Course\CoursesController@result_question_course_question')->name('result_question_course_question');

    Route::get('hoc-thu-khoa-hoc/{course_slug}/{chapter_id}/{content_id}','Course\CoursesController@tryCourse')->name('course_tryCourse');
    Route::get('thanh-toan-khoa-hoc/{course_slug}','Course\CoursesController@payment')->name('course_payment');
    Route::get('thanh-toan-khoa-hoc-dao-tao/khoa-hoc','Course\CoursesController@payment_learn')->name('payment_learn');
    Route::post('thanh-toan/khoa-hoc','Course\CoursesController@payment_course')->name('payment_course');

    Route::post('thanh-toan/khoa-hoc-mien-phi','Course\CoursesController@payment_course_free')->name('payment_course_free');
    Route::get('thong-bao/thong-tin-thanh-toan/{course_order_id}','Course\CoursesController@noti_course_order')->name('noti_course_order');
    Route::get('thong-bao/thong-tin-thanh-toan-mien-phi/{course_order_id}','Course\CoursesController@noti_course_order_free')->name('noti_course_order_free');
    Route::get('ajax-hinh-thuc-khoa-hoc/','Course\CoursesController@get_ajax_formality_id')->name('get_ajax_formality_id');
    Route::get('thanh-toan-theo-hinh-thuc-hoc','Course\CoursesController@sumbit_cart_course')->name('sumbit_cart_course');

    Route::get('hinh-thuc-dang-ky-hoc/{course_slug}','Course\CoursesController@resgiter_content_course')->name('resgiter_content_course');

    Route::get('tro-thanh-giao-vien','Course\CoursesController@becomeTeacher')->name('course_becomeTeacher');

    Route::post('kich-hoat/khoa-hoc','Course\CourseEmployeeController@employee_active_course')->name('employee_active_course');
    Route::get('khoa-hoc/{course_slug}','Course\CoursesController@showCourseDetail')->name('course_showCourseDetail');


    //giáo viên quản lý khóa học

    Route::get('giao-vien/quan-ly-khoa-hoc','Course\TeacherCourseController@list_teacher_courses')->name('list_teacher_courses');
    Route::post('giao-vien/tao-ma-kich-hoat-mien-phi','Course\TeacherCourseController@create_courses_active')->name('create_courses_active');
    Route::get('giao-vien/danh-sach-ma-kich-hoat-mien-phi/{course_id}','Course\TeacherCourseController@list_courses_active')->name('list_courses_active');

    Route::get('giao-vien/quan-ly-cau-hoi-cho-khoa-hoc','Course\TeacherCourseController@list_teacher_question')->name('list_teacher_question');
    Route::get('giao-vien/cau-hoi/{course_comments_id}','Course\TeacherCourseController@detail_teacher_question')->name('detail_teacher_question');
    Route::post('giao-vien/tra-loi-cau-hoi-ung-vien','Course\TeacherCourseController@store_question_answer')->name('store_question_answer');
    Route::post('giao-vien/cap-nhat-tra-loi-cau-hoi-ung-vien','Course\TeacherCourseController@update_question_answer')->name('update_question_answer');

    Route::get('giao-vien/doanh-thu-khoa-hoc','Course\TeacherCourseController@list_static_courses')->name('list_static_courses');
    Route::get('giao-vien/thong-tin-don-hang/{course_order_id}','Course\TeacherCourseController@detail_teacher_info_course')->name('detail_teacher_info_course');


    Route::get('giao-vien/them-khoa-hoc','Course\CoursesController@teacher_create_courses')->name('teacher_create_courses');
    Route::post('giao-vien/luu-kh-a-hoc','Course\CoursesController@teacher_store_courses')->name('teacher_store_courses');
    Route::get('giao-vien/sua-khoa-hoc/{courses_id}','Course\CoursesController@teacher_edit_courses')->name('teacher_edit_courses');
    Route::post('giao-vien/cap-nhat-khoa-hoc','Course\CoursesController@teacher_update_courses')->name('teacher_update_courses');
    Route::post('giao-vien/xoa-khoa-hoc/{courses_id}','Course\CoursesController@teacher_delete_courses')->name('teacher_delete_courses');
    //-quan ly chuong
    Route::get('giao-vien/quan-ly-chuong/{courses_id}','Course\CoursesController@list_course_chapter')->name('list_course_chapter');
    Route::get('giao-vien/them-chuong/{courses_id}','Course\CoursesController@create_course_chapter')->name('create_course_chapter');
    Route::post('giao-vien/chapter_store','Course\CoursesController@store_course_chapter')->name('store_course_chapter');
    Route::get('giao-vien/cap-nhat-chuong/{chapter_id}','Course\CoursesController@edit_course_chapter')->name('edit_course_chapter');
    Route::post('giao-vien/chapter_update','Course\CoursesController@update_course_chapter')->name('update_course_chapter');
    Route::post('giao-vien/chapter_delete/{chapter_id}','Course\CoursesController@delete_course_chapter')->name('delete_course_chapter');

    //-quan ly bai hoc
    Route::get('giao-vien/danh-sach-bai-hoc/{chapter_id}','Course\CoursesController@list_chapter_content')->name('list_chapter_content');
    Route::get('giao-vien/them-bai-hoc/{chapter_id}','Course\CoursesController@create_chapter_content')->name('create_chapter_content');
    Route::post('giao-vien/bai-hoc/luu','Course\CoursesController@store_chapter_content')->name('store_chapter_content');
    Route::get('giao-vien/cap-nhat-bai-hoc/{coutent_id}','Course\CoursesController@edit_chapter_content')->name('edit_chapter_content');
    Route::post('giao-vien/course_content_update','Course\CoursesController@update_chapter_content')->name('update_chapter_content');
    Route::post('giao-vien/course_content_delete/{coutent_id}','Course\CoursesController@delete_chapter_content')->name('delete_chapter_content');
    //quản lý tài liệu của bài học
    Route::get('giao-vien/danh-sach-tai-lieu/{content_id}','Course\CoursesController@list_voucher_content')->name('list_voucher_content');

    Route::post('giao-vien/tai-lieu/them-tai-lieu-cho-bai-hoc', 'Course\CoursesController@store_content_voucher')->name('store_content_voucher');
    Route::post('giao-vien/tai-lieu/cap-nhat-tai-lieu-cho-bai-hoc', 'Course\CoursesController@update_content_voucher')->name('update_content_voucher');
    Route::post('giao-vien/tai-lieu/xoa-tai-lieu-cho-bai-hoc/{course_content_voucher_id}', 'Course\CoursesController@delete_content_voucher')->name('delete_content_voucher');
    //thêm tài liệu đáp án cho bài học
    Route::post('giao-vien/tai-lieu/them-tai-lieu-dap-an-cho-bai-hoc', 'Course\CoursesController@store_content_voucher_answer')->name('store_content_voucher_answer');
    Route::post('giao-vien/tai-lieu/cap-nhat-tai-lieu-dap-an-cho-bai-hoc', 'Course\CoursesController@update_content_voucher_answer')->name('update_content_voucher_answer');
    Route::post('giao-vien/tai-lieu/xoa-tai-lieu-dap-an-cho-bai-hoc/{course_content_voucher_answer_id}', 'Course\CoursesController@delete_content_voucher_answer')->name('delete_content_voucher_answer');


    // quan lý câu hỏi trắc nghiệm
    Route::get('giao-vien/bai-hoc/danh-sach-cau-hoi/{content_id}','Course\CoursesController@list_content_question')->name('list_content_question');
    Route::get('giao-vien/bai-hoc/chon-danh-sach-cau-hoi/{content_id}','Course\CoursesController@select_content_question')->name('select_content_question');
    Route::post('giao-vien/chon-cau-hoi-cho-bai-hoc','Course\CoursesController@post_content_question')->name('post_content_question');
    Route::get('giao-vien/bai-hoc/them-moi-cau-hoi/{content_id}','Course\CoursesController@create_content_question')->name('create_content_question');
    Route::get('giao-vien/bai-hoc/chinh-sua-cau-hoi/{ques_id}','Course\CoursesController@edit_content_question')->name('edit_content_question');
    Route::post('giao-vien/bai-hoc/store-cau-hoi','Course\CoursesController@store_content_question')->name('store_content_question');
    Route::post('giao-vien/bai-hoc/update-cau-hoi','Course\CoursesController@update_content_question')->name('update_content_question');
    Route::post('giao-vien/bai-hoc/delete-cau-hoi/{ques_id}','Course\CoursesController@delete_content_question')->name('delete_content_question');
    //danh sach cau hoi trac nghiem giao vien da tao
    Route::get('giao-vien/danh-sach-cau-hoi-trac-nghiem','Course\CoursesController@list_teacher_exam')->name('list_teacher_exam');
    //-quan ly tai-lieu-cua-bai-hoc

    Route::get('giao-vien/quan-ly-tai-lieu/{course_content_id}','Course\CoursesController@index')->name('teacher_course_voucher_index');
    Route::get('giao-vien/them-bai-tai-lieu/{course_content_id}','Course\CoursesController@create')->name('create');
    Route::post('giao-vien/course_voucher_store','Course\CoursesController@store')->name('teacher_course_voucher_store');
    Route::get('giao-vien/cap-nhat-bai-hoc/{course_content_id}','Course\CoursesController@edit')->name('edit');
    Route::post('giao-vien/course_voucher_update','Course\CoursesController@update')->name('update');
    Route::post('giao-vien/course_voucher_delete','Course\CoursesController@delete')->name('delete');

    //quan ly cau hỏi của học viên
    Route::get('giao-vien/danh-sach-cau-hoi-cua-khoa-hoc','Course\CoursesController@index')->name('index');
    Route::post('giao-vien/tra-loi-cau-hoi-cua-khoa-hoc/{course_id}','Course\CoursesController@store')->name('store');


    //chia sẻ khóa học

    //giao vien
    Route::get('/giao-vien/danh-sach-giao-vien', 'TeacherViewController@showTeacher')->name('showTeacher');
    Route::get('/giao-vien/tim-kiem-giao-vien', 'TeacherViewController@submitTeacher')->name('submitTeacher');
    Route::get('/tim-giao-vien/{slug}', 'TeacherViewController@searchTeacher')->name('searchTeacher');
    Route::get('/danh-muc-giao-vien/{slug}', 'TeacherViewController@showCategoryTeacher')->name('showCategoryTeacher');
    Route::get('giao-vien/{slug}', 'TeacherViewController@detailTeacher')->name('detailTeacher');

    Route::resource('teacher_star', 'TeacherStarController');

    //nhaf tuyen dung
    Route::get('nha-tuyen-dung', 'EmployerController@portEmployer')->name('portEmployer');
    Route::get('bang-gia-nha-tuyen-dung/{slug}', 'EmployerController@table_price_employer')->name('table_price_employer');
    Route::get('danh-sach-nha-tuyen-dung', 'EmployerController@list_employer')->name('list_employer');
    Route::get('ajax-get-detail-table-price', 'EmployerController@detail_table_price')->name('detail_table_price');
    Route::get('ajax-get-detail-table-price1', 'EmployerController@detail_table_price1')->name('detail_table_price1');
    Route::get('ajax-get-detail-table-price2', 'EmployerController@detail_table_price2')->name('detail_table_price2'); //slug


    //thong tin dich vu
    Route::get('thong-tin-dich-vu/{slug}', 'InformationServiceController@detail_information')->name('detail_information');

    Route::get('tuyen-thuc-tap-ke-toan/danh-sach-cong-ty', 'EmployerController@intership')->name('intership');
    Route::get('tuyen-dung-ke-toan/cam-nang-tuyen-dung', 'EmployerController@recruitment')->name('recruitment');
    Route::get('tuyen-thuc-tap-ke-toan/tim-kiem-cong-ty', 'EmployerController@submit_intership')->name('submit_intership');
    Route::get('tuyen-thuc-tap-ke-toan/{slug}', 'EmployerController@search_intership')->name('search_intership');
    Route::get('cong-ty-thuc-tap-ke-toan/{slug}', 'EmployerController@detail_intership')->name('detail_intership');
    Route::get('ung-tuyen-thuc-tap/{slug}', 'EmployerController@apply_intership')->name('apply_intership');
    Route::post('danh-gia-cong-ty', 'EmployerController@star_employer')->name('star_employer');

    //  nop ho so (mặc định hồ sơ ứng viên)
    Route::post('ho-so/nop-ho-so-thuc-tap', 'EmployerController@updateEmployeeSubmitIntership')->name('updateEmployeeSubmitIntership');

    //    danh sach ung viên
    Route::get('danh-sach-ung-vien', 'EmployeeController@show_employee')->name('show_employee');
    Route::get('thong-tin-ung-vien/{employee_slug}', 'EmployeeController@detail_employee_show')->name('detail_employee_show');
    //test view pdf
    Route::get('test-thong-tin-ung-vien/{employee_slug}', 'EmployeeController@test_detail_employee_show')->name('test_detail_employee_show');
    Route::get('link_preview_cv/{employee_id}', 'EmployeeController@link_preview_cv')->name('link_preview_cv');
    Route::get('link_preview_cv_full/{employee_id}', 'EmployeeController@link_preview_cv_full')->name('link_preview_cv_full');

    Route::get('box-thong-tin-ung-vien/{employee_slug}', 'EmployeeController@box_detail_employee_show')->name('box_detail_employee_show');
    Route::get('an-thong-tin-ung-vien/{employee_slug}', 'EmployeeController@delete_file_html_employee')->name('delete_file_html_employee');
    Route::post('chi-tiet-ung-vien/hien-thi-thong-tin-lien-he', 'EmployerController@show_info_employee')->name('show_info_employee');
    Route::post('chi-tiet-ung-vien/moi-ung-tuyen-cho-cong-viec', 'EmployerController@send_job_employer')->name('send_job_employer');

    Route::post('chi-tiet-ung-vien/danh-gia-ung-vien', 'EmployerController@vote_employee')->name('vote_employee');
    Route::post('chi-tiet-ung-vien/phan-hoi-chat-luong-cv', 'EmployerController@response_employee')->name('response_employee');



    Route::get('lay-thong-tin-chi-tiet-cv-ung-vien', 'EmployeeController@modal_detail_cv')->name('modal_detail_cv');
    Route::get('thong-tin-ung-vien', 'EmployeeController@modal_detail_coin')->name('modal_detail_coin');
    Route::get('tim-kiem/ung-vien', 'EmployeeController@search_employee')->name('search_employee');
    Route::get('ajax-tong-ung-vien-carrer', 'EmployeeController@ajax_get_total_employee_carrer')->name('ajax_get_total_employee_carrer');
    Route::get('ajax-tong-ung-vien-province', 'EmployeeController@ajax_get_total_employee_province')->name('ajax_get_total_employee_province');

    Route::get('tim-kiem/ung-vien-ke-toan', 'EmployeeController@search_employee_view_mobile')->name('search_employee_view_mobile');

    Route::get('cap-nhat-image/ung-vien', 'EmployeeController@updateImage')->name('updateImage');
    Route::get('danh-sach-image/base64', 'EmployeeController@listImage64')->name('listImage64');

    Route::get('cap-nhat-ho-so-nha-tuyen-dung/nha-tuyen-dung', 'EmployerController@update_profile_employer')->name('update_profile_employer');

    //    danh sách ứng viên gửi hồ sơ thực tập

    //Đăng kí email theo nhom
    Route::post('email/dang-ki-nhan-thong-bao', 'SubcribeEmailController@addEmail')->name('addEmail');

    //lấy jobfacebook
    Route::get('viec-lam/viec-lam-facebook', 'jobFaceController@index')->name('list_job_face');
    Route::get('tim-kiem/viec-lam-facebook', 'jobFaceController@submit_search_jobfb')->name('submit_search_jobfb');


    Route::get('tim-kiem/viec-lam-ke-toan', 'jobFaceController@search_job_view_mobile')->name('search_job_view_mobile');

    Route::get('viec-lam/{slug}', 'jobFaceController@seacrh_job_facebook')->name('seacrh_job_facebook');

    Route::get('ajax/tong-viec-lam-nganh-nghe', 'jobFaceController@ajax_get_total_job_carrer')->name('ajax_get_total_job_carrer');
    Route::get('ajax/tong-viec-lam-thanh-pho', 'jobFaceController@ajax_get_total_job_province')->name('ajax_get_total_job_province');

    Route::get('tim-kiem-huyen/{provinde}', 'jobFaceController@ajaxProvince')->name('ajaxProvinceSite');
    Route::get('tim-kiem-slug/{slug}', 'jobFaceController@ajaxSlugProvince')->name('ajaxSlugProvince');
    Route::get('viec-lam-facebook/{slug}', 'jobFaceController@detailJobFace')->name('detail_job_face');

    // chinh sua user ben sidebar job facebook

    Route::get('/quan-ly-tai-khoan/doi-mat-khau', 'JobFaceUserController@show_user_job_facebook')->name('show_user_job_facebook');
    Route::post('/quan-ly-tai-khoan/doi-mat-khau', 'JobFaceUserController@storeResetPassword')->name('storeResetPassword');
    Route::get('/cap-nhat/ho-so', 'JobFaceUserController@show_step_profile_employee')->name('show_step_profile_employee');


    Route::get('/quan-ly/ho-so', 'JobFaceUserController@show_file_job_facebook')->name('show_file_job_facebook');

    Route::get('/quan-ly/ho-so2', 'JobFaceUserController@show_file_job_facebook2')->name('show_file_job_facebook2');
    Route::post('/cap-nhat-ho-so/nha-tuyen-dung', 'JobFaceUserController@updateEmployer')->name('updateEmployer');


    Route::get('/tuyen-dung/cong-thuc-tap-nha-tuyen-dung', 'JobFaceUserController@show_intership')->name('show_intership');
    Route::get('/thuc-tap/ho-so-thuc-tap', 'JobFaceUserController@list_intership_employer')->name('list_intership_employer');
    Route::get('/dich-vu/don-hang-da-dang-ky-thue-tuyen-dung', 'JobFaceUserController@show_service_price')->name('show_service_price');
    Route::get('/dich-vu/don-hang-da-dang-ky-xem-ho-so-dang-tin', 'JobFaceUserController@show_service_profile_job')->name('show_service_profile_job');


    Route::post('/tuyen-dung/cong-thuc-tap', 'JobFaceUserController@update_intership')->name('update_intership');
    Route::post('trang-thai-ho-so-thuc-tap}', 'JobFaceUserController@update_status_intership')->name('update_status_intership');
    Route::post('/xoa-ho-so-thuc-tap', 'JobFaceUserController@delete_intership')->name('delete_intership');


    Route::get('/danh-sach/danh-sach-ho-so-thuc-tap', 'EmployerController@list_profile_intership')->name('list_profile_intership');
    Route::get('/danh-sach/ho-so-ung-vien-da-nop', 'EmployerController@list_profile_job')->name('list_profile_job');


    Route::get('/tuyen-dung/cong-thuc-tap-ung-vien', 'JobFaceUserController@show_intership_employee')->name('show_intership_employee');


    Route::post('/cap-nhat-ho-so/ung-vien', 'JobFaceUserController@updateEmployee')->name('updateEmployee');
    Route::post('/cap-nhat-ho-so/anh-ung-vien', 'JobFaceUserController@ajaxUpdateEmployeeImage')->name('ajaxUpdateEmployeeImage');
    Route::post('/them-moi-ho-so-trinh-do/ung-vien', 'JobFaceUserController@store_Specialize_Employee')->name('store_Specialize_Employee');
    Route::post('/cap-nhat-ho-so-trinh-do/ung-vien', 'JobFaceUserController@update_Specialize_Employee')->name('update_Specialize_Employee');
    Route::post('/them-moi-ho-so-kinh-nghiem/ung-vien', 'JobFaceUserController@store_Experience_Employee')->name('store_Experience_Employee');
    Route::post('/cap-nhat-ho-so-kinh-nghiem/ung-vien', 'JobFaceUserController@update_Experience_Employee')->name('update_employee_experience_profile');
    Route::post('/cap-nhat-tinh-trang-ho-so/ung-vien', 'JobFaceUserController@update_File_Employee')->name('update_File_Employee');

    //    ung vien
    Route::get('/viec-lam-yeu-thich-tu-facebook/ung-vien', 'JobFaceUserController@job_Like_Employee')->name('job_Like_Employee');
    Route::get('/viec-lam-mong-muon/ung-vien', 'JobFaceUserController@job_desired_employee')->name('job_desired_employee');
    Route::post('/luu-viec-lam-mong-muon/ung-vien', 'JobFaceUserController@check_job_desired')->name('check_job_desired');

    //    Route::get('/viec-lam-da-luu-tu-facebook/ung-vien', 'JobFaceUserController@list_Job_Save_Employee')->name('list_Job_Save_Employee');
    //    Route::get('/viec-lam-da-nop-ho-sơ-facebook/ung-vien', 'JobFaceUserController@list_Job_Submit_Employee')->name('list_Job_Submit_Employee');


    //Thông kê đổi xu từ chia sẻ bài viết
    Route::get('/kiem-tien/tu-chia-se-bai-viet', 'EmployeeCointController@post_sale_employee')->name('post_sale_employee');
    Route::get('/kiem-tien/tu-chia-se-tin-tuyen-dung', 'EmployeeCointController@job_sale_employee')->name('job_sale_employee');
    Route::get('/kiem-tien/tu-chia-se-khoa-hoc', 'EmployeeCointController@course_sale_employee')->name('course_sale_employee');
    Route::get('/kiem-tien/tu-chia-se-tai-lieu', 'EmployeeCointController@voucher_sale_employee')->name('voucher_sale_employee');
    Route::get('/kiem-tien/danh-sach-doi-thuong', 'EmployeeCointController@redeem_rewards')->name('redeem_rewards');
    Route::get('/kiem-tien/lich-su-giao-dich', 'EmployeeCointController@transaction_history')->name('transaction_history');
    Route::get('/kiem-tien/danh-sach-bai-viet', 'EmployeeCointController@list_post')->name('list_post');
    Route::get('/kiem-tien/danh-sach-tin-tuyen-dung', 'EmployeeCointController@list_job')->name('list_job');
    Route::get('/kiem-tien/danh-sach-tin-thuc-tap', 'EmployeeCointController@list_intership')->name('list_intership');
    Route::get('/kiem-tien/danh-sach-khoa-hoc', 'EmployeeCointController@list_course')->name('list_course');
    Route::get('/kiem-tien/don-hang-khoa-hoc', 'EmployeeCointController@list_course_order')->name('list_course_order');
    Route::get('/kiem-tien/danh-sach-tai-lieu', 'EmployeeCointController@list_voucher')->name('list_voucher');
    Route::get('/kiem-tien/danh-sach-nha-tuyen-dung-da-gioi-thieu', 'Employee_intro_employerController@list_intro_employer')->name('list_intro_employer');


    Route::get('/doi-thuong/qua-the-cao', 'EmployeeCointController@change_card')->name('change_card');
    Route::post('/update/doi-the-cao', 'EmployeeCointController@update_change_card')->name('update_change_card');
    Route::get('/doi-thuong/rut-qua-tai-khoan', 'EmployeeCointController@change_account')->name('change_account');
    Route::post('/update/doi-rut-qua-tai-khoan', 'EmployeeCointController@update_change_account')->name('update_change_account');
    Route::get('/doi-thuong/phan-mem-ke-toan', 'EmployeeCointController@change_software')->name('change_software');
    Route::get('/doi-thuong/phan-mem-ke-toan/{slug}', 'EmployeeCointController@change_software_slug')->name('change_software_slug'); //    Route::get('/doi-thuong/phan-mem-ke-toan', 'EmployeeCointController@change_software')->name('change_software')
    ;
    Route::post('/update/doi-phan-mem-ke-toan', 'EmployeeCointController@update_change_software')->name('update_change_software');

    //get api danh sach ke-toan-thue

    Route::get('/ke-toan-dich-vu/get-danh-sach-ke-toan-thue', 'List_teacher_agencyController@get_api_teacher')->name('get_api_teacher');
    //    end api

    Route::get('/thong-tin-chi-tiet-ung-vien-ke-toan/{employee_id}', 'jobFaceController@show_detail_emplooyee')->name('show_detail_emplooyee');

    Route::get('/thong-tin-cv-ung-vien-ke-toan/{employee_id}', 'jobFaceController@show_cv_detail_employee')->name('show_cv_detail_employee');
    Route::get('/thong-tin-cv-ung-vien-no-ho-so/{employee_id}', 'jobFaceController@show_cv_detail_employee_no_login')->name('show_cv_detail_employee_no_login');

    Route::get('/thong-tin-so-yeu-ly-lich-ung-vien-ke-toan/{employee_id}', 'jobFaceController@show_syll_detail_employee')->name('show_syll_detail_employee');
    Route::get('/thong-tin-so-yeu-ly-lich-ung-vien-nop-ho-so/{employee_id}', 'jobFaceController@show_syll_detail_employee_no_login')->name('show_syll_detail_employee_no_login');

    Route::post('/hien-thi-thong-tin-lien-he-ung-vien/ung-vien', 'jobFaceController@show_info_cv_detail_employee')->name('show_info_cv_detail_employee');
    Route::get('/show-thong-tin-lien-he-ung-vien/ung-vien', 'jobFaceController@ajax_show_info_cv_detail_employee')->name('ajax_show_info_cv_detail_employee');
    Route::get('/thong-tin-ung-vien-ke-toan/{employee_id}', 'jobFaceController@show_emplooyee')->name('show_emplooyee');

    Route::get('/thong-tin-lien-he-cua-ung-vien/{employee_id}', 'jobFaceController@show_contact_detail_employee')->name('show_contact_detail_employee');
    Route::get('/moi-ung-vien-ung-tuyen/{employee_id}', 'jobFaceController@invitation_apply_detail_employee')->name('invitation_apply_detail_employee');

    Route::post('/moi-ung-vien-ung-tuyen/viec-lam', 'jobFaceController@invitation_job_apply_detail_employee')->name('invitation_job_apply_detail_employee');


    Route::get('/chi-tiet-ung-vien-ke-toan/{employee_id}', 'jobFaceController@show_emplooyee_intership')->name('show_emplooyee_intership');
    Route::get('/thong-tin-giao-vien/{teacher_id}', 'jobFaceController@show_teacher')->name('show_teacher');


    //    giao vien
    Route::get('/viec-lam-yeu-thich-tu-facebook/giao-vien', 'JobFaceUserController@job_Like_Teacher')->name('job_Like_Teacher');
    Route::get('/viec-lam-da-luu-tu-facebook/giao-vien', 'JobFaceUserController@list_Job_Save_Teacher')->name('list_Job_Save_Teacher');
    Route::get('/viec-lam-da-nop-ho-sơ-facebook/giao-vien', 'JobFaceUserController@list_Job_Submit_Teacher')->name('list_Job_Submit_Teacher');

    //    danh sách tin tuyển dụng ứng viên ứng tuyển facebook
    Route::get('/danh-sach-tin-ung-vien-ung-tuyen/faebook', 'JobFaceUserController@list_Candidate_Employee')->name('list_Candidate_Employee');
    //    danh sách ứng viên ứng tuyển
    Route::get('/danh-sach-ung-vien-ung-tuyen/{job_facebook_id}', 'JobFaceUserController@detail_Candidate_Employee')->name('detail_Candidate_Employee');

    //    hồ sơ ứng viên
    Route::get('/ho-so-ung-vien-ung-tuyen/{employee_id}', 'JobFaceUserController@detail_Submit_Employee')->name('detail_Submit_Employee');
    Route::get('/xem-ho-so-trang-thai/{submit_job_fb_id}', 'JobFaceUserController@show_profile_Employee')->name('show_profile_Employee');
    Route::post('/xem-ho-so-trang-thai/luu-trang-thai-ho-so', 'JobFaceUserController@save_id_status_submit_job')->name('save_id_status_submit_job');

    Route::get('/xem-thong-tin_cv/{submit_job_fb_id}', 'JobFaceUserController@show_cv_Employee')->name('show_cv_Employee');
    Route::get('/xem-thong-tin_so-yeu-ly-lich/{submit_job_fb_id}', 'JobFaceUserController@show_syll_Employee')->name('show_syll_Employee');

    Route::get('/xem-ho-so-thuc-tap-trang-thai/{intership_id}', 'JobFaceUserController@show_profile_Employee_intership')->name('show_profile_Employee_intership');

    Route::get('/xem-cv-thuc-tap-trang-thai/{intership_id}', 'JobFaceUserController@intership_show_cv_Employee')->name('intership_show_cv_Employee');

    Route::get('/xem-syll-thuc-tap-trang-thai/{intership_id}', 'JobFaceUserController@intership_show_syll_Employee')->name('intership_show_syll_Employee');

    //câp nhat cv cho ung vien
    Route::get('/get_all_update_cv_employee/{star}/{limit}', 'EmployeeController@get_all_update_cv_employee')->name('get_all_update_cv_employee');

    //cap nhat syll

    Route::get('/get_all_update_syll_employee/{star}/{limit}', 'EmployeeController@get_all_update_syll_employee')->name('get_all_update_syll_employee');
    //    cap nhat kinh nghiem
    Route::get('/get_update_time_word_employee/{star}/{limit}', 'EmployeeController@get_update_time_word_employee')->name('get_update_time_word_employee');
    //cài đặt hồ sơ
    Route::get('/cai-dat/ho-so', 'EmployeeController@setting_profile_employee')->name('setting_profile_employee');
    Route::post('/cap-nhat/cai-dat/ho-so', 'EmployeeController@update_setting_profile_employee')->name('update_setting_profile_employee');

    //sơ yếu lý lịch
    Route::get('ung-vien/so-yeu-ly-lich', 'EmployeeController@employee_curriculum_vitae')->name('employee_curriculum_vitae');
    Route::post('ung-vien/cap-nhat-so-yeu-ly-lich', 'EmployeeController@post_employee_curriculum_vitae')->name('post_employee_curriculum_vitae');
    //tao cv
    Route::get('ung-vien/tao-cv', 'EmployeeController@create_emplyee_cv')->name('create_emplyee_cv');

    Route::post('ung-vien/luu-cv', 'EmployeeController@store_update_cv')->name('store_update_cv');

    Route::get('ung-vien/sua-cv/{cv_id}', 'EmployeeController@edit_emplyee_cv')->name('edit_emplyee_cv');
    Route::post('ung-vien/cap-nhat-cv', 'EmployeeController@update_edit_cv')->name('update_edit_cv');
    Route::get('chinh-mau-cv/{cv_id}/{cv_color}', 'EmployeeController@config_color_cv')->name('config_color_cv');

    //tải Cv
    Route::get('ung-vien/tai-cv', 'EmployeeController@view_emplyee_cv')->name('view_emplyee_cv');
    Route::get('ung-vien/test-tai-cv', 'EmployeeController@view_emplyee_cv_test')->name('view_emplyee_cv_test');
    Route::post('ung-vien/tai-cv', 'EmployeeController@upload_emplyee_cv')->name('upload_emplyee_cv');
    Route::post('ung-vien/upload_tai-cv', 'EmployeeController@upload_new_emplyee_cv')->name('upload_new_emplyee_cv');
    Route::post('ung-vien/tai-cv-ajax', 'EmployeeController@ajax_upload_emplyee_cv')->name('ajax_upload_emplyee_cv');

    //    Route::get('ung-vien/pdf/tao-cv', 'EmployeeController@exportpdf_cv')->name('exportpdf_cv');

    //    Route::post('ung-vien/cap-nhat-cv', 'EmployeeController@store_update_cv')->name('store_update_cv');
    Route::get('ung-vien/pdf/tao-so-yeu-ly-lich', 'PdfController@exportpdf_so_yeu_ly_lich')->name('exportpdf_ll');
    Route::get('ung-vien/pdf/tao-cv', 'PdfController@exportpdf_cv')->name('exportpdf_cv');
    Route::get('ung-vien/pdf/page-cv/{user_id}', 'PdfController@exportpdf_cv_user_id')->name('exportpdf_cv_user_id');
    Route::get('self-ung-vien/pdf/page-cv/{user_id}.pdf', 'PdfController@self_exportpdf_cv_user_id')->name('self_exportpdf_cv_user_id');
    //show thông tin trong chi tiết ứng viên có hidden phone và email
    Route::get('nha-tuyen-dung/pdf/page-cv/{user_id}.pdf', 'PdfController@employer_exportpdf_cv_user_id')->name('employer_exportpdf_cv_user_id');
    //show hết thông tin ứng viên trong app phan show full thông tin
    Route::get('nha-tuyen-dung/pdf/page-cv-full-cv/{user_id}.pdf', 'PdfController@employer_exportpdf_cv_user_id_full')->name('employer_exportpdf_cv_user_id_full');


    Route::get('ung-vien/pdf/tao-so-yeu-ly-lich/{employee_id}', 'PdfController@employer_exportpdf_so_yeu_ly_lich')->name('employer_exportpdf_ll');
    Route::get('ung-vien/pdf/tao-cv/{employee_id}', 'PdfController@employer_exportpdf_cv')->name('employer_exportpdf_cv');


    //kết quả đề thi
    Route::get('/ket-qua-thi-cua-ung-vien/{employee_id}/{job_facebook_id}', 'EmployeeController@detail_exam_employee')->name('detail_exam_employee');

    //    hồ sơ giáo viên
    Route::get('/ho-so-giao-vien-ung-tuyen/{teacher_id}', 'JobFaceUserController@detail_Submit_Teacher')->name('detail_Submit_Teacher');


    //    danh sách tin tuyển dụng ứng viên ứng tuyển tin nah tuyển dụng
    Route::get('/danh-sach-tin-ung-vien-ung-tuyen/nha-tuyen-dung', 'JobUserController@list_Job_Candidate_Employee')->name('list_Job_Candidate_Employee');

    Route::get('/danh-sach-tin-ung-vien-ung-tuyen/nha-tuyen-dung-vip', 'JobUserController@list_Job_Candidate_Employee_vip')->name('list_Job_Candidate_Employee_vip');

    Route::post('/cap-nhat-trang-thai/nha-tuyen-dung', 'JobUserController@update_id_status_job')->name('update_id_status_job');

    Route::get('/don-hang/danh-sach-tin-tuyen-dung', 'JobUserController@list_order_job')->name('list_order_job');
    Route::get('/don-hang/chi-tiet-don-hang/{order_id}', 'JobUserController@detail_order_job')->name('detail_order_job');
    Route::get('/don-hang/ho-so-ung-tuyen', 'JobUserController@list_submit_employee_order')->name('list_submit_employee_order');


    Route::post('/cap-nhat-trang-thai-thuc-tap/nha-tuyen-dung', 'JobUserController@update_id_status_intership')->name('update_id_status_intership');
    Route::get('/cap-nhat-trang-thai-ho-so-thuc-tap/nha-tuyen-dung', 'JobUserController@ajax_update_id_status_intership')->name('ajax_update_id_status_intership');

    Route::get('/danh-sach-ho-so-ung-tuyen/{job_id}', 'JobUserController@job_Candidate_Employee')->name('job_Candidate_Employee'); Route::get('/don-hang-ho-so-ung-tuyen/{job_id}', 'JobUserController@job_Candidate_Employee_order')->name('job_Candidate_Employee_order');
    //
    Route::get('trang-thai/ho-so-nha-tuyen-dung', 'JobUserController@ajax_status_submit_job')->name('ajax_status_submit_job');
    //    danh sách ứng viên ứng tuyển
    //    Route::get('/danh-sach-ung-vien-ung-tuyen/{job_facebook_id}', 'JobUserController@detail_Candidate_Employee')->name('detail_Candidate_Employee');


    //
    //    Route::post('/xoa-ho-so-trinh-do/ung-vien', 'JobFaceUserController@delete_Specialize_Employee')->name('delete_Specialize_Employee');

    Route::post('/cap-nhat-ho-so-qua-trinh-lam-viec/ung-vien', 'JobFaceUserController@update_Experience_Employee')->name('update_Experience_Employee');

    //    giao vien
    Route::post('/cap-nhat-ho-so/giao-vien', 'JobFaceUserController@updateTeacher')->name('updateTeacher');
    Route::post('/them-moi-ho-so-trinh-do/giao-vien', 'JobFaceUserController@store_Specialize_Teacher')->name('store_Specialize_Teacher');
    Route::post('/cap-nhat-ho-so-trinh-do/giao-vien', 'JobFaceUserController@update_Specialize_Teacher')->name('update_Specialize_Teacher');
    Route::post('/them-moi-ho-so-kinh-nghiem/giao-vien', 'JobFaceUserController@store_Experience_Teacher')->name('store_Experience_Teacher');
    Route::post('/cap-nhat-ho-so-kinh-nghiem/giao-vien', 'JobFaceUserController@update_Experience_Teacher')->name('update_Experience_Teacher');
    Route::post('/them-khoa-hoc/giao-vien', 'JobFaceUserController@store_Course_Teacher')->name('store_Course_Teacher');
    Route::post('/cap-nhat-khoa-hoc/giao-vien', 'JobFaceUserController@update_Course_Teacher')->name('update_Course_Teacher');


    //viec lam facebook
    Route::get('/viec-lam-yeu-thich-tu-facebook/ung-vien', 'JobFaceUserController@job_Like_Employee')->name('job_Like_Employee');
    Route::get('/viec-lam-da-luu-tu-facebook/ung-vien', 'JobFaceUserController@list_Job_Save_Employee')->name('list_Job_Save_Employee');
    Route::get('/viec-lam-da-nop-ho-sơ-facebook/ung-vien', 'JobFaceUserController@list_Job_Submit_Employee')->name('list_Job_Submit_Employee');

    //viec lam từ nhà tuyển dụng
    Route::get('/viec-lam-yeu-thich-tu-nha-tuyen-dung/ung-vien', 'JobUserController@jobs_Like_Employee')->name('jobs_Like_Employee');
    Route::get('/viec-lam-da-luu-tu-nha-tuyen-dung/ung-vien', 'JobUserController@list_Jobs_Save_Employee')->name('list_Jobs_Save_Employee');

    Route::get('/viec-lam-da-nop-ho-so-nha-tuyen-dung/ung-vien', 'JobUserController@list_Jobs_Submit_Employee')->name('list_Jobs_Submit_Employee');

    Route::get('/viec-lam-theo-doi-nha-tuyen-dung/ung-vien', 'JobUserController@list_employee_follow_employer')->name('list_employee_follow_employer');
    Route::get('/viec-lam-theo-doi-nha-tuyen-dung/{employer_id}', 'JobUserController@list_employee_follow_employer_id')->name('list_employee_follow_employer_id');

    //    tin tuyển dụng từ nhà tuyển dụng
    Route::resource('job-user', 'JobUserController');
    Route::get('ajax/check-content-career', 'JobUserController@ajax_show_content_career')->name('ajax_show_content_career');

    Route::get('ajax/check-content-career', 'JobUserController@ajax_show_content_career')->name('ajax_show_content_career');
    //đẩy tin
    Route::get('tin-tuyen-dung/day-tin/{job_id}', 'JobUserController@update_update_at')->name('update_update_at');
    //tạm dừng tin
    Route::get('tin-tuyen-dung/tam-dung/{job_id}', 'JobUserController@update_stop_job')->name('update_stop_job');
    Route::get('quan-ly/viec-lam-tu-nha-tuyen-dung', 'JobUserController@getAllJobs')->name('getAllJobs');

    Route::get('quan-ly/hr-dang-tuyen-ho-cong-ty', 'JobUserController@get_job_all_vip')->name('get_job_all_vip');

    Route::get('ajax/ajax_get_company_id', 'JobUserController@ajax_get_company_id')->name('ajax_get_company_id');

    Route::get('quan-ly/them-hr-dang-tuyen-ho-cong-ty', 'JobUserController@create_job_all_vip')->name('create_job_all_vip');
    Route::post('quan-ly/luu-hr-dang-tuyen-ho-cong-ty', 'JobUserController@save_job_all_vip')->name('save_job_all_vip');
    Route::get('quan-ly/sua-hr-dang-tuyen-ho-cong-ty/{job_id}', 'JobUserController@edit_job_all_vip')->name('edit_job_all_vip');
    Route::post('quan-ly/cap-nhat-hr-dang-tuyen-ho-cong-ty', 'JobUserController@update_job_all_vip')->name('update_job_all_vip');

    Route::get('quan-ly/dang-ho-tin-tuyen-dung', 'JobUserController@get_job_facebook')->name('get_job_facebook');

    Route::get('quan-ly/danh-sach-ho-so-nop-tin-dang-ho/{job_facebook_id}', 'JobUserController@submit_job_facebook')->name('submit_job_facebook');
    //Route::get('quan-ly/thong-tin-ung-vien/{submit_job_fb_id}', 'JobUserController@detail_employee_submit_job_facebook')->name('detail_employee_submit_job_facebook');

    //điểm nhà tuyển dụng
    Route::get('diem-nha-tuyen-dung/lich-su-giao-dich', 'JobUserController@list_transaction_coin_employer')->name('list_transaction_coin_employer');
    Route::get('diem-nha-tuyen-dung/danh-sach-ung-vien-da-xem', 'JobUserController@list_coin_employer_show_employee')->name('list_coin_employer_show_employee');
    Route::get('diem-nha-tuyen-dung/danh-sach-ung-vien-da-moi', 'JobUserController@list_coin_employer_invitation_employee')->name('list_coin_employer_invitation_employee');

    Route::get('diem-nha-tuyen-dung/danh-sach-ung-vien-da-moi-cong-viec/{job_id}', 'JobUserController@list_invitation_employee_job')->name('list_invitation_employee_job');

    Route::get('diem-nha-tuyen-dung/moi-ung-vien-dong-loat', 'JobUserController@list_coin_employees_invitation_job')->name('list_coin_employees_invitation_job');
    Route::get('diem-nha-tuyen-dung/moi-ung-vien-dong-loat-ung-tuyen/{job_id}', 'JobUserController@list_coin_employees_invitation_job_apply')->name('list_coin_employees_invitation_job_apply');
    Route::post('diem-nha-tuyen-dung/moi-danh-sach-ung-vien-ung-tuyen', 'JobUserController@send_employees_invitation_job_apply')->name('send_employees_invitation_job_apply');

    //    tin tuyển dụng từ facebook
    Route::resource('job-face-user', 'JobFaceUserController');
    Route::post('tu-van/dang-ky-nhan-tu-van', 'ResAdvisoryController@createResAdvisory')->name('createResAdvisory');
    Route::get('quan-ly/viec-lam-facebook', 'JobFaceUserController@getAllUser')->name('getAllUser');
    Route::get('bao-tin-sai/{id_job_fb}', 'JobFaceUserController@addWarning')->name('addWarning');
    Route::get('luu-viec-lam-facebok/{id_job_fb}', 'JobFaceUserController@saveJobFacebook')->name('saveJobFacebook');
    Route::get('huy-luu-viec-lam-facebok/{id_job_fb}', 'JobFaceUserController@deletesaveJobFacebook')->name('deletesaveJobFacebook');
    Route::get('luu-viec-lam/{id_job}', 'JobUserController@saveJob')->name('saveJob');
    Route::get('huy-luu-viec-lam/{id_job}', 'JobUserController@deletesaveJob')->name('deletesaveJob');

    //    login facebook
    Route::get('auth/facebook', 'FacebookAuthController@redirectToProvider')->name('facebook.login');
    Route::get('auth/facebook/callback', 'FacebookAuthController@handleProviderCallback');


    Route::get('login-token/{token}', 'LoginApiController@login_api');
    Route::get('login-token-danh-sach-ho-so-ung-tuyen/{token}', 'LoginApiController@login_api_submit_job');
    //thông kê ứng viên;
    Route::resource('statiscal_site', 'StatisticalController');
    Route::get('thong-ke/ung-vien-xem-tin-tuyen-dung/{val}', 'StatisticalController@updateStatiscal_view_job')->name('updateStatiscal_view_job');

    //  nop ho so (mặc định hồ sơ ứng viên)
    Route::get('nop-ho-so-viec-lam/{id_job_fb}/{status_job}', 'JobUserSubmitController@submitFileJobFacebook')->name('submitFileJobFacebook');
    Route::post('nop-ho-so-viec-lam/ung-tuyen-ngay', 'JobUserSubmitController@submit_apply_now')->name('submit_apply_now');

    Route::get('nop-ho-so-thanh-cong/{submit_job_fb_id}', 'JobUserSubmitController@show_appy_to_success')->name('show_appy_to_success');

    Route::get('thi-trac-nghiem/viec-lam/{id_job_fb}', 'JobUserSubmitController@submitExamJob')->name('submitExamJob');
    Route::post('nop-ho-so-viec-lam/ket-qua-de-thi', 'JobUserSubmitController@createResultJobExam')->name('createResultJobExam');

    Route::get('thi-trac-nghiem/nop-ho-so/{id_result_job_exam}', 'JobUserSubmitController@showResultExam')->name('showResultExam');
    //nop ho so ung vien

    Route::post('ajax/luu-bai-thi/cong-viec', 'JobUserSubmitController@update_question_showResultExam')->name('update_question_showResultExam');

    Route::post('cap-nhat-thong-tin-ung-vien/ung-tuyen', 'JobUserSubmitController@updateEmployeeSubmit')->name('updateEmployeeSubmit');
    //ung tuyen cong viec thành công
    Route::get('ung-tuyen-thanh-cong/{job_id}', 'JobUserSubmitController@applySucces')->name('applySucces');
    Route::get('ung-tuyen-thanh-cong-chua-kiem-duyet/{job_id}', 'JobUserSubmitController@applySucces_job_facebook')->name('applySucces_job_facebook');
    Route::post('tra-loi-cau-hoi/ung-vien', 'JobUserSubmitController@employee_answer')->name('employee_answer');
    //nop ho so ung vien
    //   nop ho so khi chua dang nhap
    Route::post('tao-moi-thong-tin-ung-vien/ung-tuyen', 'JobUserSubmitController@createEmployeeSubmit')->name('createEmployeeSubmit');
    //   nop ho so giao vien
    Route::post('cap-nhat-thong-tin-giao-vien/ung-tuyen', 'JobUserSubmitController@updateTeacherSubmit')->name('updateTeacherSubmit');
    //tìm kiếm chi nhánh
    Route::get('tim-kiem/chi-nhanh', 'InformationServiceController@search_branch')->name('search_branch');

    //site map công việc facebook
    Route::get('sitemap/sitemap.xml', 'SiteMapController@sitemap_all');
    Route::get('sitemap/jobfacebook.xml', 'SiteMapController@sitemap_jobfacebook');
    //site map công việc NTD
    Route::get('sitemap/job.xml', 'SiteMapController@sitemap_job');
    //site map cổng thực tập
    Route::get('sitemap/intership.xml', 'SiteMapController@sitemap_intership');
    //danh mục tài liệu
    Route::get('sitemap/category_voucher.xml', 'SiteMapController@category_voucher');
    //site map kho tài liệu
    Route::get('sitemap/voucher.xml', 'SiteMapController@sitemap_voucher');
    //site map danh mục tin tức
    Route::get('sitemap/categories.xml', 'SiteMapController@sitemap_categories');
    //site map tin tức
    Route::get('sitemap/post.xml', 'SiteMapController@sitemap_post');
    //site map đề thi
    Route::get('sitemap/exam.xml', 'SiteMapController@sitemap_exam');
    //site map giáo viên
    Route::get('sitemap/teacher.xml', 'SiteMapController@sitemap_teacher');
    //site map chi tiết nhà tuyển dụng
    Route::get('sitemap/employer.xml', 'SiteMapController@sitemap_employer');
    //site map danh sach ke toan tai cac thanh pho
    Route::get('sitemap/list_provice_category_career.xml', 'SiteMapController@list_provice_category_career');

    //total_get_all_coe trong số lương
    Route::get('sitemap/coe_salary.xml', 'SiteMapController@coe_salary');

    //site map danh sach ke toan tai cac thanh pho
    //site map danh mục tag
    Route::get('sitemap/tag.xml', 'SiteMapController@sitemap_tag');
    Route::get('sitemap/tag_post.xml', 'SiteMapController@sitemap_tag_post');
    Route::get('sitemap/tag_voucher.xml', 'SiteMapController@sitemap_tag_voucher');
    Route::get('sitemap/tag_job.xml', 'SiteMapController@sitemap_tag_job');


    Route::get('email/send_email', 'MailConfigController@test_send_email');


    Route::get('email/view_send_email', 'MailConfigController@view_send_email')->name('view_send_email');
    Route::post('email/tien-hanh-gui-email', 'MailConfigController@post_send_email')->name('post_send_email');


    //courser ugn vien dang ky khoa hoc
    Route::get('dang-ky-hoc/{teacher_id}', 'TeacherViewController@joblearn')->name('joblearn');
    Route::get('ung-vien/danh-sach-khoa-hoc-da-dang-ky', 'TeacherViewController@listlearn')->name('listlearn');


    Route::get('ung-vien/danh-gia-ung-vien-theo-thang/{id_teacher_learn}', 'TeacherViewController@starlearn')->name('starlearn');
    Route::post('ung-vien/danh-gia-khoa-hoc', 'TeacherViewController@addstarlearn')->name('addstarlearn');
    Route::post('ung-vien/sua-danh-gia-khoa-hoc', 'TeacherViewController@updatestarlearn')->name('updatestarlearn');

    Route::get('giao-vien-khoa-hoc/ung-vien-dang-ky', 'TeacherViewController@teacher_learn_employee')->name('teacher_learn_employee');
    Route::post('giao-vien-khoa-hoc/cap-nhat-khoa-hoc', 'TeacherViewController@update_teacher_learn')->name('update_teacher_learn');

    // list cate job



    //    tin tuyen dung nha tuyen dung
    Route::get('giao-vien/{cate}/{post_teacher}', 'TeacherViewController@detail_new')->name('detail_new');
    Route::get('thuc-tap-ke-toan/{cate_slug_intership}/{post_slug}', 'EmployerController@detail_new_intership')->name('detail_new_intership');

    Route::get('viec-lam-ke-toan/danh-sach-viec-lam', 'JobGroupController@listCateJob')->name('list_cate_job');

    Route::get('viec-lam-ke-toan/tim-kiem-viec-lam', 'JobGroupController@submit_search')->name('submit_search');
    Route::get('viec-lam-ke-toan/{slug}', 'JobGroupController@search_job')->name('search_job');


    //thong bao
    Route::get('/thong-bao/test-thong-bao', 'NotificationWindowController@index')->name('notification');
    Route::get('/thong-bao/ung-vien', 'NotificationWindowController@noti_employee')->name('noti_employee');
    Route::get('/thong-bao/nha-tuyen-dung', 'NotificationWindowController@noti_employer')->name('noti_employer');
    Route::get('/thong-bao/giao-vien', 'NotificationWindowController@noti_teacher')->name('noti_teacher');
    //    cứ 5s kiểm tra thông báo 1 lần
    Route::get('/thong-bao/kiem-tra-thong-bao-moi', 'NotificationWindowController@ajax_checkNoti')->name('ajax_checkNoti');
    Route::get('/thong-bao/update-thong-bao-moi', 'NotificationWindowController@ajax_update_view_window')->name('ajax_update_view_window');
    Route::get('/thong-bao/update-trang-thai-thong-bao-moi', 'NotificationWindowController@ajax_update_status')->name('ajax_update_status');
    Route::get('/thong-bao/xoa-thong-bao', 'NotificationWindowController@ajax_delete_noti')->name('ajax_delete_noti');

    Route::get('chi-tiet/tin-ho-tro', 'PostController@ajax_post_content')->name('ajax_post_content');
    Route::get('tim-kiem/tin-ho-tro', 'PostController@search_post_ajax')->name('search_post_ajax');
    //    ajax cong luot view chia se
    Route::get('chia-se-facebook/tinh-luot-chia-se/', 'PostSaleMoneyController@add_ajax_sale_money')->name('add_ajax_sale_money');
    //    ajax tinh tiến cho khóa học
    Route::get('chia-se-khoa-hoc/tinh-luot-chia-se/', 'PostSaleMoneyController@add_ajax_sale_money_course')->name('add_ajax_sale_money_course');


    //ajax tạo ứng viên chia se bài viết
    Route::get('chia-se-facebook/tao-ung-vien/', 'PostSaleMoneyController@create_employee_share')->name('create_employee_share'); //ajax tạo ứng viên chia se bài viết
    Route::get('chia-se-khoa-hoc/tao-ung-vien/', 'PostSaleMoneyController@create_employee_share_course')->name('create_employee_share_course'); //ajax tạo ứng viên chia se bài viết

    Route::get('chia-se-facebook/xoa-luot-xem-theo-ngay/', 'PostSaleMoneyController@delete_post_sale_money')->name('delete_post_sale_money');

    Route::get('chia-se-khoa-hoc/xoa-luot-xem-theo-ngay/', 'PostSaleMoneyController@delete_course_sale_money')->name('delete_course_sale_money');

    //chia se tin tin thuc tap
    Route::get('chia-se-facebook/tin-thuc-tap/', 'EmployerSaleMoneyController@create_employee_share_employer')->name('create_employee_share_employer'); //ajax tạo ứng viên chia se bài viết




    Route::get('chia-se-facebook/danh-sach-top-bai-viet-chia-se/', 'ListTopController@list_post_share')->name('list_post_share');
    Route::get('chia-se-facebook/danh-sach-top-tin-tuyen-dung-chia-se/', 'ListTopController@list_job_share')->name('list_job_share');
    Route::get('chia-se-facebook/hien-thi-danh-sach-bai-viet-chia-se/', 'ListTopController@show_list_post')->name('show_list_post');

    Route::get('chia-se-facebook/hien-thi-danh-sach-tin-tuyen-dung-chia-se/', 'ListTopController@show_list_job')->name('show_list_job');

    Route::get('chia-se-facebook/danh-muc-chia-se/', 'ListTopController@show_category_post')->name('show_category_post');
    Route::get('chia-se-facebook/danh-muc-top-chia-se/', 'ListTopController@list_category_post_share')->name('list_category_post_share');

    Route::get('chia-se-facebook/danh-sach-phan-mem-doi-thuong/', 'ListTopController@list_change_product')->name('list_change_product');


    //chia sẻ tài liệu -tạm dừng bên sanketoan.vn
    Route::get('chia-se-tai-lieu/tao-ung-vien/', 'VoucherSaleMoneyController@create_employee_share_voucher')->name('create_employee_share_voucher');
    Route::get('chia-se-tai-lieu/tinh-luot-chia-se/', 'VoucherSaleMoneyController@add_ajax_sale_money_voucher')->name('add_ajax_sale_money_voucher');
    Route::get('chia-se-tai-lieu/xoa-luot-xem-theo-ngay/', 'VoucherSaleMoneyController@delete_post_sale_money_voucher')->name('delete_post_sale_money_voucher'); //ajax tạo ứng viên chia se bài viết

    //chia sẻ bài tuyển dụng
    Route::post('chia-se-tin-tuyen-dung/tinh-luot-chia-se/', 'JobSaleMoneyController@add_ajax_sale_money_job')->name('add_ajax_sale_money_job');
    Route::get('chia-se-tin-thuc-tap/tinh-luot-chia-se/', 'EmployerSaleMoneyController@add_ajax_sale_money_employer')->name('add_ajax_sale_money_employer');

    Route::get('tinh-tong/tin-tuyen-dung/', 'JobSaleMoneyController@get_total_sale_money_employer')->name('get_total_sale_money_employer');
    //ajax tạo ứng viên chia se bài viết


    Route::get('chia-se-tin-tuyen-dung/tao-ung-vien/', 'JobSaleMoneyController@create_employee_share_job')->name('create_employee_share_job'); //ajax tạo ứng viên chia se bài viết
    Route::get('chia-se-tin-tuyen-dung/xoa-luot-xem-theo-ngay/', 'JobSaleMoneyController@delete_post_sale_money_job')->name('delete_post_sale_money_job');
    Route::get('chia-se-tin-thuc-tap/xoa-luot-xem-theo-ngay/', 'EmployerSaleMoneyController@delete_post_sale_money_employer')->name('delete_post_sale_money_employer');
    //    Route::get('chia-se-tin-tuyen-dung/danh-sach-top-bai-viet-chia-se/', 'ListTopController@list_post_share')->name('list_post_share');
    Route::get('chia-se-tin-tuyen-dung/hien-thi-danh-sach-bai-viet-chia-se/', 'JobSaleMoneyController@show_list_post_job')->name('show_list_post_job');

    // từ khóa (TAG)
    Route::get('tu-khoa/bai-viet', 'CategoryTagController@list_type_post')->name('list_type_post');
    Route::get('bai-viet/{tag_slug}', 'CategoryTagController@detail_type_post')->name('detail_type_post');

    Route::get('tu-khoa/tai-lieu', 'CategoryTagController@list_type_voucher')->name('list_type_voucher');
    Route::get('tai-lieu/{tag_slug}', 'CategoryTagController@detail_type_voucher')->name('detail_type_voucher');

    Route::get('tu-khoa/viec-lam', 'CategoryTagController@list_type_job')->name('list_type_job');
    Route::get('viec-lam-tag/{tag_slug}', 'CategoryTagController@detail_type_job')->name('detail_type_job');
    // END TAG



    Route::get('bang-gia/dich-vu', 'ListPriceController@list_price')->name('list_price');
    Route::get('bang-gia/dich-vu-mien-phi', 'ListPriceController@list_price_free')->name('list_price_free');

    Route::get('bang-gia/dich-vu/{slug}', 'ListPriceController@detail_list_price')->name('detail_list_price');
    Route::get('bang-gia/lay-binh-luan-cua-dich-vu', 'ListPriceController@get_comment')->name('get_comment');
    Route::get('xuat-pdf/bang-gia/{id}', 'PdfController@pdf_list_price')->name('pdf_list_price');
    Route::get('xuat-pdf/bang-gia-tuyen-dung/{id}', 'PdfController@pdf_list_price_hunter')->name('pdf_list_price_hunter');
    Route::get('dang-ky/dich-vu', 'ListPriceController@pay_price')->name('pay_price');
    Route::get('dang-ky/su-dung-icon', 'ListPriceController@pay_icon')->name('pay_icon');
    Route::post('dang-ky/dich-vu', 'ListPriceController@save_order')->name('save_order');
    Route::post('dang-ky/su-dung-icon', 'ListPriceController@save_order_icon')->name('save_order_icon');
    Route::get('thanh-toan/dich-vu', 'ListPriceController@bank_price')->name('bank_price');
    Route::get('dich-vu/tuyen-dung-thue', 'ListPriceController@registration_hunter')->name('registration_hunter');
    Route::post('dich-vu/tuyen-dung-thue', 'ListPriceController@save_registration_hunter')->name('save_registration_hunter');

    Route::get('service_table_price/service_table_price_id/{service_table_price_id}', 'ListPriceController@ajax_get_detail')->name('ajax_get_detail');

    //đào tạo
    Route::get('dao-tao/chuyen-muc', 'EducateCategoriesController@list_edu_categories')->name('list_edu_categories');
    Route::get('dao-tao/chuyen-muc/{slug}', 'EducateCategoriesController@edu_categories')->name('edu_categories');
    Route::get('dao-tao-lop/{slug}', 'EducateClassController@detail_edu_class')->name('detail_edu_class');
    Route::post('dao-tao/dang-ki-lop-hoc', 'EducateClassController@register_educate')->name('register_educate');
    Route::get('dao-tao/danh-sach-ung-vien-da-dang-ki/{slug_class}', 'EducateClassController@list_educate_employee')->name('list_educate_employee');

    //nhung banner ve may
    Route::get('embed/banner.html', 'HomeController@embed_banner')->name('embed_banner');

    //Kho tài liệu
    Route::get('{slugCategoryVoucher}/kho-tai-lieu', 'VoucherCategoriesController@getAllCategoryVoucher')->name('getAllCategoryVoucher');
    Route::get('{slugChildVoucher}/danh-muc', 'VoucherCategoriesController@getChildVoucher')->name('getChildVoucher');
    Route::get('/{slug_voucher}', 'VoucherCategoriesController@getVoucher')->name('getVoucher');
    Route::get('tim-kiem/tai-lieu', 'VoucherCategoriesController@searchVoucher')->name('searchVoucher');
    Route::get('binh-luan/tai-lieu', 'VoucherCommentController@addComment')->name('addComment');
    Route::get('dowload-tai-lieu/{id}', 'VoucherCategoriesController@dowload_total')->name('dowload_total');

    Route::get('/gioi-thieu/app-san-ke-toan', 'PostController@intro_app_sanketoan')->name('intro_app_sanketoan');
    Route::get('/test/danh-sach-podcard', 'PostController@list_podcard')->name('podcard');

    //danh sach to tu ván
    Route::get('/gia-su/ke-toan', 'UserSupportAdvieController@user_support_advise')->name('user_support_advise');
    Route::get('/dang-ky/gia-su', 'UserSupportAdvieController@res_user_advise')->name('res_user_advise');
    Route::get('/dang-ky/tu-van-ke-toan', 'UserSupportAdvieController@res_user_support')->name('res_user_support');

    Route::get('/dang-ky/ke-noi-ke-toan/{user_id}', 'UserSupportAdvieController@get_connect_user_support')->name('get_connect_user_support');

    Route::get('/chi-tiet-gia-su/{slug}', 'UserSupportAdvieController@detail_user_teacher')->name('detail_user_teacher');
    Route::get('/chi-tiet-ke-toan/{slug}', 'UserSupportAdvieController@detail_user_employee')->name('detail_user_employee');

    Route::post('/dang-ky-thanh-vien/to-tu-van', 'UserSupportAdvieController@res_advise')->name('res_advise');
    Route::post('/dang-ky-ho-tro/to-tu-van', 'UserSupportAdvieController@res_support')->name('res_support');

    //gửi email
    Route::post('/dang-ky/nhan-gia-su-1-1', 'UserSupportAdvieController@user_advise_submit')->name('user_advise_submit');
    //gửi email
    Route::post('/dang-ky/tu-van-ke-toan', 'UserSupportAdvieController@support_user_advise')->name('support_user_advise');
    //gia sư - danh sách kế toán cần tư vấn
    Route::get('/danh-sach/tu-van-ke-toan', 'UserSupportAdvieController@list_advise_user')->name('list_advise_user');
    //gửi email
    Route::post('/danh-sach/cap-nhat-trang-thai-giang-vien', 'UserSupportAdvieController@list_update_advise_status')->name('list_update_advise_status');

    //kế toán danh sách nhưng gia sư muốn tư vấn
    Route::get('/danh-sach/gia-su-ke-toan', 'UserSupportAdvieController@list_support_user')->name('list_support_user');
    //gửi email
    Route::post('/danh-sach/cap-nhat-trang-thai-ke-toan/{ques_id}', 'UserSupportAdvieController@list_update_support_status')->name('list_update_support_status');



    //hệ số lương
    Route::get('tinh/he-so-luong', 'CoefficientsSalaryController@get_all_coe')->name('get_all_coe');
    Route::post('tinh-toan/he-so-luong', 'CoefficientsSalaryController@post_sum_coe')->name('post_sum_coe');
    Route::get('he-so-luong/{career_category_slug}/{coe_id}', 'CoefficientsSalaryController@total_get_all_coe')->name('total_get_all_coe');
    //video SKT
    Route::get('video/ke-toan-truong', 'VideoSktController@video_skt')->name('video_skt');
    Route::get('chi-tiet-video/{slug}', 'VideoSktController@detail_video_skt')->name('detail_video_skt');

});



Route::group(['namespace' => 'Site', 'middleware' => 'HtmlMifier'], function () {
    require('test_login.php');
    Route::get('{slug_cate}/tin-tuc', 'CategoryController@index')->name('site_category_post');
    Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');
    Route::get('test/test/{post_slug}', 'PostController@test')->name('post_test');
    Route::get('ho-tro-ho-so/{cate_slug}/{post_slug}.html', 'PostController@support')->name('support');

});
