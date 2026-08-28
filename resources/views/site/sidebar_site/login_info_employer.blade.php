<div class="row">
    <div class="col-md-4 ">
        <div class="accountThumbnail mgt10 mgb10">
            <?php
            $user = \Illuminate\Support\Facades\Auth::user();
            $id_user = $user->id;
            $role = $user->role;
            $static = $user->status_teacher_sc;
            ?>
            <?php $employer = \App\Entity\Employer::getIdUser($id_user); ?>
            <img class="lazy pdl10"
                 src="{{ !empty($employer->employee_image) ? $employer->employee_image : '/assets/image/no_avatar.jpg'}}"
                 alt="" width="100% ">
        </div>
    </div>
    <div class="col-md-8">
        <div class="accountInfo mgt10 mgb10">
            <h5 class="mgb0">
                {{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}
            </h5>
            <p class="mgb0">
                <span class="clRed dsBlock mgt5 mgb5">
                    <span class="clRed">
                        <i>(Nhà tuyển dụng)</i>
                        @if(!empty($employer->employer_vip))
                        <span>< Vip ></span>
                            @endif
                    </span>
                </span>
            <?php
            $employee_profile = 0;
            $employee_profile = \App\Entity\Employee::get_profile($id_user);
            ?>
            @if(!empty($employer->total_employer_coin))
                <p class="mgb0 clGreen">
                    Điểm : {{ number_format($employer->employer_coin )}} điểm
                    <span data-toggle="modal" data-target="#create_coin"
                          class="btnOrange mg10-0 d-sm-inline-block  bdr3 mgf5"
                          style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                class="fas fa-coins"></i></span>
                </p>
            @else
                <p class="mgb0 clGreen">
                    <?php
                    $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                    $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                    $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                    ?>
                    Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm

                    <span data-toggle="modal" data-target="#create_coin"
                          class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgf5"
                          style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                class="fas fa-coins"></i></span>
                </p>
            @endif
        </div>
    </div>
</div>

@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
    <?php
    $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info();
    ?>
    <div class="modal fade" id="create_coin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn nạp điểm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>

                </div>
            </div>
        </div>
    </div>
@endif

<?php
$check_job_fb_employer = \App\Entity\Employer::check_is_admin($id_user)
?>
<hr class="mgt0">
@if(!empty($check_job_fb_employer))
    <div class="createNew text-center mgb10" data-toggle="tooltip" data-placement="right"
         title="Đăng tin miễn phí">
        <a href="{{ route('job-face-user.create') }}" class="f18 md-f14 btnOrange bdr3">
            <i class="fas disInBlock fa-paper-plane "></i>
            <span class="dnavnone">Đăng tin miễn phí</span></a>
    </div>
@else
    <div class="createNew text-center mgb10" data-toggle="tooltip" data-placement="right"
         title="Đăng tin miễn phí">
        <a href="{{ route('job-user.create') }}" class="f18 md-f14 btnOrange bdr3"><i
                    class="fas disInBlock fa-paper-plane "></i> <span class="dnavnone">Đăng tin miễn
                                phí</span></a>
    </div>
@endif