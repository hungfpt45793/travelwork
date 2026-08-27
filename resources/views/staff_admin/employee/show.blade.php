<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Chi tiết ứng viên' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        {{--<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
        </div>--}}
        <div class="col-xl-12 col-lg-12 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 " style="height: auto">
                <div class="container-fluid">
                    <div class="row detailEmployee">
                        <div class="col-xs-12 col-md-12 col-lg-8">

                            <h3 class="">CV của bạn</h3>
                        <?php
                        $check_show_employee = 1;
                        //xem co upload cv khong
                        $check_show_cv = \App\Entity\Employee_upload_cv::check_employee_cv_status($employee->employee_id);
                        $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
//                        echo 1;die;
                        ?>
                        {{--có upload cv--}}
                            @if(!empty($check_show_cv))
                        {{--@if(!empty($check_show_cv))--}}
                            <?php
                            $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
                            $link_cv_upload = asset($link_cv_upload);
                            ?>
                           <iframe class="iframe_cv_employee"src="{{ $link_cv_upload }}#view=fitH" style="width: 100%; height: 90vh; " type="application/pdf">
                                        </iframe>
                                {{--@include('site.employee_site.partials.preview_employee', ['link_cv' => $link_cv_upload])--}}
                            @else

                                <div id="appendToThis">
                                    @include('site.employee_site.partials.item_cv_template_employee', ['employee' =>$employee ,'check_show_employee'=>$check_show_employee])
                                    {{--@include('site.employee_site.partials.preview_employee', ['link_cv' => route('employer_exportpdf_cv_user_id',['user_id'=> $employee->user_id]) ])--}}
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-4 pl-0" style="overflow: scroll;height: 97vh">
                            <table class="table table-bordered table_info mb-0">
                                <tbody>
                                    <tr>
                                        <td>Họ và tên</td>
                                        <td colspan="2">{{$employee->employee_name}} - {{$employee->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td colspan="2">
                                            @if ($employee->status_email_account == 0)
                                            <span class="text-danger">{{$employee->email}}<i
                                                    class="fas fa-times-circle"></i></span>
                                            @else
                                            <span class="text-success">{{$employee->email}}<i
                                                    class="fas fa-check-circle"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái</td>
                                        <td class="duyet">
                                            @if ($employee->status_employee == 1)
                                            <span class="text-success">Đã duyệt <i
                                                    class="fas fa-check-circle"></i></span>
                                            @else
                                            <span class="text-danger">Chưa duyệt <i
                                                    class="fas fa-times-circle"></i></span>
                                            @endif
                                        </td>
                                        <td class="display_disable_profile">
                                            @if ($employee->show_hidden_profile == 0)
                                            <span class="text-success">Hiện H/S <i
                                                    class="fas fa-check-circle"></i></span>
                                            @else
                                            <span class="text-danger">Ẩn H/S <i class="fas fa-times-circle"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TT công việc</td>
                                        <td colspan="2">
                                            @if ($employee->status == 0)
                                            <span class="text-danger">Chưa đi làm <i
                                                    class="fas fa-times-circle"></i></span>
                                            @else
                                            <span class="text-success">Đã đi làm <i
                                                    class="fas fa-check-circle"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mức lương</td>
                                        <td colspan="2">{{$employee->salary}}</td>
                                    </tr>
                                    <tr>
                                        <td>Điểm hồ sơ</td>
                                        <td colspan="2" class="td_profile">{{$employee->profile}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                                $date=date_create($employee->created_at);
                                                echo date_format($date,"d/m/Y");
                                            ?>
                                        </td>
                                        <td colspan="2">
                                            <?php
                                                $date=date_create($employee->updated_at);
                                                echo date_format($date,"d/m/Y");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-toggle="tooltip" title="Vị trí công việc ứng viên cần tìm"
                                            data-original-title="Vị trí công việc ứng viên cần tìm" colspan="3">
                                            {{$employee->careers}}</td>
                                    </tr>
                                    <tr>
                                        <td data-toggle="tooltip" title="Khu vực ứng viên mong muốn tìm việc"
                                            data-original-title="Khu vực ứng viên mong muốn tìm việc" colspan="3">
                                            {{$employee->areas}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table_coin">
                                <tbody>
                                    @if($employee_profile)
                                    <tr>
                                        <td data-toggle="tooltip" title="Thông tin cơ bản của ứng viên"
                                            data-original-title="Thông tin cơ bản của ứng viên">
                                            <b style="font-size:0.7rem">Điểm HS</b>
                                        </td>
                                        <td data-toggle="tooltip" title="Thông tin trên CV của ứng viên"
                                            data-original-title="Thông tin trên CV của ứng viên">
                                            <b style="font-size:0.7rem">Điểm CV</b>
                                        </td>
                                        <td data-toggle="tooltip" title="Sàn kế toán đánh giá chất lượng hồ sơ"
                                            data-original-title="Sàn kế toán đánh giá chất lượng hồ sơ">
                                            <b style="font-size:0.7rem">Điểm SKT</b>
                                        </td>
                                        <td data-toggle="tooltip"
                                            title="Điểm ứng viên đã tham gia khóa học của sàn kế toán"
                                            data-original-title="Điểm ứng viên đã tham gia khóa học của sàn kế toán">
                                            <b style="font-size:0.7rem">Điểm K/HỌC</b>
                                        </td>
                                        <td data-toggle="tooltip"
                                            title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên"
                                            data-original-title="Điểm trung bình các nhà tuyển dụng đánh giá ứng viên">
                                            <b style="font-size:0.7rem">Điểm NTD</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_coin_profile_info">{{$employee_profile->profile_info}}</td>
                                        <td class="table_coin_profile_cv">{{$employee_profile->profile_cv}}</td>
                                        <td class="td_profile_staff">{{$employee_profile->profile_staff}}</td>
                                        <td>{{$employee_profile->profile_course}}</td>
                                        <td>{{$employee_profile->profile_avg}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <ul class="list-group ul_action">
                                <li class="list-group-item cus-list-group-item">
                                    <i class="fas fa-reply"></i>
                                    <span type="button" class="response" data-toggle="modal" data-target="#response_cv">
                                        Gửi email ứng viên
                                    </span>
                                </li>
                                <li
                                    class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="employee_status"
                                            id="radio_approved" value="1" {{ ($employee->status_employee == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radio_approved">
                                            Duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="employee_status"
                                            id="radio_un_approved" value="0" {{ ($employee->status_employee == 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radio_un_approved">
                                            Không duyệt
                                        </label>
                                    </div>
                                </li>
                                <li
                                    class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="follow_status"
                                            id="radio_follow" value="1"
                                        {{ (!empty($staff_follow) && $staff_follow->status_follow == 1) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="radio_follow">
                                            Theo dõi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="follow_status"
                                            id="radio_un_follow" value="0"
                                            {{ (!empty($staff_follow) && $staff_follow->status_follow != 1) ? 'checked' : '' }}    
                                        >
                                        <label class="form-check-label" for="radio_un_follow">
                                            Không theo dõi
                                        </label>
                                    </div>
                                </li>
                                <li class="list-group-item cus-list-group-item">
                                    <i class="fas fa-reply"></i>
                                    <span type="button" class="evaluate" data-toggle="modal" data-target="#evaluate">
                                        Đánh giá
                                    </span>
                                </li>
                                <li class="list-group-item cus-list-group-item">
                                    <a target="_blank" href="{{ route('staff_employee_edit_form', $employee->employee_id) }}" class="text-dark link_edit_form">
                                        <i class="fas fa-pen"></i>
                                        <span>
                                            Chỉnh sửa thông tin
                                        </span>
                                    </a>
                                </li>
                                <li class="list-group-item cus-list-group-item">
                                    <a target="_blank" href="{{ route('detail_employee', $employee->employee_id) }}" class="text-dark link_interactive">
                                        <i class="fas fa-sync"></i>
                                        <span>
                                            Tương tác
                                        </span>
                                    </a>
                                </li>
                                <li class="list-group-item cus-list-group-item">
                                    <i class="fas fa-calculator"></i>
                                    <span type="button" class="calculator_profile" data-toggle="modal"
                                        data-target="#calculator_profile">
                                        Chỉnh sửa điểm hồ sơ
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- modal phan hoi uwng vien -->
<div id="response_cv" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phản hồi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <textarea class="form-control error_border_feedback" name="feedback" id="feedback" rows="6" cols="80"
                    required placeholder="Nhập phản hồi" /></textarea>
                <div class="mess_notice_feedback clearfix note_text_feedback"></div>
                <div class="error_reg_mess clearfix error_text_feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_response">Gửi</button>
            </div>
        </div>
    </div>
</div>
<!-- modal danh gia ung vien -->
<div id="evaluate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đánh giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm đánh giá hồ sơ</label>
                    <input type="number" name="coin_profile" min="0" max="15" placeholder="Điểm đánh giá hồ sơ"
                        class="form-control">
                    <div class="error_coin text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="">Nhận xét</label>
                    <textarea class="form-control" name="content" id="content_evaluate" rows="6" cols="80" required
                        placeholder="Nhập đánh giá" />
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>
            </div>
        </div>
    </div>
</div>
<!-- modal tinh lai diem ho so ung vien -->
<div id="calculator_profile" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa điểm hồ sơ ứng viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm hồ sơ cơ bản</label>
                    <input type="number" name="profile_info" id="profile_info" data-name="Điểm hồ sơ cơ bản" min="0"
                        max="20" class="form-control">
                    <small>Error message</small>
                </div>
                <div class="form-group">
                    <label for="">Điểm CV</label>
                    <input type="number" name="profile_cv" id="profile_cv" data-name="Điểm CV" min="0" max="40"
                        class="form-control">
                    <small>Error message</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_caculator_profile">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/valina_validate.js') }}"></script>
<script>
$(document).ready(function() {
    //Chức năng gửi phản hồi
    $('.send_response').click(function() {
        let employee_id = <?php echo $employee->employee_id; ?>;
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
        let checked = $(this).val();
        let employee_id = <?php echo $employee->employee_id; ?>;
        $.ajax({
            'type': 'get',
            'url': "{{ route('approved_employee') }}",
            'data': {
                employee_id: employee_id,
                status_employee: checked
            },
            'success': function(res) {
                if (res.status == 0) {
                    $('#radio_approved').prop('checked', false);
                    $('#radio_un_approved').prop('checked', true);
                    $('table.table_info .duyet').html(
                        `<span class="text-danger">Chưa duyệt <i class="fas fa-times-circle"></i></span>`
                    );
                } else {
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
        let employee_id = <?php echo $employee->employee_id; ?>;
        $.ajax({
            'type': 'get',
            'url': "{{ route('follow_employee') }}",
            'data': {
                employee_id: employee_id,
                follow_status: checked
            },
            'success': function(res) {
                if (res.follow == 0) {
                    $('#radio_follow').prop('checked', false);
                    $('#radio_un_follow').prop('checked', true);
                } else {
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
        let employee_id = <?php echo $employee->employee_id; ?>;
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
        let employee_id = <?php echo $employee->employee_id; ?>;

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

})
</script>
<script type="text/javascript" src="/assets/js/sweetalert.min.js"></script>
<script>
    $('#list_job_app').change(function () {
        var show_category_id = $(this).val();
        $('.js_hidden_job_app').hide();
        $('#' + show_category_id).show();
    });
    $('#is_click_appen').click(function () {
        $('#show_hidden').hide();
    });


    $('.js_btn_loading').click(function () {
        $(this).html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang ứng tuyển ...');
        $btn.attr('disabled', false);
    });
</script>
<script src="/assets/js/ajax_redmore_jquery.min.js"></script>
<script src="/assets/js/readmore.js"></script>
<script>
    $('article').readmore({
        speed: 1000,
        collapsedHeight: 400,
        moreLink: '<a title="Xem thêm" class="redmore" href="#"> <span> Xem thêm <i class="fas fa-angle-double-down"></i> </span></a>',
        lessLink: '<a title="Thu gọn" class="redmore" href="#">   <span> Thu gọn <i class="fas fa-angle-double-up"></i> </span> </a>',
    });
</script>
<script src="/assets/ckeditor_easy/ckeditor.js"></script>
<script>

    $('.editor_basic').each(function (e) {
        CKEDITOR.replace(this.id);
    });
    $('.select2').select2({
        width: '100%',
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

@endsection