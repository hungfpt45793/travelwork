@extends('staff_admin.layouts.master')

@section('title', 'Tương tác giáo viên' )

@section('content')
    <div id="tbody"></div>
    <div class="container-fluid">
        <div class="row row-content">
            {{-- sitebar --}}
            <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
                @include('staff_admin.sidebars.teacher')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <div class="log_error">
                    @if (session('error'))
                        <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                            <div class="alert alert-danger mg-b-0 " role="alert">
                                {{ session('error') }}
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">
                                    x
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                            <div class="alert alert-success mg-b-0 ">
                                {{session('success')}}
                                <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">
                                    x
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting pd15 col-f14 ">
                        <h5 class="text-info" style="display: inline-block">Danh sách lịch sử tương tác giáo viên &nbsp;
                        </h5>
                        <h5 style="display: inline-block" class="text-success"> {{ $teacher->teacher_name }}</h5>
                        {{-- <div class="row"> --}}
                        <form action="{{ route('interactive_store', $teacher->teacher_id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Nội dung tương tác</label>
                                        <textarea name="content" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Ngày tương tác</label>
                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                               name="interactive_day">
                                    </div>
                                    <button type="submit" class="btn btn-success ">Lưu</button>

                                    @if ($teacher->status_accounting==0)
                                        <a target="_blank"
                                           href="https://ketoandichvu.com.vn/api/copy-tai-khoan-giao-vien/{{ $teacher->teacher_id }}"
                                           class="btn btn-primary coppy_account">Chuyển TK</a>&nbsp;
                                    @endif

                                    <a href="{{ route('staff_teacher.edit', $teacher->teacher_id) }}"
                                       class="btn btn-primary">
                                        Sửa
                                    </a>
                                    @if($check == 0)
                                        <a href="{{ route('staff_teacher_delete_request',  $teacher->teacher_id) }}"
                                           class="btn btn-danger delete_request">Đề nghị xóa</a>
                                    @else
                                        <a href="{{ route('staff_teacher_undelete_request',  $teacher->teacher_id) }}"
                                           class="btn btn-danger undelete_request">Bỏ loại</a>
                                    @endif
                                    {{--<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"--}}
                                    {{--href="{{ route('SendFeedbackTeacher',$teacher->teacher_id) }}" onclick="return submitDelete(this);">Phản hồi</button>--}}

                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Trạng thái tương tác </label>
                                        <?php
                                        $list_status = \App\Entity\Teacher_status::getALL();
                                        ?>
                                        <select class="select22" name="teacher_status_id">
                                            <option value="0" selected>Chọn trạng thái</option>
                                            @foreach($list_status as $status_t)
                                                <option value="{{ $status_t->teacher_status_id }}"
                                                        @if($teacher->teacher_status_id == $status_t->teacher_status_id ) selected @endif>{{ isset($status_t->teacher_status_name) ? $status_t->teacher_status_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <?php
                                        $check_move_employee_teacher = \App\Entity\Employee_move_teacher::check_teacher($teacher->teacher_id);
                                        $total_check_exit = \App\Entity\Employee_move_teacher::check_exit_teacher($teacher->teacher_id);
                                        ?>
                                        @if(!empty($total_check_exit))

                                            <p class="mgb0"> Tài khoản giáo viên này đươc chuyển khoản từ tài khoản ứng
                                                viên</p>
                                            <p class="mgb0"> User chuyển tài khoản : <span
                                                        class="clgreen fw6">{{ $check_move_employee_teacher->name }}</span>
                                            </p>
                                            <p class="mgb0"> Ngày chuyển tài khoản : <?php
                                                $date = date_create($check_move_employee_teacher->created_at);
                                                echo date_format($date, "d/m/Y");
                                                ?></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>


                        {{-- <div class="col-4" style="border-left:3px solid #009385">
                            <div class="form-group">
                                <label for="" >Thao tác</label>
                                <div class="form-control" style="border: none;padding:0">
                                @if ($teacher->status_accounting==0)
                                <button target="_blank" href="https://ketoandichvu.com.vn/api/copy-tai-khoan-giao-vien/{{ $teacher->teacher_id }}" class="btn btn-primary coppy_account" >Chuyển tài khoản</button>&nbsp;
                                @endif
                                <a href="{{ route('staff_teacher.edit', $teacher->teacher_id) }}" >
                                    <button class="btn btn-primary">Sửa tt giáo viên</button>
                                </a>
                                @if($check == 0)
                                    <a href="{{ route('staff_teacher_delete_request',  $teacher->teacher_id) }}" class="btn btn-danger delete_request">Đề nghị xóa</a>
                                @else
                                    <a href="{{ route('staff_teacher_undelete_request',  $teacher->teacher_id) }}" class="btn btn-danger undelete_request">Bỏ đề nghị xóa</a>
                                @endif
                            </div>
                            </div>
                        </div> --}}
                        {{-- </div> --}}

                        @foreach ($interactives as $interactive)
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <form role="form" action="{{ route('interactive_update') }}" method="POST"
                                          id="send_feedback_teacher">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="id" value="{{ $interactive->id }}">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Sửa trạng thái </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea class="form-control error_border_feedback" id="feedback"
                                                          name="content" id="feedback" rows="6" cols="80" required
                                                          placeholder="Nhập phản hồi"/>{{ $interactive->content }}</textarea>
                                                <div class="mess_notice_feedback clearfix note_text_feedback"></div>
                                                <div class="error_reg_mess clearfix error_text_feedback"></div>


                                                <div class="form-group">
                                                    <label for="">Trạng thái tương tác</label>
                                                    <?php
                                                    $list_status = \App\Entity\Teacher_status::getALL();
                                                    ?>
                                                    <select class="select22" name="teacher_status_id">
                                                        <option value="0" selected>Chọn trạng thái</option>
                                                        @foreach($list_status as $status_t)
                                                            <option value="{{ $status_t->teacher_status_id }}"
                                                                    @if( $status_t->teacher_status_id == $interactive->teacher_status_id) selected @endif
                                                            >{{ isset($status_t->teacher_status_name) ? $status_t->teacher_status_name : '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Đóng
                                                </button>
                                                <button type="submit" class="btn btn-primary send">Gửi</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        @endforeach
                        <hr class="hr">
                        <div class="row">
                            <div class="col-12">
                            {{$interactives->links()}}
                                <div class="table-responsive" style="padding-bottom:100px;">
                                    <table class="table table-bordered table-hover ">
                                        <thead>
                                        <tr>
                                            <th scope="col ">id</th>
                                            <th scope="col ">Ngày tương tác</th>
                                            <th scope="col ">Người tt</th>
                                            <th scope="col ">Nội dung</th>
                                            <th scope="col ">Trạng thái tt</th>
                                            <th scope="col ">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($interactives as $interactive)
                                            <tr>
                                                <td>{{ $interactive->id }}</td>
                                                <td>
                                                    <?php
                                                    $date = date_create($interactive->interactive_day);
                                                    echo date_format($date, "d/m/Y");
                                                    ?>
                                                </td>
                                                <td>
                                                    {{$interactive->user_name}}
                                                </td>
                                                <td>{{ $interactive->content }}</td>
                                                <td>
                                                    <?php
                                                    $status_t = \App\Entity\Teacher_status::getId($interactive->teacher_status_id)
                                                    ?>
                                                    {{ isset($status_t->teacher_status_name) ? $status_t->teacher_status_name : 'Chưa chọn trạng thái' }}
                                                </td>
                                                <td>
                                                    @if (Auth::id() == $interactive->user_id)
                                                        <button type="button" class="btn btn-primary update_interactive"
                                                                href="{{route('staff_teacher_update_interactive',  $interactive->id)}}"
                                                                content="{{$interactive->content}}"
                                                                interactive_day="{{date('Y-m-d',strtotime($interactive->interactive_day))}}"
                                                                data-toggle="modal" data-target="#myModal"
                                                        >Sửa
                                                        </button>
                                                        <a href="{{ route('staff_teacher_delete_interactive',  $interactive->id) }}"
                                                           class="btn btn-danger btnDelete">Xóa</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{-- {{ $interactives->links() }} --}}
                                    <hr class="hr">
                                    <div class="info-teacher">
                                        <div class="bgrWhite radius10">
                                            <div class="row">
                                                <div class="col-lg-4 textCenter pdt20 pdb20">
                                                    <div class="img w300x h300x">
                                                        <?php
                                                        $teacher_images = \App\Entity\Teacher::getTeacher_image($teacher->teacher_id);
                                                        ?>

                                                        <img src="{{ !empty($teacher_images->teacher_images) ? 'https://sanketoan.vn'.$teacher_images->teacher_images : asset('assets/image/avatarteacher.png') }}"
                                                             alt="{{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}"
                                                             title="{{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}"
                                                             width="100px" class="radius50p mgb20">

                                                    </div>
                                                    <div class="Evaluate">

                                                        <p class="orange mgb0">Giáo viên
                                                            :
                                                            {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                                        </p>


                                                    </div>
                                                    <!-- col-lg-4 -->
                                                </div>
                                                <div class="col-lg-8 pdt20">
                                                    <div class="nameTeacher">
                                                        <h1 class="clhome fw6 f24">
                                                            {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                                        </h1>
                                                        <p class="mgb5"><i class="fas fa-phone-alt mgr5"></i> <span
                                                                    class="fw6">Số điện thoại : </span>
                                                            {{ isset($teacher->teacher_phone) ? $teacher->teacher_phone : '' }}
                                                        </p>
                                                        <p class="mgb5"><i class="fas fa-envelope mgr5"></i><span
                                                                    class="fw6">Email : </span>
                                                            {{ isset($teacher->teacher_email) ? $teacher->teacher_email : '' }}
                                                        </p>

                                                        <?php $business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($teacher->business_type_id);?>

                                                        <p class="mgb5"><i class="fas fa-certificate mgr5"></i>Lĩnh vực
                                                            :
                                                            {{ isset($business_type['type_of_business_name']) ? $business_type['type_of_business_name'] : 'Đang cập nhật' }}
                                                        </p>

                                                        <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span
                                                                    class="fw6">Địa chỉ : </span>
                                                            <?php $district = \App\Entity\District::getId($teacher->district); ?>
                                                            @if(!empty($district))
                                                                {{ $district->district_name . ' -' }}
                                                            @endif
                                                            <?php $province = \App\Entity\Province::getId($teacher->province);?>
                                                            @if(!empty($province))
                                                                {{ $province->province_name }}
                                                            @endif


                                                        </p>
                                                        <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span
                                                                    class="fw6">Địa chỉ cụ thể : </span>
                                                            {{ isset($teacher->address) ? $teacher->address : '' }}
                                                        </p>


                                                        <!-- info -->
                                                    </div>
                                                    <style>
                                                        .infomartion p {
                                                            margin-bottom: 5px;
                                                        }
                                                    </style>
                                                {{-- <div class="buttonRegisterNow mgt10">

                                                    <a id="regedit_course"
                                                        class="noDecoration white bgrBlueN dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite"
                                                        data-toggle="modal" data-target="#star_teacher">Đánh giá giáo
                                                        viên
                                                    </a>
                                                </div>

                                                @php
                                                $countTeacher = \App\Entity\TeacherStar::countTeacher($teacher->teacher_id);
                                                $starAll = \App\Entity\TeacherStar::checkStarTeacher($teacher->teacher_id);
                                                $countStar = \App\Entity\TeacherStar::countTeacher($teacher->teacher_id);

                                                $aumAll = 0;
                                                foreach ($starAll as $star) {
                                                    $aumAll += $star['qty_stars'];
                                                }
                                                if ($countStar > 0) {
                                                    $avgStar = $aumAll / $countStar;
                                                } else {
                                                    $avgStar = 0;
                                                }
                                                @endphp

                                                <div class="mgt10 mgb10"><span class=""
                                                        style="vertical-align: text-bottom;">Đánh giá :</span>
                                                    <span class="rate-product" style=""></span>
                                                    <script>
                                                        $(".rate-product").starRating({
                                                            initialRating: {{ $avgStar }},
                                                            useFullStars: true,
                                                            starSize: 30,
                                                            readOnly: true,
                                                            strokeColor: '#894A00',
                                                        });
                                                    </script>
                                                    </span>
                                                </div>

                                                @if(!empty($course))
                                                <div class="buttonRegisterNow mgt10">
                                                    <a id="regedit_learn"
                                                        href="{{ route('joblearn',['teacher_id' => $teacher->teacher_id]) }}"
                                                        class="noDecoration white bgorang dsInline hvWhite pdt5 pdb5 pdr15 pdl15 clwhite">
                                                        <i class="fas fa-chalkboard-teacher mgr5"></i>Đăng kí học
                                                    </a>
                                                </div>
                                                @endif --}}


                                                <!-- col-lg-8 -->
                                                </div>
                                            </div>
                                            <!-- row -->
                                        </div>

                                        <div class="detailTeacher mgt15 mgb15 bg-white pd10">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab"
                                                       href="#home"
                                                       role="tab" aria-controls="home" aria-selected="true">Công việc
                                                        làm
                                                        thêm</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab"
                                                       href="#profile"
                                                       role="tab" aria-controls="profile" aria-selected="false">Trình
                                                        độ</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="contact-tab" data-toggle="tab"
                                                       href="#contact"
                                                       role="tab" aria-controls="contact" aria-selected="false">Kinh
                                                        nghiệm</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="fow-tab" data-toggle="tab" href="#fow"
                                                       role="tab" aria-controls="contact" aria-selected="false">Giới
                                                        thiệu</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                     aria-labelledby="home-tab">
                                                    @if(!empty($course))
                                                        <div class="content pd10"
                                                             style="border: 1px solid #ccc;border-top: none;">
                                                            <div class="titleCourse">
                                                                <h3 class="f20 clhome fw6">
                                                                    {{ isset($course->course_name) ? $course->course_name : '' }}
                                                                </h3>
                                                                <p class="f16 mgb10">Thời gian
                                                                    :
                                                                    {{ isset($course->course_time) ? $course->course_time : '' }}
                                                                </p>
                                                                <p class="f18 red fw6">Giá khóa học
                                                                    :
                                                                    {{ isset($course->course_price) ? number_format(intval($course->course_price)) : '' }}
                                                                    đ</p>
                                                            </div>
                                                            <hr>
                                                            <div class="introCourse">
                                                                <h4 class="f18 clhome fw6">Giới thiệu công việc làm thêm
                                                                    :</h4>
                                                                {!! isset($course->course_intro) ? $course->course_intro : 'Đang
                                                                cập nhập' !!}
                                                            </div>
                                                            <hr>
                                                            <div class="contentCourse ">
                                                                <h4 class="f18 clhome fw6">Nội dung làm thêm :</h4>
                                                                {!! isset($course->course_content) ? $course->course_content :
                                                                'Đang cập nhập' !!}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="content pd10"
                                                             style="border: 1px solid #ccc;border-top: none;">
                                                            <p>Đang cập nhập thông tin</p>
                                                        </div>
                                                    @endif


                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                                     aria-labelledby="profile-tab">
                                                    <div class="content pd10"
                                                         style="border: 1px solid #ccc;border-top: none;">
                                                        @if(!empty($teacher_specialize))
                                                            @foreach($teacher_specialize as $spec)
                                                                <div class="titleCourse">
                                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                                        : {{ $spec->star_specialize_time }}
                                                                        - {{ $spec->end_specialize_time }}</h3>
                                                                    <p class="f14 mgb5"><i class="fas fa-school"></i>
                                                                        <span
                                                                                class="fw6">Trường học </span>
                                                                        :
                                                                        {{ isset($spec->school) ? $spec->school : 'Đang cập nhập' }}
                                                                    </p>
                                                                    <p class="f14 mgb5"><i
                                                                                class="fab fa-leanpub"></i><span
                                                                                class="fw6">Ngành học</span>
                                                                        :
                                                                        {{ isset($spec->majors) ? $spec->majors : 'Đang cập nhập' }}
                                                                    </p>
                                                                    <p class="f14 mgb5"><i
                                                                                class="fas fa-id-card"></i><span
                                                                                class="fw6">Trình độ</span>
                                                                        :
                                                                    <?php
                                                                    $literacy = App\Entity\Literacy::getIdLi($spec->leve);
                                                                    ?>{{ isset($literacy->literacy_name) ? $literacy->literacy_name : 'Đang cập nhập' }}
                                                                    <p class="f14 mgb5"><i class="fas fa-jedi"></i><span
                                                                                class="fw6">Trạng thái</span>
                                                                        :
                                                                        {{ isset($spec->specialize_status) ? $spec->specialize_status : 'Đang cập nhập' }}
                                                                    </p>

                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        @else
                                                            <p>Đang cập nhập thông tin</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="contact" role="tabpanel"
                                                     aria-labelledby="contact-tab">
                                                    <div class="content pd10"
                                                         style="border: 1px solid #ccc;border-top: none;">
                                                        @if(!empty($teacher_experience))
                                                            @foreach($teacher_experience as $exp)
                                                                <div class="titleCourse">
                                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                                        : {{ $exp->star_working_time }}
                                                                        - {{ $exp->end_working_time }}</h3>
                                                                    <p class="f14 mgb5"><i
                                                                                class="fas fa-location-arrow"></i><span
                                                                                class="fw6">Tên công ty </span>
                                                                        :
                                                                        {{ isset($exp->company) ? $exp->company : 'Đang cập nhập' }}
                                                                    </p>
                                                                    <p class="f14 mgb5"><i class="fas fa-map"></i><span
                                                                                class="fw6">Vị trí công việc</span>
                                                                        :
                                                                        {{ isset($exp->position) ? $exp->position : 'Đang cập nhập' }}
                                                                    </p>
                                                                    <p class="f14 mgb5"><i
                                                                                class="fas fa-id-badge"></i><span
                                                                                class="fw6">Mô tả công việc </span>
                                                                        : {!! isset($exp->des_position) ? $exp->des_position : 'Đang
                                                            cập nhập' !!}
                                                                    </p>

                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        @else
                                                            <p>Đang cập nhập thông tin</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="fow" role="tabpanel"
                                                     aria-labelledby="fow-tab">
                                                    <div class="content pd10"
                                                         style="border: 1px solid #ccc;border-top: none;">
                                                        <div class="titleCourse">
                                                            <h3 class="f18 clhome fw6">Giới thiệu bản thân</h3>
                                                            <div class="content">
                                                                {!! isset($teacher->information_verifier) ?
                                                                $teacher->information_verifier : 'Đang cập nhật thông tin'
                                                                !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form role="form" action="" method="POST" id="form_update_interactive">
            {!! csrf_field() !!}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cập nhật tương tác</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="col-6"> --}}
                        <div class="form-group">
                            <label for="">Nội dung tương tác</label>
                            <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                        </div>
                        {{-- </div>   --}}
                        {{-- <div class="col-6"> --}}
                        <div class="form-group">
                            <label for="">Ngày tương tác</label>
                            <input type="date" name="interactive_day" id="interactive_day" class="form-control">
                        </div>

                        {{-- </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <script>
        $('.send').click(function () {
            if ($.trim($('#feedback').val()).length === 0) {
                $('.note_text_feedback').hide();
                $('.error_text_feedback').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
                $('.error_reg_mess_icon').css("color", "#ff0000");
                $('.error_border_feedback').css("cssText", "border: 1px solid #ff0000  !important;");
                event.preventDefault();
            }
        });

        function submitDelete(e) {
            var url = $(e).attr('href');

            var Ids = [];
            console.log(url);
            $('#send_feedback_teacher').attr('action', url);
            return false;
        }

        $('.update_interactive').click(function () {
            var interactive_day = $(this).attr('interactive_day');
            var url = $(this).attr('href');
            var content = $(this).attr('content');
            $('#interactive_day').attr('value', interactive_day);
            document.getElementById("content").value = content;
            $('#form_update_interactive').attr('action', url);
            // return false;
        });
        $('.delete_request').click(function () {
            var x = confirm("Bạn có chắc chắc đề nghị xóa?");
            if (x)
                return true;
            else
                return false;
        });
        $('.undelete_request').click(function () {
            var x = confirm("Bạn có chắc chắc bỏ đề nghị xóa?");
            if (x)
                return true;
            else
                return false;
        });
        $('.btnDelete').click(function () {
            var x = confirm("Bạn có chắc chắc muốn xóa?");
            if (x)
                return true;
            else
                return false;
        });
        // $('.coppy_account').click(function(){
        //     var url = $(this).attr('href');
        //     console.log(url);
        //     // var content = $("#feedback_all").val();
        //     // var check_mission = $("#check_mission").val();
        //     var changeHtml = '';
        //         $.ajax({
        //             type: 'get',
        //             url: url,
        //             success: function (data) {
        //                 console.log(1);
        //                 console.log(data);
        //                 if (data) {
        //                     changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
        //                     changeHtml+=    '<div class="alert alert-success mg-b-0 ">';
        //                     changeHtml+=        'Chuyển thành công';
        //                     changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
        //                     changeHtml+=    '</div>';
        //                     changeHtml+= '</div>';
        //                     $('.log_error').html(changeHtml);
        //                     // $('#myModal1').modal('hide');
        //                 }
        //
        //             },
        //             error: function (err) {
        //                 console.log(2);
        //                 console.log(err);
        //                 changeHtml+= '<div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">';
        //                 changeHtml+=    '<div class="alert alert-danger mg-b-0 " role="alert">';
        //                 changeHtml+=        'Chuyển không thành công';
        //                 changeHtml+=        '<button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>';
        //                 changeHtml+=    '</div>';
        //                 changeHtml+= '</div>';
        //                 $('.log_error').html(changeHtml);
        //                 // $('#myModal1').modal('hide');
        //             }
        //         });
        // });
    </script>
@endsection
