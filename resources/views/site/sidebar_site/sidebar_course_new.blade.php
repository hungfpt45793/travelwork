<div class="col-lg-3 col-md-12 siderbar_new" id="">
    <div class="UvNew bgrWhite">
        <div class="title_box_sidebar">
            Danh sách khóa học
        </div>
        <div class="contentsUvNew bdLightGray">

            <?php 
                $isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                , $_SERVER["HTTP_USER_AGENT"]);
                if($isMobile == 1){
                    $limit = 3;
                }
                else{
                    $limit = 10;
                }
                $list_course = \App\Course\Courses::get_courses($limit); 
            ?>
            @if(!empty($list_course))
                @foreach ($list_course as $course)
                    <a href="{{ route('course_showCourseDetail', ['course_slug' => $course->course_slug]) }}"
                       class="NoDecoration linkCourseInVoucher job_post_sidebar">
                        <div class="item_job_post sd_item_course">
                            <div class="sd_image_course">
                                <img src="{{ !empty($course->course_image) ? asset($course->course_image) : '' }}">
                            </div>
                            <div class="sd_image_title">
                                <h3>{{ !empty($course->course_title) ? $course->course_title : '' }}</h3>
                            </div>
                            <p class="sd_course_price text-center pt-3">
                                <span class="font-weight-bold f16">
                                {{ !empty($course->course_discount)? 'Giá bán:' : '' }} {{ !empty($course->course_discount)? number_format($course->course_discount).'đ' : 'Miễn phí' }}
                                </span>
                            </p>
                            <div class="course_star d-flex pt-2">
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
                            <div class="d-flex justify-content-between pt-2">
                                <div class="d-flex align-items-center">
                                    <?php
//                                    $total_employee = \App\Course\Course_employee::get_total_employee($course->course_id);
                                    $total_employee = \App\Course\Course_order::get_total($course->course_id);
                                    ?>
                                    <i class="fas fa-user-check text-secondary mr-1"></i>
                                    <span>{{!empty($total_employee)? $total_employee." học viên" : 'Mới xuất bản'}} </span>
                                </div>
                                <span class="float-right clGreen">
                                    <i class="far fa-eye"></i>
                                     {{ !empty($course->course_views)? number_format($course->course_views) : '' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('course_index') }}" class="link_show_sidebar">Xem thêm</a>
            @else
                <p>
                    Không có dữ liệu
                </p>
            @endif
        </div>
    </div>

</div>