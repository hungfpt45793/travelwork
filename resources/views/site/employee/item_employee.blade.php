<div class="col-xl-4 col-lg-4 pd0 bdBottomGray bdRightGray hvbgrClick">
    <div class="JobInteresting pd hvBoxShadow">
        <div class="company listEmployee">

            <a href="{{ route('detail_employee_show', ['employee_slug' => $employee['employee_slug']]) }}" target="_blank"
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
                    <?php $career = App\Entity\Career::getIdCareer($employee['career_category_id'])?>
                    {{ isset($career['career_category_name']) ? $career['career_category_name'] : 'Nhân viên kế toán'  }}</i>
                </span>

                <span class="block green itemVoucher dsBlock"><i class="fas fa-hand-holding-usd money"></i>
                    <?php
                    $salary = \App\Entity\Salary::getIdSalary($employee['salary_id'])
                    ?>
                    <i>{{ isset($salary['description']) ? $salary['description'] : 'Thỏa thuận'  }}</i>

                     <span class="mgl10"><i class="fas fa-id-badge"></i>{{ $employee['profile'] }} % hồ sơ</span>
                </span>

                <?php $distinct = \App\Entity\District::getId($employee['district']) ?>
                <?php $province = \App\Entity\Province::getId($employee['province']) ?>
                <i>
                    <span class="block gray"><i class="fas fa-map-marker-alt"></i>
                        @if(isset($distinct->district_name))
                            {{ $distinct->district_name }} -
                        @endif
                        @if(isset($province->province_name))
                            {{ $province->province_name }}
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