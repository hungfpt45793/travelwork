<div class="col-md-12 bgrWhite show_info_employee">
    @if(session('suscess'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
             style="margin-top: 15px;width: 100%">
            <strong>{{ session('suscess') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('erorr'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert"
             style="margin-top: 15px;width: 100%">
            <strong>{{ session('erorr') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

        @include('site.sidebar.item_coin_employer',['employer' => $employer])


</div>
<div class="bgrWhite pd20">
    <form action="{{ route('invitation_job_apply_detail_employee') }}" method="post"
          id="invitation_job_apply_detail_employee">
        <div class="row">
            <div class="col-md-6"><h3 class="f20 fw6 clgreen">Mời ứng viên ứng tuyển</h3>
                <p>Vui lòng tích vào ô <input type="checkbox"> để mới ứng viên ứng tuyển vào tin tuyển dụng ! </p></div>
            <div class="col-md-4">
                <p class="js_show_length_checkbox mgb0 clred"></p>
                <p class="js_total_coin mgb10 clgreen"></p>
                <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btnGreen pd5-10 js_submit_disabled">Mời ứng tuyển</button>
                <span class="js_noti_employer_coin clred f10"></span></div>
        </div>


        {!! csrf_field() !!}
        {{ method_field('POST') }}
        <table id="jobfb" class="table table-hover table-bordered">
            <thead>
            <tr>
                <td>
                    <label> <input type="checkbox" id="checkAll" class="mgr5 checkbox">Chọn hết</label>
                </td>
                <th>Mã tin</th>
                <th>Ngày đăng - Hạn nộp</th>
                <th>Tiêu đề</th>
                <th>Lượt xem</th>
                <th>Link tuyển dụng</th>


            </tr>
            </thead>
            <tbody>
            @foreach($list_jobs as $job)
                <tr>
                    <td style="width: 10%">
                        <?php
                        $check_inviton_aplly = \App\Entity\Coin_apply_employee::check_employer_contact_job_employee($employer->employer_id, $employee->employee_id, $job->job_id)
                        ?>
                        <input type="checkbox" name="job_ids[]" value="{{ $job['job_id'] }}"
                               class="checkbox js_checkbox_checked">


                        @if(!empty($check_inviton_aplly))
                            <span class="clgreen">đã mời</span>
                            </br>
                            <?php
                            $date_facebook = \App\Ultility\Ultility::getdateFacebook($check_inviton_aplly['created_at']);
                            ?>
                            <span class="clred">({{ $date_facebook }})</span>

                        @endif
                    </td>
                    <td>{{ $job['job_code'] }}
                        </br>
                        @if($job['active_job'] == 1)
                            <p class="mg0  clgreen"><i class="fas fa-check"></i> Đã đăng tin </p>
                        @else
                            <p class="mg0 red "><i class="fas fa-exclamation mgr5"></i>Chưa đăng tin </p>
                        @endif
                    </td>
                    <td>
                        <?php
                        $date_create = date_create($job['date_submit']);
                        echo date_format($date_create, "d/m/Y");
                        ?> -
                        <?php
                        $date_submit = date_create($job['deadline_submit_profile']);
                        echo date_format($date_submit, "d/m/Y");
                        ?>

                    </td>

                    <td>{{ $job['title'] }}</td>

                    <td>{{ $job['views'] }} <i class="fas fa-eye"></i></td>
                    <td>
                        <a target="_blank" href="{{ route('job_detail',['slug'=>$job['slug']]) }}">Link</a>


                    </td>


                </tr>
            </tbody>
            @endforeach
        </table>
        <p class="js_show_length_checkbox mgb0 clred"></p>
        <p class="js_total_coin mgb10 clgreen"></p>

        <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
        <button type="button" class="btnGreen pd5-10 js_submit_disabled">Mời ứng tuyển</button>
        <span class="js_noti_employer_coin clred f10"></span>

    </form>
    <div style="border: 1px solid #ccc;
    padding: 10px 15px;
    margin-top: 20px;">
        <?php
        $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
        ?>
        <h3 class="fw6 f16 clgreen">Mô tả quá trình mời ứng tuyển</h3>
            {!! isset($coin_infomation['mo-ta-qua-trinh-moi-ung-vien-ung-tuyen']) ? $coin_infomation['mo-ta-qua-trinh-moi-ung-vien-ung-tuyen'] : '' !!}

    </div>


    <style>
        .checkbox, #checkAll {
            width: 20px;
            height: 20px;
        }

    </style>
    <script>
        $("#checkAll").click(function () {
            $('.checkbox').not(this).prop('checked', this.checked);
        });
        <?php
        $coint_career = \App\Entity\Career::getIdCareer($employee->career_category_id);
        ?>
        $('.js_submit_disabled').click(function () {
            var checked = $('.js_checkbox_checked:checked').length;
            if (checked > 0) {
                $('.js_submit_disabled').html('<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang mời ứng tuyển...');
                $('#invitation_job_apply_detail_employee').submit();
            } else {
                alert('Vui lòng chọn tin tuyển dụng để mời ứng viên');
            }
        });
        $('.checkbox').change(function () {
            var coin_career = '{{ !empty($coint_career->view_apply) ? $coint_career->view_apply : 1 }}';
            var numberOfChecked = $('.js_checkbox_checked:checked').length;
            var total_coin = numberOfChecked * coin_career;
            var coin_free = '{{ !empty($coin_free) ?$coin_free  : 0 }}';
            var total_employer_coin = '{{ !empty($employer->total_employer_coin) ?$employer->total_employer_coin  : 0 }}';
            var employer_coin = '{{ !empty($employer->employer_coin) ?$employer->employer_coin  : 0 }}';
            // var employer_coin = '4';

            $('.js_show_length_checkbox').html('Đã chọn ' + numberOfChecked + ' tin tuyển dụng');
            $('.js_total_coin').html('Tổng điểm cần để mời ứng viên ứng tuyển là ' + total_coin + ' điểm');
            //nếu chưa chọn
            if (total_employer_coin > 0) {
                if (employer_coin < total_coin) {
                    $(".js_submit_disabled").attr("disabled", true);
                    $(".js_submit_disabled").css("background", '#326d32');
                    $('.js_noti_employer_coin').html('(<i>' + 'Số điểm của bạn không đủ để mời ứng viên' + '</i>)');
                    console.log('số điểm không đủ để đổi');
                } else {
                    $(".js_submit_disabled").attr("disabled", false);
                    $(".js_submit_disabled").css("background", 'green');
                    $('.js_noti_employer_coin').html('');
                }
            } else {
                if (coin_free < total_coin) {
                    $(".js_submit_disabled").attr("disabled", true);
                    $(".js_submit_disabled").css("background", '#326d32');
                    $('.js_noti_employer_coin').html('(<i>' + 'Số điểm miễn phí của bạn không đủ để mời ứng viên' + '</i>)');
                    console.log('số điểm không đủ để đổi');
                } else {
                    $(".js_submit_disabled").attr("disabled", false);
                    $(".js_submit_disabled").css("background", 'green');
                    $('.js_noti_employer_coin').html('');
                }
            }

            // alert(numberOfChecked);


        });
    </script>


</div>




<?php
$user_id = \Illuminate\Support\Facades\Auth::user()->id;
$employer = \App\Entity\Employer::getIdUser($user_id);
$check_contact_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
?>
@if(!empty($check_contact_employee))
    <div class="link bgrWhite md-mgt20 mgb10">
        <div class="content_contact pd20">
            <h3 class="f20 fw6 clgreen">Thông tin liên hệ</h3>
            <p class="mgb0"><span>Email : <strong>{{ isset($employee->email) ? $employee->email : '' }}</strong></span>
            </p>
            <p class="mgb0"><span>Số điện thoại : <strong>{{ isset($employee->phone) ? $employee->phone : '' }}</strong></span>
            </p>
            <p class="mgb0">
                <span>Link facebook : <strong>{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}</strong></span>
            </p>
        </div>
    </div>
@endif

<div class="CV bgrWhite radius5 mgt5 mgb20 pdb5 " style="border: 1px solid #ccc;">
    <div class="content">
        <div class="col-md-12  mgt15">
            <div class="row">
                <div class="col-lg-12 col-md-12 pdl15 pdRight15">
                    <div class="row">

                        <div class="col-md-6">
                            <p class="mgb10 mgl15"><span class="fw6"> Ngày cập nhật hồ sơ :</span>
                                <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                        echo $date_facebook;
                                        ?>
                                    @else
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                        echo $date_facebook;
                                        ?>
                                    @endif
                                                </span>
                            </p>
                            <p class="mgl15">
                                <span class="fw6"> Trình độ :</span>
                                <span class="green" style="color: green">
                                                        @if(!empty($employee->employee_level_id))
                                        <?php
                                        $literacy_employee = App\Entity\Literacy::getIdLi($employee->employee_level_id);
                                        echo $literacy_employee->literacy_name;
                                        ?>
                                    @endif

                                                </span>

                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mgb10 mgl15"><span class="fw6"> Ngày duyệt hồ sơ :</span>
                                <span class="green" style="color: green">
                                                     @if(!empty($employee->updated_at))
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                                        echo $date_facebook;
                                        ?>
                                    @else
                                        <?php
                                        $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                                        echo $date_facebook;
                                        ?>
                                    @endif
                                                </span>
                            </p>
                            <p class="mgl15"><span class="fw6"> Kinh nghiệm :</span>
                                <span class="red">

                                                    @if(!empty($employee->time_to_work))
                                        <?php
                                        $date_home = date_create();
                                        $date_ex = date_format($date_home, "Y") - $employee->time_to_work;
                                        ?>
                                        @if($date_ex == 0)
                                            dưới 1 năm kinh nghiệm
                                        @else
                                            {{ $date_ex }} năm kinh nghiệm
                                        @endif
                                    @else
                                        Đang cập nhật
                                    @endif

                                                </span></p>
                        </div>
                    </div>

                </div>
           


            </div>
            <div class="row">
                <div class="col-md-5 ">
                    <label for="inputAddress2" class="fw6 mgl15" style="display: block;">Trạng thái
                        : @if($employee->status == 0) Đang tìm việc @else Đã đi làm @endif </label>
                </div>
                <div class="col-md-7 ">
                    <div class="row">
                        <div class="col-md-3 pd0">
                            <label for="inputAddress2" class="fw6 mgl15" style="display: block;">%
                                hồ sơ : </label>
                        </div>
                        <div class="col-md-9">
                            <div class="progress mgr15">
                                <div class="progress-bar progress-bar-striped bg-success"
                                     role="progressbar"
                                     style="width: {{ round($employee->profile) }}%;"
                                     aria-valuenow="{{ round($employee->profile) }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">{{ round($employee->profile) }}%
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>

            <div class="title mgt20">
                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
                <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">
                    Thông
                    tin ứng viên
                </div>
                <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
            </div>

            <div class="col-xl-12 col-lg-12 left">

                <div class="form-group mgb0">
                    <div class="" style="margin: 10px 0">
                        <label for="inputAddress2" class="fw6" style="display: inline-block;">Avatar:
                            <span
                                    class="clhome">

                                                </span></label>
                        <img src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}"
                             class="thumbnail" style="width: 100px;display: inline-block">

                        <span class="fw6 mgl15 dsInline">Lượt xem : </span>
                        <span class="green">{{ !empty($employee['views']) ? $employee['views'] : '0' }} <i
                                    class="far fa-eye"></i></span>
                    </div>
                </div>
                <div class="form-group mgb0">
                    <label for="inputAddress2" class="fw6">Tên ứng viên : <span
                                class="clhome">{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</span></label>
                </div>
                <div class="form-row  gruopRadio">
                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Giới tính:
                            <span
                                    class="clhome">@if($employee->gender == 0)
                                    Không xác định
                                @endif
                                @if($employee->gender == 1)
                                    Nữ
                                @endif
                                @if($employee->gender == 2)
                                    Nam
                                @endif
                                                </span></label>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Tình trạng
                            hôn
                            nhân:
                            <span class="clhome">
                                                    @if($employee->marry == 0) Độc thân @endif
                                @if($employee->marry == 1) Đã kết hôn @endif
                                                </span>
                        </label>
                    </div>

                </div>
                {{--<div class="form-row  gruopRadio">--}}
                {{--<div class="col-md-6">--}}
                {{--<label for="inputAddress2" class="fw6" style="display: block;">Số điện thoại:--}}
                {{--<span--}}
                {{--class="clhome">--}}
                {{--*******--}}
                {{--</span></label>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                {{--<label for="inputAddress2" class="fw6" style="display: block;">Email liên hệ:--}}
                {{--<span--}}
                {{--class="clhome">--}}
                {{--******--}}
                {{--</span></label>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-row  gruopRadio">
                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Ngày sinh:
                            <span
                                    class="clhome">
                                                @if(!empty($employee->birthday))
                                    <?php
                                    $date_birthday = date_create($employee->birthday);
                                    echo date_format($date_birthday, "d/m/Y");
                                    ?>
                                @endif
                                                </span></label>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Tuổi: <span
                                    class="clhome">
                                                 @if(!empty($employee->birthday))
                                    <?php
                                    $date_year = getdate();
                                    $age = $date_year['year'] - date_format($date_birthday, "Y");
                                    ?>
                                    {{ !empty($age) ? $age : '' }}
                                @endif
                                                </span></label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="fw6">Khu vực cần tìm việc

                        </label>
                    </div>
                </div>
                <div class="form-row">

                    <div class="col-md-6">
                        <div class="">
                            <label for="exampleInputEmail1" class="fw6">Tỉnh/Thành phố :
                                <span class="clhome">
                                                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                        @if($employee->province == $province->province_id) {{$province->province_name}} @endif
                                    @endforeach
                                                    </span>
                            </label>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label for="exampleInputEmail1" class="fw6">Quận/Huyện :
                                <span class="clhome">
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                        @if($employee->district == $district->district_id) {{$district->district_name}} @endif
                                    @endforeach
                                                    </span>
                            </label>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="">
                            <label for="exampleInputEmail1" class="fw6">Địa chỉ cụ thể :
                                <span class="clhome">{{ isset($employee->address) ? $employee->address : '' }}</span>
                            </label>

                        </div>
                    </div>


                </div>

                <div class="form-row  gruopRadio">

                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Công việc cần
                            tìm: <span
                                    class="clhome">
                                               <?php $careers = \App\Entity\Career::getAllCareer(); ?>
                                @foreach($careers as $career)
                                    @if($employee->career_category_id == $career->career_category_id) {{$career->career_category_name}} @endif
                                @endforeach
                                                </span></label>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress2" class="fw6" style="display: block;">Mức lương
                            mong
                            muốn: <span
                                    class="clhome">

                                                <?php
                                $salary = \App\Entity\Salary::getIdSalary($employee['salary_id'])
                                ?>
                                {{ isset($salary['description']) ? $salary['description'] : ''  }}
                                                </span></label>
                    </div>

                </div>


            </div>
        </div>

        <div class="title mgt20">
            <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
            <div class="inBlock fw7 f18 w17 xl-w19 lt-w26 lg-w35 sm-w100 textCenter clred ">Hồ sơ
                ứng viên
            </div>
            <div class="underline bgrBlueN h1x w41 xl-w40 lt-w36 lg-w31 disOnMobile inBlock"></div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="slideNews submit_job_slide">
                    <div class="text-center">
                        <label class="clgreen f16 fw6"> CV ứng viên</label>
                        <div class="submit_job_img">
                            <img class="js_max_height_img mg_0_auto"
                                 src="{{ asset('assets/image/item_cv.jpg') }}">
                            <?php
                            $cv_employee = \App\Entity\Cv_employee::check_cv_employee($employee->employee_id)
                            ?>
                            @if(!empty($cv_employee))
                                <a target="_blank" href="{{ route('show_cv_detail_employee',['employee_id'=>$employee->employee_id]) }}">Xem
                                    CV</a>
                            @else
                                <a  href="#">Đang cập
                                    nhật</a>
                            @endif

                        </div>

                    </div>



                    <?php
                    //show_hidden_syll = 0 là hiên thị syll
                    $employee_show_syll = \App\Entity\Employee::get_syll_employee($employee->employee_id)
                    ?>
                    @if($employee_show_syll->show_hidden_syll == 0)
                        <div class="text-center">
                            {{--<label class="clgreen f16 fw6"><input type="checkbox" class="form-check-input" id="exampleCheck1" name="status_syll" checked value="1"> Sơ yếu lý lịch</label>--}}

                            <label class="clgreen f16 fw6">Sơ yếu lý lịch</label>
                            <div class="submit_job_img">
                                <img class="js_max_height_img mg_0_auto"
                                     src="{{ asset('assets/image/item_syll.jpg') }}">
                                <?php
                                $check_syll = '';
                                $check_syll = \App\Entity\Employee_curriculum::check_syll_employee($employee->employee_id)
                                ?>
                                @if(!empty($check_syll))
                                    <a target="_blank" href="{{ route('show_syll_detail_employee',['employee_id'=>$employee->employee_id]) }}">Xem
                                        sơ yếu lý lịch</a>
                                @else
                                    <a  href="#">Đang cập
                                        nhật</a>
                                @endif

                            </div>


                        </div>
                    @endif
                </div>
                <script type="text/javascript">
                    $('.slideNews').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        responsive: [
                            {
                                breakpoint: 1500,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 1100,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 800,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 501,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            },
                        ]
                    });

                    // $('#show_notification').modal('show');
                    // Nếu trình duyệt không hỗ trợ thông báo
                    $(document).ready(function () {

                    });
                </script>
            </div>
        </div>


    </div>
</div>







