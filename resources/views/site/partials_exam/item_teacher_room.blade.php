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
<div class="boxItemRoom">

    <div class="itemQuestion">
        <a href="{{ route('getRomAllTeacher',['teacher_sc_id'=> $teacher_room->teacher_sc_id]) }}">
            <h3> Giảng viên : {{ $teacher_room->teacher_sc_name }}</h3>
            <div class="desRoom">
                <p>
                   {{ $teacher_room->teacher_school }}
                </p>
            </div>
        </a>

        <div class="buttonRoom">
            <a href="{{ route('getRomAllTeacher',['teacher_sc_id'=> $teacher_room->teacher_sc_id]) }}">Danh sách phòng thi</a>
        </div>
        <img class="lazy" src="{{ isset($teacher_room->logo_teacher) ? $teacher_room->logo_teacher : '' }}" style="width: 100px;
    position: absolute;
    right: 25px;
    top: 5px;z-index:1;">

    </div>
</div>


