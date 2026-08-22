<div class="form bgrWhite pd15 radius10 bdLightGray">
    <div class="CropImg">
        <a href="{{ route('detailCourse',['slug'=>$course->slug]) }}" class="thumbs" title="{{ $course->course_name }}">
            <img class="lazy" data-src="{{ $course->course_image }}" alt="{{ $course->course_name }}"
                 width="100%">
        </a>
    </div>
    <div class="iconTeacher">
        <img class="lazy" data-src="{{ $course->teacher_images }}" alt=""
             class="bd3orange radius50p absolute top27p z3"
             width="60"
             height="60">
        <span class="absolute top31p left85x bgrOrange pdl20 pdr20 fw6 white z1">{{ $course->teacher_name }}</span>
    </div>
    <div class="nameClass pdt35 maxHeightTitle mgb10">

        <p class="fw7 CutText2"> <a class="clhome f16" href="{{ route('detailCourse',['slug'=>$course->slug]) }}"
                                    title="{{ $course->course_name }}">{{ $course->course_name }}  </a></p>


    </div>
    <div class="time maxHeightDes">
        <p class="mgb0"><i class="far fa-calendar-alt"></i><span
                    class="fw6"> Thời gian: </span> {{ $course->course_time }}
        </p>
        <p class="mgb0"><span class="fw6">Giới thiệu khóa học : </span>
            {{ \App\Ultility\Ultility::textLimit($course->course_intro , 20) }}
        </p>

    </div>
    <div class="price mgb15">
        {{--<span>4 sao</span>--}}
        <span class="red f23 fw6">{{ number_format( intval($course->course_price)) }} đ </span>
    </div>
    <div class="buttonRegisterNow textCenter">
        <a href="{{ route('detailCourse',['slug'=>$course->slug]) }}" class="noDecoration white bgrBlueN block hvWhite pdt5 pdb5">Xem thêm</a>
    </div>
    <!-- form -->
</div>