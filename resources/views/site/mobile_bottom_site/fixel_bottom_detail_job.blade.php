<link rel="stylesheet" type="text/css" href="/assets/css/thang_job_reponsive.css"/>
<div class="container-fluid dsNone show_mobile_job_500">
    <div class="row ">
        <div class="col-3">
            <div class="item_job_mobile text-center">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ route('show_step_profile_employee') }}">
                        <i class="fas fa-paper-plane"></i>
                        <p class="mgb0">Tạo hồ sơ</p>
                    </a>
                @else
                    <a data-toggle="modal" data-target="#loginTiva">
                        <i class="fas fa-paper-plane"></i>
                        <p class="mgb0">Tạo hồ sơ</p>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-3">
            <div class="item_job_mobile text-center">
                <a href="{{ route('search_job_view_mobile') }}">
                    <i class="fas fa-search"></i>
                    <p class="mgb0">Tìm kiếm</p>
                </a>
            </div>
        </div>
        <div class="col-3">
            <div class="item_job_mobile text-center">
                <a data-toggle="modal" data-target="#contac_employer">
                    <i class="fas fa-phone"></i>
                    <p class="mgb0">Liên hệ</p>
                </a>
            </div>
        </div>
        <div class="col-3">
            <div class="item_job_mobile text-center">
                <a data-toggle="modal" data-target="#modal_dowload_app">
                    <i class="fas fa-download"></i>
                    <p class="mgb0">Tải App</p>
                </a>
            </div>
        </div>
    </div>
</div>

@if(!empty($employer))
<div class="modal fade" id="contac_employer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)
            <div class="modal-body">
                <?php

                $employee_profile = \App\Entity\Employee::get_profile(\Illuminate\Support\Facades\Auth::user()->id)
                ?>
                @if(!empty($employee_profile->profile) && $employee_profile->profile == 100)
                    <h4 class="f18 clgreen">
                        {{ !empty($employer->enterprise_name) ? $employer->enterprise_name : '' }}
                    </h4>
                    <p class="mgb5"><span class="fw6">Số điện : </span> {{ !empty($employer->phone) ? $employer->phone : '' }} </p>
                    <p class="mgb5"><span class="fw6">Địa chỉ :  </span> {{ !empty($employer->address) ? $employer->address : '' }} </p>
                    <p class="mgb5"><span class="fw6">Website :  </span> {{ !empty($employer->website) ? $employer->website : '' }} </p>
                @else
                    <p class="mgb5">
                        Hồ sơ của bạn chưa được cập nhật 100% hồ sơ! <a href="{{ route('show_step_profile_employee') }}"> Cập nhật hồ sơ tại đây !</a>
                    </p>

                @endif
            </div>
            @else
                <div class="modal-body">
                    <p class="mgb5">
                        Vui lòng đăng nhập tài khoản ứng viên để xem thông tin nhà tuyển dụng ! <a href="#" data-toggle="modal" data-target="#loginTiva"> Đăng nhập tại đây !</a>
                    </p>
                    <p class="mgb5">
                        Nếu bạn chưa có tài khoản  ! <a href="{{ route('employee_register') }}">Có thể đăng kí tại đây ! </a>
                    </p>
                </div>
                @endif

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnOrange" data-dismiss="modal" id="submit_notication">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@endif






