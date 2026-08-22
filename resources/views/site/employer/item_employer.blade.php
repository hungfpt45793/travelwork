<div class="col-lg-12">
    <div class="row itemPostSale itemEmployer">
        <div class="col-max-2 col-xl-3 col-lg-3 col-md-5 mbdsNone">
            <div class="imagePostSale">
                <a class="z-depth-1"
                   href="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}"
                   title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">
                    <div class="CropImg CropImg50 CropImgMB60">
                        <div class="thumbs">
                            <img class="responsive-img lazy"
                                 src="{{ isset($employer['image']) ? $employer['image'] : 'assets/image/tuyendung.jpg'}}"
                                 alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"
                                 title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">
                        </div>
                    </div>

                </a>
                <div class="text-center">
                <span class="checkintership" style=""><i class="far fa-paper-plane"></i> Tuyển thực tập</span>
                </div>
            </div>
        </div>
        <div class="col-max-10 col-xl-9 col-lg-9 col-md-7">
            <div class="contentPostSale">
                <a href="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}" class=""><h3
                            class="clorang f18 fw6">{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}</h3>
                </a>
                <div class="text-center dsNone mbdsBlock">
                    <span class="checkintership" style=""><i class="far fa-paper-plane"></i> Tuyển thực tập</span>
                </div>
                <p class="mgb5">
                    </span>
                    <?php $distinct = \App\Entity\District::getId($employer['district']) ?>
                    <?php $province = \App\Entity\Province::getId($employer['province']) ?>
                    <i>
                    <span class="gray  f14 dsInline mgr10"><i class="fas fa-map-marker-alt f16"></i>
                        @if(isset($distinct->district_name))
                            {{ $distinct->district_name }} -
                        @endif
                        @if(isset($province->province_name))
                            {{ $province->province_name }}
                        @endif
                    </span>
                        @if(!empty($employer['website']))

                            <span class="dsInline">
                                <span class="green  f14 dsInline mgr10"><i class="fab fa-internet-explorer f16"></i> {{ $employer['website'] }}</span>
                            </span>

                        @endif

                    </i>
                </p>
                <div class="descriptionPostSale">
                    <?php
                    $countTeacher = \App\Entity\StarEmployer::countEmployer($employer->employer_id);
                    $sum_star = \App\Entity\StarEmployer::sumStarEmployer($employer->employer_id);
                    $countStar = \App\Entity\StarEmployer::countEmployer($employer->employer_id);

                    if ($countStar > 0) {
                        $avgStar = $sum_star / $countStar;
                    } else {
                        $avgStar = 0;
                    }
                    ?>

                    <div class=" text-left starItemEmployer"><span class="fw6 dsnonelg" style="vertical-align: text-bottom;"> Đánh giá : </span>
                        <span
                                class="rate-product mgr10" style=""></span>
                        <script>
                            $(".rate-product").starRating({
                                initialRating: {{ $avgStar }},
                                useFullStars: true,
                                starSize: 22,
                                readOnly: true,
                                strokeColor: '#894A00',
                            });
                        </script>
                        </span>
                        @if(!empty($employer['view']))
                        <span class="green  f14 dsInline mgr10 relative-4px"><i class="fas fa-eye f16"></i> {{ $employer['view'] }} lượt xem</span>
                        @endif
                        @if(!empty($employer['status_allowance']))
                        <span class="red  f14 dsInline mgr10 relative-4px"><i class="fab fa-rebel f16"></i> Có phụ cấp </span>
                            @endif



                        @if(!empty($employer->type_of_business_id))
                            <?php
                            $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
                            ?>
                        <span class="clhome  f14 dsInline mgr10 relative-4px"> <i class="far fa-building f16"></i> {{ $type_of_business->type_of_business_name }} </span>
                            @endif



                    </div>
                </div>
                <a href="{{ route('detail_intership',['slug'=>$employer['slug'] ]) }}" class="link">Xem thêm</a>
            </div>

        </div>
    </div>

</div>


