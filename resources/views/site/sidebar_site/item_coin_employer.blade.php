<div class="row">
    <div class=" col-md-6 mgt5">
        <div class="btn_info_employee mgb5">
            <?php
            $view_profile = 2;
            $view_apply = 1;
            $carra = \App\Entity\Career::check_view_coint($employee->employee_id);
            if (!empty($carra)) {
                $view_profile = $carra->view_profile;
                $view_apply = $carra->view_apply;
            }
            ?>
            <form id="show_info_cv_detail_employee" action="{{ route('show_info_cv_detail_employee') }}"
                  method="post">

                <?php
                $view_profile = 2;
                $view_apply = 1;
                $carra = \App\Entity\Career::check_view_coint($employee->employee_id);
                if (!empty($carra)) {
                    $view_profile = $carra->view_profile;
                    $view_apply = $carra->view_apply;
                }
                ?>

                <div class="btn_info_employee" style="padding: 0">
                    <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                    <a type="submit" class="clwhite submit_show_info_cv_detail_employee" style="background: none;
    border: none;">
                        <i class="fas fa-id-card-alt mgr5"></i> Xem Thông tin liên hệ của ứng viên
                        ( {{ $view_profile }} điểm ) <i
                                class="fas fa-id-card-alt mgf5"></i>
                    </a>
                        @else
                        <a type="submit" class="clwhite" style="background: none;
    border: none;" data-toggle="modal" data-target="#contac_employee">
                            <i class="fas fa-id-card-alt mgr5"></i> Xem Thông tin liên hệ của ứng viên
                            ( {{ $view_profile }} điểm ) <i
                                    class="fas fa-id-card-alt mgf5"></i>
                        </a>

                    @endif

                </div>

            </form>
            <script>
                $('.submit_show_info_cv_detail_employee').click(function () {
                    $('#show_info_cv_detail_employee').submit();
                })
            </script>
        </div>
        <br>
        <div class="btn_info_employee">
            <a class="clwhite"
               href="{{ route('invitation_apply_detail_employee',['employee_id'=>$employee->employee_id]) }}">
                <i class="fas fa-id-card-alt mgr5"></i> Mời ứng viên ứng tuyển ( {{ $view_apply }} điểm ) <i
                        class="fas fa-id-card-alt mgf5"></i>
            </a>
        </div>
    </div>


    @if(!empty($employer))
        <div class=" col-md-6 mgt5">
            <h3 class="f20 fw6 clgreen"> {{ isset($employer->enterprise_name) ? $employer->enterprise_name : ''}}</h3>
            @if(!empty($employer->total_employer_coin))
                <p class="mgb0 clgreen">
                    Điểm : {{ number_format($employer->employer_coin )}} điểm
                    <span data-toggle="modal" data-target="#create_coin"
                          class="btnOrange mg10-0 d-sm-inline-block  bdr3 mgl10"
                          style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                class="fas fa-coins"></i></span>

                    <a href="{{ route('list_job_face') }}" target="_blank"
                       class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                       style="padding: 5px 15px;cursor: pointer">Hồ sơ NTD </a>
                </p>
            @else

                <p class="mgb0 clgreen">
                    <?php
                    $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();
                    $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
                    $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;
                    ?>
                    Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm

                    <span data-toggle="modal" data-target="#create_coin"
                          class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                          style="padding: 5px 15px;cursor: pointer">Nạp điểm <i
                                class="fas fa-coins"></i></span>

                    <a href="{{ route('list_job_face') }}" target="_blank"
                       class="btnOrange mg10-0 d-sm-inline-block mgb10 bdr3 mgl10"
                       style="padding: 5px 15px;cursor: pointer">Hồ sơ NTD </a>

                </p>
            @endif
        </div>
    @endif
</div>
