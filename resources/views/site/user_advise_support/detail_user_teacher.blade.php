@extends('site.layout_site.site')
@section('type_meta', 'website')
@section('title', 'Giảng viên' . isset($teacher->teacher_name) ? $teacher->teacher_name : '')
@section('meta_description', 'Giảng viên' . isset($teacher->teacher_name) ? $teacher->teacher_name : '')
@section('keywords', 'Giảng viên' . isset($teacher->teacher_name) ? $teacher->teacher_name : '')
@section('meta_image', isset($information['logo']) ?  asset($information['logo']) : '')
@section('canonical', 'https://sanketoan.vn/')
@section('meta_url', 'https://sanketoan.vn/')

<link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">
@section('content')

    {{--@include('site.partials.slider_new')--}}

    {{--@include('site.filter_site.filter_new')--}}

    <section class="detail_user_teacher">
        <div class="container container_w_1200">
            <div class="row">
                <div class="col-md-8 detail_user_teacher_left">
                    <div class="box_user_teacher_left js_matchHeight_box_teacher">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="box_user_teacher_right_img">
                                    <img src="{{ !empty($teacher->teacher_images) ? asset($teacher->teacher_images) : asset('assets/image/avatarteacher.png') }}">
                                    {{--<img src="https://sanketoan.vn/public/library_teacher/cfcvietnam%40gmail.com-54837/images/Picture1.png">--}}
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="nameTeacher">
                                    <h1 class="clhome fw6 f24">
                                        {{ isset($teacher->teacher_name) ? $teacher->teacher_name : '' }}
                                    </h1>


                                    <?php $business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($teacher->business_type_id);?>

                                    <p class="mgb5"><i class="fas fa-certificate mgr5"></i>Lĩnh vực
                                        : {{ isset($business_type['type_of_business_name']) ? $business_type['type_of_business_name'] : 'Đang cập nhật' }}
                                    </p>

                                    <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ : </span>
                                        <?php $district = \App\Entity\District::getId($teacher->district); ?>
                                        @if(!empty($district))
                                            {{ $district->district_name . ' -' }}
                                        @endif
                                        <?php $province = \App\Entity\Province::getId($teacher->province);?>
                                        @if(!empty($province))
                                            {{ $province->province_name }}
                                        @endif


                                    </p>
                                    <p class="mgb5"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6">Địa chỉ cụ thể : </span>
                                        {{ isset($teacher->address) ? $teacher->address : '' }}
                                    </p>


                                    <!-- info -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 detail_user_teacher_right">
                    <div class="box_user_teacher_right js_matchHeight_box_teacher">
                        <div class="text-center ">
                            <h3 class="clhome fw6 f24">Dịch vụ cung cấp</h3>
                        </div>
                        <div class="box_user_teacher_right_content">
                            <ul>
                                <li>
                                    Quyết toán thuế thu nhập
                                </li>
                                <li>
                                    Dịch vụ toán kế
                                </li>
                                <li>
                                    Tư vấn thu nhập cá nhân
                                </li>
                                <li>
                                    Dịch vụ kế toán trọn gói
                                </li>
                            </ul>
                        </div>

                        <div class="text-center">

                            @if(\Illuminate\Support\Facades\Auth::check())
                                <a class="advise_connect"
                                   href="{{ route('get_connect_user_support',['user_id'=>$teacher->user_id]) }}"><i
                                            class="fas fa-wrench"></i>  Kết nối với gia sư</a>
                            @else
                                <a class="advise_connect" data-toggle="modal"
                                   data-target="#messgae_modal"><i
                                            class="fas fa-wrench"></i>  Kết nối với gia sư</a>
                            @endif

                            <?php
                            $check_advise = \App\Entity\User_advise::where('user_id', $teacher->user_id)
                                ->where('ad_status', 1)
                                ->first();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box_user_ex_sp">
                        <div class="detailTeacher detail_user_teacher_ex_spec mgt15 mgb15 bg-white pd10">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="fow-tab" data-toggle="tab" href="#fow" role="tab"
                                       aria-controls="contact" aria-selected="false">Giới thiệu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                       aria-controls="contact" aria-selected="false">Kinh nghiệm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                       aria-controls="profile" aria-selected="false">Trình độ</a>
                                </li>


                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="fow" role="tabpanel"
                                     aria-labelledby="fow-tab">
                                    <div class="content pd15">
                                        <div class="titleCourse">
                                            <h3 class="f18 clhome fw6">Giới thiệu bản thân</h3>
                                            <div class="content">
                                                {!! isset($teacher->information_verifier) ? $teacher->information_verifier : 'Đang cập nhật thông tin' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="content pd15">
                                        @if(!empty($teacher_experience))
                                            @foreach($teacher_experience as $exp)
                                                <div class="titleCourse">
                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                        : {{ $exp->star_working_time }}
                                                        - {{ $exp->end_working_time }}</h3>
                                                    <p class="f14 mgb5"><i class="fas fa-location-arrow"></i><span
                                                                class="fw6">Tên công ty </span>
                                                        : {{ isset($exp->company) ? $exp->company : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-map"></i><span class="fw6">Vị trí công việc</span>
                                                        : {{ isset($exp->position) ? $exp->position : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-id-badge"></i><span
                                                                class="fw6">Mô tả công việc </span>
                                                        : {!! isset($exp->des_position) ? $exp->des_position : 'Đang cập nhập' !!}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <p>Đang cập nhập thông tin</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="content pd15">
                                        @if(!empty($teacher_specialize))
                                            @foreach($teacher_specialize as $spec)
                                                <div class="titleCourse">
                                                    <h3 class="f18 clhome fw6">Thời gian (năm)
                                                        : {{ $spec->star_specialize_time }}
                                                        - {{ $spec->end_specialize_time }}</h3>
                                                    <p class="f14 mgb5"><i class="fas fa-school"></i> <span class="fw6">Trường học </span>
                                                        : {{ isset($spec->school) ? $spec->school : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fab fa-leanpub"></i><span class="fw6">Ngành học</span>
                                                        : {{ isset($spec->majors) ? $spec->majors : 'Đang cập nhập' }}
                                                    </p>
                                                    <p class="f14 mgb5"><i class="fas fa-id-card"></i><span class="fw6">Trình độ</span>
                                                        : <?php
                                                    $literacy = App\Entity\Literacy::getIdLi($spec->leve);
                                                    ?>{{ isset($literacy->literacy_name) ? $literacy->literacy_name : 'Đang cập nhập' }}
                                                    <p class="f14 mgb5"><i class="fas fa-jedi"></i><span class="fw6">Trạng thái</span>
                                                        : {{ isset($spec->specialize_status) ? $spec->specialize_status : 'Đang cập nhập' }}
                                                    </p>

                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <p>Đang cập nhập thông tin</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>


    @if(!empty($check_advise))
        <div class="modal fade bd-example-modal-lg" id="connect" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('user_advise_submit') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Kết nối với gia
                                sư  : {{ !empty($teacher->teacher_name) ? $teacher->teacher_name : '' }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="content_box_res_advise">
                                <p>Dịch vụ cần hỗ trợ</p>
                                <?php
                                $list_support_input = \App\Entity\List_support::get();
                                ?>
                                @if(!empty($list_support_input))
                                    @foreach($list_support_input as $id_c=>$combo)
                                        <div class="item_service_input">
                                            <label>
                                                <input name="support_id" type="radio"
                                                       value="{{ !empty($combo->support_id) ? $combo->support_id : '' }}" @if($id_c == 0) checked @endif>
                                                {{ !empty($combo->title_support) ? $combo->title_support : '' }}
                                            </label>

                                        </div>
                                    @endforeach
                                @endif

                                <div class="text-center">
                                    <input type="hidden" name="user_id" value="{{ $teacher->user_id }}">
                                    {{--<input type="hidden" name="teacher_id" value="">--}}
                                    <button type="submit" class="btn btn-primary">Kết nối với gia sư</button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <!-- Modal  support-->
    <div class="modal fade" id="support_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="contentMessage">
                        <p>Vui lòng đăng ký tài khoản nhà tuyển dụng hoặc tài khoản ứng viên để sử dụng chức năng
                            này</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    {{--!-- Modal  support-->--}}
    <div class="modal fade" id="message_support" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="contentMessage">
                        <p>Chức năng này chỉ dành cho gia sư</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="messgae_modal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content text-center">
                {{--<div class="modal-header">--}}
                {{--<h5 class="modal-title" id="exampleModalLabel">Đăng ký cần hỗ trợ</h5>--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
                {{--</div>--}}
                <div class="modal-body">
                    <div class="body_header">
                        <a href="/">
                            <img class="lazy" src="{{ isset($information['logo']) ?  $information['logo'] : '' }}"
                                 alt="" width="100%">
                            {{--<img class="lazy" src="https://sanketoan.vn/public/library/images/home_new/Logo.png" alt="" width="100%">--}}
                        </a>
                    </div>
                    <div class="body_content">
                        <a data-toggle="modal" title="Đăng nhập" data-target="#loginTiva" class="text_body_message"
                           id="text_body_message">Bạn cần đăng nhập để sử dụng dịch vụ này</a>
                    </div>
                    <div class="body_footer">
                        <a data-toggle="modal" title="Đăng nhập" data-target="#loginTiva">Đăng nhập</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Để sau</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('show_js')
    @if(!empty($errors->all()))
        <script>
            $('#res_advise').modal('show');
        </script>
    @endif
    <script>
        $('.js_matchHeight_box_teacher').matchHeight();
    </script>
    {{--@if(!empty($errors->all()))--}}
    {{--<script>--}}
    {{--$('#res_advise').modal('show');--}}
    {{--</script>--}}
    {{--@endif--}}
@endsection
