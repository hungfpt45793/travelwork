<div class="col-xl-12 item_employee_new">
    <a href="{{ route('detail_employee_show', ['employee_slug' => $employee['employee_slug']]) }}" target="_blank"
       class="CutText100" style="padding-bottom: 0;text-decoration: none !important;">
        <div class="row">
            <div class="col-xl-5 col-lg-7 pd0">
                <div class="item_employee_intro">
                    <div class="item_employee_img">
                    <!--{{--<img src="{{ !empty($employee->employee_image) ? asset($employee->employee_image) : '/CV/Profile.jpg' }}">--}}-->
                        <img src="/CV/Profile.jpg">
                    </div>
                    <div class="item_employee_title">
                        <h3 class="f16 clBlack mgt5 js_name">{{ isset($employee['employee_name']) ? \App\Ultility\Ultility::textLimit($employee['employee_name'], 12) : '' }}</h3>
                        <p class="mgb5 clOrange dateUpdate js_date"><i class="far fa-clock"></i>
                            @if(!empty($employee->date_update))
                                <?php
                                $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->date_update);
                                echo $date_facebook;
                                ?>
                            @else
                                <?php
                                $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->date_create);
                                echo $date_facebook;
                                ?>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                                <?php
                                $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
                                $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id)
                                ?>
                                <span class="employee_watched">
                                    @if(!empty($check_show_employee))
                                        <span class="box_job_submit js_check_employee">
                                                <i class="far fa-eye mgr5"></i>Đã xem
                                        </span>
                                    @else
                                        <span class="box_job_submit js_check_employee">
                                        </span>
                                    @endif
                                </span>
                            @endif

                        </p>
                        <p class="mgb5 clBlack cutTitle areaEmployeeWork js_provice_district"><i
                                    class="fas fa-map-marker-alt"></i>

                            @if(isset($employee->province_name))
                                {{ $employee->province_name }}
                            @endif
                            {{--//danh sach quan huyen--}}
                            <?php
                            $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                            ?>
                            @if(!empty($list_district_name))
                                @foreach($list_district_name as $ids=>$district)
                                    <i> | {{ $district->district_name }}</i>
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="uv-info td-cty-lv-gan-day" data-toggle="tooltip" title="" data-trigger="hover"
                     data-original-title="Công việc cần tìm">
                    <?php
                    $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
                    ?>
                        @if(!empty($list_career_name))
                    <p class="mgb5 cutTitle clRed employeeJobLookFor js_career_name">
                        <i class="fas fa-certificate mgr5"></i>


                            @foreach($list_career_name as $id_c=>$career)
                                @if($id_c == 0)
                                    <span> {{ $career->career_category_name }}</span>
                                @else
                                    <span> | {{ $career->career_category_name }}</span>
                                @endif
                            @endforeach

                    </p>
                        @endif
                </div>
                <div class="uv-info td-nam-kinh-nghiem"><i class="li-sun" title="Số năm kinh nghiệm"></i>
                    <p class="mgb5 cutTitle clGreen ">
                        <?php
                        $date_day = date_create();
                        $year_day = date_format($date_day, "Y") - $employee->time_to_work;
                        ?>
                        <i class="fas fa-clipboard-check mgr5"></i><span>  Kinh nghiệm:</span>
                        <span class="employeeExperience js_year">{{ !empty($year_day) ? $year_day   : 1 }}</span>
                        năm
                    </p>
                </div>
                <?php
                $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
                ?>
                @if(!empty($list_business_name))
                    <div class="uv-info td-cty-lv-gan-day" data-toggle="tooltip" title="" data-trigger="hover"
                         data-original-title="Kinh nghiệm trong lĩnh vực">
                        <p class="mgb5 cutTitle experienceInField js_business_name">
                            <i class="fas fa-share-alt mgr5"></i>
                            @foreach($list_business_name as $id_b=>$business)
                                @if($id_b == 0)
                                    <span> {{ $business->business_type_name }}</span>
                                @else
                                    <span> | {{ $business->business_type_name }}</span>
                                @endif
                            @endforeach

                        </p>
                    </div>
                @endif

            </div>
            <div class="col-xl-3 uv_info_item_employee">
                <div class="uv-info td-bang-cap"><i class="li-graduation-hat"></i>
                    <p class="mgb5 js_literacy_name">
                        <?php
                        $employee_level = \App\Entity\Literacy::get_literacy_name($employee->employee_level_id);
                        ?>
                        <i class="fas fa-clipboard-check mgr5"></i> {{ !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật' }}
                    </p>
                </div>
                <div class="uv-info td-diem-ho-so" data-toggle="tooltip" title="" data-trigger="hover"
                     data-original-title="Điểm đánh giá mức độ hoàn tất hồ sơ">
                    <p class="mgb5 clGreen ">
                        <span class="js_profile">  <i class="fas fa-id-badge mgr5"></i> {{ $employee['profile'] }}
                        %</span>
                        <span class="link_detail_item">Chi tiết</span>
                    </p>
                </div>
                <div class="uv-info td-muc-luong" data-toggle="tooltip" title="" data-trigger="hover"
                     data-original-title="Mức lương mong muốn">
                    <p class="mgb5 clRed js_salary">
                        <i class="fas fa-hand-holding-usd mgr5"></i>
                        {{ isset($employee['description']) ? $employee['description'] : 'Thỏa thuận'  }}
                    </p>
                </div>
            </div>
        </div>
    </a>
</div>