<?php
Route::group(['prefix' => 'staff', 'namespace' => 'Staff', 'middleware' => 'HtmlMifier'], function () {
    //quản lý thông tin tài khoản

    // // route Ajax thêm mới từ khóa
    // Route::get('them-tu-khoa-ajax','CategoryTagController@them_tu_khoa_ajax')->name('them_tu_khoa_ajax');

    Route::get('thong-tin-nhan-vien', 'SaffController@edit_staff_info')->name('edit_staff_info');
    Route::post('cap-nhat/thong-tin-nhan-vien', 'SaffController@update_staff_info')->name('update_staff_info');
    Route::get('doi-mat-khau-nhan-vien', 'SaffController@staff_change_password')->name('staff_change_password');
    Route::post('doi-mat-khau-nhan-vien', 'SaffController@post_change_password')->name('post_change_password');

    Route::resource('coursesStaff', 'CoursesController');
    Route::get('coursesStaffDestroy/{id}', 'CoursesController@coursesStaffDestroy')->name('coursesStaffDestroy');
    Route::get('ung-vien-dang-ky-khoa-hoc', 'ReportController@candidates_register_course')->name('candidates_register_course');

    Route::get('thong-tin-khoa-hoc/{course_id}','CoursesController@course_chapter_staff')->name('course_chapter_staff');
    Route::post('them-chuong-cho-khoa-hoc-staff', 'CoursesController@store_course_chapter_staff')->name('store_course_chapter_staff');
    Route::post('cap-nhat-chuong-cho-khoa-hoc-staff', 'CoursesController@update_course_chapter_staff')->name('update_course_chapter_staff');
    Route::get('xoa-chuong-cua-khoa-hoc-staff/{course_chapter_id}', 'CoursesController@delete_course_chapter_staff')->name('delete_course_chapter_staff');

    Route::get('thong-tin-chuong-cua-khoa-hoc/{course_chapter_id}', 'CoursesController@list_chapters_staff')->name('list_chapters_staff');
    Route::post('them-bai-hoc-cho-chuong', 'CoursesController@store_chapter_content_staff')->name('store_chapter_content_staff');
    Route::post('cap-nhat-bai-hoc-chuong', 'CoursesController@update_chapter_content_staff')->name('update_chapter_content_staff');
    Route::get('xoa-bai-hoc-chuong/{course_content_id}', 'CoursesController@delete_chapter_content_staff')->name('delete_chapter_content_staff');

    Route::get('thong-tin-tai-lieu-cua-bai-hoc/{course_content_id}', 'CoursesController@list_content_voucher_staff')->name('list_content_voucher_staff');
    Route::post('them-tai-lieu-cho-bai-hoc-staff', 'CoursesController@store_content_voucher_staff')->name('store_content_voucher_staff');
    Route::post('cap-nhat-tai-lieu-cho-bai-hoc-staff', 'CoursesController@update_content_voucher_staff')->name('update_content_voucher_staff');
    Route::get('xoa-tai-lieu-cho-bai-hoc-staff/{course_content_voucher_id}', 'CoursesController@delete_content_voucher_staff')->name('delete_content_voucher_staff');
    //thêm tài liệu đáp án cho bài học
    Route::post('them-tai-lieu-dap-an-cho-bai-hoc-staff', 'CoursesController@store_content_voucher_answer_staff')->name('store_content_voucher_answer_staff');
    Route::post('cap-nhat-tai-lieu-dap-an-cho-bai-hoc-staff', 'CoursesController@update_content_voucher_answer_staff')->name('update_content_voucher_answer_staff');
    Route::get('xoa-tai-lieu-dap-an-cho-bai-hoc-staff/{course_content_voucher_answer_id}', 'CoursesController@delete_content_voucher_answer_staff')->name('delete_content_voucher_answer_staff');

    Route::get('danh-sach-hinh-thuc-hoc/{course_id}', 'CoursesController@list_formality_staff')->name('list_formality_staff');
    Route::post('them-hinh-thuc-khoa-hoc-staff', 'CoursesController@store_formality_staff')->name('store_formality_staff');
    Route::post('cap-nhat-hinh-thuc-hoc-staff', 'CoursesController@update_formality_staff')->name('update_formality_staff');
    Route::get('xoa-hinh-thuc-hoc-staff/{course_join_formality_id}', 'CoursesController@delete_formality_staff')->name('delete_formality_staff');

    Route::resource('categoryCourse', 'CategoryCourseController');
    Route::get('categoryCourseDestroy/{id}', 'CategoryCourseController@categoryCourseDestroy')->name('categoryCourseDestroy');

    Route::resource('courseOrder', 'CourseOrderController');
    Route::get('courseOrderDestroy/{id}', 'CourseOrderController@courseOrderDestroy')->name('courseOrderDestroy');
    Route::get('order_sales_statistics_staff', 'CourseOrderController@order_sales_statistics_staff')->name('order_sales_statistics_staff');

    Route::get('ung-vien-nop-ho-so-ntd', 'JobNTDController@employee_submit_job')->name('employee_submit_job_ntd');
    Route::get('ung-vien-ung-tuyen-nhanh-nop-ho-so-ntd', 'JobNTDController@employee_submit_apply_job')->name('employee_submit_apply_job');
    Route::post('duyet-ung-tuyen-nhanh', 'JobNTDController@post_submit_apply_job')->name('post_submit_apply_job');

    Route::get('ung-vien-nop-ho-so-theo-viec-lam-NTD', 'ReportController@candidates_apply_for_jobs')->name('candidates_apply_for_jobs');

    Route::get('ung-vien-nop-ho-so-theo-viec-lam_FB', 'ReportController@candidates_apply_for_jobs_fb')->name('candidates_apply_for_jobs_fb');

    Route::get('staff_employee/show_modal_interactive_job', 'JobNTDController@show_modal_interactive_job')->name('show_modal_interactive_job');
    Route::get('ung-vien-nop-ho-so-fb', 'JobNTDController@employee_submit_job')->name('employee_submit_job_fb');

    Route::resource('courseEmployee', 'CourseEmployeeController');

    Route::resource('courseTag', 'CourseTagController');
    Route::get('courseTagDestroy/{id}', 'CourseTagController@courseTagDestroy')->name('courseTagDestroy');

    Route::resource('courseFormality', 'CourseFormalityController');
    Route::get('courseFormalityDestroy/{id}', 'CourseFormalityController@courseFormalityDestroy')->name('courseFormalityDestroy');

    Route::resource('educateCategories', 'EducateCategoriesController');
    Route::get('educateCategoriesDestroy/{id}', 'EducateCategoriesController@educateCategoriesDestroy')->name('educateCategoriesDestroy');

    Route::resource('educateClass', 'EducateClassController');
    Route::get('educateClassDestroy/{id}', 'EducateClassController@educateClassDestroy')->name('educateClassDestroy');
    Route::get('danh-sach-ung-vien-dang-ki/{educate_class_id}', 'EducateClassController@list_educate_employee_class_staff')->name('list_educate_employee_class_staff');

    Route::resource('courseFeedback', 'CourseFeedbackController');
    Route::get('courseFeedbackDestroy/{id}', 'CourseFeedbackController@courseFeedbackDestroy')->name('courseFeedbackDestroy');

    Route::resource('courseQuestions', 'CourseQuestionsController');
    Route::get('courseQuestionsDestroy/{id}', 'CourseQuestionsController@courseQuestionsDestroy')->name('courseQuestionsDestroy');

    Route::post('staff_employee/staff_look_exp_employee', 'EmployeeController@staff_look_exp_employee')->name('staff_look_exp_employee');
    Route::post('staff_employee/staff_look_spec_employee', 'EmployeeController@staff_look_spec_employee')->name('staff_look_spec_employee');
    Route::post('staff_employee/delete_all_request', 'EmployeeController@delete_all_request')->name('staff_employee_delete_all_request');
    Route::delete('staff_employee/delete_all', 'EmployeeController@delete_all')->name('staff_employee_delete_all');
    Route::post('staff_employee/duyet-ung-vien-da-chon', 'EmployeeController@approved_all_employee')->name('approved_all_employee');
    Route::post('staff_employee/bo-duyet-ung-vien-da-chon', 'EmployeeController@un_approved_all_employee')->name('un_approved_all_employee');
    Route::get('staff_employee/approved_employee', 'EmployeeController@approved_employee')->name('approved_employee');
    Route::get('staff_employee/evaluate_employee', 'EmployeeController@evaluate_employee')->name('evaluate_employee');
    Route::get('staff_employee/caculator_profile', 'EmployeeController@caculator_profile')->name('caculator_profile');
    Route::get('staff_employee/approved_cv', 'EmployeeController@approved_cv')->name('approved_cv');
    Route::post('staff_employee/phan-hoi-tat-ca-ung-vien', 'EmployeeController@SendFeedbackAllEmployee')->name('SendFeedbackAllEmployee');
    Route::get('staff_employee/phan-hoi-ung-vien', 'EmployeeController@SendFeedbackEmployee')->name('SendFeedbackEmployee');
    Route::get('staff_employee/delete_request', 'EmployeeController@delete_request')->name('staff_employee_delete_request');
    Route::get('staff_employee/statistical-district/{province_id}', 'EmployeeController@district')->name('staff_employee_district');
    Route::get('staff_employee/statistical-63provinces', 'EmployeeController@statistical')->name('staff_employee_statistical');
    Route::get('staff_employee/list-deleted', 'EmployeeController@list_deleted')->name('staff_employee_list_deleted');
    Route::get('staff_employee/submit-job', 'ReportController@staff_employee_submit_job')->name('staff_employee_submit_job');
    Route::get('staff_employee/submit-job-list/{employee_id}', 'ReportController@list_staff_employee_submit_job')->name('list_staff_employee_submit_job');

    Route::get('staff_employee/chi-tiet-ung-vien-nop-ho-so-ntd', 'ReportController@application_details_ntd')->name('application_details_ntd');
    Route::get('staff_employee/chi-tiet-ung-vien-nop-ho-so-fb', 'ReportController@application_details_fb')->name('application_details_fb');
    Route::get('dashboard-bao-cao', 'ReportController@dashboard_report')->name('dashboard_report');
    Route::post('loc-ngay', 'ReportController@loc_ngay')->name('loc_ngay');


    Route::post('staff/nhan-vien-giao-viec', 'EmployeeController@task_job')->name('task_job');
    Route::post('staff/nhan-vien-bao-cao-giao-viec', 'EmployeeController@task_completed_job')->name('task_completed_job');
    Route::get('staff_aiax/nhan-vien-giao-viec', 'EmployeeController@ajax_task_job')->name('ajax_task_job');

    Route::get('staff_employee/interactive_employee', 'EmployeeController@interactive_employee')->name('interactive_employee');
    Route::get('staff_employee/interactive_employee_list/{interactive_employee_id}', 'EmployeeController@interactive_employee_list')->name('interactive_employee_list');

    Route::get('staff_employee/mau-email', 'Template_emailController@index')->name('form_email');
    Route::get('staff_employee/mau-email/create', 'Template_emailController@create')->name('create_email');
    Route::post('staff_employee/mau-email/store', 'Template_emailController@store')->name('store_email');
    Route::get('staff_employee/interactive_employee_all', 'EmployeeController@interactive_employee_all')->name('interactive_employee_all');
    Route::get('staff_employee/show_modal_interactive', 'EmployeeController@show_modal_interactive')->name('show_modal_interactive');

    Route::get('danh-sach-mau-theo-danh-muc/{id_cate_tem}', 'Template_emailController@list_category_template_email')->name('list_category_template_email');
    Route::get('edit_category_template_email/{id_tem}', 'Template_emailController@edit_category_template_email')->name('edit_category_template_email');
    Route::put('update_category_template_email/{id_tem}', 'Template_emailController@update_category_template_email')->name('update_category_template_email');
    Route::post('gui-email_template', 'Template_emailController@sendEmailOfStaff')->name('sendEmailOfStaff');



    Route::get('staff_employee/employee-statistics', 'EmployeeController@employee_statistics')->name('staff_employee_statistics');
    Route::get('staff_employee/report-employee', 'EmployeeController@report_employee')->name('staff_employee_report_employee');
    Route::get('staff_employee/Detail/{id}', 'EmployeeController@Detail')->name('detail_employee');
    Route::get('staff_employee/Create_Interactive_Employee/{id}', 'EmployeeController@Create_Interactive_Employee')->name('Create_Interactive_Employee');
    Route::get('staff_employee/edit_form/{id}', 'EmployeeController@form_edit')->name('staff_employee_edit_form');
    Route::post('staff_employee/edit_employee/{id}', 'EmployeeController@edit_employee')->name('employee_update_with_staff_admin');
    Route::get('staff_employee/delete_interactive/{id}', 'EmployeeController@delete_interactive')->name('staff_employee_delete_interactive');
    Route::get('export-excel-employee', 'EmployeeController@exportExcelEmployee')->name('exportExcelEmployee');
    Route::post('staff_employee/edit_interactive/{id}', 'EmployeeController@edit_interactive')->name('staff_employee_update_interactive');

    //danh sach ung vien chua convert dc CV -> tam thoi dong laij chuc nang nay
    //Route::get('staff_employee_no_convert_cv', 'EmployeeController@staff_employee_no_convert_cv')->name('staff_employee_no_convert_cv');
    //Route::get('staff_detail_convert_cv/{employee_id}', 'EmployeeController@staff_detail_convert_cv')->name('staff_detail_convert_cv');
    //Route::post('staff_convert_cv', 'EmployeeController@staff_convert_cv')->name('staff_convert_cv');


    Route::post('staff_employee/edit_data', 'EmployeeController@edit_data')->name('edit_data');

    Route::post('delete/all-employee-hard', 'EmployeeController@deleteAllHard')->name('delete_allemployee_hard');
    Route::get('delete/hard-employee/{id}', 'EmployeeController@deleteHard')->name('delete_employee_hard');
    Route::get('reset/employee/{id}', 'EmployeeController@reset_employee')->name('reset_employee');

    Route::post('staff_employee/chuyen-tai-khoan-sang-giao-vien', 'EmployeeController@change_employee_to_teacher')->name('change_employee_to_teacher');

//    Route::post('staff_employee/chuyen-tai-khoan-sang-giao-vien', 'EmployeeController@post_change_employee_to_teacher')->name('post_change_employee_to_teacher');

    Route::get('watch_cv/staff_employee', 'EmployeeController@detail_cv')->name('staff_detail_cv');
    Route::get('nhan-vien/tai-lai-cv', 'EmployeeController@staff_reload_cv')->name('staff_reload_cv');
    Route::resource('staff_employee', 'EmployeeController');
    Route::get('bao-cao/danh-sach-ung-vien-duoc-giao', 'EmployeeController@employee_assigned')->name('employee_assigned');
    Route::get('bao-cao/danh-sach-ung-vien-chua-giao', 'EmployeeController@employee_no_task')->name('employee_no_task');
    Route::get('bao-cao/danh-sach-ung-vien-da-giao', 'EmployeeController@employee_task')->name('employee_task');
    Route::get('bao-cao/tong-hop-giao-nhiem-vu', 'EmployeeController@general_task')->name('general_task');
    Route::get('bao-cao/lay-thong-tin-giao-viec', 'EmployeeController@task_info')->name('task_info');
    Route::get('quet-uv-upload-anh-cu/{skip}/{take}', 'EmployeeController@uv_old')->name('uv_old');
    Route::post('sua-quet-uv-upload-anh-cu', 'EmployeeController@edit_uv_old')->name('edit_uv_old');
    Route::get('employee_staff/follow', 'EmployeeController@index')->name('list_employee_follow');
    Route::get('staff/follow_employee', 'EmployeeController@follow_employee')->name('follow_employee');

    Route::get('ung-vien-da-duyet', 'EmployeeController@index')->name('list_employee_approved');
    Route::get('ung-vien-chua-duyet', 'EmployeeController@index')->name('list_employee_no_approved');

    Route::get('ung-vien-0-den-20', 'EmployeeController@index')->name('employee0To20');
    Route::get('ung-vien-20-den-40', 'EmployeeController@index')->name('employee20To40');
    Route::get('ung-vien-40-den-60', 'EmployeeController@index')->name('employee40To60');
    Route::get('ung-vien-60-tro-len', 'EmployeeController@index')->name('employee60ToMax');


    Route::get('bao-cao-giao-viec', 'EmployeeController@assignment_list')->name('assignment_list');
    Route::get('bao-cao-giao-viec-theo-ngay', 'EmployeeController@daily_task_list')->name('daily_task_list');
    Route::get('tong-hop-ket-qua-giao-viec', 'EmployeeController@assignment_results')->name('assignment_results');

    //quản lý giáo viên
    Route::post('staff_teacher/delete_all_request', 'TeacherController@delete_all_request')->name('staff_teacher_delete_all_request');
    Route::post('staff_teacher/delete_all', 'TeacherController@delete_all')->name('staff_teacher_delete_all');

    Route::post('staff_teacher/update_teacher', 'TeacherController@staff_updateTeacher')->name('staff_updateTeacher');
    Route::post('staff_teacher/store_teacher', 'TeacherController@staff_store_teacher')->name('staff_store_teacher');

    Route::post('staff_teacher/update_specialize_teacher', 'TeacherController@staff_update_Specialize_Teacher')->name('staff_update_Specialize_Teacher');
    Route::post('staff_teacher/store_specialize_teacher', 'TeacherController@staff_store_Specialize_Teacher')->name('staff_store_Specialize_Teacher');

    Route::post('staff_teacher/update_experience_teacher', 'TeacherController@staff_update_Experience_Teacher')->name('staff_update_Experience_Teacher');
    Route::post('staff_teacher/store_experience_teacher', 'TeacherController@staff_store_Experience_Teacher')->name('staff_store_Experience_Teacher');

    Route::post('/staff_teacher/store_ourse_Teacher', 'TeacherController@staff_store_Course_Teacher')->name('staff_store_Course_Teacher');
    Route::post('/staff_teacher/update_Course_Teacher', 'TeacherController@staff_update_Course_Teacher')->name('staff_update_Course_Teacher');


    Route::post('staff_teacher/phan-hoi-tat-ca-giao-vien', 'TeacherController@SendFeedbackAllTeacher')->name('SendFeedbackAllTeacher');
    Route::post('staff_teacher/phan-hoi-giao-vien/{id}', 'TeacherController@SendFeedbackTeacher')->name('SendFeedbackTeacher');
    Route::post('staff_teacher/edit_interactive/{id}', 'TeacherController@edit_interactive')->name('staff_teacher_update_interactive');
    Route::get('staff_teacher/delete_interactive/{id}', 'TeacherController@delete_interactive')->name('staff_teacher_delete_interactive');
    Route::get('staff_teacher/delete_request/{id}', 'TeacherController@delete_request')->name('staff_teacher_delete_request');
    Route::get('staff_teacher/undelete_request/{id}', 'TeacherController@undelete_request')->name('staff_teacher_undelete_request');
    Route::get('staff_teacher/statistical-63provinces', 'TeacherController@statistical')->name('staff_teacher_statistical');
    Route::get('staff_teacher/statistical-district/{province_id}', 'TeacherController@district')->name('staff_teacher_district');
    Route::get('staff_teacher/list-deleted', 'TeacherController@list_deleted')->name('staff_teacher_list_deleted');
    Route::get('staff_teacher/delete-hard/{id}', 'TeacherController@delete_hard')->name('delete_hard_teacher');
    Route::get('staff_teacher/delete-hard-all', 'TeacherController@delete_hard_all')->name('delete_all_hard_teacher');
    Route::get('staff_teacher/reset-teacher/{id}', 'TeacherController@reset_teacher')->name('reset_teacher');
    Route::get('staff_teacher/report-teacher', 'TeacherController@report_teacher')->name('staff_teacher_report_teacher');
    Route::get('staff_teacher/ajax/district', 'TeacherController@getDistrict')->name('staff_getDistrict');
    Route::get('staff_teacher/interactive/{teacher_id}', 'InteractiveTeacherController@index')->name('interactive_index');
    Route::post('staff_teacher/interactive/store/{teacher_id}', 'InteractiveTeacherController@store')->name('interactive_store');
    Route::get('staff_teacher/bao-cao-tuong-tac-giao-vien', 'InteractiveTeacherController@listInteractive')->name('list_interactive');
    Route::get('staff_teacher/danh-sach-giao-vien-da-tuong-tac/{staff_id}', 'InteractiveTeacherController@listInteractiveStaff')->name('list_interactive_staff');

    Route::post('staff_teacher/interactive/update_id', 'InteractiveTeacherController@interactive_update')->name('interactive_update');

    Route::get('staff_teacher/interactive/edit/{teacher_id}', 'InteractiveTeacherController@edit')->name('interactive_edit');
//    Route::PATCH('staff_teacher/interactive/edit/{id}', 'InteractiveTeacherController@update')->name('interactive_update');
    Route::get('staff_teacher/List_teacher_in_district', 'TeacherController@List_teacher_in_district')->name('List_teacher_in_district');
    Route::get('staff_teacher/getListTeacher', 'TeacherController@datatable_getListTeacher')->name('datatable_getListTeacher');
    Route::get('staff_teacher/getListTeacherNotInterActive', 'TeacherController@datatable_getListTeacher_not_interactive')->name('datatable_getListTeacher_not_interactive');
    Route::post('staff_teacher/gui-phan-hoi-giao-vien', 'TeacherController@send_post_content_teacher')->name('send_post_content_teacher');
    Route::get('staff_teacher/ListTeacherNotInterActive', 'TeacherController@getListTeacher_not_interactive')->name('getListTeacher_not_interactive');

    Route::resource('staff_teacher', 'TeacherController');
    //quản lý nhà tuyển dụng

    Route::post('staff_employer/delete_all_request', 'EmployerController@delete_all_request')->name('staff_employer_delete_all_request');
    Route::post('staff_employer/delete_all', 'EmployerController@delete_all')->name('staff_employer_delete_all');
    Route::post('staff_employer/duyet-NTD-da-chon', 'EmployerController@approved_all_employer')->name('approved_all_employer');
    Route::get('staff_employer/approved_employer/{id}', 'EmployerController@approved_employer')->name('approved_employer');
    Route::post('staff_employer/phan-hoi-tat-ca-NTD', 'EmployerController@SendFeedbackAllEmployer')->name('SendFeedbackAllEmployer');
    Route::post('staff_employer/phan-hoi-NTD/{id}', 'EmployerController@SendFeedbackEmployer')->name('SendFeedbackEmployer');
    Route::get('staff_employer/delete_request/{id}', 'EmployerController@delete_request')->name('staff_employer_delete_request');
    Route::get('staff_employer/undelete_request/{id}', 'EmployerController@undelete_request')->name('staff_employer_undelete_request');
    Route::get('staff_employer/statistical-63provinces', 'EmployerController@statistical')->name('staff_employer_statistical');
    Route::get('staff_emloyer/statistical-12months', 'EmployerController@statistical12month')->name('staff_employer_statistical_12month');
    Route::get('staff_employer/statistical-district/{province_id}', 'EmployerController@district')->name('staff_employer_district');
    Route::get('staff_employer/edit_form/{id}', 'EmployerController@form_edit')->name('staff_employer_edit_form');
    Route::post('staff_employer/edit_interactive/{id}', 'EmployerController@edit_interactive')->name('staff_employer_update_interactive');
    Route::post('staff_employer/edit_employer/{id}', 'EmployerController@update')->name('employer_update_with_staff_admin');
    Route::get('staff_employer/delete_interactive/{id}', 'EmployerController@delete_interactive')->name('staff_employer_delete_interactive');
    Route::get('staff_employer/Create_Interactive_Employer/{id}', 'EmployerController@Create_Interactive_Employer')->name('Create_Interactive_Employer');
    Route::get('staff_employer/Detail/{id}', 'EmployerController@Detail')->name('detail_employer_with_staff_admin');
    Route::post('staff_employer/add-contact-employer', 'EmployerController@add_employer_contact')->name('add_employer_contact');
    Route::get('staff_employer/update-contact-employer', 'EmployerController@update_employer_contact')->name('update_employer_contact');
    Route::get('staff_employer/delete-contact-employer', 'EmployerController@delete_employer_contact')->name('delete_employer_contact');
    Route::get('staff_employer/list-deleted', 'EmployerController@list_deleted')->name('staff_employer_list_deleted');
    Route::get('staff_employer/report-employer', 'EmployerController@report_employer')->name('staff_employer_report_employer');
    Route::resource('staff_employer', 'EmployerController');
    Route::get('employer_staff/follow', 'EmployerController@index')->name('list_employer_follow');
    Route::get('export-excel-employer', 'EmployerController@exportExcelEmployer')->name('exportExcelEmployer');

    Route::get('staff_employer/delete-hard/{id}', 'EmployerController@delete_hard')->name('delete_hard_employer');
    Route::post('staff_employer/delete-hard-all', 'EmployerController@delete_hard_all')->name('delete_all_hard_employer');
    Route::get('staff_employer/reset-employer/{id}', 'EmployerController@reset_employer')->name('reset_employer');
    //quản lý tin tuyển dụng
    //quản lý việc làm nhà tuyển dụng
    Route::post('staff_job-ntd/delete_all_request', 'JobNTDController@delete_all_request')->name('staff_job_delete_all_request');
    Route::post('staff_job-ntd/duyet-job-da-chon', 'JobNTDController@approved_all_job')->name('approved_all_job');
    Route::get('staff_job-ntd/delete_request/{id}', 'JobNTDController@delete_request')->name('staff_job_delete_request');
    Route::get('staff_job-ntd/undelete_request/{id}', 'JobNTDController@undelete_request')->name('staff_job_undelete_request');
    Route::get('staff_job-ntd/Detail/{id}', 'JobNTDController@Detail')->name('detail_job_with_staff_admin');
    Route::get('staff_job-ntd/send_email/{id}', 'JobNTDController@send_email_job')->name('send_email_job');
    Route::post('staff_job-ntd/gui-email-ung-tuyen', 'JobNTDController@post_send_email_job')->name('post_send_email_job');
    Route::post('staff_job-ntd/phan-hoi-job/{id}', 'JobNTDController@SendFeedbackJob')->name('SendFeedbackJob');
    Route::post('staff_job-ntd/phan-hoi-tat-ca-job', 'JobNTDController@SendFeedbackAllJob')->name('SendFeedbackAllJob');

    //duyet tin tuyen dung
    Route::get('staff_job-ntd/approved_job_NTD/{id}', 'JobNTDController@approved_job_NTD')->name('approved_job_NTD');
    Route::get('staff_job-ntd/form_create_job', 'JobNTDController@form_create_job')->name('form_create_job');
    Route::get('staff_job-ntd/form_edit_job/{id}', 'JobNTDController@form_edit_job')->name('form_edit_job');
    Route::post('staff_job-ntd/update_job/{id}', 'JobNTDController@update_job')->name('update_job_with_staff');
    Route::get('staff_job-ntd/cap-nhat-ma-cong-viec', 'JobNTDController@update_job_code')->name('update_job_code_with_staff');
    Route::get('staff_job-ntd/job-vip', 'JobNTDController@job_vip')->name('staff_job_ntd_job_vip');
    Route::post('staff_job-ntd/duyet-job-vip-da-chon', 'JobNTDController@approved_all_job_2')->name('approved_all_job_2');
    Route::post('staff_job-ntd/bo-duyet-job-vip-da-chon', 'JobNTDController@unapproved_all_job_2')->name('unapproved_all_job_2');
    Route::get('staff_job-ntd/job-casual', 'JobNTDController@job_casual')->name('staff_job_ntd_job_casual');
    Route::get('staff_job-ntd/job-end', 'JobNTDController@list_date_end')->name('staff_job_ntd_list_date_end');
    Route::get('staff_job-ntd/bao-cao-viec-lam-NTD', 'JobNTDController@employer_job_list')->name('employer_job_list');

    Route::get('staff_job-ntd/show_modal_feedback', 'JobNTDController@show_modal_feedback')->name('show_modal_feedback');
    Route::get('staff_job-ntd/ung-tuyen-nhanh', 'JobNTDController@show_submit_cv_job')->name('show_submit_cv_job');
    Route::resource('staff_job-ntd', 'JobNTDController');


    Route::get('delete/all-job-ntd', 'JobNTDController@deleteAll')->name('delete_all_job_ntd');
    Route::get('delete/all-job-ntd-hard', 'JobNTDController@deleteAllHard')->name('delete_all_job_ntd_hard');
    Route::get('delete/job-ntd-hard/{product_id}', 'JobNTDController@deleteHard')->name('delete_job_ntd_hard');
    Route::get('staf-khoi-phuc-tin-ntd/{id}', 'JobNTDController@job_ntd_srestore')->name('staff_job_ntd_restore');
    Route::get('job-ntd/deleted', 'JobNTDController@list_deleted')->name('job_ntd_deleted');
    // quản lý việc làm facebook
    Route::get('staff_job-facebook/get_between_user_facebook/{star_time}/{end_time}/{id}', 'JobFacebookController@get_between_user_facebook')->name('get_between_user_facebook_with_staff');
    Route::get('staff_job-facebook/get_user_facebook/{id}', 'JobFacebookController@get_user_facebook')->name('get_user_facebook');
    Route::get('staff_job-facebook/form_edit_job_facebook/{id}', 'JobFacebookController@form_edit_job_facebook')->name('form_edit_job_facebook');
    Route::get('staff_job-facebook/hard_delete_job_facebook/{id}', 'JobFacebookController@hard_delete_job_facebook')->name('hard_delete_job_facebook');
    Route::get('staf-khoi-phuc-tin-facebook/{job_facebook_id}', 'JobFacebookController@Job_facebook_srestore')->name('staff_job_facebook_restore');
    Route::get('staff_job-facebook/form_create_job_facebook', 'JobFacebookController@form_create_job_facebook')->name('form_create_job_facebook');
    Route::get('staff_job-facebook/cap-nhat-tin', 'JobFacebookController@update_job_facebook')->name('update_job_facebook_with_staff');
    Route::get('staff_job-facebook/user-facebook', 'JobFacebookController@total_user_facebook')->name('staff_job_facebook_total_user_facebook');
    Route::get('staff_job-facebook/job-facebook-deleted', 'JobFacebookController@job_facebook_deleted')->name('staff_job_facebook_deleted');
    Route::get('staff_job-facebook/bao-cao-thong-ke', 'JobFacebookController@bao_cao_thong_ke_jobfb')->name('bao_cao_thong_ke_jobfb');

    Route::get('staff_job-facebook/show_modal_content_tt', 'JobFacebookController@show_modal_content_tt')->name('show_modal_content_tt');

    Route::resource('staff_job-facebook', 'JobFacebookController');
    Route::post('create-interactive-jobfb', 'JobFacebookController@create_interactive_jobfb')->name('create_interactive_jobfb');
    Route::put('update-interactive-jobfb/{id}', 'JobFacebookController@update_interactive_jobfb')->name('update_interactive_jobfb');
    Route::get('delete-interactive-jobfb/{id}', 'JobFacebookController@delete_interactive_jobfb')->name('delete_interactive_jobfb');
    Route::delete('delete/all-job-facebook', 'JobFacebookController@deleteAll')->name('delete_all_job_facebook');
    Route::delete('delete-hard/all-job-facebook', 'JobFacebookController@deleteHardAll')->name('delete_hard_all_job_facebook');
    //quản lý tin bài viết
    Route::get('staff-posts-add-question/{post_id}', 'PostController@add_question')->name('staff_add_question');
    Route::post('staff-posts-store-question', 'PostController@store_question')->name('staff_store_question');

    Route::get('staff-posts-edit-question/{post_ques_id}', 'PostController@edit_question')->name('staff_edit_question');
    Route::post('staff-posts-update-question', 'PostController@update_question')->name('staff_update_question');
    Route::delete('staff-posts-delete-question/{post_ques_id}', 'PostController@delete_question')->name('staff_delete_question');


    Route::get('bai-viet-xoa','PostController@staff_article_delete')->name('staff_article_delete');
    Route::get('delete/hard-post/{id}', 'PostController@delete_hard_post')->name('delete_hard_post');
    Route::get('reset/{id}', 'PostController@reset_post')->name('reset_post');

    Route::resource('staff_article', 'PostController');
    Route::post('delete/all-hard-post', 'PostController@deleteHardAllPost')->name('delete_all_hard_post');


    Route::delete('delete/all-post', 'PostController@deleteAll')->name('delete_all_post');
    Route::resource('staff_category_article', 'ArticleCategoryController');
    Route::delete('delete/category-article', 'ArticleCategoryController@deleteAll')->name('delete_all_category_article');

    // Quản lý kho tài liệu
    Route::resource('staff_archives', 'ArchivesController');
    Route::delete('delete/all-archives', 'ArchivesController@deleteAll')->name('delete_all_archives');
    Route::resource('staff_category_document', 'CategoryDocumentController');
    Route::delete('delete/category-document', 'CategoryDocumentController@deleteAll')->name('delete_all_category_document');
    Route::resource('staff_voucher', 'VoucherController');

    Route::get('tai-lieu-xoa','VoucherController@list_deleted')->name('list_deleted_vaucher');
    Route::get('delete/voucher-hard/{product_id}', 'VoucherController@deleteHard')->name('delete_voucher_hard');
    Route::get('reset_voucher/{id}', 'VoucherController@voucher_srestore')->name('staff_voucher_restore');
    Route::delete('delete/all-voucher-hard', 'VoucherController@deleteAllHard')->name('delete_all_voucher_hard');

    Route::delete('delete/all_voucher', 'VoucherController@deleteAll')->name('delete_all_voucher');
    Route::resource('staff_comment_voucher', 'CommentVoucherController');
    Route::delete('delete/all_comment_voucher', 'CommentVoucherController@deleteAll')->name('delete_all_comment_voucher');
    // quản lý đăng ký tư vấn
    Route::resource('staff_advisory_contact', 'ContactController');
    Route::delete('delete/all-advisory-contact', 'ContactController@deleteAll')->name('delete_all_advisory_contact');
    Route::resource('staff_advisory_employer', 'AdvisoryEmployerController');
    Route::delete('delete/all-advisory_employer', 'AdvisoryEmployerController@deleteAll')->name('delete_all_advisory_employer');
    Route::resource('staff_advisory_employee', 'AdvisoryEmployeeController');
    Route::resource('staff_employee_interactive', 'AdvisoryInteractiveController');

    Route::resource('staff_service_order', 'ServiceOrderController');
    Route::get('danh-sach-don-hang-da-thanh-toan', 'ServiceOrderController@index')->name('staff_service_order_status1');
    Route::post('task_status', 'ServiceOrderController@task_status')->name('task_status');
    Route::get('general/order', 'ServiceOrderController@general_order')->name('general_order');

    Route::get('delete_order', 'ServiceOrderController@delete_order')->name('delete_order');
    Route::get('delete/order-hard/{id}', 'ServiceOrderController@delete_order_hard')->name('delete_order_hard');
    Route::get('khoi-phuc/{id}', 'ServiceOrderController@delete_order_restore')->name('delete_order_restore');
    Route::delete('delete_all_hard_service_order', 'ServiceOrderController@delete_all_hard_service_order')->name('delete_all_hard_service_order');

    Route::resource('order_interactive', 'OrderInteractiveController');
    Route::delete('delete/all-service_order', 'ServiceOrderController@deleteAll')->name('delete_all_service_order');
    Route::delete('delete/all-general_order', 'ServiceOrderController@deleteAllGeneral')->name('delete_all_general_order');
    Route::get('/service_order_employer_staff/index', 'ServiceOrderController@list_employer')->name('list_employer_to_add_service_order_in_staff');

    Route::resource('staff_hunter_order', 'HunterOrderController');
    Route::resource('staff_order_request', 'OrderRequestController');
    Route::get('request-orders-deleted', 'OrderRequestController@list_deleted')->name('request_orders_deleted');
    Route::get('restore-request-orders-deleted/{order_request_id}', 'OrderRequestController@restore_request_orders_deleted')->name('restore_request_orders_deleted');
    Route::delete('request-orders-deleted-force/{order_request_id}', 'OrderRequestController@request_orders_deleted_force')->name('request_orders_deleted_force');
    Route::get('staff-create-order-request/{hunter_regis_id}', 'OrderRequestController@staff_create_order_request')->name('staff_create_order_request');
    Route::resource('staff_order_job', 'OrderJobController');
    Route::get('staff_order_job_deleted', 'OrderJobController@staff_order_job_deleted')->name('staff_order_job_deleted');
    Route::get('restore-job-orders-deleted/{order_job_id}', 'OrderJobController@restore_job_orders_deleted')->name('restore_job_orders_deleted');
    Route::delete('job-orders-deleted-force/{order_job_id}', 'OrderJobController@job_orders_deleted_force')->name('job_orders_deleted_force');
    Route::get('manager/staff_order_job/{order_job_id}', 'OrderJobController@manager_order_job')->name('manager_order_job');
    Route::post('manager/staff_order_job/change_staff_status_job_submit', 'OrderJobController@change_staff_status_job_submit')->name('change_staff_status_job_submit');
    Route::get('manager/staff_order_job/delete_employer_in_order/{staff_employee_id}/{submit_job_fb_id}', 'OrderJobController@delete_employer_in_order')->name('delete_employer_in_order');
    Route::post('manager/staff_order_job/add_employee_apply_order_job', 'OrderJobController@add_employee_apply_order_job')->name('add_employee_apply_order_job');
    Route::post('manager/staff_order_job/search_employee_order_job', 'OrderJobController@search_employee_order_job')->name('search_employee_order_job');
    Route::post('manager/staff_order_job/form_change_staff_status_job_submit', 'OrderJobController@form_change_staff_status_job_submit')->name('form_change_staff_status_job_submit');
    Route::post('manager/staff_order_job/get_status_job_employee', 'OrderJobController@get_status_job_employee')->name('get_status_job_employee');
    Route::get('create-order-request/get-info-hunter-register', 'OrderRequestController@get_info_hunter_register')->name('get_info_hunter_register');
    Route::get('staff-create-order-job/{order_request_id}', 'OrderJobController@staff_create_order_job')->name('staff_create_order_job');
    Route::get('recruitment-order/index', 'HunterOrderController@request_recruitment_order')->name('request_recruitment_order');
    Route::get('ajax/get_employer_select2', 'HunterOrderController@get_employer_select2')->name('get_employer_select2');
    Route::get('ajax/get_job_select2', 'OrderJobController@get_job_select2')->name('get_job_select2');
    Route::delete('delete/all-hunter_order', 'HunterOrderController@deleteAll')->name('delete_all_hunter_order');
    Route::get('/hunter_order_employer_staff/index', 'HunterOrderController@list_employer')->name('list_employer_to_add_hunter_order_in_staff');

    Route::resource('staff_icon_order', 'IconOrderController');
    Route::delete('delete/all-icon_order', 'IconOrderController@deleteAll')->name('delete_all_icon_order');
    Route::get('/icon_order_employer_staff/index', 'IconOrderController@list_employer')->name('list_employer_to_add_icon_order_in_staff');

    Route::get('/staff_follow/{id}', 'SaffController@follow_user')->name('follow_user');

    Route::resource('tag-category', 'CategoryTagController');
    Route::post('delete_all/tag_category', 'CategoryTagController@delete_all')->name('delete_all_tag_category');

    Route::get('dashboard','EmployeeController@dashboard')->name('dashboard');
    Route::get('dashboard-employer','EmployerController@dashboard')->name('dashboard_employer');
    Route::get('dashboard-teacher','TeacherController@dashboard')->name('dashboard_teacher');
    Route::get('dashboard-article','PostController@dashboard')->name('dashboard_article');
});
?>
