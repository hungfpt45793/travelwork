<link rel="stylesheet" type="text/css" href="/public/assets/css/thang_job_reponsive.css"/>
<div class="container-fluid dsNone show_mobile_job_500">
    <div class="row ">


        <div class="col-3">
            <div class="item_job_mobile text-center">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ route('show_file_job_facebook') }}">
                        <i class="fas fa-paper-plane "></i>
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
                <a href="{{ route('search_employee_view_mobile') }}">
                    <i class="fas fa-search"></i>
                    <p class="mgb0">Tìm kiếm</p>
                </a>
            </div>
        </div>


            <div class="col-3">
                <div class="item_job_mobile text-center">
                    <a data-toggle="modal" data-target="#contac_employee">
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


<!-- Modal -->
{{--//phuong thuc tu include--}}
<?php $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info(); ?>
{{--//truong hop chua dang nhap--}}
@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)

    <div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <?php $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id); ?>

                    @if(!empty($employer->total_employer_coin))
                        <p class="mgb0 clgreen">
                            Nhà tuyển dụng còn  : {{ number_format($employer->employer_coin )}} điểm

                        </p>
                    @else
                        <p class="mgb0 clgreen">
                            <?php
                            $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                            $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                            $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                            ?>
                            Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm
                        </p>
                    @endif

                    @if(!empty($check_contact_employee))


                        <p class="mgb0"><span>Thông tin liên hệ của ứng viên : <strong>{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</strong></span>
                        </p>  <p class="mgb0"><span>Email : <strong>{{ isset($employee->email) ? $employee->email : '' }}</strong></span>
                        </p>
                        <p class="mgb0">
                            <span>Số điện thoại : <strong>{{ isset($employee->phone) ? $employee->phone : '' }}</strong></span>
                        </p>
                        <p class="mgb10">
                            <span>Link facebook : <strong>{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}</strong></span>
                        </p>
                        @else

                        @endif

                        {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}


                </div>

                <div class="modal-footer" style="text-align: center;display: block">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin liên hệ ứng viên ! <a href="#"
                                                                                                          data-toggle="modal"
                                                                                                          data-target="#loginTiva">
                            Đăng nhập tại đây !</a></p>
                    <p>Nếu bạn chưa có tài khoản bạn có thể <a href="{{ route('employer_register') }}"> Đăng kí tại
                            đây</a></p>
                    {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>

                <div class="modal-footer" style="text-align: center;display: block">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endif