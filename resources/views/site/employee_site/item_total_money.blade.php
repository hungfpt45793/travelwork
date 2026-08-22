
<div class="row">
    <div class="col-lg-12">
        @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1 )
            <?php
            $employee_static = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
            $employee_coints_static = \App\Entity\Employee_coins::get_id($employee_static->employee_id);
            $employee_money_intro = \App\Entity\Employee_intro_employer::sum_total_money_employee(\Illuminate\Support\Facades\Auth::user()->id);
            ?>
            <div class="title mgb20 mgt20">
                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10">
                    Tổng số lượt chia sẻ : <span class="red">{{ isset($employee_coints_static->total_sale) ? number_format($employee_coints_static->total_sale) : 0 }}
                        chia sẻ</span>
                </h5>

                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10">
                    Tổng số tiền nhận được khi giới thiệu nhà tuyển dụng : <span class="red">{{ isset($employee_money_intro) ? number_format($employee_money_intro) : 0 }}
                        VND </span>
                </h5>

                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10">
                    Tổng số tiền trong tài khoản : <span class="red">{{ isset($employee_coints_static->total_money) ? number_format($employee_coints_static->total_money) : 0 }}
                        VND </span>
                </h5>
                <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10">
                    Số dư trong tài khoản :
                    <span class="red">{{ isset($employee_coints_static->money) ? number_format($employee_coints_static->money) : 0 }}
                        VND </span>
                </h5>

            </div>
        @endif
    </div>

</div>
<div class="NoteTransaction">
    {!! isset($information_money['quy-dinh-chung-ve-rut-tien-va-doi-thuong']) ? $information_money['quy-dinh-chung-ve-rut-tien-va-doi-thuong'] : '' !!}
</div>

<hr>
