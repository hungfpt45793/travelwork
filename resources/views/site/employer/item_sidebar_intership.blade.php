<div class="row itemPostSale itemIntership">
    <div class="col-lg-3 pdr0">
        <div class="imagePostSale">
            <a class="z-depth-1"
               href="{{ route('detail_intership',['slug'=>$employerstar['slug'] ]) }}"
               title="{{ isset($employerstar->enterprise_name) ? \App\Ultility\Ultility::textLimit($employerstar->enterprise_name, 12) : '' }}">
                <div class="CropImg CropImg60 CropImgMB60">
                    <div class="thumbs">
                        <img class="responsive-img lazy"
                             src="{{ !empty($employerstar->image) ? $employerstar->image : asset('assets/image/tuyendung.jpg') }}"
                             alt="{{ isset($employerstar->enterprise_name) ? $employerstar->enterprise_name : '' }}"
                             title="{{ isset($employerstar->enterprise_name) ? $employerstar->enterprise_name : '' }}">
                    </div>
                </div>
            </a>

            <p class="mgb0 mgt5 text-center limiEmail">
                <span class="green  f14 dsInline mgr10 relative-4px"><i class="fas fa-eye f16"></i> {{ isset($employerstar->view) ? $employerstar->view : '0' }} </span>
            </p>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="contentPostSale">
            <a href="{{ route('detail_intership',['slug'=>$employerstar['slug'] ]) }}" class=""><h3 class="clorang f14 fw6">{{ isset($employerstar->enterprise_name) ? \App\Ultility\Ultility::textLimit($employerstar->enterprise_name, 10) : '' }}</h3></a>

            <?php $distinct_star = \App\Entity\District::getId($employerstar['district']) ?>
            <?php $province_star = \App\Entity\Province::getId($employerstar['province']) ?>
            <p class="mgb0 gray f12"><i
                        class="fas fa-map-marker-alt gray"></i> @if(isset($distinct_star->district_name))
                    {{ $distinct_star->district_name }} -
                @endif
                @if(isset($province_star->province_name))
                    {{ $province_star->province_name }}
                @endif</p>


            <div class="descriptionPostSale">
                <?php
                $countTeacher = \App\Entity\StarEmployer::countEmployer($employerstar->employer_id);
                $sum_star = \App\Entity\StarEmployer::sumStarEmployer($employerstar->employer_id);
                $countStar = \App\Entity\StarEmployer::countEmployer($employerstar->employer_id);

                if ($countStar > 0) {
                    $avgStar = $sum_star / $countStar;
                } else {
                    $avgStar = 0;
                }
                ?>
                <span class="fw6 dsnonelg"
                      style="vertical-align: text-bottom;"> Đánh giá : </span> <span
                        class="rate-product" style=""></span>
                <script>
                    $(".rate-product").starRating({
                        initialRating: '{{ $avgStar }}',
                        useFullStars: true,
                        starSize: 22,
                        readOnly: true,
                        strokeColor: '#894A00',
                    });
                </script>
                </span>
            </div>
            <p class="mgb0">
                </span>
            </p>
        </div>

    </div>
</div>