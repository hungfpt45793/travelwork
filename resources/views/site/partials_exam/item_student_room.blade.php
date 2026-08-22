<?php
$day_date = date('H:i');

$star_date = date_create($teacher_room->time_star_room);
$end_date = date_create($teacher_room->time_end_room);

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
                    $day_date = date_create($teacher_room->day_room);
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

            </ul>
        </div>
        @if($day_time >= $star_minute && $day_time <= $end_minute && empty($end))
            <div class="pull-right Rightimg hidden_show_live">
                <img class="lazy" src="{{ asset('tracnghiem') }}/img/live-now.gif">
            </div>
        @endif
    </div>
    <div class="clearfix"></div>
    <div class="itemQuestion">
        <a @if($day_time >= $star_minute && $day_time <= $end_minute) data-toggle="modal"
           data-target="#room{{ $teacher_room->id_room }}" @endif >
            <h3>{{ $teacher_room->name_room }}</h3>
            <p class="mgBottom0 f15"><strong>Mã phòng thi : </strong> <span
                        style="color: white; padding: 2px 5px;background: #009385;">  {{ $teacher_room->code_room }} </span>
            </p>

            <div class="desRoom">
                <p>
                    {{ $teacher_room->des_room }}
                </p>
            </div>
        </a>

            <div class="buttonRoom">
                <a href="{{ route('detail_room',['id_room'=>$teacher_room->id_room ]) }}">Vào phòng thi</a>
            </div>
        <img class='lazy' src="{{ isset($teacher_room->logo_teacher) ? $teacher_room->logo_teacher : '' }}" style="width: 100px;
    position: absolute;
    right: 25px;
    top: 57px;z-index:1;">

    </div>
</div>


