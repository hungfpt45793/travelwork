<?php
$day_date = date('H:i');

$star_date = date_create($room->time_star_room);
$end_date = date_create($room->time_end_room);

$fomat_star_date = date_format($star_date, "H:i");
$fomat_end_date = date_format($end_date, "H:i");

$star_minute = \App\Ultility\ExchangeDate::getMinute($fomat_star_date);
$end_minute = \App\Ultility\ExchangeDate::getMinute($fomat_end_date);
$day_time = \App\Ultility\ExchangeDate::getMinute($day_date);
?>
{{--viet script dung settime hin live--}}
{{--.hidden_show_live--}}
<div class="boxItemRoom">
    <div class="boxItemTop">
        <div class="titletime">
            <ul>
                <li class="">
                    <i class="fas fa-calendar-day mgr5"></i>
                    <?php
                    $day_date = date_create($room->day_room);
                    echo date_format($day_date, "d/m/Y");
                    ?>
                </li>
                <li>
                    <i class="far fa-clock mgr5"></i><?php
                    echo date_format($star_date, "H:i");
                    ?>
                    - <i class="far fa-clock mgr5"></i><?php
                    echo date_format($end_date, "H:i");
                    ?>
                </li>
                <?php
                $total_employee = 0;
                $total_employee = \App\Exam\ResultRoomExam::total_result_room($room->id_room);
                ?>
                <li>
                    Người thi : {{ $total_employee }}
                </li>

            </ul>
        </div>


    </div>
    <div class="clearfix"></div>
    <div class="itemQuestion">
        <a @if($day_time >= $star_minute && $day_time <= $end_minute) data-toggle="modal"
           data-target="#room{{ $room->id_room }}" @endif >
            <h3>{{ $room->name_room }}</h3>
            <p class="mgBottom0 f15"><strong>Mã phòng thi : </strong> <span
                        style="color: white; padding: 2px 5px;background: #009385;">  {{ $room->code_room }} </span>
            </p>

            <div class="desRoom">
                <p class="mgb5">
                    {{ $room->des_room }}
                </p>

            </div>
        </a>
        <div class="buttonRoom hidden_show_live">
            <a href="{{ route('charEmployer',['room_id' => $room->id_room]) }}">Xem kết quả phòng thi</a>
        </div>
        @if(\Illuminate\Support\Facades\Auth::check())
            <?php
            $id_user = \Illuminate\Support\Facades\Auth::user()->id;

            $check_result = \App\Exam\ResultRoomExam::checkUserRoom($room->id_room, $id_user);
            $detail_result_room = array();
            if (!empty($check_result)) {
                $detail_result_room = \App\Exam\DetailResultRoom::countDetailResultRoom($check_result->id_result_room);
            }
            ?>
            @if(!empty($detail_result_room))
                <p>Bạn đã thi phòng này rồi !</p>
            @endif
        @endif


    </div>
</div>


