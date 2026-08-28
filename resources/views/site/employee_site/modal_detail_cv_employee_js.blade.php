{{--<script>--}}
   {{----}}
{{--$(function(){--}}
    {{----}}
    {{--const asset_web = '<?php echo asset('') ?>';--}}
    {{--$('.modal_employee_cv[data-target="#detailEmployee"]').on('click', function(){--}}
        {{--$('#detailEmployeeCv').modal('show');--}}
    {{--})--}}
    {{--$('#detailEmployeeCv .col_pdf .show_cv').html('');--}}
    {{--$('#detailEmployeeCv .title_employer_response').html('');--}}
    {{--$('#detailEmployeeCv .employer_response').html('');--}}
    {{--//khi dong cv thi reset modal--}}
    {{--$('#detailEmployeeCv').on('hide.bs.modal', function () {--}}
        {{--$('#detailEmployeeCv .col_pdf .show_cv').html('');--}}
        {{--$('#detailEmployeeCv .title_employer_response').html('');--}}
        {{--$('#detailEmployeeCv .employer_response').html('');--}}
        {{--$('#detailEmployeeCv table.table_info tbody').html('');--}}
        {{--$('#detailEmployeeCv table.table_coin tbody').html('');--}}
    {{--})--}}
    {{--//hien cv--}}
    {{--$('.modal_employee_cv').on('click', function(){--}}
        {{--let area_employee_work = $(this).find('.areaEmployeeWork').text();--}}
        {{--let employee_job_look_for = $(this).find('.employeeJobLookFor').text();--}}
        {{--let employee_experience = $(this).find('.employeeExperience').text();--}}
        {{--let experience_in_field = $(this).find('.experienceInField').text();--}}
        {{--let date_update = $(this).find('.dateUpdate').text();--}}
        {{--$('#detailEmployeeCv .col_pdf .show_cv').html('');--}}
        {{--$('#detailEmployeeCv').attr('data-employee-id', $(this).attr('data-id'));--}}
        {{--let employee_id = $(this).attr('data-id');--}}

        {{--let link_invite = "{{ route('invitation_apply_detail_employee', ':id') }}";--}}
        {{--link_invite = link_invite.replace(':id', $(this).attr('data-id'));--}}
        {{--$('#detailEmployeeCv .a_invite_employee').attr('href', link_invite)--}}
        {{--$.ajax({--}}
            {{--'type': 'get',--}}
            {{--'url': "{{ route('modal_detail_cv') }}",--}}
            {{--'data': {--}}
                {{--employee_id: employee_id--}}
            {{--},--}}
            {{--beforeSend: function()--}}
            {{--{--}}
                {{--$('.loading_cv').css('display', 'block');--}}
            {{--},--}}
            {{--'success': function(res){--}}
                {{----}}
                {{--let col_pdf = $('#detailEmployeeCv .col_pdf');--}}
                {{--let table_info = $('#detailEmployeeCv table.table_info');--}}
                {{--let table_coin = $('#detailEmployeeCv table.table_coin tbody');--}}
                {{--let employer_response = $('#detailEmployeeCv .employer_response')--}}
                {{--let title_employer_response = $('#detailEmployeeCv .title_employer_response')--}}
                {{--//chech ung vien co cv upload hay khong--}}
                {{--if(res.cv_upload) {--}}
                    {{--//check nha tuyen dung da xem cv nay chua--}}
                    {{--if(res.coin_show_employee) {--}}
                        {{--if(res.link_cv_upload){--}}
                            {{--let iframe = document.createElement('iframe');--}}
                            {{--iframe.id = 'iframe_cv_employee';--}}
                            {{--iframe.src = `https://docs.google.com/viewer?url=${res.link_cv_upload}&embedded=true`;--}}
                            {{--iframe.loading = 'lazy';--}}
                            {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                            {{--iframe.frameborder = '0';--}}
                            {{--col_pdf.find('.show_cv').append(iframe);--}}
                        {{--}--}}
                    {{--}--}}
                    {{--else {--}}
                        {{--col_pdf.find('.show_cv').append(`--}}
                            {{--<img src="/image_cv_upload/cv_upload.jpg" alt="" style="height:95vh">--}}
                        {{--`);--}}
                    {{--}--}}
                {{--}--}}
                {{--// nha td khong co cv upload--}}
                {{--else{--}}
                    {{--// neu co cv tao tu web skt--}}
                    {{--if(res.check_employee_cv) {--}}
                        {{--//check nha tuyen dung da xem cv nay chua--}}
                        {{--if(res.coin_show_employee) {--}}
                            {{--let iframe = document.createElement('iframe');--}}
                            {{--iframe.id = 'iframe_cv_employee';--}}
                            {{--iframe.src = `https://docs.google.com/viewer?url=${asset_web}ung-vien/pdf/page-cv/${res.employee.user_id}&embedded=true`;--}}
                            {{--iframe.loading = 'lazy';--}}
                            {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                            {{--iframe.frameborder = '0';--}}
                            {{--col_pdf.find('.show_cv').append(iframe);--}}
                        {{--}--}}
                        {{--// chua xem--}}
                        {{--else {--}}
                            {{--let iframe = document.createElement('iframe');--}}
                            {{--iframe.id = 'iframe_cv_employee';--}}
                            {{--iframe.src = `https://docs.google.com/viewer?url=${asset_web}nha-tuyen-dung/pdf/page-cv/${res.employee.user_id}&embedded=true#toolbar=0`;--}}
                            {{--iframe.loading = 'lazy';--}}
                            {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                            {{--iframe.frameborder = '0';--}}
                            {{--col_pdf.find('.show_cv').append(iframe);--}}
                        {{--}--}}
                    {{--}--}}
                    {{--//  th ko co cv nao ca--}}
                    {{--else {--}}
                        {{--setTimeout(function(){ --}}
                            {{--col_pdf.find('.show_cv').append(`<p style="font-size:2rem">Ứng viên chưa có CV.</p>`);--}}
                        {{--});--}}
                    {{--}--}}
                {{--}--}}
                {{--setTimeout(function(){ $('.loading_cv').css('display', 'none'); }, 3000);--}}
                {{----}}
                {{--let status_job = "";--}}
                {{--if(res.employee.status == 0) {--}}
                    {{--status_job = `<span class="text-danger">Chưa đi làm <i class="fas fa-times-circle"></i></span>`;--}}
                {{--}--}}
                {{--else {--}}
                    {{--status_job = `<span class="text-success">Đã đi làm <i class="fas fa-check-circle"></i></span>`;--}}
                {{--}--}}
                {{--let marry = null;--}}
                {{--if(res.employee.marry == 0)--}}
                {{--{--}}
                    {{--marry = `--}}
                        {{--<tr>--}}
                            {{--<td>TT hôn nhân</td>--}}
                            {{--<td colspan="2" class="td_profile">Độc thân</td>--}}
                        {{--</tr>--}}
                    {{--`;--}}
                {{--}--}}
                {{--if(res.employee.marry == 1)--}}
                {{--{--}}
                    {{--marry = `--}}
                        {{--<tr>--}}
                            {{--<td>TT hôn nhân</td>--}}
                            {{--<td colspan="2" class="td_profile">Đã kết hôn</td>--}}
                        {{--</tr>--}}
                    {{--`;--}}
                {{--}--}}
                {{--//xu ly tt lien he--}}
                {{--if(res.coin_show_employee) {--}}
                    {{--table_info.find('.info_contact').html(`--}}
                        {{--<tr>--}}
                            {{--<td>Email</td>--}}
                            {{--<td colspan="2">${res.employee.email}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Số điện thoại</td>--}}
                            {{--<td colspan="2">${res.employee.phone}</td>--}}
                        {{--</tr>--}}
                    {{--`);--}}
                {{--}--}}
                {{--else {--}}
                    {{--if(res.user && res.user.role == 2) {--}}
                        {{--table_info.find('.info_contact').html(`--}}
                        {{--<tr>--}}
                            {{--<td colspan="3">--}}
                                {{--<a type="submit" class="text-light btn btn-sm btn-success submit_show_info_cv_detail_employee">--}}
                                    {{--Xem Thông tin liên hệ của ứng viên( ${res.view_profile} điểm )--}}
                                {{--</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--`);--}}
                    {{--}--}}
                    {{--else {--}}
                        {{--table_info.find('.info_contact').html(`--}}
                        {{--<tr>--}}
                            {{--<td colspan="3">--}}
                                {{--<a type="submit" class="text-light btn btn-sm btn-success" data-toggle="modal"--}}
                                    {{--data-target="#contac_employee">--}}
                                    {{--Xem Thông tin liên hệ của ứng viên( ${res.view_profile} điểm )--}}
                                {{--</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--`);--}}
                    {{--}--}}
                {{--}--}}
                {{--table_info.find('.info_different').html(`--}}
                    {{--<tr>--}}
                        {{--<td>Họ và tên</td>--}}
                        {{--<td colspan="2">${res.employee.employee_name}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>TT công việc</td>--}}
                        {{--<td colspan="2">${status_job}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mức lương</td>--}}
                        {{--<td colspan="2">${res.employee.salary}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Điểm hồ sơ</td>--}}
                        {{--<td colspan="1" class="td_profile">${res.employee.profile}</td>--}}
                        {{--<td colspan="1" class="td_profile">Mã ứng viên: ${res.employee.employee_id}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Ngày cập nhật</td>--}}
                        {{--<td colspan="1" class="td_profile">${date_update}</td>--}}
                        {{--<td colspan="1" class="td_profile">--}}
                            {{--<i class="far fa-eye mgr5"></i>: ${res.employee.views}--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--${marry}--}}
                    {{--<tr>--}}
                        {{--<td>Kinh nghiệm</td>--}}
                        {{--<td colspan="2">${employee_experience} năm</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td --}}
                        {{--data-toggle="tooltip" title="Kinh nghiệm trong lĩnh vực" --}}
                        {{--data-original-title="Kinh nghiệm trong lĩnh vực"--}}
                        {{--colspan="3">--}}
                            {{--${experience_in_field}--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td --}}
                        {{--data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm" --}}
                        {{--data-original-title="Vị trí công việc ứng viên cần tìm"--}}
                        {{--colspan="3">${employee_job_look_for}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td --}}
                        {{--data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc" --}}
                        {{--data-original-title="Khu vực ứng viên mong muốn tìm việc"--}}
                        {{--colspan="3">${area_employee_work}</td>--}}
                    {{--</tr>--}}
                {{--`);--}}
                {{--table_coin.html(`--}}
                    {{--<tr>--}}
                        {{--<td--}}
                        {{--data-toggle="tooltip" title="Thông tin cơ bản của ứng viên" --}}
                        {{--data-original-title="Thông tin cơ bản của ứng viên">--}}
                            {{--<b class="text-success" style="font-size:0.7rem">Điểm HS</b>--}}
                        {{--</td>--}}
                        {{--<td--}}
                        {{--data-toggle="tooltip" title="Thông tin trên CV của ứng viên" --}}
                        {{--data-original-title="Thông tin trên CV của ứng viên">--}}
                            {{--<b class="text-success" style="font-size:0.7rem">Điểm CV</b>--}}
                        {{--</td>--}}
                        {{--<td--}}
                        {{--data-toggle="tooltip" title="Sàn kế toán đánh giá chất lượng hồ sơ" --}}
                        {{--data-original-title="Sàn kế toán đánh giá chất lượng hồ sơ">--}}
                            {{--<b class="text-success" style="font-size:0.7rem">Điểm SKT</b>--}}
                        {{--</td>--}}
                        {{--<td--}}
                        {{--data-toggle="tooltip" title="Điểm ứng viên đã tham gia khóa học của sàn kế toán" --}}
                        {{--data-original-title="Điểm ứng viên đã tham gia khóa học của sàn kế toán">--}}
                            {{--<b class="text-success" style="font-size:0.7rem">Điểm K/HỌC</b>--}}
                        {{--</td>--}}
                        {{--<td--}}
                        {{--data-toggle="tooltip" title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên" --}}
                        {{--data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên">--}}
                            {{--<b class="text-success" style="font-size:0.7rem">Điểm NTD</b>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td style="padding: 0 .4rem; text-align:center" class="table_coin_profile_info">--}}
                            {{--${res.employee_profile.profile_info}--}}
                        {{--</td>--}}
                        {{--<td style="padding: 0 .4rem; text-align:center" class="table_coin_profile_cv">--}}
                            {{--${res.employee_profile.profile_cv}--}}
                        {{--</td>--}}
                        {{--<td style="padding: 0 .4rem; text-align:center" class="td_profile_staff">--}}
                            {{--${res.employee_profile.profile_staff}--}}
                        {{--</td>--}}
                        {{--<td style="padding: 0 .4rem; text-align:center">--}}
                            {{--${res.employee_profile.profile_course}--}}
                        {{--</td>--}}
                        {{--<td style="padding: 0 .4rem; text-align:center" class="td_profile_avg">--}}
                            {{--${res.employee_profile.profile_avg}--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--`);--}}

                {{--// nha tuyen dung phan hoi--}}
                {{----}}
                {{--if(res.user && res.user.role == 2) {--}}
                        {{--if((res.list_response).length  > 0){--}}
                            {{--title_employer_response.html(`--}}
                            {{--<p style="font-size: 1rem;font-weight: 600;color: darkblue;text-align: center;">--}}
                                {{--Lịch sử phản hồi chất lượng CV--}}
                            {{--</p>`)--}}
                        {{--}--}}
                        {{--else{--}}
                            {{--title_employer_response.html(``);--}}
                            {{--employer_response.html(``);--}}
                        {{--}--}}
                        {{--(res.list_response).forEach(ele => {--}}
                            {{--let date_response = new Date(ele.created_at);--}}
                            {{--let formatted_date_response = date_response.getDate() + "-" + (date_response.getMonth() + 1) + "-" + date_response.getFullYear();--}}
                            {{--let select_response = '';--}}
                            {{--if(ele.responses) {--}}
                                {{--select_response = `--}}
                                    {{--<span>Phản hồi: </span>${(ele.responses).toString()} --}}
                                    {{--<br>--}}
                                {{--`;--}}
                            {{--}--}}
                            {{--let response_diff = '';--}}
                            {{--if(ele.response_diff) {--}}
                                {{--response_diff = `--}}
                                    {{--<span>Nội dung: </span>--}}
                                    {{--<div style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; width:300px;">--}}
                                    {{--${ele.response_diff}--}}
                                    {{--</div>--}}
                                {{--`;--}}
                            {{--}--}}
                            {{--employer_response.append(`--}}
                            {{--<span>Ngày phản hồi: </span>${formatted_date_response}--}}
                            {{--<br>--}}
                            {{--${select_response}--}}
                            {{--${response_diff}--}}
                            {{--<hr>--}}
                        {{--`);--}}
                    {{--})--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}

    {{--//vote star--}}
    {{--$(".employer_vote_star").starRating({--}}
        {{--starSize: 30,--}}
        {{--totalStars: 5,--}}
        {{--useFullStars: true,--}}
        {{--disableAfterRate: false,--}}
        {{--starShape: 'rounded',--}}
        {{--activeColor: 'orange',--}}
        {{--ratedColor: 'orange',--}}
        {{--hoverColor: 'orange',--}}
        {{--onHover: function (currentIndex, currentRating, $el) {--}}
            {{--var showText = '';--}}
            {{--if (currentIndex == 1) {--}}
                {{--showText = 'Tệ';--}}
            {{--}--}}
            {{--if (currentIndex == 2) {--}}
                {{--showText = 'Trung bình';--}}
            {{--}--}}
            {{--if (currentIndex == 3) {--}}
                {{--showText = 'Khá';--}}
            {{--}--}}
            {{--if (currentIndex == 4) {--}}
                {{--showText = 'Tốt';--}}
            {{--}--}}
            {{--if (currentIndex == 5) {--}}
                {{--showText = 'Xuất sắc';--}}
            {{--}--}}
            {{--$('.live-rating').removeClass('hide');--}}
            {{--$('.live-rating').text(showText);--}}

        {{--},--}}
        {{--onLeave: function (currentIndex, currentRating, $el) {--}}
            {{--$('.live-rating').addClass('hide');--}}
        {{--},--}}
        {{--callback: function (currentIndex, $el) {--}}
            {{--var showText = '';--}}
            {{--if (currentIndex == 1) {--}}
                {{--showText = 'Tệ';--}}
            {{--}--}}
            {{--if (currentIndex == 2) {--}}
                {{--showText = 'Trung bình';--}}
            {{--}--}}
            {{--if (currentIndex == 3) {--}}
                {{--showText = 'Khá';--}}
            {{--}--}}
            {{--if (currentIndex == 4) {--}}
                {{--showText = 'Tốt';--}}
            {{--}--}}
            {{--if (currentIndex == 5) {--}}
                {{--showText = 'Xuất sắc';--}}
            {{--}--}}
            {{--activeRate = showText;--}}

            {{--$('.live-rating').removeClass('hide');--}}
            {{--$('.live-rating').text(showText);--}}
            {{--$('.form-rating').addClass('show');--}}
            {{--$('.live-rating').addClass('show');--}}
            {{--$('.form-rating').removeClass('hide');--}}
            {{--// console.log(currentIndex);--}}
            {{--$('input[name="vote_star"]').attr('value', currentIndex);--}}
        {{--}--}}
    {{--});--}}
    {{--//đánh giá--}}
    {{--$('#vote_employee .send_evaluate').on('click', function(){--}}
        {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
        {{--let vote_star = $('#vote_employee input[name="vote_star"]').val();--}}
        {{--let comment = $('#vote_employee textarea#textarea_comment_star').val();--}}

        {{--$.ajax({--}}
            {{--'type': 'get',--}}
            {{--'url': "{{ route('employer_avaluate_employee') }}",--}}
            {{--'data': {--}}
                {{--employee_id: employee_id,--}}
                {{--comment: comment,--}}
                {{--vote_star: vote_star--}}
            {{--},--}}
            {{--'success': function(res) {--}}
                {{--$('#vote_employee').modal('hide');--}}
                {{--swal({--}}
                    {{--title: res.mess,--}}
                    {{--icon: "success",--}}
                    {{--button: "Đóng",--}}
                {{--});--}}
                {{--$('.table_info .td_profile').html(res.profile)--}}
                {{--$('.table_coin .td_profile_avg').html(res.avg)--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}
    {{--//mo danh gia--}}
    {{--$('#vote_employee').on('hide.bs.modal', function () {--}}
        {{--$(".employer_vote_star").starRating('setRating',0);--}}
        {{--$('#vote_employee #textarea_comment_star').val('');--}}
    {{--})--}}
    {{--$('#detailEmployeeCv .vote_employee').on('click', function(){--}}
        {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
        {{--let textarea_comment = $('#vote_employee #textarea_comment_star');--}}
        {{--$.ajax({--}}
            {{--'type': 'get',--}}
            {{--'url': "{{ route('get_employer_avaluate_employee') }}",--}}
            {{--'data': {--}}
                {{--employee_id: employee_id--}}
            {{--},--}}
            {{--'success': function(res) {--}}
                {{--if(res.status == 'error'){--}}
                    {{--swal({--}}
                        {{--title: res.mess,--}}
                        {{--icon: "error",--}}
                        {{--button: "Đóng",--}}
                    {{--});--}}
                {{--}--}}
                {{--else {--}}
                    {{--$('#vote_employee').modal('show')--}}
                    {{--$(".employer_vote_star").starRating('setRating', res.employer_rating_employee.rating_start);--}}
                    {{--textarea_comment.val(res.employer_rating_employee.rating_content);--}}
                {{--}--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}
    {{--// show thông tin liên lạc ứng viên--}}
    {{--$(document).on('click', '.submit_show_info_cv_detail_employee', function() {--}}
        {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
        {{--$.ajax({--}}
            {{--'type': 'get',--}}
            {{--'url': "{{ route('ajax_show_info_cv_detail_employee') }}",--}}
            {{--'data': {--}}
                {{--employee_id: employee_id--}}
            {{--},--}}
            {{--'success': function(res) {--}}
                {{--let col_pdf = $('#detailEmployeeCv .col_pdf');--}}
                {{--let table_info = $('#detailEmployeeCv table.table_info');--}}
                {{--$('#detailEmployeeCv .col_pdf .show_cv').html('');--}}
                {{--if(res.status == 'error') {--}}
                    {{--swal({--}}
                        {{--title: res.mess,--}}
                        {{--icon: "error",--}}
                        {{--button: "Đóng",--}}
                    {{--});--}}
                {{--}--}}
                {{--else {--}}
                    {{--table_info.find('.info_contact').html(`--}}
                        {{--<tr>--}}
                            {{--<td>Email</td>--}}
                            {{--<td colspan="2">${res.employee_contact.email}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Số điện thoại</td>--}}
                            {{--<td colspan="2">${res.employee_contact.phone}</td>--}}
                        {{--</tr>--}}
                    {{--`);--}}
                    {{--if(res.link_cv_upload) {--}}
                        {{--let iframe = document.createElement('iframe');--}}
                        {{--iframe.id = 'iframe_cv_employee';--}}
                        {{--iframe.src = `https://docs.google.com/viewer?url=${res.real_link_cv_upload}&embedded=true`;--}}
                        {{--iframe.loading = 'lazy';--}}
                        {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                        {{--iframe.frameborder = '0';--}}
                        {{--col_pdf.find('.show_cv').append(iframe);--}}
                    {{--}--}}
                    {{--else{--}}
                        {{--if(res.check_employee_cv) {--}}
                            {{--let iframe = document.createElement('iframe');--}}
                            {{--iframe.id = 'iframe_cv_employee';--}}
                            {{--iframe.src = `https://docs.google.com/viewer?url=${asset_web}ung-vien/pdf/page-cv/${res.employee_contact.user_id}&embedded=true`;--}}
                            {{--iframe.loading = 'lazy';--}}
                            {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                            {{--iframe.frameborder = '0';--}}
                            {{--col_pdf.find('.show_cv').append(iframe);--}}
                        {{--}   --}}
                        {{--else {--}}
                            {{--col_pdf.find('.show_cv').append(`<p style="font-size:2rem">Ứng viên chưa có CV.</p>`)--}}
                        {{--}--}}
                        {{--$(`.modal_employee_cv[data-id="${employee_id}"]`).find('.employee_watched').html(`--}}
                        {{--<span class="box_job_submit"><i--}}
                                                                                {{--class="far fa-eye mgr5"></i>Đã xem</span>--}}
                        {{--`)--}}
                    {{--}--}}
                {{--}--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}

    {{--// phan hoi chat luong cv ve skt--}}
    {{--@if(Auth::check() && Auth::user()->role == 2)--}}
        {{--$('.response_employee').on('click', function(){--}}
            {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
            {{--$.ajax({--}}
                {{--'type': 'get',--}}
                {{--'url': "{{ route('check_employer_can_response_cv') }}",--}}
                {{--'data': {--}}
                    {{--employee_id: employee_id--}}
                {{--},--}}
                {{--'success': function(res){--}}
                    {{--if(res.status == 'success'){--}}
                        {{--$('#modal_response_employee').modal('show');--}}
                    {{--}--}}
                    {{--else{--}}
                        {{--swal({--}}
                            {{--title: res.mess,--}}
                            {{--icon: "error",--}}
                            {{--button: "Đóng",--}}
                        {{--});--}}
                    {{--}--}}
                {{--}--}}
            {{--})--}}
            {{----}}
        {{--})--}}

        {{--$('#modal_response_employee .send_response_cv').on('click', function() {--}}
            {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
            {{--let response_diff = $('#modal_response_employee textarea#response_diff').val();--}}
            {{--let response = $('#modal_response_employee select#response').val();--}}

            {{--$.ajax({--}}
                {{--'type': 'get',--}}
                {{--'url': "{{ route('response_cv') }}",--}}
                {{--'data': {--}}
                    {{--employee_id: employee_id,--}}
                    {{--response_diff: response_diff,--}}
                    {{--response: response--}}
                {{--},--}}
                {{--'success': function(res) {--}}
                    {{--let employer_response = $('#detailEmployeeCv .employer_response')--}}
                    {{--let title_employer_response = $('#detailEmployeeCv .title_employer_response')--}}
                    {{--$('#modal_response_employee').modal('hide');--}}
                    {{--if (title_employer_response.is(':empty')) {--}}
                        {{--title_employer_response.html(`--}}
                            {{--<p style="font-size: 1rem;font-weight: 600;color: darkblue;text-align: center;">--}}
                                {{--Lịch sử phản hồi chất lượng CV--}}
                            {{--</p>`)--}}
                    {{--}--}}
                    {{--let content_response = '';--}}
                    {{--if(response){--}}
                        {{--content_response = `--}}
                            {{--<span>Phản hồi: </span>${(res.list_select_response).toString()}--}}
                            {{--<br>--}}
                        {{--`;--}}
                    {{--}--}}
                    {{--let content_response_diff = '';--}}
                    {{--if(response_diff){--}}
                        {{--content_response_diff = `--}}
                            {{--<span>Nội dung: </span--}}
                            {{--<div style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; width:300px;">--}}
                                {{--${response_diff}--}}
                            {{--</div>--}}
                        {{--`;--}}
                    {{--}--}}
                    {{--employer_response.prepend(`--}}
                        {{--<span>Ngày phản hồi: </span>Vừa xong--}}
                        {{--<br>--}}
                        {{--${content_response}--}}
                        {{--${content_response_diff}--}}
                        {{--<hr>--}}
                    {{--`);--}}
                    {{--swal({--}}
                        {{--title: res.mess,--}}
                        {{--icon: "success",--}}
                        {{--button: "Đóng",--}}
                    {{--});--}}
                {{--}--}}
            {{--})--}}
        {{--})--}}
    {{--@else --}}
        {{--$('.response_employee').on('click', function(){--}}
            {{--swal({--}}
                {{--title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",--}}
                {{--icon: "error",--}}
                {{--button: "Đóng",--}}
            {{--});--}}
        {{--})--}}
        {{--$('#detailEmployeeCv .a_invite_employee').on('click', function(event){--}}
            {{--event.preventDefault()--}}
            {{--swal({--}}
                {{--title: "Bạn cần đăng nhập tài khoản nhà tuyển dụng để thực hiện chưc năng này.",--}}
                {{--icon: "error",--}}
                {{--button: "Đóng",--}}
            {{--});--}}
        {{--})--}}
    {{--@endif--}}

    {{--//reload cv--}}
    {{--$('.reload_cv').on('click', function() {--}}
        {{--$(document).ajaxStart(function(){--}}
            {{--$('.loading_cv').css('display', 'block');--}}
        {{--});--}}
        {{--let employee_id = $('#detailEmployeeCv').attr('data-employee-id');--}}
        {{--$.ajax({--}}
            {{--'type': 'get',--}}
            {{--'url': "{{ route('reload_cv') }}",--}}
            {{--'data': {--}}
                {{--employee_id: employee_id--}}
            {{--},--}}
            {{--'beforeSend': function()--}}
            {{--{--}}
                {{--$('#detailEmployeeCv .col_pdf .show_cv').html('');--}}
                {{--$('.loading_cv').css('display', 'block');--}}
            {{--},--}}
            {{--'success': function(res) {--}}
                {{--let col_pdf = $('#detailEmployeeCv .col_pdf');--}}
                {{--let iframe = document.createElement('iframe');--}}
                {{--iframe.id = 'iframe_cv_employee';--}}
                {{--iframe.src = `https://docs.google.com/viewer?url=${res.link_cv}&embedded=true`;--}}
                {{--iframe.loading = 'lazy';--}}
                {{--iframe.style = 'width:100%;height:95vh;position:absolute;top:0';--}}
                {{--iframe.frameborder = '0';--}}
                {{--col_pdf.find('.show_cv').append(iframe);--}}
                {{--setTimeout(function(){ $('.loading_cv').css('display', 'none'); }, 3000);--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}
{{--});--}}

{{--</script>--}}