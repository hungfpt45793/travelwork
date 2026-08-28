<div class="col-12  col-md-6 col-lg-3 my-3">
    <a class="card shadow courses_item cust_link" style=""
       href="{{route('course_showCourseDetail',['course_slug'=>!empty($course['course_slug'])?$course['course_slug']:'not-found'])}}">
        <img
            style="width: 100%;height:198px;"
            src="{{ asset(!empty($course['course_image'])?$course['course_image']:'public/images/no_image.png') }}"
            class="card-img-top img-fuild"
            alt="{{!empty($course['course_title'])?$course['course_title']:''}}">
        <div class="card-body pt-2">
            <p class="card-text overflow-hidden course_name">{{!empty($course['course_title'])?$course['course_title']:''}}</p>
            <div class="course_star d-flex">

                <div class="text-warning mr-3">
                    @if(isset($course['star']))
                        @for($i=0;$i<$course['star'];$i++)
                            <i class="fa fa-star "></i>
                        @endfor
                    @else
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                        <i class="fa fa-star "></i>
                    @endif
                </div>

                <div class="mx-2 ">
                    <strong>  @if(!is_null($course['star'])){{$course['star']}}@else
                            5 @endif </strong>
                    ({{ isset($course['total_feedback'])? $course['total_feedback']:'0' }}
                    đánh giá)
                </div>
            </div>
            <div class="mt-1 ">
                <i class="fas fa-eye mr-1"></i>
                <span>{{ !empty($course->course_views)? number_format($course['course_views']) :'0' }} lượt xem</span>
            </div>
            <?php
                $course_min = \App\Entity\Learn_training::min_learn_discount($course->course_id);
            ?>
            <?php
            if (empty($course_min->learn_discount)) {
                $percent = 0;
            } else {
                $percent = ceil((1 - $course_min->learn_discount / $course_min->learn_price) * 100);
            }
            ?>
            <div class="d-flex justify-content-between align-items-center my-3 ">
                <div class="text-danger" style="font-size: 1.2rem;">
                    {{ !empty($course_min->learn_discount) ? number_format($course_min->learn_discount).'đ' : 'Miễn phí' }}
                </div>
                <div class="text-secondary"  style="text-decoration: line-through;">
                    {{ !empty($course_min->learn_price) ? number_format($course_min->learn_price).'đ' : '' }}
                </div>
            </div>

            <div class="border-top d-flex justify-content-between pt-3">
                <div class="d-flex align-items-center ">
                    <img class=" rounded-circle user_thump "
                         src="{{!empty($course['teacher_images'])?$course['teacher_images']:asset('images/no_image.png')}}"
                         alt="{{!empty($course['teacher_name'])?$course['teacher_name']:''}}">
                    <span
                        class="ml-2">{{!empty($course['teacher_name'])?$course['teacher_name']:'Đang cập nhật'}}</span>
                </div>
                <div class="d-flex align-items-center">
                    <?php
                    $total_employee = \App\Course\Course_order::where('course_id',$course->course_id)->count();
                    ?>
                    <i class="fas fa-user-check text-secondary mr-1"></i>
                    <span>{{!empty($total_employee)? $total_employee." học viên" : 'Mới xuất bản'}} </span>
                </div>
            </div>
        </div>
    </a>

</div>
