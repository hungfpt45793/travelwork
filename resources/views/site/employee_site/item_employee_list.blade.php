<link rel="stylesheet" type="text/css" href="/public/assets/web/css/modal_detail_cv_employee.css"/>
<link rel="stylesheet" type="text/css" href="/public/assets/web/css/star-rating-svg.css"/>
<div class="col-xl-4 col-lg-4 item_employee">

    <!-- <a href="{{ route('show_detail_emplooyee', ['employee_id' => $employee['employee_id']]) }}" target="_blank"
       class="CutText100" style="padding-bottom: 0"> -->
       <a class="modal_employee_cv text-success" data-toggle="modal" data-id="{{ $employee->employee_id }}" data-target="#detailEmployee" href="#">
        <div class="content_item_employee">
            <img class="lazy"
                 src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}">

            <span class="item_title_employee">
         {{ isset($employee['employee_name']) ? \App\Ultility\Ultility::textLimit($employee['employee_name'], 12) : '' }}
                @if (\Illuminate\Support\Facades\Auth::check())
                    <?php
                    $user = \Illuminate\Support\Facades\Auth::user();
                    ?>
                    @if($user->id == $employee['user_id'] && $user->role == 1)
                        <span> <i class="fas fa-check clgreen mgl5"
                                  style="border-radius: 50%;border: 1px solid green"></i></span>
                    @endif
                @endif
       </span>

            <span class="item_title_career"><i class="fas fa-certificate mgr5"></i>
                {{ isset($employee['career_category_name']) ? $employee['career_category_name'] : 'Nhân viên du lịch'  }}</i>
                </span>

            <span class="item_title_description"><i class="fas fa-hand-holding-usd clOrange"></i>
                    <i class="clGreen">{{ isset($employee['description']) ? $employee['description'] : 'Thỏa thuận'  }}</i>

                     <span class="mgl10 clGreen"><i class="fas fa-id-badge mgr5"></i>{{ $employee['profile'] }} điểm hồ sơ</span>
                </span>
            <i>
                    <span class="item_title_province_district"><i class="fas fa-map-marker-alt"></i>
                        @if(isset($employee->district_name))
                            {{ $employee->district_name }} -
                        @endif
                        @if(isset($employee->province_name))
                            {{ $employee->province_name }}
                        @endif
                    </span>
            </i>

            <div class="mgt5" style="width: 100%;display: inline-block;">
                @if($employee['status'] == 1)
                    <span class="box_job_submit mgr5"><i class="fas fa-exclamation mgr5 clred"></i>Đã đi làm</span>
                @endif
                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                    <?php
                    $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
                    $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id)
                    ?>
                    @if(!empty($check_show_employee))
                            <span class="box_job_submit"><i class="far fa-eye mgr5"></i>Đã xem</span>
                    @endif
                @endif
                <span class="clOrange float-right">
                        Ngày tạo hồ sơ :
                    {{--vi bang khoa ngoaiu cia employee cung co create update--}}
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
                    </span>
            </div>
        </div>
    </a>
</div>
<!-- modal xem cv -->
@include('site.employee_site.modal_detail_cv_employee')
<!-- code js suw ly trong modal xem cv -->
@include('site.employee_site.modal_detail_cv_employee_js')
<script type="text/javascript" src="/public/assets/js/jquery.star-rating-svg.js"></script>
<script type="text/javascript" src="/public/assets/js/sweetalert.min.js"></script>
<!-- thu vien alert -->

