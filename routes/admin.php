<?php
Route::group(['middleware' => 'HtmlMifier', 'prefix' => 'admin', 'namespace' => 'Admin', ' ' => ['admin']], function () {
    Route::get('home', 'AdminController@home')->name('admin_home');

    // // route Ajax thêm mới từ khóa
    // Route::get('them-tu-khoa-ajax','CategoryTagController@them_tu_khoa_ajax')->name('them_tu_khoa_ajax');

    Route::resource('posts', 'PostController');
    Route::resource('list_product', 'ListProductController');
    Route::resource('money_month', 'MoneyMonthPayController');
    Route::resource('employee_coints', 'EmployeeCointsController');
    Route::get('danh-sach-ung-vien-gioi-thieu-nha-tuyen-dung', 'EmployeeCointsController@list_employee_intro')->name('list_employee_intro');
//    Route::get('chi-tiet-danh-sach-ung-vien-gioi-thieu/{intro_id}', 'EmployeeCointsController@detail_employee_intro')->name('detail_employee_intro');
    Route::get('duyet-gioi-thieu/{intro_id}', 'EmployeeCointsController@update_status_employee_intro')->name('update_status_employee_intro');
    Route::resource('cv_template', 'Cv_templateController');

//dao tao
    Route::resource('educate_categories', 'EducateCategoriesController');
    Route::resource('educate_class', 'EducateClassController');
    Route::resource('educate_teacher', 'EducateTeacherController');
    Route::resource('educate_employees_class', 'EducateEmployeesClassController');
    Route::resource('adv_noti', 'AdvNotiController');


    //Danh mục của khóa học
    Route::resource('category_course', 'Course\CategoryCourseController');
    //Hình thức học
    Route::resource('course_formality', 'Course\CourseFormalityController');
    //khóa học
    Route::resource('courses', 'Course\CoursesController');
//    Route::resource('learn_training', 'Course\Learn_trainingController');
//    Route::resource('learn_training_content', 'Course\Learn_training_contentController');
    Route::resource('training', 'Course\TrainingController');

    Route::get('danh-sach-hinh-thuc-dao-tao/{course_id}', 'Course\CoursesController@list_learn')->name('list_learn');
    Route::get('them-moi-hinh-thuc-dao-tao/{course_id}', 'Course\CoursesController@create_learn')->name('create_learn');
    Route::post('luu-hinh-thuc-dao-tao/{course_id}', 'Course\CoursesController@store_learn')->name('store_learn');
    Route::get('cap-nhat-hinh-thuc-dao-tao/{learn_id}', 'Course\CoursesController@edit_learn')->name('edit_learn');
    Route::post('update-hinh-thuc-dao-tao/{learn_id}', 'Course\CoursesController@update_learn')->name('update_learn');
    Route::post('xoa-hinh-thuc-dao-tao/{learn_id}', 'Course\CoursesController@delete_learn')->name('delete_learn');

    Route::get('danh-sach-hinh-thuc-dao-tao-da-xoa/{course_id}', 'Course\CoursesController@list_delete_learn')->name('list_delete_learn');
    Route::get('khoi-phuc-hinh-thuc-dao-tao-da-xoa/{learn_id}', 'Course\CoursesController@restore_learn')->name('restore_learn');
    Route::post('xoa-vinh-vien-hinh-thuc-dao-tao-da-xoa/{learn_id}', 'Course\CoursesController@force_delete_learn')->name('force_delete_learn');


    Route::get('danh-sach-hinh-thuc-hoc/{course_id}', 'Course\CoursesController@list_formality')->name('list_formality');
    Route::post('them-hinh-thuc-khoa-hoc', 'Course\CoursesController@store_formality')->name('store_formality');
    Route::post('cap-nhat-hinh-thuc-hoc', 'Course\CoursesController@update_formality')->name('update_formality');
    Route::post('xoa-hinh-thuc-hoc/{course_join_formality_id}', 'Course\CoursesController@delete_formality')->name('delete_formality');

    Route::get('kiem-tra-ma-khoa-hoc', 'Course\CoursesController@ajax_check_courses_code')->name('ajax_check_courses_code');
    Route::get('thong-tin-khoa-hoc/{course_id}', 'Course\CoursesController@detail_course')->name('detail_course');
    //thêm chương cho khóa học
    Route::post('them-chuong-cho-khoa-hoc', 'Course\CourseChaptersController@store_course_chapter')->name('admin_store_course_chapter');
    Route::post('cap-nhat-chuong-cho-khoa-hoc', 'Course\CourseChaptersController@update_course_chapter')->name('admin_update_course_chapter');
    Route::post('xoa-chuong-cua-khoa-hoc/{course_chapter_id}', 'Course\CourseChaptersController@delete_course_chapter')->name('admin_delete_course_chapter');
    //thêm bài học cho chương
    Route::get('thong-tin-chuong-cua-khoa-hoc/{course_chapter_id}', 'Course\CourseChaptersController@list_chapters')->name('list_chapters');
    Route::post('them-bai-hoc-cho-chuong', 'Course\CourseChapterContentsController@store_chapter_content')->name('store_chapter_content');
    Route::post('cap-nhat-bai-hoc-chuong', 'Course\CourseChapterContentsController@update_chapter_content')->name('update_chapter_content');
    Route::post('xoa-bai-hoc-chuong/{course_content_id}', 'Course\CourseChapterContentsController@delete_chapter_content')->name('delete_chapter_content');
    //thêm câu hỏi trắc nghiệm cho khóa học
    Route::get('danh-sach-de-thi-cho-bai-hoc/{course_content_id}', 'Course\CourseChapterContentsController@list_question_content')->name('list_question_content');
    Route::get('them-moi-de-thi-cho-bai-hoc/{course_content_id}', 'Course\CourseChapterContentsController@add_question_content')->name('add_question_content');
    Route::post('luu-de-thi-cho-bai-hoc/{course_content_id}', 'Course\CourseChapterContentsController@create_question_content')->name('create_question_content');
    Route::get('chinh-sua-de-thi-cho-bai-hoc/{id_ques}', 'Course\CourseChapterContentsController@edit_question_content')->name('edit_question_content');
    Route::post('cap-nhat-de-thi-cho-bai-hoc/{id_ques}', 'Course\CourseChapterContentsController@update_question_content')->name('update_question_content');
    Route::post('xoa-de-thi-cho-bai-hoc/{id_ques}', 'Course\CourseChapterContentsController@delete_question_content')->name('delete_question_content');

    //thêm tài liệu cho bài học
    Route::get('thong-tin-tai-lieu-cua-bai-hoc/{course_content_id}', 'Course\CourseChapterContentsController@list_content_voucher')->name('list_content_voucher');
    Route::post('them-tai-lieu-cho-bai-hoc', 'Course\CourseContentVoucherController@store_content_voucher')->name('store_content_voucher');
    Route::post('cap-nhat-tai-lieu-cho-bai-hoc', 'Course\CourseContentVoucherController@update_content_voucher')->name('update_content_voucher');
    Route::post('xoa-tai-lieu-cho-bai-hoc/{course_content_voucher_id}', 'Course\CourseContentVoucherController@delete_content_voucher')->name('delete_content_voucher');
    //thêm tài liệu đáp án cho bài học
    Route::post('them-tai-lieu-dap-an-cho-bai-hoc', 'Course\CourseContentVoucherController@store_content_voucher_answer')->name('store_content_voucher_answer');
    Route::post('cap-nhat-tai-lieu-dap-an-cho-bai-hoc', 'Course\CourseContentVoucherController@update_content_voucher_answer')->name('update_content_voucher_answer');
    Route::post('xoa-tai-lieu-dap-an-cho-bai-hoc/{course_content_voucher_answer_id}', 'Course\CourseContentVoucherController@delete_content_voucher_answer')->name('delete_content_voucher_answer');

    //danh sách đơn hàng đăng kí khóa học
    Route::resource('course_order', 'Course\CourseOrderController');
    Route::get('course_order_sales_statistics', 'Course\CourseOrderController@course_order_sales_statistics')->name('course_order_sales_statistics');
    //danh sách ứng viên đăng kí khóa học
    Route::resource('course_employee', 'Course\CourseEmployeeController');
    //danh sách feedback của khóa học
    Route::resource('course_feedback', 'Course\CourseFeedbackController');
    //danh sách câu hỏi của khóa học
    Route::resource('course_questions', 'Course\CourseQuestionsController');
    //danh sách từ khóa của khóa học
    Route::resource('course_tag', 'Course\CourseTagController');


    Route::resource('course_chapter', 'Course\CourseChaptersController');


    Route::get('danh-sach-ung-vien-dang-ki/{educate_class_id}', 'EducateClassController@list_educate_employee_class')->name('list_educate_employee_class');

    Route::get('cau-hinh-cv/{cv_template_id}', 'Cv_templateController@setting_cv')->name('setting_cv');
    Route::post('cau-hinh-cv/cap-nhat', 'Cv_templateController@update_config_cv')->name('update_config_cv');

    Route::get('note/{cv_template_id}', 'Cv_templateController@note_cv')->name('note_cv');
    Route::post('note/cap-nhat', 'Cv_templateController@update_note_cv')->name('update_note_cv');

    Route::get('danh-sach-chi-se-bai-viet/{employee_id}', 'EmployeeCointsController@detail_employee_coints')->name('detail_employee_coints');
    Route::get('danh-sach-chi-se-tin-tuyen-dung/{employee_id}', 'EmployeeCointsController@detail_employee_coints_job')->name('detail_employee_coints_job');
    Route::post('cap-nhat-trang-thai/chia-se-bai-viet', 'EmployeeCointsController@update_status_employee_coints')->name('update_status_employee_coints');

    Route::resource('category_template_email', 'Category_template_emailController');
    Route::resource('template_email', 'Template_emailController');

    Route::get('danh-sach-mau-theo-danh-muc/{id_cate_tem}', 'Template_emailController@list_template')->name('list_template');
    Route::get('them-moi-mau-theo-danh-muc/{id_cate_tem}', 'Template_emailController@add_template')->name('add_template');

    Route::post('test-gui-email_template', 'Template_emailController@sendEmail')->name('sendEmail');

    Route::get('posts-add-question/{post_id}', 'PostController@add_question')->name('add_question');
    Route::post('posts-store-question', 'PostController@store_question')->name('store_question');

    Route::get('posts-edit-question/{post_ques_id}', 'PostController@edit_question')->name('edit_question');
    Route::post('posts-update-question', 'PostController@update_question')->name('update_question');
    Route::get('posts-delete-question/{post_ques_id}', 'PostController@delete_question')->name('delete_question');


    Route::get('posts-show', 'PostController@anyDatatables')->name('datatable_post');

    Route::get('posts-visiable', 'PostController@visiable')->name('visable_post');

// giao dịch đổi thẻ cào
    Route::resource('transaction_card', 'Transaction_history_cardController');
// giao dịch chuyển khoản
    Route::resource('transaction_bank', 'Transaction_history_bankController');
    Route::get('chuyen-khoan/dung-chuyen-khoan', 'Transaction_history_bankController@stop_list_bank')->name('stop_list_bank');

    Route::get('tam-dung/chuyen-khoan/{employee_id}', 'Transaction_history_bankController@stop_trannsaction_bank')->name('stop_trannsaction_bank');
    Route::get('khoi-phuc/chuyen-khoan/{employee_id}', 'Transaction_history_bankController@restore_trannsaction_bank')->name('restore_trannsaction_bank');

// giao dich đổi phần mềm
    Route::resource('transaction_product', 'Transaction_history_productController');


    Route::resource('pages', 'PageController');
    Route::get('pages-show', 'PageController@anyDatatables')->name('show_page');

// Quản lý công việc
    Route::resource('job', 'JobController');
    Route::resource('job_app', 'Job_applicationController');

    Route::resource('teacher_school', 'Teacher_schoolController');

    Route::resource('combo_advise', 'Combo_adviseController'); //gói gia sư
    Route::resource('user_advise', 'User_adviseController'); //tổ tư vấn



    Route::get('danh-sach-giang-vien/{ad_id}', 'User_adviseController@list_advise_connect')->name('list_advise_connect');
    Route::get('danh-sach-ke-toan-ket-noi', 'User_adviseController@list_user_suppotr_advise_connect')->name('list_user_suppotr_advise_connect');
    Route::post('cap-nhat-trang-thai-giang-vien', 'User_adviseController@update_advise_status')->name('update_advise_status');



    Route::resource('user_support', 'User_supportController'); // kế toán hỗ trợ
    Route::get('danh-sach-ke-toan-ho-tro/{sup_id}', 'User_supportController@list_support_connect')->name('list_support_connect');
    Route::post('cap-nhat-trang-thai-ket-toan-ket-noi', 'User_supportController@update_support_status')->name('update_support_status');

    Route::post('cap-nhat-trang-thai-show-an-ke-toan', 'User_supportController@update_advise_status')->name('update_advise_status');

    Route::get('danh-sach-noi-dung-ket-toan-ho-tro', 'User_supportController@list_user_suppotr_question')->name('list_user_suppotr_question');
    Route::get('ke-toan-ho-tro/{ques_id}', 'User_supportController@detail_question')->name('detail_question');
    Route::post('cap-nhat-ke-toan-ho-tro/{ques_id}', 'User_supportController@update_detail_question')->name('update_detail_question');


    Route::resource('list_price', 'ListPriceController');
    Route::resource('service_comment', 'ServiceCommentController');
    Route::resource('service_icon', 'ServiceIconController');
    Route::resource('service_hunter', 'ServiceHunterController');
    Route::resource('service_bank', 'ServiceBankController');
    Route::resource('service_benifit', 'ServiceBenifitController');
    Route::resource('service_name_benifit', 'ServiceNameBenifitController');
    Route::resource('service_order', 'ServiceOrderController');
    Route::resource('service_order_icon', 'ServiceOrderIconController');
    Route::resource('hunter_order', 'HunterOrderController');
    Route::resource('hunter_pos', 'HunterPosController');
    Route::resource('hunter_time', 'HunterTimeController');
    Route::resource('hunter_price', 'HunterPriceController');
    Route::get('/service_order_employer/index', 'ServiceOrderController@list_employer')->name('list_employer_to_add_service_order');
    Route::get('/hunter_order_employer/index', 'HunterOrderController@list_employer')->name('list_employer_to_add_hunter_order');
    Route::get('/order_icon_employer/index', 'ServiceOrderIconController@list_employer')->name('list_employer_to_add_order_icon');
    Route::resource('list_table_price', 'ListTablePriceController');
    Route::get('datatable_list_table_price', 'ListTablePriceController@anyDatatable')->name('dt_list_table_price');
    Route::get('/ajax-service-table-price/get', 'ServiceCommentController@ajaxServiceTable')->name('ajaxServiceTable');
    Route::resource('school_subject', 'School_subjectController');

    Route::get('cap-nhat-ma-cong-viec', 'JobController@update_job_code')->name('update_job_code');
    Route::get('xoa-job-de-nghi-xoa/{id}', 'JobController@Job_delete_with_admin')->name('Job_delete_with_admin');
    Route::get('bo-xoa-job-de-nghi-xoa/{id}', 'JobController@Job_undelete_with_admin')->name('Job_undelete_with_admin');
    Route::get('tin-de-nghi-xoa', 'JobController@listJobDeleteRequest')->name('listJobDeleteRequest');
    Route::get('tin-het-han', 'JobController@list_date_end')->name('list_date_end');
    Route::get('tin-vip', 'JobController@list_vip')->name('list_vip');
    Route::get('tin-thuong', 'JobController@list_believe')->name('list_believe');
    Route::get('tin-da-xoa', 'JobController@list_delete')->name('list_delete');

    Route::get('khoi-phuc-tin-tuyen-dung/{job_id}', 'JobController@Jobsrestore')->name('Jobsrestore');
    Route::get('xoa-vinh-vien-tin-tuyen-dung/{job_id}', 'JobController@JobsForceDelete')->name('JobsForceDelete');


// Ajax lấy thông tin của gói bán hàng
    Route::get('ajax-sale/{sale}', 'AjaxController@ajaxSale');

// Ajax lấy thông tin việc làm của NTD
    Route::get('ajax-job/{employer}', 'AjaxController@ajaxJob');

    Route::get('datatable_job', 'JobController@anyDatatable')->name('dt_job');

// Ajax lấy tỉnh thàng
    Route::get('ajax-district/{province}', 'AjaxController@ajaxProvince');

// Tìm kiếm công việc
    Route::get('job-search', 'JobController@search')->name('searchJob');

// Quản lý việc làm cần phê duyệt
    Route::get('jobApproval', 'JobController@jobApproval')->name('jobApproval');
    Route::get('datatable_jobApproval', 'JobController@anyDatatableApproval')->name('dt_jobApproval');

// Quản lý việc làm tồn
    Route::get('jobInventory', 'JobController@jobInventory')->name('jobInventory');
    Route::get('datatable_jobInventory', 'JobController@anyDatatableInventory')->name('dt_Inventory');

// Quản lý việc làm tuyển đủ người
    Route::get('jobEnough', 'JobController@jobEnough')->name('jobEnough');
    Route::get('datatable_jobEnough', 'JobController@anyDatatableEnough')->name('dt_Enough');

// Quản lý việc làm Vip
    Route::get('jobVip', 'JobController@jobVip')->name('jobVip');
    Route::get('datatable_jobVip', 'JobController@anyDatatableVip')->name('dt_jobVip');
// Ajax lấy thông tin nhà tuyển dụng
    Route::get('ajax-employer-province/{employer}', 'AjaxController@ajaxEmployerProvince');

    Route::get('ajax-employer-district/{employer}', 'AjaxController@ajaxEmployerDistrict');
    Route::get('ajax-employer-businessType/{employer}', 'AjaxController@ajaxEmployerBusinessType');
    Route::get('ajax-employer-typeBusiness/{employer}', 'AjaxController@ajaxEmployerTypeBusiness');

// Quản lý nhóm việc làm
    Route::resource('job-group', 'JobGroupController');
    Route::get('datatable_job_group', 'JobGroupController@anyDatatable')->name('dt_job_group');

    Route::resource('job-facebook', 'JobFacebookController');

    Route::get('danh-sach-tin-facebook-da-xoa', 'JobFacebookController@job_facebook_delete')->name('job_facebook_delete');
    Route::get('khoi-phuc-tin-facebook/{job_facebook_id}', 'JobFacebookController@Job_facebook_srestore')->name('Job_facebook_srestore');
    Route::get('xoa-vinh-vien-tin-facebook/{job_facebook_id}', 'JobFacebookController@Job_facebook_ForceDelete')->name('Job_facebook_ForceDelete');


    Route::get('cap-nhat-tin', 'JobFacebookController@update_job_facebook')->name('update_job_facebook');

    Route::get('thong_ke_user_dang_tin_fb', 'JobFacebookController@total_user_facebook')->name('total_user_facebook');

    Route::get('danh_sach_tin_fb_theo_ngay/{employer}', 'JobFacebookController@get_day_user_facebook')->name('get_day_user_facebook');
    Route::get('danh_sach_tin_fb_theo_thang/{employer}', 'JobFacebookController@get_month_user_facebook')->name('get_month_user_facebook');
    Route::get('danh_sach_tin_fb/{star_time}/{end_time}/{employer}', 'JobFacebookController@get_between_user_facebook')->name('get_between_user_facebook');

    Route::get('job-facebook_datatable', 'JobFacebookController@jobFacebookDatatable')->name('db_job_facebook');
//search tìm kiếm việc làm với bộ lọc trang chủ




//Quanr lys danh muc tuowng tacs cuar nhaf tuyeenr dungj
    Route::resource('employer_select_response', 'EmployerSelectResponseController');

    Route::get('tat-ca-phan-hoi-tu-ntd', 'EmployerSelectResponseController@list_employer_feedback')->name('list_employer_feedback');


    Route::get('chi-tiet-phan-hoi-cua-ntd/{employer_select_response_id}', 'EmployerSelectResponseController@detail_feedback_employer')->name('detail_feedback_employer');

    Route::get('tra-lai-diem-cho-ntd/{employer_response_cv_id}/{cojn_view_profile}', 'EmployerSelectResponseController@employer_feedback_coin')->name('employer_feedback_coin');


// Quản lý gói bán hàng
    Route::resource('sale', 'SaleController');
    Route::get('datatable_sale', 'SaleController@anyDatatable')->name('dt_sale');
    Route::get('nguoi-ban-hang-xuat-sac', 'SellersController@excellentSellers')->name('excellent_sellers');

// Ajax lưu thông tin ghi chú gói bán hàng
    Route::get('note-sale/content', 'SaleController@note')->name('note-sale');

// Quản lý đơn hàng
    Route::resource('order', 'OrderController');
    Route::get('datatable_order', 'OrderController@anyDatatable')->name('dt_order');
    Route::get('note-order/content', 'OrderController@note')->name('note-order');

    Route::get('order-affiliate', 'OrderController@affiliate')->name('order_affiliate');
    Route::get('order-complain', 'OrderController@complain')->name('order_complain');
    Route::get('order-deleted', 'OrderController@deleted')->name('order_deleted');
    Route::get('order-duplicate', 'OrderController@duplicate')->name('order_duplicate');

//Quản lý nhà tuyển dụng
    Route::resource('employer', 'EmployerController');
    Route::resource('employer_coin', 'Coin_employerController');

    Route::get('nha-tuyen-dung/danh-sach-nap-xu/{employer_id}', 'Coin_employerController@list_coin_employer')->name('list_coin_employer');
    Route::get('nha-tuyen-dung/them-xu/{employer_id}', 'Coin_employerController@create_coin_employer')->name('create_coin_employer');
    Route::post('nha-tuyen-dung/nap-xu', 'Coin_employerController@store_coin_employer')->name('store_coin_employer');
    Route::get('nha-tuyen-dung/sua-xu/{coin_money_id}', 'Coin_employerController@edit_coin_employer')->name('edit_coin_employer');
    Route::post('nha-tuyen-dung/cap-nhat-xu/{coin_money_id}', 'Coin_employerController@update_coin_employer')->name('update_coin_employer');
    Route::get('nha-tuyen-dung/xoa-xu/{coin_money_id}', 'Coin_employerController@delete_coin_employer')->name('delete_coin_employer');


    Route::get('nha-tuyen-dung/lich-su-giao-dich/{employer_id}', 'Coin_employerController@history_transaction_employer')->name('history_transaction_employer');
    Route::get('nha-tuyen-dung/lich-su-xem-ho-so/{employer_id}', 'Coin_employerController@history_employee_employer')->name('history_employee_employer');


//    id laf ma usser
    Route::get('nha-tuyen-dung-bi-de-nghi-xoa', 'EmployerController@listEmployerDeleteRequest')->name('listEmployerDeleteRequest');
    Route::get('xoa-nha-tuyen-dung-de-nghi-xoa/{id}', 'EmployerController@Employer_delete_with_admin')->name('Employer_delete_with_admin');
    Route::get('bo-xoa-nha-tuyen-dung-de-nghi-xoa/{id}', 'EmployerController@Employer_undelete_with_admin')->name('Employer_undelete_with_admin');
    Route::get('nha-tuyen-dung-da-xoa', 'EmployerController@listEmployerDelete')->name('listEmployerDelete');
    Route::get('khoi-phuc-nha-tuyen-dung/{id}', 'EmployerController@Employerestore')->name('Employerestore');
    Route::get('xoa-vinh-vien-nha-tuyen-dung/{id}', 'EmployerController@EmployerForceDelete')->name('EmployerForceDelete');


    Route::get('cap-nhat-dai-ly/{employer_id}', 'EmployerController@show_employer_angency')->name('show_employer_angency');
    Route::post('update', 'EmployerController@employer_angency')->name('employer_angency');

    Route::get('danh-sach-thuc-tap-ung-vien/{employer_id}', 'EmployerController@list_intership')->name('list_intership');
    Route::post('cap-nhat-trang-thai-thuc-tap', 'EmployerController@update_status_intership')->name('ad_update_status_intership');
    Route::post('xoa-thuc-tap', 'EmployerController@delete_intership')->name('ad_delete_intership');

    Route::get('xuat-file-excel', 'EmployerController@exportToExcel')->name('exportToExcel');


    Route::get('search-employer', 'EmployerController@search')->name('searchEmployer');
    Route::get('transaction/{employer}', 'EmployerController@transaction')->name('transaction');
    Route::get('datatable_transaction', 'EmployerController@anyDatatableTransaction')->name('dt_transaction');
    Route::get('datatable-employer', 'EmployerController@anyDatatable')->name('dt_employer');
    Route::get('note-employer', 'EmployerController@note')->name('note-employer');


// Ajax lấy thông tin nhân viên phụ trách
    Route::get('ajax-staff/{staff}', 'AjaxController@ajaxStaff')->name('ajax-staff');

//Ajax lấy thông tin nhà tuyển dụng
    Route::get('ajax-employer/{employer}', 'AjaxController@ajaxEmployer');

//Ajax lấy thông tin ứng viên
    Route::get('ajax-employee/{employee}', 'AjaxController@ajaxEmployee');

// Ajax tìm kiếm thông tin nhóm công việc
    Route::get('ajax-jobgroup/{jobGroupName}', 'AjaxController@ajaxJobGroup')->name('ajax-jobgroup');

// Ajax lấy tất cả thông tin nhóm công việc
    Route::get('ajax-jobgroup-list', 'AjaxController@ajaxJobGroupList')->name('ajax-jobgroup-list');

// Ajax lấy tất cả thông tin danh mục việc làm
    Route::get('ajax-career-list', 'AjaxController@ajaxCareerList')->name('ajax-career-list');

//Ajax tìm kiếm thông tin danh mục việc làm
    Route::get('ajax-career/{careerName}', 'AjaxController@ajaxCareer')->name('ajax-career');

//Ajax tìm kiếm thông tin loại hình doanh nghiệp
    Route::get('ajax-type/{typeName}', 'AjaxController@ajaxType');

// Ajax lấy tất cả thông tin loại hình doanh nghiệp
    Route::get('ajax-type-list', 'AjaxController@ajaxTypeList')->name('ajax-type-list');

//Ajax lấy tất cả thông tin loại hình kinh doanh
    Route::get('ajax-business-list', 'AjaxController@ajaxBusinessList')->name('ajax-business-list');

//Ajax tìm kiếm thông tin loại hình kinh doanh
    Route::get('ajax-business/{businessName}', 'AjaxController@ajaxBusiness');

// Quản lý ứng viên
    Route::resource('employee', 'EmployeeController');



    //Route::get('quet-diem-ho-so-ung-vien/{star}/{limit}', 'EmployeeController@clear_employee_coin')->name('clear_employee_coin');
    Route::get('quet-danh-muc-quan-huyen/{star}/{limit}', 'EmployeeController@clear_employee_district')->name('clear_employee_district');
    Route::get('quet-cv/{star}/{limit}', 'EmployeeController@clear_employee_cv')->name('clear_employee_cv');
    Route::get('quet-tao-cv-cho-ung-vien/{star}/{limit}', 'EmployeeController@create_employee_cv')->name('create_employee_cv');

    Route::get('quet-profile-cv/{star}/{limit}', 'EmployeeController@clear_profile')->name('clear_profile');
    Route::get('quet-slug-ung-vien/{star}/{limit}', 'EmployeeController@create_slug_employee')->name('create_slug_employee');
    Route::get('quet-profile/{employee_id}', 'EmployeeController@check_profile')->name('check_profile');

//    Route::resource('cv_template', 'CvTemplateController');

    Route::resource('staff', 'StaffController');

    Route::resource('staff_member', 'StaffMemberController');
    Route::resource('staff_hr', 'StaffHrController');
    Route::get('ung-vien-bi-de-nghi-xoa', 'EmployeeController@listEmployeeDeleteRequest')->name('listEmployeeDeleteRequest');
    Route::get('xoa-ung-vien-de-nghi-xoa/{id}', 'EmployeeController@Employee_delete_with_admin')->name('Employee_delete_with_admin');
    Route::get('bo-xoa-ung-vien-de-nghi-xoa/{id}', 'EmployeeController@Employee_undelete_with_admin')->name('Employee_undelete_with_admin');
    Route::get('ung-vien-da-xoa', 'EmployeeController@listEmployeeDelete')->name('listEmployeeDelete');
    Route::get('nhan-vien-da-xoa', 'StaffController@listStaffDelete')->name('listStaffDelete');
    Route::get('cong-tac-vien-da-xoa', 'StaffMemberController@listStaffMemberDelete')->name('listStaffMemberDelete');
    Route::get('cong-tac-vien-da-xoa-hr', 'StaffHrController@listStaffHrDelete')->name('listStaffHrDelete');

    Route::get('khoi-phuc-ung-vien/{id}', 'EmployeeController@Employeerestore')->name('Employeerestore');
    Route::get('xoa-vinh-vien-ung-vien/{id}', 'EmployeeController@EmployeeForceDelete')->name('EmployeeForceDelete');

    Route::get('khoi-phuc-nhan-vien/{staff_id}', 'StaffController@Staff_restore')->name('Staff_restore');
    Route::get('xoa-vinh-vien-nhan-vien/{staff_id}', 'StaffController@Staff_forceDelete')->name('Staff_forceDelete');

    Route::get('khoi-phuc-cong-tac-vien/{staff_member_id}', 'StaffMemberController@Staff_member_restore')->name('Staff_member_restore');
    Route::get('xoa-vinh-vien-cong-tac-vien/{staff_member_id}', 'StaffMemberController@Staff_member_forceDelete')->name
    ('Staff_member_forceDelete');

    Route::get('khoi-phuc-cong-tac-vien-hr/{staff_hr_id}', 'StaffHrController@Staff_hr_restore')->name('Staff_hr_restore');
    Route::get('xoa-vinh-vien-cong-tac-vien-hr/{staff_hr_id}', 'StaffHrController@Staff_hr_forceDelete')->name
    ('Staff_hr_forceDelete');

    Route::get('cat-nhat-trang-thai-tat-ca-ho-so', 'EmployeeController@updateFriofileEmployee')->name('updateFriofileEmployee');


    Route::get('e-show', 'EmployeeController@anyDatatable')->name('dt_employee');
    Route::get('search-employee', 'EmployeeController@search')->name('searchEmployee');
    Route::get('note-employee', 'EmployeeController@note')->name('note-employee');
// Thông kê ứng viên
    Route::resource('statiscal', 'StatisticalController');

// Quản lý giáo viên
    Route::resource('teacher', 'TeacherController');
    Route::resource('teacher_status', 'Teacher_statusController');
    Route::resource('role', 'RoleController');
    Route::resource('category-tag', 'CategoryTagController');

//    id laf ma usser
    Route::get('giao-vien-bi-de-nghi-xoa', 'TeacherController@listTeacherDeleteRequest')->name('listTeacherDeleteRequest');
    Route::get('xoa-giao-vien-de-nghi-xoa/{id}', 'TeacherController@Teacher_delete_with_admin')->name('Teacher_delete_with_admin');
    Route::get('bo-xoa-giao-vien-de-nghi-xoa/{id}', 'TeacherController@Teacher_undelete_with_admin')->name('Teacher_undelete_with_admin');
    Route::get('giao-vien-da-xoa', 'TeacherController@listTeacherDelete')->name('listTeacherDelete');
    Route::get('khoi-phuc-giao-vien/{id}', 'TeacherController@Teacherrestore')->name('Teacherrestore');
    Route::get('xoa-vinh-vien-giao-vien/{id}', 'TeacherController@TeacherForceDelete')->name('TeacherForceDelete');



// Danh mục gói bán hàng
    Route::resource('saleGroup', 'SaleGroupController');
    Route::get('datatable-sale-group', 'SaleGroupController@anyDatatable')->name('dt_sale_group');

    Route::group(['prefix' => 'facebook', 'middleware' => 'HtmlMifier'], function () {
        Route::get('login', 'JobFacebookController@loginFB')->name('login-facebook');
        Route::get('callback', 'JobFacebookController@loginFB_callback');
        Route::get('group', 'JobFacebookController@groupFB')->name('groupFB');
        Route::get('feed', 'JobFacebookController@feed');
        Route::get('photo', 'JobFacebookController@photo');
        Route::get('video', 'JobFacebookController@video');
    });

    Route::resource('affiliate-group', 'AffiliateGroupController');
    Route::resource('affiliate-setting', 'AffiliateSettingController');
    Route::get('affiliate-setting-order', 'AffiliateSettingController@affiliateSettingOrder')->name('affiliate_setting_order');
    Route::get('affiliate-setting-job', 'AffiliateSettingController@affiliateSettingJob')->name('affiliate_setting_job');
    Route::get('affiliate-setting-group', 'AffiliateSettingController@affiliateSettingGroup')->name('affiliate_setting_group');

    Route::resource('coupon', 'CouponController');
    Route::resource('rose', 'RoseController');
    Route::resource('rose-setting', 'RoseSettingController');
    Route::get('rose-setting-order', 'RoseSettingController@roseSettingOrder')->name('rose_setting_order');
    Route::get('rose-setting-employer', 'RoseSettingController@roseSettingEmployer')->name('rose_setting_employer');

    Route::resource('filter', 'FilterController');

    Route::resource('comments', 'CommentController');
    Route::get('comments-show', 'CommentController@anyDatatables')->name('datatable_comment');
    Route::post('comments-random', 'CommentController@randomCommentFromForm')->name('randomCommentFromForm');
    Route::get('comments-random', 'CommentController@randomComment')->name('randomComment');

    Route::resource('contact', 'ContactController');
    Route::resource('res-dvisory', 'ResAdvisoryController');
    Route::get('nha-tuyen-dung-dang-ki', 'ResAdvisoryController@resEmployer')->name('resEmployer');
    Route::get('nguoi-tim-viec-dang-ki', 'ResAdvisoryController@resEmployee')->name('resEmployee');

    Route::resource('products', 'ProductController');
    Route::get('products-show', 'ProductController@anyDatatables')->name('datatable_product');
    Route::get('export-products', 'ProductController@exportToExcel')->name('exportProducts');
    Route::post('import-products', 'ProductController@importToExcel')->name('importProducts');
    Route::post('get-product-getfly', 'ProductController@getProductGetfly')->name('getProductGetfly');

    Route::resource('templates', 'TemplateController');
    Route::resource('type-information', 'TypeInformationController');
    Route::resource('type-information-money', 'TypeInformationMoneyController');

    Route::resource('coin_type_information_employer', 'Coin_type_infomation_employerController');
    Route::resource('type-input', 'TypeInputController');
    Route::resource('type-sub-post', 'TypeSubPostController');
    Route::resource('categories', 'CategoryController');
    Route::resource('category-products', 'CategoryProductController');
    Route::get('get-cate-product-getfly', 'CategoryProductController@getCateProductGetfly')->name('getCateProductGetfly');

    Route::group(['prefix' => '{typePost}', 'middleware' => 'HtmlMifier'], function ($typePost) {
// Files
        Route::resource('sub-posts', 'SubPostController');
        Route::get('sub-posts-show', 'SubPostController@anyDatatables')->name('datatable_sub_posts');
    });
    Route::resource('information', 'InformationController', ['only' => [
        'index', 'store'
    ]]);
    Route::resource('information-money', 'InformationMoneyController');

    Route::resource('coin_information_employer', 'Coin_information_employerController');

    Route::get('information/general', 'InformationController@generalCreate')->name('information-general');
    Route::post('information/general-store', 'InformationController@generalStore')->name('information-store');

    Route::resource('menus', 'MenuController');
    Route::resource('users', 'UserController');

    Route::get('thanh-vien-da-xoa', 'UserController@listUserDelete')->name('listUserDelete');
    Route::get('khoi-phuc-thanh-vien/{id}', 'UserController@Userrestore')->name('UserRestore');
    Route::get('xoa-vinh-vien/{id}', 'UserController@UserForceDelete')->name('UserForceDelete');

    Route::resource('subcribe-email', 'SubcribeEmailController');
    Route::get('subcribe-email-anyDatabase', 'SubcribeEmailController@anyDatatables')->name('subcribe-email-data');
    Route::post('group-mail/create', 'GroupMailController@store')->name('group_mail.create');
    Route::delete('group-mail/{groupMail}', 'GroupMailController@destroy')->name('group_mail.destroy');
    Route::post('send-mail', 'SubcribeEmailController@send')->name('subcribe-email_send');

    Route::get('cau-hinh-email', 'SettingController@setting')->name('method_payment');
    Route::get('cau-hinh-getfly', 'SettingController@settingGetfly')->name('setting_getfly');

    Route::post('cap-nhat-ngan-hang', 'SettingController@updateBank')->name('bank');
    Route::delete('quan-li-ngan-hang/{orderBanks}', 'SettingController@deleteBank')->name('orderBanks.destroy');
    Route::post('cap-nhat-ma-giam-gia', 'SettingController@updateCodeSale')->name('code_sale');
    Route::delete('quan-li-giam-gia/{orderCodeSales}', 'SettingController@deleteCodeSale')->name('orderCodeSales.destroy');

    Route::post('cap-nhat-phi-ship', 'SettingController@updateShip')->name('cost_ship');
    Route::post('cap-nhat-tinh-diem', 'SettingController@updateSetting')->name('updateSetting');
    Route::delete('quan-li-phi-ship/{orderShips}', 'SettingController@deleteShip')->name('orderShips.destroy');

    Route::post('cai-dat-getfly', 'SettingController@updateSettingGetFly')->name('updateSettingGetFly');
    Route::post('cau-hinh-email', 'SettingController@updateSettingEmail')->name('updateSettingEmail');
    Route::post('kiem-tra-cau-hinh', 'SettingController@testEmail')->name('testEmail');
    Route::get('bao-cao-doanh-thu', 'ReportController@revenue')->name('report_revenue');
    Route::get('datatable_revenue', 'ReportController@datatableRevenue')->name('dt_revenue');
    Route::get('bao-cao-cong-viec', 'ReportController@job')->name('report_job');
    Route::get('datatable_report_job', 'ReportController@datatableJob')->name('dt_report_job');
    Route::get('bao-cao-don-hang', 'ReportController@order')->name('report_order');
    Route::get('datatable_report_order', 'ReportController@datatableOrder')->name('dt_report_order');

    Route::post('cap-nhat-trang-thai-don-hang', 'OrderController@updateStatusOrder')->name('orderUpdateStatus');

    Route::get('thong-bao', 'NotificationController@allreport')->name('report');
    Route::get('da-xem-thong-bao', 'NotificationController@seenNotification')->name('seenNotification');
    Route::get('da-doc-thong-bao', 'NotificationController@readNotification')->name('readNotification');
    Route::get('thong-bao-day', 'NotificationController@pushNotification')->name('pushNotify');

//    Quản lý kho tài liệu
    Route::resource('voucher-categories', 'VoucherCategoriesController');
    Route::resource('voucher-child-categories', 'VoucherChildCategoriesController');
    Route::resource('voucher', 'VoucherController');

    Route::resource('voucher-comment', 'VoucherCommentController');


// Quản lý domain and theme
// Route::resource('domains', 'DomainController');
// Route::get('domain-show', 'DomainController@anyDatatables')->name('datatable_domain');

// Route::resource('themes', 'ThemeController');
// Route::get('theme-show', 'ThemeController@anyDatatables')->name('datatable_theme');
// Route::get('active-theme', 'ThemeController@activeTheme')->name('active_theme');
// Route::post('change-theme', 'ThemeController@changeTheme')->name('change_theme');

// Route::resource('group-theme', 'GroupThemeController');
// Route::get('group-theme-show', 'GroupThemeController@anyDatatables')->name('datatable_group_theme');

// Route::resource('group-help-video', 'GroupHelpVideoController');
// Route::get('group-help-video-show', 'GroupHelpVideoController@anyDatatables')->name('datatable_group_help_video');

// Route::resource('help-video', 'HelpVideoController');
// Route::get('help-video-show', 'HelpVideoController@anyDatatables')->name('datatable_help_video');

// Route::post('upload-fanpage', 'PostFanpageController@uploadFanpage')->name('upload_fanpage');
// Route::get('comment-facebook', 'CommentFacebookController@pushComment')->name('comment_facebook');

// Route::post('update-groups', 'FanpageController@updateGroups')->name('update_groups');
// Route::post('update-face-id', 'FanpageController@updateFaceIds')->name('update_facebook_id');
// Route::get('delete-face-id', 'FanpageController@deleteFaceIds')->name('delete_facebook_id');
// Route::post('update-setting-face', 'FanpageController@updateSetting')->name('update_setting_face');
// Route::get('get-post-facebook', 'FanpageController@index')->name('get_post_facebook');

// Route::get('get-uid', 'FacebookUidController@getUid')->name('get_uid');
// Route::get('show-get-uid', 'FacebookUidController@showGetUid')->name('show_get_uid');

// Route::get('show-convert-uid', 'FacebookConvertController@showConvertFromUid')->name('show_convert_uid');
// Route::get('convert-uid', 'FacebookConvertController@convertFromUid')->name('convert_uid');
// Route::post('get-uid-from-excel', 'FacebookConvertController@getUidFromExcel')->name('get_uid_from_excel');

// Route::get('show-request-friend', 'FacebookConvertController@showRequestFriend')->name('show_request_friend');
// Route::get('request-friend', 'FacebookConvertController@requestFriend')->name('request_friend');

// Route::get('download-member', 'FacebookUidController@showMembers')->name('download-member');


//    Trắc nghiệm exam
//    loại hình doanh nghiệp
    Route::resource('exam_type_business', 'Exam\ExamTypeBusinessController');

//    vị trí công việc
    Route::resource('exam_local_job', 'Exam\ExamLocalJobController');

//phan cau hỏi
    Route::resource('categories-exam', 'Exam\CategoriesExamController');
    Route::resource('exam', 'Exam\ExamController');

    Route::get('exam-show', 'Exam\ExamController@examDatatables')->name('examDatatables');


   //tam dung xoa de thi Route::get('delete-exam-show/{id_exam}', 'Exam\ExamController@delete_exam')->name('delete_exam');
//end cau hoi
//tao cau hoi
    Route::post('them-cau-hoi', 'Exam\ExamController@add_questions')->name('add_questions');
    Route::get('sua-cau-hoi/{id_ques}', 'Exam\ExamController@edit_questions')->name('edit_questions');
    Route::get('xoa-cau-hoi/{id_ques}', 'Exam\ExamController@delete_questions')->name('delete_questions');


    Route::resource('question', 'Exam\QuestionController');
// Zero , One , Two tuong duong type question
    Route::get('danh-sach-cau-hoi-trac-nghiem/{id_exam}', 'Exam\QuestionController@getQuestionZero')->name('getQuestionZero');
    Route::get('danh-sach-cau-hoi-dung-sai/{id_exam}', 'Exam\QuestionController@getQuestionOne')->name('getQuestionOne');
    Route::get('danh-sach-cau-hoi-tu-luan/{id_exam}', 'Exam\QuestionController@getQuestionTwo')->name('getQuestionTwo');

    Route::get('/them-moi-cau-hoi/{id_exam}', 'Exam\QuestionController@createQuestionAdmin')->name('createQuestionAdmin');
    Route::get('/sua-cau-hoi/{id_ques}', 'Exam\QuestionController@editQuestionAdmin')->name('editQuestionAdmin');
    Route::get('/copy-cau-hoi/{id_ques}', 'Exam\QuestionController@copyQuestionAdmin')->name('copyQuestionAdmin');
//    End Trắc nghiệm câu hỏi


    //setting-cai-dat
    // Quản lý danh mục ngành nghề - vị trí công việc
    Route::resource('career', 'CareerController');
    Route::get('datatable_job_career', 'CareerController@anyDatatable')->name('dt_job_career');

// khuyến mãi
    Route::get('affiliate', 'AffiliateController@index')->name('affiliate.index');
    Route::get('affiliate/edit', 'AffiliateController@edit')->name('affiliate.edit');
    Route::get('affiliate', 'AffiliateController@index')->name('affiliate.index');

// Quản lý mức lươngviec-lam
    Route::resource('salary', 'SalaryController');
    Route::resource('age', 'AgeController');
    Route::resource('status_submit_job', 'Status_sumbit_jobController');
    Route::resource('config_meta', 'ConfigMetaController');
//thong tin dịch vụ
    Route::resource('information_service', 'InformationServiceController');
    Route::resource('location_area', 'LocationAreaController');
    Route::resource('local_branch', 'LocalBranchController');
    Route::resource('province', 'ProvinceController');
    Route::resource('district', 'DistrictController');

    Route::resource('experience', 'ExperienceController');
    Route::get('datatable_salary', 'SalaryController@anyDatatable')->name('dt_salary');

    Route::resource('coe', 'CoefficientsSalaryController');
    Route::get('datatable_coe', 'CoefficientsSalaryController@anyDatatable')->name('dt_coe');
// Quản lý phần mềm
    Route::resource('software', 'SoftwareController');
    Route::get('datatable_software', 'SoftwareController@anyDatatable')->name('dt_software');

    // Loại hình kinh doanh
    Route::resource('business', 'BusinessController');
    Route::get('datatable_businees', 'BusinessController@anyDatatable')->name('dt_business');

    // Trình độ học vấn
    Route::resource('literacy', 'LiteracyController');
    Route::get('datatable_literacy', 'LiteracyController@anyDatatable')->name('dt_literacy');

    // Loại hình doanh nghiệp
    Route::resource('typeOfBusiness', 'TypeOfBusinessController');
    Route::get('datatable_type_of_business', 'TypeOfBusinessController@anyDatatable')->name('dt_type_business');
    // Tin học văn phòng  - office

    Route::resource('office', 'OfficeController');
    Route::get('datatable_type_office', 'OfficeController@anyDatatable')->name('dt_type_office');

    //Kinh nghieemhj vị trí
    Route::resource('exp_pos', 'ExperiencePosController');
    Route::get('datatable_type_exp_pos', 'ExperiencePosController@anyDatatable')->name('dt_type_exp_pos');

    //Kinh nghiệm loại hình doanh nghiệp
    Route::resource('exp_bus', 'ExperienceBusController');
    Route::get('datatable_type_exp_bus', 'ExperienceBusController@anyDatatable')->name('dt_type_exp_bus');

    //Trình độ ngoại ngữ
    Route::resource('lang', 'LanguageLiteracyController');
    Route::get('datatable_type_lang', 'LanguageLiteracyController@anyDatatable')->name('dt_type_lang');

    //Kỹ năng mềm
    Route::resource('soft', 'SoftSkillsController');
    Route::get('datatable_type_soft', 'SoftSkillsController@anyDatatable')->name('dt_type_soft');

    //chứng chỉ nghef nghiệp
    Route::resource('cert', 'CertificateController');
    Route::get('datatable_type_cert', 'CertificateController@anyDatatable')->name('dt_type_cert');

    //Khả năng chịu áp lực
    Route::resource('work', 'WorkPressureController');
    Route::get('datatable_type_work', 'WorkPressureController@anyDatatable')->name('dt_type_work');


    //Cam kết gắn bó với công ty
    Route::resource('com', 'CommitCompanyController');
    Route::get('datatable_type_com', 'CommitCompanyController@anyDatatable')->name('dt_type_com');



});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'HtmlMifier'], function () {
    Route::get('/', 'LoginController@showLoginForm');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
//reset password
    Route::get('password/reset', 'LoginController@getReset');
    Route::post('password/reset', 'LoginController@postReset');
});
?>
