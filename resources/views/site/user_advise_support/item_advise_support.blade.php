<link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">

<?php
$list_advise = \App\Entity\User_advise::get_list_advise(4);
$list_support =  \App\Entity\User_support::get_list_support(5);
?>
<section class="user_support_advise">
    <div class="container container_w_1200">
        <div class="row">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-12 col_box_title">
                        <div class="col_left_advise col_title_support">
                            <i class="fas fa-user-graduate"></i>
                            <span>Gia sư kế toán Online 1-1</span>
                        </div>

                        <div class="col_right_support col_title_support">
                            <span>Kế toán cần hỗ trợ</span>
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="box_advise">
                    <div class="text-center">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            @if(\Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role == 3 )
                                <a class="button_res_advíe" href="{{ route('res_user_advise') }}">Đăng ký
                                    trở thành gia sư</a>
                            @else
                                <a class="button_res_advíe" data-toggle="modal" data-target="#res_message">Đăng ký
                                    trở thành gia sư</a>
                            @endif
                        @else
                            <a class="button_res_advíe" data-toggle="modal" data-target="#messgae_modal">Đăng ký trở
                                thành gia sư</a>
                        @endif
                    </div>
                    @if(!empty($list_advise))
                        @foreach($list_advise as $id_a=>$advise)
                            <div class="item_box_advise">
                                @if($advise->role == 1)

                                    <?php
                                    $employee = \App\Entity\Employee::where('user_id', $advise->id)->first();
                                    $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                                    $province_name = \App\Entity\Province::where('province_id', $employee->province)->value('province_name');
                                    $date_day = date_create();
                                    $year_day = date_format($date_day, "Y") - $employee->time_to_work;

                                    ?>

                                    <div class="box_advise_hd">
                                        <img class=" rounded-circle user_thump lazy"
                                             src="{{ !empty($employee->employee_image) ? asset($employee->employee_image) : asset('assets/image/avatarteacher.png') }}"
                                             alt="{{ !empty($advise->name) ? $advise->name : '' }}">
                                        <span>{{ !empty($advise->name) ? $advise->name : '' }}</span>
                                    </div>

                                    <div class="box_advise_content">
                                        <p class="box_advise_province"><i class="fas fa-map-marker-alt"></i>
                                            @if(isset($province_name))
                                                {{ $province_name }}
                                            @endif
                                            @if(!empty($list_district_name))
                                                @foreach($list_district_name as $ids=>$district)
                                                    <i> | {{ $district->district_name }}</i>
                                                @endforeach
                                            @endif
                                        </p>
                                        <p class="box_advise_exp"><i class="fas fa-briefcase"></i>Kinh nghiệm
                                            : {{ !empty($year_day) ? $year_day   : 1 }} năm</p>

                                        <?php
                                        $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
                                        ?>
                                        @if(!empty($list_business_name))
                                            <div class="uv-info td-cty-lv-gan-day" data-toggle="tooltip" title=""
                                                 data-trigger="hover"
                                                 data-original-title="Kinh nghiệm trong lĩnh vực">
                                                <p class="mgb5 cutTitle experienceInField js_business_name">
                                                    <i class="fas fa-share-alt mgr5"></i>
                                                    @foreach($list_business_name as $id_b=>$business)
                                                        @if($id_b == 0)
                                                            <span> {{ $business->business_type_name }}</span>
                                                        @else
                                                            <span> | {{ $business->business_type_name }}</span>
                                                        @endif
                                                    @endforeach

                                                </p>
                                            </div>
                                        @else
                                            <p>Đang cập nhật</p>
                                        @endif
                                        <p class="box_advise_exp"><i class="fas fa-dollar-sign"></i>
                                            {{--combo_ad_id--}}
                                            <?php
                                            $price_combo = \App\Entity\Combo_advise::where('combo_ad_id', $advise->combo_ad_id)->value('combo_price');
                                            ?>
                                            Chi phí
                                            : {{ !empty($price_combo) ? number_format($price_combo)   : '' }} VNĐ
                                        </p>

                                        <div class="text-center">
                                            <a href="{{ route('detail_user_employee', ['employee_slug' => $employee['employee_slug']]) }}"
                                               target="_blank" class="box_advise_link"><i
                                                        class="fas fa-eye mr-1"></i>
                                                Xem chi tiết </a>

                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                <?php
                                                $check_res_advise = \App\Entity\User_support_connect_advise::check_res_advise($advise->ad_id, \Illuminate\Support\Facades\Auth::user()->id);
                                                ?>
                                                @if(!empty($check_res_advise))
                                                    <a class="advise_connect"><i class="fas fa-wrench"></i> Đang
                                                        liên hệ</a>
                                                @else
                                                    <a class="advise_connect"
                                                       href="{{ route('get_connect_user_support',['user_id'=>$advise->id]) }}"><i
                                                                class="fas fa-wrench"></i> Kết nối</a>
                                                @endif


                                            @else
                                                <a class="advise_connect" data-toggle="modal"
                                                   data-target="#messgae_modal"><i
                                                            class="fas fa-wrench"></i> Kết nối</a>
                                            @endif


                                        </div>
                                    </div>
                                @endif

                                @if($advise->role == 3)

                                    <?php
                                    $tea = \App\Entity\Teacher::where('user_id', $advise->id)->first();
                                    $district = \App\Entity\District::getId($tea->district);
                                    ?>
                                    @if(!empty($district))

                                    @endif
                                    <?php $province = \App\Entity\Province::getId($tea->province);?>
                                    <div class="box_advise_hd">
                                        <img class=" rounded-circle user_thump lazy"
                                             data-src="{{ !empty($tea->teacher_images) ? asset($tea->teacher_images) : asset('assets/image/avatarteacher.png') }}"
                                             alt="{{ !empty($advise->name) ? $advise->name : '' }}">
                                        <span>{{ !empty($advise->name) ? $advise->name : '' }}</span>
                                    </div>

                                    <div class="box_advise_content">
                                        <p class="box_advise_province"><i class="fas fa-map-marker-alt"></i>
                                            {{ $province->province_name }} | {{ $district->district_name }}
                                        </p>
                                        <p class="box_advise_exp">
                                            <i class="fas fa-briefcase"></i>Đang cập nhật
                                        </p>
                                        <p class="box_advise_exp"><i class="fas fa-dollar-sign"></i>
                                            {{--combo_ad_id--}}
                                            <?php
                                            $price_combo = \App\Entity\Combo_advise::where('combo_ad_id', $advise->combo_ad_id)->value('combo_price');
                                            ?>
                                            Chi phí
                                            : {{ !empty($price_combo) ? number_format($price_combo)   : '' }} VNĐ
                                        </p>
                                        <div class="text-center">
                                            <a href="{{ route('detail_user_teacher',['slug'=>$tea->slug]) }}?advise=connect"
                                               target="_blank"
                                               class="box_advise_link"><i class="fas fa-eye mr-1"></i> Xem chi tiết
                                            </a>

                                            @if(\Illuminate\Support\Facades\Auth::check())
                                                <?php
                                                $check_res_advise = \App\Entity\User_support_connect_advise::check_res_advise($advise->ad_id, \Illuminate\Support\Facades\Auth::user()->id);
                                                ?>
                                                @if(!empty($check_res_advise))
                                                    <a class="advise_connect"><i class="fas fa-wrench"></i> Đang
                                                        liên hệ</a>
                                                @else
                                                    <a class="advise_connect"
                                                       href="{{ route('get_connect_user_support',['user_id'=>$advise->id]) }}"><i
                                                                class="fas fa-wrench"></i> Kết nối</a>
                                                @endif
                                            @else
                                                <a class="advise_connect" data-toggle="modal"
                                                   data-target="#messgae_modal"><i
                                                            class="fas fa-wrench"></i> Kết nối</a>
                                            @endif


                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif


                    <div class="text-center">
                        <a class="link_get_all" href="{{ route('user_support_advise') }}">Xem tất cả</a>
                    </div>


                </div>
            </div>


            <div class="col-md-6 col-12">
                <div class="box_advise">
                    <div class="text-center">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            @if(\Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role == 2 )
                                <a class="button_res_advíe" href="{{ route('res_user_support') }}">Đăng ký nội dung
                                    cần hỗ trợ </a>
                            @else
                                <a class="button_res_advíe" data-toggle="modal" data-target="#res_support">Đăng ký
                                    nội dung cần hỗ trợ </a>
                            @endif
                        @else
                            <a class="button_res_advíe" data-toggle="modal" data-target="#messgae_modal">Đăng ký nội
                                dung cần hỗ trợ</a>
                        @endif


                    </div>


                    @if(!empty($list_support))
                        @foreach($list_support as $id_p=>$sup)
                            <div class="item_box_advise">


                                {{--//kiemr tra xem là tài khoản ứng viên hay giao vien--}}
                                <?php
                                $title_support = \App\Entity\List_support::where('support_id', $sup->support_id)->value('title_support');
                                $message_status = 'Cần được tư vấn';
                                if ($sup->ques_status == 1) {
                                    $message_status = 'Đã được tư vấn';
                                }
                                if ($sup->ques_status == 2) {
                                    $message_status = 'Đã từ chối';
                                }
                                if ($sup->ques_status == 3) {
                                    $message_status = 'Đã tư vấn xong';
                                }
                                if (!empty($sup->ad_id)) {
                                    $message_status = 'Gia sư đang liên hệ';
                                }
                                ?>
                                @if($sup->role == 1)
                                    <?php
                                    $employee = \App\Entity\Employee::where('user_id', $sup->id)->first();
                                    $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                                    $province_name = \App\Entity\Province::where('province_id', $employee->province)->value('province_name');
                                    $date_day = date_create();
                                    $year_day = date_format($date_day, "Y") - $employee->time_to_work;
                                    ?>
                                    <div class="box_advise_hd">
                                        <img class=" rounded-circle user_thump lazy"
                                             data-src="{{ !empty($employee->employee_image) ? asset($employee->employee_image) : asset('assets/image/avatarteacher.png') }}"
                                             alt="{{ !empty($sup->name) ? $sup->name : '' }}">
                                        <span>{{ !empty($sup->name) ? $sup->name : '' }}</span>
                                    </div>
                                    <div class="box_advise_content">
                                        <p class="box_advise_province"><i class="fas fa-map-marker-alt"></i>
                                            @if(isset($province_name))
                                                {{ $province_name }}
                                            @endif
                                            @if(!empty($list_district_name))
                                                @foreach($list_district_name as $ids=>$district)
                                                    <i> | {{ $district->district_name }}</i>
                                                @endforeach
                                            @endif
                                        </p>
                                        <p class="box_advise_exp">
                                            <i class="fas fa-briefcase"></i>{{ !empty($title_support) ? $title_support : '' }}
                                        </p>


                                        <div class="text-center">
                                            <a href="{{ route('detail_employee_show', ['employee_slug' => $employee['employee_slug']]) }}"
                                               target="_blank" class="box_advise_link"><i
                                                        class="fas fa-eye mr-1"></i>
                                                Xem chi tiết</a>
                                            @if($sup->support_id == 1 || $sup->support_id == 3)
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    <?php
                                                    $check_advise = \App\Entity\User_advise::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
                                                        ->where('ad_status', 1)
                                                        ->first();
                                                    ?>
                                                    <a data-toggle="modal" title="Đăng nhập"
                                                       data-target="{{ !empty($check_advise) ? '#modal_show_support'.$id_p : '#message_support' }}"
                                                       class="advise_connect color_message{{$sup->ques_status}}">
                                                        {{ $message_status }} </a>
                                                @else
                                                    <a data-toggle="modal" title="Đăng nhập"
                                                       data-target="#messgae_modal"
                                                       class="advise_connect color_message{{$sup->ques_status}}">
                                                        {{ $message_status }} </a>
                                                @endif

                                            @else
                                                <a data-toggle="modal" title="Đăng nhập"
                                                   data-target="#messgae_modal"
                                                   class="advise_connect color_message{{$sup->ques_status}}">
                                                    {{ $message_status }} </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif


                                @if($sup->role == 2)
                                    <?php
                                    $employer = \App\Entity\Employer::where('user_id', $sup->id)->first();
                                    $province_name = App\Entity\Province::where('province_id', $employer->province)->value('province_name');
                                    $district_name = App\Entity\District::where('district_id', $employer->district)->value('district_name');
                                    ?>
                                    <div class="box_advise_hd">
                                        <img class=" rounded-circle user_thump lazy"
                                             data-src="{{ !empty($employer->image) ? asset($employer->image) : asset('assets/image/avatarteacher.png') }}"
                                             alt="{{ !empty($sup->name) ? $sup->name : '' }}">
                                        <span>{{ !empty($sup->name) ? $sup->name : '' }}</span>
                                    </div>
                                    <div class="box_advise_content">
                                        <p class="box_advise_province"><i class="fas fa-map-marker-alt"></i>
                                            {{ $province_name}} | {{ $district_name }}
                                        </p>
                                        <p class="box_advise_exp">
                                            <i class="fas fa-briefcase"></i>{{ !empty($title_support) ? $title_support : '' }}
                                        </p>

                                        <div class="text-center">
                                            <a href="{{ route('detail_employer',['slug'=>$employer['slug'] ]) }}"
                                               target="_blank"
                                               class="box_advise_link"><i class="fas fa-eye mr-1"></i> Xem chi tiết</a>
                                            @if($sup->support_id == 1 || $sup->support_id == 3)
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    <?php
                                                    $check_advise = \App\Entity\User_advise::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
                                                        ->where('ad_status', 1)
                                                        ->first();
                                                    ?>
                                                    <a data-toggle="modal" title="Đăng nhập"
                                                       data-target="{{ !empty($check_advise) ? '#modal_show_support'.$id_p : '#message_support' }}"
                                                       class="advise_connect color_message{{$sup->ques_status}}">
                                                        {{ $message_status }} </a>
                                                @else
                                                    <a data-toggle="modal" title="Đăng nhập"
                                                       data-target="#messgae_modal"
                                                       class="advise_connect color_message{{$sup->ques_status}}">
                                                        {{ $message_status }} </a>
                                                @endif

                                            @else
                                                <a data-toggle="modal" title="Đăng nhập"
                                                   data-target="#messgae_modal"
                                                   class="advise_connect color_message{{$sup->ques_status}}">
                                                    {{ $message_status }} </a>
                                            @endif
                                        </div>

                                    </div>
                                @endif



                            </div>
                        @endforeach
                    @endif

                    <div class="text-center">
                        <a class="link_get_all" href="{{ route('user_support_advise') }}">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="res_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <p>Vui lòng đăng ký tài khoản giáo viên hoặc tài khoản ứng viên để sử dụng chức năng này</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
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
                        <img class="lazy" data-src="{{ isset($information['logo']) ?  $information['logo'] : '' }}"
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
<!-- Modal  tư vấn kế toán-->
@foreach($list_support as $id_p=>$sup)
    <div class="modal fade bd-example-modal-lg" id="modal_show_support{{$id_p}}" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('support_user_advise') }}" method="post">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Liên hệ tư vấn</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content_box_res_advise">
                            <p>Bạn muốn gia sư cho kế toán : {{ !empty($sup->name) ? $sup->name : '' }}</p>

                            <div class="text-center">
                                <input type="hidden" name="ques_id"
                                       value="{{ !empty($sup->ques_id) ? $sup->ques_id : 0 }}">
                                <input type="hidden" name="sup_id"
                                       value="{{ !empty($sup->sup_id) ? $sup->sup_id : 0 }}">
                                <input type="hidden" name="user_id"
                                       value="{{ !empty(\Illuminate\Support\Facades\Auth::user()->id) ? \Illuminate\Support\Facades\Auth::user()->id : 0 }}">
                                <button type="submit" class="btn btn-primary">Liên hệ tư vấn hỗ trợ</button>
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
@endforeach
@if(!empty($list_advise))
    @foreach($list_advise as $id_a=>$advise)
        {{--//kiemr tra xem là tài khoản ứng viên hay giao vien--}}
        <div class="modal fade bd-example-modal-lg" id="connect{{$id_a}}" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('user_advise_submit') }}" method="post">
                    {!! csrf_field() !!}

                    <div class="modal-content">
                        @if($advise->role == 1)
                            <?php
                            $employee = \App\Entity\Employee::where('user_id', $advise->id)->first();
                            ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Kết nối với gia
                                    sư : {{ !empty($employee->employee_name) ? $employee->employee_name : '' }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($advise->role == 3)
                            <?php
                            $tea = \App\Entity\Teacher::where('user_id', $advise->id)->first();
                            ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Kết nối với gia
                                    sư : {{ !empty($tea->teacher_name) ? $tea->teacher_name : '' }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
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
                                                       value="{{ !empty($combo->support_id) ? $combo->support_id : '' }}"
                                                       @if($id_c == 0) checked @endif>
                                                {{ !empty($combo->title_support) ? $combo->title_support : '' }}
                                            </label>

                                        </div>
                                    @endforeach
                                @endif
                                <div class="text-center">
                                    <input type="hidden" name="user_id" value="{{ $advise->id }}">
                                    {{--<input type="hidden" name="teacher_id" value="">--}}
                                    <button type="submit" class="btn btn-primary" src="">Kết nối với gia sư
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--support_id--}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endif