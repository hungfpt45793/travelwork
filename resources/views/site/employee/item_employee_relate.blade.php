<div class="col-xl-4 col-lg-4 pd0 bdBottomGray bdRightGray hvbgrClick">
    <div class="JobInteresting pd hvBoxShadow">
        <div class="company listEmployee">
            <a href="{{ route('show_emplooyee', ['employee_id' => $employee['employee_id']]) }}" target="_blank"
               class="block pd15 noDecoration CutText100 Postion">

                <img class="lazy" src="{{ !empty($employee['employee_image']) ? $employee['employee_image'] : '/CV/Profile.jpg' }}">
                <span class="textCap black maxTitleVoucher dsBlock">  <b style="vertical-align: bottom;">
         {{ isset($employee['employee_name']) ? \App\Ultility\Ultility::textLimit($employee['employee_name'], 12) : '' }}
         </b></span>

                <span class="block red itemVoucher dsBlock"><i class="fas fa-certificate mgr5"></i>
                    <?php $career = App\Entity\Career::getIdCareer($employee['career_category_id'])?>
                    {{ isset($career['career_category_name']) ? $career['career_category_name'] : ''  }}</i>
                </span>
                <span class="block green itemVoucher dsBlock"><i class="fas fa-hand-holding-usd money"></i>
                    <?php
                    $salary = \App\Entity\Salary::getIdSalary($employee['salary_id'])
                    ?>
                    <i>{{ isset($salary['description']) ? $salary['description'] : ''  }}</i>
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
                <div style="width: 100%;display: inline-block;text-align: right;">
                    <span class="clorange">
                        Ngày tạo hồ sơ :

                    {{--vi bang khoa ngoaiu cia employee cung co create update--}}

                        @if(!empty($employee->updated_at))
                    <?php
                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->updated_at);
                    echo $date_facebook;
                    ?>
                    @else
                    <?php
                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($employee->created_at);
                    echo $date_facebook;
                    ?>
                    @endif


                    </span>
                </div>
            </a>
        </div>
    </div>
</div>