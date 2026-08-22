<div class="form bgrWhite pd10">
    <div class="CropImg CropImg80">
        <a href="{{ route('detailTeacher',['slug'=>$tea->slug]) }}" class="thumbs"
           title="{{ $tea->teacher_name }}">
            <img class="lazy" src="{{ !empty($tea->teacher_images) ? $tea->teacher_images : asset('assets/image/avatarteacher.png') }}" alt="{{ $tea->teacher_name }}" title="{{ $tea->teacher_name }}"
                 width="100%">
        </a>
    </div>
    <div class="nameClass pdt15 maxHeightTitle mgb10">
        <p class="fw7 CutText2 mgb5"><a class="clhome f16" href="{{ route('detailTeacher',['slug'=>$tea->slug]) }}"
                                   title="{{ $tea->teacher_name }}">{{ $tea->teacher_name }}  </a></p>
        <?php $business_type = \App\Entity\TypeOfBusiness::getIdTypeBusiness($tea->business_type_id);?>
        <p class="mgb5">  <i class="fas fa-building mgr5"></i>
            <span class="fw6 dsnonelg"> Lĩnh vực : </span>{{ isset($business_type['type_of_business_name']) ? $business_type['type_of_business_name'] : 'Đang cập nhật' }}</p>
        <p class="mgb0 f12 maxHeightaddress"><i class="fas fa-map-marker-alt mgr5"></i><span class="fw6 dsnonelg">Địa chỉ : </span>
            <?php $district = \App\Entity\District::getId($tea->district); ?>
            @if(!empty($district))
                {{ $district->district_name . ' -' }}
                @endif
            <?php $province = \App\Entity\Province::getId($tea->province);?>
            @if(!empty($province))
                {{ $province->province_name }}
            @endif
        </p>
        <?php
        $countTeacher = \App\Entity\TeacherStar::countTeacher($tea->teacher_id);
        $starAll = \App\Entity\TeacherStar::checkStarTeacher($tea->teacher_id);
        $countStar = \App\Entity\TeacherStar::countTeacher($tea->teacher_id);
        $aumAll = 0;
        foreach ($starAll as $star) {
            $aumAll += $star['qty_stars'];
        }
        if ($countStar > 0) {
            $avgStar = $aumAll / $countStar;
        } else {
            $avgStar = 0;
        }
        ?>
        <div class="mgt5 mgb5 text-center"><span class="fw6 dsnonelg" style="vertical-align: text-bottom;"> Đánh giá : </span>
            <span class="rate-product" style=""></span>
                <script>
                    $(".rate-product").starRating({
                        initialRating: '{{ $avgStar }}',
                        useFullStars: true,
                        starSize: 20,
                        readOnly: true,
                        strokeColor: '#894A00',
                    });
                </script>
        </div>
    </div>
    <div class="buttonRegisterNow textCenter">
        <a href="{{ route('detailTeacher',['slug'=>$tea->slug]) }}"
           class="noDecoration white bgrBlueN block hvWhite pdt5 pdb5">Xem thêm</a>
    </div>
    <!-- form -->
</div>
