<div class="col-xl-4 col-lg-4 pd0 bdBottomGray bdRightGray hvbgrClick">
    <div class="JobInteresting pd hvBoxShadow">
        <div class="company listEmployee">
            <a href="{{ route('show_detail_emplooyee', ['employee_id' => $employee['employee_id']]) }}" target="_blank"
               class="block pd15 noDecoration CutText100 Postion"  style="padding-bottom: 0">

                <img class="lazy" src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}">
                <span class="textCap black maxTitleVoucher dsBlock">  <b style="vertical-align: bottom;">
         {{ isset($employee['employee_name']) ? \App\Ultility\Ultility::textLimit($employee['employee_name'], 12) : '' }}
                        @if (\Illuminate\Support\Facades\Auth::check())
                            <?php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            ?>
                            @if($user->id == $employee['user_id'] && $user->role == 1)
                                <span> <i class="fas fa-check clgreen mgl5" style="border-radius: 50%;border: 1px solid green"></i></span>
                            @endif
                        @endif
         </b></span>

                <span class=" red itemVoucher "><i class="fas fa-certificate mgr5"></i>
                    {{ isset($employee['career_category_name']) ? $employee['career_category_name'] : 'Nhân viên du lịch'  }}</i>
                </span>

                <span class="block green itemVoucher dsBlock"><i class="fas fa-hand-holding-usd money"></i>
                    <i>{{ isset($employee['description']) ? $employee['description'] : 'Thỏa thuận'  }}</i>

                     <span class="mgl10"><i class="fas fa-id-badge"></i>{{ $employee['profile'] }} điểm hồ sơ</span>
                </span>
                <i>
                    <span class="block gray"><i class="fas fa-map-marker-alt"></i>
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
                        <span class="clgreen float-left" style="border: 1px solid red;padding: 0px 5px"><i class="fas fa-exclamation mgr5 clred" style="border-radius: 50%;"></i>Đã đi làm</span>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)
                        <?php
                        $employer = \App\Entity\Employer::get_employer_id(\Illuminate\Support\Facades\Auth::user()->id);
                        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id,$employee->employee_id)
                        ?>
                        @if(!empty($check_show_employee))
                            <span class="clgreen float-left mgl5" style="border: 1px solid red;padding: 0px 5px"><i class="far fa-eye mgr5 " style="border-radius: 50%;"></i>Đã xem</span>
                        @endif
                    @endif
                    <span class="clorange float-right pdb2">
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
            </a>
        </div>
    </div>
</div>
