<script>
    $(document).ready(function(){
        $('#detailEmployee .col_pdf .show_cv').remove();
        $('#detailEmployee').on('hide.bs.modal', function() {
            $('#detailEmployee .col_pdf .show_cv').remove();
            $('#detailEmployee table.table_info tbody').html('');
            $('#detailEmployee table.table_coin tbody').html('');
            let li_status_employee = $('#detailEmployee .ul_action .li_status_employee');
            let li_delete_request = $('#detailEmployee .ul_action .li_delete_request');
            let li_follow_employee = $('#detailEmployee .ul_action .li_follow_employee');
            li_delete_request.find('input').prop('checked', false);
            li_status_employee.find('input').prop('checked', false);
            li_follow_employee.find('input').prop('checked', false);
        });

        // Xem chi tiết cv ứng viên
        $('.modal_cv').on('click', function() {
            console.log('hien thi');
            $('#detailEmployee').attr('data-employee-id', $(this).attr('data-id'));

            let link_interactive = "{{ route('detail_employee', ':id') }}";
            link_interactive = link_interactive.replace(':id', $(this).attr('data-id'));
            $('#detailEmployee .link_interactive').attr('href', link_interactive);

            let link_edit_form = "{{ route('staff_employee_edit_form', ':id') }}";
            link_edit_form = link_edit_form.replace(':id', $(this).attr('data-id'));
            $('#detailEmployee .link_edit_form').attr('href', link_edit_form);

            $.ajax({
                'type': 'get',
                'url': "{{ route('staff_detail_cv') }}",
                'data': {
                    employee_id: $(this).attr('data-id')
                },
                beforeSend: function() {
                    $('.loading_cv').css('display', 'block');
                },
                'success': function(res) {
                    let col_pdf = $('#detailEmployee .col_pdf');
                    let table_info = $('#detailEmployee table.table_info tbody');
                    let table_coin = $('#detailEmployee table.table_coin tbody');
                    let li_status_employee = $(
                        '#detailEmployee .ul_action .li_status_employee');
                    let li_delete_request = $('#detailEmployee .ul_action .li_delete_request');
                    let li_follow_employee = $(
                        '#detailEmployee .ul_action .li_follow_employee');
                    // th co cv upload
                    if (res.cv_upload) {
                        // hien thi cv upload
                        col_pdf.append(
                            `
                                <div class="show_cv" style="width:100%">
                                    <iframe src="https://docs.google.com/gview?url=${res.url_cv_upload}&embedded=true#toolbar=0"
                                    frameborder="0" style="width:100%;height:97vh"></iframe>
                                </div>
                            `
                        )
                    } else {
                        if (res.check_employee_cv) {
                            col_pdf.html(`<div class="show_cv" style="width:100%">
                                <iframe src="/ung-vien/pdf/page-cv/${res.employee.user_id}#toolbar=0"
                                    frameborder="0" style="width:100%;height:97vh"></iframe></div>
                            `);
                        } else {
                            col_pdf.html(
                                `<div class="show_cv" style="width:100%"><p style="font-size:2rem;text-align:center">Ứng viên chưa có CV.</p></div>`
                            )
                        }
                    }
                    $('.loading_cv').css('display', 'none');
                    //in table
                    let approved = "";
                    let status_job = "";
                    if (res.employee.status_employee == 1) {
                        approved =
                            `<span class="text-success">Đã duyệt <i class="fas fa-check-circle"></i></span>`;
                    } else {
                        approved =
                            `<span class="text-danger">Chưa duyệt <i class="fas fa-times-circle"></i></span>`;
                    }

                    if (res.employee.status == 0) {
                        status_job =
                            `<span class="text-danger">Chưa đi làm <i class="fas fa-times-circle"></i></span>`;
                    } else {
                        status_job =
                            `<span class="text-success">Đã đi làm <i class="fas fa-check-circle"></i></span>`;
                    }
                    //format ngay
                    let created_at = new Date(res.employee.created_at);
                    let formatted_created_at = created_at.getDate() + "-" + (created_at
                        .getMonth() + 1) + "-" + created_at.getFullYear();
                    let updated_at = new Date(res.employee.updated_at);
                    let formatted_updated_at = updated_at.getDate() + "-" + (updated_at
                        .getMonth() + 1) + "-" + updated_at.getFullYear()
                    // xac dinh email dda xac thuc chua
                    let employee_email = '';
                    if (res.employee.status_email_account == 0) {
                        employee_email = `
                            <span class="text-danger">${res.employee.email} <i class="fas fa-times-circle"></i></span>
                        `;
                    } else {
                        employee_email = `
                            <span class="text-success">${res.employee.email} <i class="fas fa-check-circle"></i></span>
                        `;
                    }
                    // xac dinh an hay hien thi ho so
                    // 0 la hen thi 1 la an
                    let show_hidden_profile = '';
                    if (res.employee.show_hidden_profile == 0) {
                        show_hidden_profile = `
                            <span class="text-success">Hiện H/S <i class="fas fa-check-circle"></i></span>
                        `;
                    } else {
                        show_hidden_profile = `
                            <span class="text-danger">Ẩn H/S <i class="fas fa-times-circle"></i></span>
                        `;
                    }
                    table_info.html(`
                        <tr>
                            <td>Họ và tên</td>
                            <td colspan="2">${res.employee.employee_name} - ${res.employee.phone}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td colspan="2">${employee_email}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái</td>
                            <td class="duyet">${approved}</td>
                            <td class="display_disable_profile">${show_hidden_profile}</td>
                        </tr>
                        <tr>
                            <td>TT công việc</td>
                            <td colspan="2">${status_job}</td>
                        </tr>
                        <tr>
                            <td>Mức lương</td>
                            <td colspan="2">${res.employee.salary}</td>
                        </tr>
                        <tr>
                            <td>Điểm hồ sơ</td>
                            <td colspan="2" class="td_profile">${res.employee.profile}</td>
                        </tr>
                        <tr>
                            <td>${formatted_created_at}</td>
                            <td colspan="2">${formatted_updated_at}</td>
                        </tr>
                        <tr>
                            <td
                            data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm"
                            data-original-title="Vị trí công việc ứng viên cần tìm"
                            colspan="3">${res.employee.careers}</td>
                        </tr>
                        <tr>
                            <td
                            data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc"
                            data-original-title="Khu vực ứng viên mong muốn tìm việc"
                            colspan="3">${res.employee.areas}</td>
                        </tr>
                    `);
                    table_coin.html(`
                        <tr>
                            <td
                            data-toggle="tooltip" title="Thông tin cơ bản của ứng viên"
                            data-original-title="Thông tin cơ bản của ứng viên"
                            >
                                <b style="font-size:0.7rem">Điểm HS</b>
                            </td>
                            <td
                            data-toggle="tooltip" title="Thông tin trên CV của ứng viên"
                            data-original-title="Thông tin trên CV của ứng viên"
                            >
                                <b style="font-size:0.7rem">Điểm CV</b>
                            </td>
                            <td
                            data-toggle="tooltip" title="Sàn kế toán đánh giá chất lượng hồ sơ"
                            data-original-title="Sàn kế toán đánh giá chất lượng hồ sơ"
                            >
                                <b style="font-size:0.7rem">Điểm SKT</b>
                            </td>
                            <td
                            data-toggle="tooltip" title="Điểm ứng viên đã tham gia khóa học của sàn kế toán"
                            data-original-title="Điểm ứng viên đã tham gia khóa học của sàn kế toán"
                            >
                                <b style="font-size:0.7rem">Điểm K/HỌC</b>
                            </td>
                            <td
                            data-toggle="tooltip" title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                            data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                            >
                                <b style="font-size:0.7rem">Điểm NTD</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_coin_profile_info">${res.employee_profile.profile_info}</td>
                            <td class="table_coin_profile_cv">${res.employee_profile.profile_cv}</td>
                            <td class="td_profile_staff">${res.employee_profile.profile_staff}</td>
                            <td>${res.employee_profile.profile_course}</td>
                            <td>${res.employee_profile.profile_avg}</td>
                        </tr>
                    `);
                    //check cac trang thai cua de nghi xoa, duyet, theo doi
                    if (res.employee_delete_request) {
                        li_delete_request.find('input').prop('checked', true);
                    } else {
                        li_delete_request.find('input').prop('checked', false);
                    }
                    if (res.employee.status_employee == 1) {
                        // li_status_employee.find('input').prop('checked', true);
                        $('#radio_approved').prop('checked', true);
                        $('#radio_un_approved').prop('checked', false);
                    } else {
                        $('#radio_un_approved').prop('checked', true);
                        $('#radio_approved').prop('checked', false);
                    }
                    if (res.staff_follow && res.staff_follow.status_follow == 1) {
                        // li_follow_employee.find('input').prop('checked', true);
                        $('#radio_follow').prop('checked', true);
                        $('#radio_un_follow').prop('checked', false);
                    } else {
                        $('#radio_follow').prop('checked', false);
                        $('#radio_un_follow').prop('checked', true);
                    }
                }
            })
        })
        //Chức năng gửi phản hồi
        $('.send_response').click(function() {
            let employee_id = $('#detailEmployee').attr('data-employee-id')
            if ($.trim($('#feedback').val()).length === 0) {
                $('.note_text_feedback').hide();
                $('.error_text_feedback').html(
                    '<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>'
                );
                $('.error_reg_mess_icon').css("color", "#ff0000");
                $('.error_border_feedback').css("cssText", "border: 1px solid #ff0000  !important;");
                event.preventDefault();
            }
            let response_content = $('#response_cv textarea').val();
            $.ajax({
                'type': 'get',
                'url': "{{ route('SendFeedbackEmployee') }}",
                'data': {
                    employee_id: employee_id,
                    feedback: response_content
                },
                'success': function(res) {
                    $('#response_cv').modal('hide')
                    swal({
                        title: res,
                        icon: "success",
                        button: "Đóng",
                    });
                }
            })
        });
        // Chức năng duyệt hồ sơ
        $("input[name='employee_status']").on('change', function() {
            // let checked = 0;
            let checked = $(this).val();
            let employee_id = $('#detailEmployee').attr('data-employee-id')
            // if($(this).is(":checked")){
            //     checked = 1;
            // }
            $.ajax({
                'type': 'get',
                'url': "{{ route('approved_employee') }}",
                'data': {
                    employee_id: employee_id,
                    status_employee: checked
                },
                'success': function(res) {
                    if (res.status == 0) {
                        // $('.ul_action .li_status_employee input').prop('checked', false);
                        $('#radio_approved').prop('checked', false);
                        $('#radio_un_approved').prop('checked', true);
                        $('table.table_info .duyet').html(
                            `<span class="text-danger">Chưa duyệt <i class="fas fa-times-circle"></i></span>`
                        );
                    } else {
                        // $('.ul_action .li_status_employee input').prop('checked', true);
                        $('#radio_approved').prop('checked', true);
                        $('#radio_un_approved').prop('checked', false);
                        $('table.table_info .duyet').html(
                            `<span class="text-success">Đã duyệt <i class="fas fa-check-circle"></i></span>`
                        );
                        $('.table_info .td_profile').html(res.profile);
                        $('.table_coin .table_coin_profile_cv').html(res.profile_cv);
                    }
                    swal({
                        title: res.mess,
                        icon: "success",
                        button: "Đóng",
                    });
                }
            })
        })

        // Chức năng theo dõi
        $("input[name='follow_status']").on('change', function() {
            // let checked = 0;
            let checked = $(this).val();
            let employee_id = $('#detailEmployee').attr('data-employee-id')
            // if($(this).is(":checked")){
            //     checked = 1;
            // }
            $.ajax({
                'type': 'get',
                'url': "{{ route('follow_employee') }}",
                'data': {
                    employee_id: employee_id,
                    follow_status: checked
                },
                'success': function(res) {
                    if (res.follow == 0) {
                        // $('.ul_action .li_follow_employee input').prop('checked', false);
                        $('#radio_follow').prop('checked', false);
                        $('#radio_un_follow').prop('checked', true);
                    } else {
                        // $('.ul_action .li_follow_employee input').prop('checked', true);
                        $('#radio_follow').prop('checked', true);
                        $('#radio_un_follow').prop('checked', false);
                    }
                    swal({
                        title: res.mess,
                        icon: "success",
                        button: "Đóng",
                    });
                }
            })
        })
        //Chức năng đánh giá hồ sơ và cho điểm
        $('input[name="coin_profile"]').on('keyup', function() {
            if ($(this).val() > 15 || $(this).val() < 0) {
                $('.error_coin').html(`<p>0 <= Điểm đánh giá <= 15</p>`)
            } else {
                $('.error_coin').html(``)
            }
        });
        $('.send_evaluate').on('click', function() {
            let coin = $('input[name="coin_profile"]').val();
            let content = $('textarea#content_evaluate').val();
            let employee_id = $('#detailEmployee').attr('data-employee-id');
            if ((content.trim()).length == 0) {
                alert('Bạn chưa nhận xét gì cả.');
            }
            if ((coin.trim()).length == 0) {
                alert('Bạn chưa cho điểm.');
            }
            if (coin <= 15 && coin >= 0 && (content.trim()).length != 0 && (coin.trim()).length != 0) {
                $.ajax({
                    'type': 'get',
                    'url': '{{ route("evaluate_employee") }}',
                    'data': {
                        employee_id: employee_id,
                        coin: coin,
                        content: content
                    },
                    'success': function(res) {
                        swal({
                            title: res.mess,
                            icon: "success",
                            button: "Đóng",
                        });
                        $('input[name="coin_profile"]').val("");
                        $('textarea#content_evaluate').val("");
                        $('.detailEmployee .td_profile').html(`${res.profile}`)
                        $('.detailEmployee .td_profile_staff').html(`${coin}`)
                        $('#evaluate').modal('hide');
                        $(`.td_${employee_id}`).parent().find('.custom_table_td_profile').html(
                            `${res.profile}%`);
                    }
                })
            }
        })
        //danh gia lai diem ho so
        $('.calculator_profile').on('click', function() {
            let coin_info = $('.table_coin .table_coin_profile_info').text();
            let coin_cv = $('.table_coin .table_coin_profile_cv').text();
            console.log(coin_info);
            $('#calculator_profile input#profile_info').val(coin_info);
            $('#calculator_profile input#profile_cv').val(coin_cv);
        })
        $('.send_caculator_profile').on('click', function() {
            let profile_info = document.getElementById('profile_info');
            let profile_cv = document.getElementById('profile_cv');
            let employee_id = $('#detailEmployee').attr('data-employee-id')

            if (checkRange(profile_cv, 0, 40) && checkRange(profile_info, 0, 20)) {
                if (profile_info.value == '' && profile_cv.value == '') {
                    alert('Chưa có sự thay đổi nào cả.')
                } else {
                    $.ajax({
                        'type': 'get',
                        'url': '{{ route("caculator_profile") }}',
                        'data': {
                            employee_id: employee_id,
                            profile_info: profile_info.value,
                            profile_cv: profile_cv.value
                        },
                        'success': function(res) {
                            $('.table_coin_profile_info').html(res.profile_info);
                            $('.table_coin_profile_cv').html(res.profile_cv);
                            $('.td_profile').html(res.profile);
                            $('#calculator_profile').modal('hide')
                            swal({
                                title: res.mess,
                                icon: "success",
                                button: "Đóng",
                            });
                            $(`.td_${employee_id}`).parent().find('.custom_table_td_profile')
                                .html(`${res.profile}%`);
                        }
                    })
                }
            }
        })
        // Chức năng tải lại CV
        $('.reload_cv').on('click', function() {
            $(document).ajaxStart(function() {
                $('.loading_cv').css('display', 'block');
            });
            let employee_id = $('#detailEmployee').attr('data-employee-id')
            $.ajax({
                'type': 'get',
                'url': "{{ route('staff_reload_cv') }}",
                'data': {
                    employee_id: employee_id
                },
                'beforeSend': function() {
                    $('#detailEmployee .col_pdf .show_cv').html('');
                    $('.loading_cv').css('display', 'block');
                },
                'success': function(res) {
                    if (res.link_cv) {
                        let col_pdf = $('#detailEmployee .col_pdf');
                        let iframe = document.createElement('iframe');
                        iframe.id = 'iframe_cv_employee';
                        iframe.src =
                            `https://docs.google.com/viewer?url=${res.link_cv}&embedded=true`;
                        iframe.loading = 'lazy';
                        iframe.style = 'width:100%;height:97vh;position:absolute;top:0';
                        iframe.frameborder = '0';
                        col_pdf.find('.show_cv').append(iframe);
                    } else {
                        col_pdf.find('.show_cv').append('<h3>Ứng viên không có CV</h3>');
                    }
                }
            })
        })
    })
</script>