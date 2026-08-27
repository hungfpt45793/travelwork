<?php
    $last_chapter_content= \App\Course\Course_employee_status::where('course_id',$cou['course_id'])
        ->where('employee_id',$employee_id)
        ->orderBy('updated_at','desc')
        ->first();
    if (empty($last_chapter_content)){
        $last_chapter_content=\App\Course\Course_chapter_contents::where('course_id',$cou['course_id'])
            ->orderBy('course_content_id','asc')
            ->first();
    }
    $crr_chapter_id=$last_chapter_content['course_chapter_id'];
    $crr_content_id=$last_chapter_content['course_content_id'];
?>

<div class="col-12  col-md-6 col-lg-3 my-3">
    <a class="card shadow courses_item cust_link" style="color:inherit"
       href="{{route('course_learingCourse',['course_slug'=>$cou['course_slug'],'chapter_id'=>$crr_chapter_id,'content_id'=>$crr_content_id])}}">
        <img
            style="width: 100%;height:198px;"
            src="{{ asset(!empty($cou['course_image'])?$cou['course_image']:'public/images/no_image.png') }}"
            class="card-img-top img-fuild"
            alt="{{!empty($cou['course_title'])?$cou['course_title']:''}}">
        <div class="card-body pt-2">
            <p class="card-text overflow-hidden course_name">{{!empty($cou['course_title'])?$cou['course_title']:''}}</p>
            <div class="percent_rating mt-3">
                <?php
                $progress = \App\Course\Course_employee_status::getProcess($cou['course_id'], $employee_id);

                if ($progress['total'] != 0) {
                    if ($progress['learned'] < $progress['total'])
                        $percent = $progress['learned'] / $progress['total'] * 100;
                    else
                        $percent = 100;
                } else
                    $percent = 0;

                $percent =  number_format($percent);
                ?>

                <div class="percent_learned mb-2">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{$percent}}%"
                             aria-valuenow="{{$percent}}" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="body_percent_rating">
                    <div>
                        <span>Hoàn thành {{ $percent }}%</span><br>
                    </div>
                    <div class="show-rating text-right " id="show-rating-171">
                        <div>
                            @if(isset($cou['star']))
                                @for($i=0;$i<$cou['star'];$i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                            @else
                                <i class="far fa-star "></i>
                                <i class="far fa-star "></i>
                                <i class="far fa-star "></i>
                                <i class="far fa-star "></i>
                                <i class="far fa-star "></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="border-top d-flex justify-content-between pt-3">
                <div class="d-flex align-items-center ">
                    <img class=" rounded-circle user_thump "
                         src="{{!empty($cou['teacher_images'])?$cou['teacher_images']:asset('images/no_image.png')}}"
                         alt="{{!empty($cou['teacher_name'])?$cou['teacher_name']:''}}">
                    <span
                        class="ml-2">{{!empty($cou['teacher_name'])?$cou['teacher_name']:'Đang cập nhật'}}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-check text-secondary mr-1"></i>
                    <span>{{!empty($cou['total_employee'])?$cou['total_employee']:'khóa học mới'}} học viên</span>
                </div>
            </div>
        </div>
    </a>
</div>
