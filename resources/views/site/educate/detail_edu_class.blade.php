@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($edu_class->edu_class_name) ? $edu_class->edu_class_name : '')
@section('meta_description', isset($edu_class['edu_class_des']) ? $edu_class['edu_class_des'] : '' )
@section('keywords', isset($edu_class['edu_class_name']) ? $edu_class['edu_class_name'] : '')
@section('meta_image', ''  )

@section('content')
    <section class="content pdt20 bgrGray">
        <section class="container">
            <div class="link bgrWhite md-mgt20">
                <ul class="nav">
                    <li class="nav-item pd8">
                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item pd8">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <a href="{{ route('list_edu_categories') }}" class=" f18 md-f14 mgb0"><h1 class="f16"
                                                                                                  style="margin-bottom: 3px;">
                                Đào tạo du lịch</h1></a>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <a href="{{ route('edu_categories',['slug'=>$edu_categories->edu_cate_slug]) }}"
                           class=" f18 md-f14 mgb0"><h1 class="f16"
                                                        style="margin-bottom: 3px;">{{ isset($edu_categories->edu_cate_title) ? $edu_categories->edu_cate_title : '' }}</h1>
                        </a>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <p class="mgt5 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8 mbds_none_770">
                        <a href="#"
                           class=" f18 md-f14 mgb0"><h1 class="f16"
                                                        style="margin-bottom: 3px;">{{ isset($edu_class->edu_class_name) ? $edu_class->edu_class_name : '' }}</h1>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="content pdt20 bgrGray">
            <div class="container">
                <div class="bgrWhite pdl15 pdr15">
                    <div class="row" style="padding-bottom: 30px">

                        <div class="col-xl-9 col-lg-8 infomartionTeacher">
                            <div class="bgrWhite radius10">
                                <div class="row">
                                    <div class="col-lg-4 textCenter pdt20 pdb20">
                                        <div class="CropImg">
                                            <div class="thumbs">
                                                <img src="{{ !empty($edu_class->educate_class_image) ? $edu_class->educate_class_image : '' }}"
                                                     alt="{{ isset($edu_class->edu_class_name) ? $edu_class->edu_class_name : '' }}"
                                                     title="{{ isset($edu_class->edu_class_name) ? $edu_class->edu_class_name : '' }}"
                                                     width="100%" class="radius50p mgb20">
                                            </div>
                                        </div>

                                        <div class="Evaluate">

                                            <p class="orange mgb0">Giáo viên phụ trách
                                                : <a target="_blank" class="clhome f16 fw7"
                                                     href="{{ isset($edu_class->teacher_link) ? $edu_class->teacher_link : '#' }}">{{ isset($edu_class->teacher_name) ? $edu_class->teacher_name : '' }}</a>
                                            </p>


                                        </div>
                                        <!-- col-lg-4 -->
                                    </div>
                                    <div class="col-lg-8 pdt20">
                                        <div class="nameTeacher">
                                            <h1 class="clhome fw6 f24">
                                                {{ isset($edu_class->edu_class_name) ? $edu_class->edu_class_name : '' }}
                                            </h1>
                                            <div class="edu_class_des">
                                                {{ isset($edu_class->edu_class_des) ? $edu_class->edu_class_des : ''  }}
                                            </div>
                                            <span class="dsInline text-left clred f16 fw7">
                Thời gian học:  20h ngày <?php
                                                $date_end = date_create($edu_class->edu_date_end);
                                                echo date_format($date_end, "d/m/Y");
                                                ?>
             </span>


                                            <p class="mgb5">
                                                <span class="clgreen f14 fw7">
                                                  <i class="far fa-user"></i>    Số học viên tối đa của khóa học :  {{ isset($edu_class->edu_total_employee) ? $edu_class->edu_total_employee : '' }} học viên
                                                </span>
                                            </p>
                                            <p class="mgb5">
                                                <?php
                                                $total_employee_class = \App\Entity\Educate_employees_class::get_total_employee_class($edu_class->edu_class_id)
                                                ?>
                                                <span>
                                                <a class="btnOrange"
                                                   href="{{ route('list_educate_employee',['slug_class'=>$edu_class['edu_class_slug']]) }}">Danh sách ứng viên đã đăng kí
                                                    ( {{ !empty($total_employee_class) ? $total_employee_class : 0 }}/{{ isset($edu_class->edu_total_employee) ? $edu_class->edu_total_employee : '' }}
                                                    )</a>

                                                </span>
                                                <span class="mbdsBlock mgt15">
                                                @if($total_employee_class == $edu_class->edu_total_employee)
                                                        <a class="btn_Green mgLeft10">Khóa học đã đầy</a>
                                                    @else
                                                        <a class="btn_Green mgLeft10" data-toggle="modal"
                                                           data-target="#noti_educate">Đăng kí khóa học</a>
                                                    @endif
                                                </span>
                                            </p>

                                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
                                                <?php
                                                $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
                                                $employee_profile = \App\Entity\Employee::get_profile(\Illuminate\Support\Facades\Auth::user()->id);
                                                $check_employee_class = \App\Entity\Educate_employees_class::get_employee_class($edu_class->edu_class_id, $employee->employee_id);
                                                ?>
                                                @if($employee_profile->profile < 100)
                                                    <p class="mgt10 mgb0">
                                                        <a href="{{ route('show_step_profile_employee') }}"
                                                           target="_blank"> <span  class="clred"><i class="fas fa-times mgr5"></i>Hồ sơ của bạn chưa được hoàn thiện ({{ $employee_profile->profile }}/100) nên không thể đăng kí khóa học -> Cập nhật hồ sơ tại đây ! </span>
                                                        </a>
                                                    </p>
                                                @else
                                                            <p class="mgt10 mgb0">
                                                                <span class="clgreen"><i class="fas fa-check mgr5"></i>Hồ sơ của bạn có thể đăng kí khóa học này ! </span>

                                                            </p>
                                                @endif
                                                @if(!empty($check_employee_class))
                                                    <p class="mgt10 mgb0">
                                                        <span class="clgreen"><i class="fas fa-check mgr5"></i> Bạn đã đăng kí khóa học này rồi ! </span>
                                                    </p>
                                                    <p class="mgb0">Mời bạn vào Group Zalo của khóa học này : <a
                                                                href=" {{ isset($edu_class->edu_class_link_zalo) ? $edu_class->edu_class_link_zalo : ''  }}"> {{ isset($edu_class->edu_class_link_zalo) ? $edu_class->edu_class_link_zalo : ''  }}</a>
                                                    </p>
                                                @endif
                                            @endif

                                        </div>
                                        <!-- col-lg-8 -->
                                    </div>


                                    <div class="col-lg-12">
                                        <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                                            <div class="titleJobs  fw6 f16 white bgrBlueN pd10-20 col-f14">
                                                <h1 class="titleJobs  fw6 f20 mgb0 col-f14"> Nội dung khóa học</h1>
                                            </div>
                                            <div class="contentJobsInteresting pdl15 pdr15 col-f14 mgt10">
                                                {!! isset($edu_class->edu_class_content) ? $edu_class->edu_class_content : '' !!}
                                            </div>
                                        </section>
                                        <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                                            <div class="titleJobs  fw6 f16 white bgrBlueN pd10-20 col-f14">
                                                <h2 class="titleJobs  fw6 f20 mgb0 col-f14"> Quy định đăng kí khóa
                                                    học</h2>
                                            </div>
                                            <div class="contentJobsInteresting pdl15 pdr15 col-f14 mgt10">
                                                {!! isset($edu_class->edu_class_regulations) ? $edu_class->edu_class_regulations : '' !!}
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- row -->
                            </div>

                            <!-- col-lg-8 infomartionTeacher -->
                        </div>
                        <div class="col-lg-3">
                            <div>
                                @if(!empty($list_relative_class))
                                    @foreach($list_relative_class as $cate_class)
                                        @include('site.educate.item_categories')
                                    @endforeach
                                @endif
                            </div>

                        </div>


                    </div>


                </div>

            </div>
        </section>
    </section>
    @include('site.module_index.hotline')

    <!-- Modal -->
    <div class="modal fade" id="noti_educate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('register_educate') }}" method="POST">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Đăng kí khóa học</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! !empty($information['huong-dan-dang-ki-khoa-hoc']) ? $information['huong-dan-dang-ki-khoa-hoc'] : '' !!}
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="edu_class_id" value="{{ $edu_class->edu_class_id }}">
                        <button type="submit" class="btn btn_Green">Đăng kí khóa học</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('noti_educate_profile'))
        <div class="modal fade" id="noti_educate_profile" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Đăng kí khóa học</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mgb0"> {{ session('noti_educate_profile') }}</p>
                        <p class="mgb0"><a target="_blank" href="{{ route('show_step_profile_employee') }}">Hoàn thiện
                                hồ sơ tại đây !</a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if(session('noti_educate'))
        <div class="modal fade" id="noti_educate_note" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Đăng kí khóa học</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mgb0"> {{ session('noti_educate') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
    @endif
    <script>
        @if(session('noti_educate'))
        $('#noti_educate_note').modal('show');
        @endif

        @if(session('noti_educate_profile'))
        $('#noti_educate_profile').modal('show');
        @endif
    </script>
@endsection

