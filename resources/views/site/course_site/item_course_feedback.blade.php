<div class="col-12 col-md-6 col-lg-3 my-3">
    <div class="card shadow " style="">
        <div class="card-body pt-2">
            <div class=" row pt-3">
                <div class="col-3">
                    <img class=" rounded-circle user_thump "
                         style="width: 3rem; height:3rem;"
                         src="https://blog.cpanel.com/wp-content/uploads/2019/08/user-01.png"
                         alt=""/>
                </div>
                <div class="col pl-0">
                    <div class="course_star">
                        <p class="user_name mb-1 ">{{ !empty($feedback['employee_name'])?$feedback['employee_name']:'' }}</p>
                        <div class="text-warning " style="font-size: 1rem;">
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
                    </div>
                </div>
            </div>
            <p class="text-secondary overflow-hidden feedback_body pt-3">
                {{ $feedback['course_feedback_descript'] }}
            </p>

        </div>
    </div>

</div>
