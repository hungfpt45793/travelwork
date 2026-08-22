<div class="col-lg-12">
    <div class="row itemPostSale itemEmployer">
        <div class="col-max-2 col-xl-3 col-lg-3 col-md-5 mbdsNone">
            <div class="imagePostSale">


                <a class="z-depth-1"
                   href="{{ route('detail_employer',['slug'=>$employer['slug'] ]) }}"
                   title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">



                    {{--<img src="public/library_employer/hoaquaphuclinh%40gmail.com-549/images/phuclinh.png">--}}
                    <div class="CropImg CropImg60 CropImgMB60">
                        <div class="thumbs">
                            <?php $external_link = asset($employer['image']);?>
                           
                            <img class="responsive-img lazy"
                                 src="{{ isset($employer['image']) ? asset($employer['image']) : 'assets/image/avatarEmployer.png'}}"
                                 alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"
                                 title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">
                              
                        </div>
                    </div>

                </a>

            </div>
        </div>
        <div class="col-max-10 col-xl-9 col-lg-9 col-md-7">
            <div class="contentPostSale">
                <a href="{{ route('detail_employer',['slug'=>$employer['slug'] ]) }}" class=""><h3
                            class="clorang f18 fw6">{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}</h3>
                </a>

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
                            <a class="dsInline">
                                <span class="green  f14 dsInline mgr10"><i class="fab fa-internet-explorer f16"></i> {{ $employer['website'] }}</span>
                            </a>

                        @endif
                        {{--@if(!empty($employer['phone']))--}}
                            {{--<span class="red  f14 dsInline mgr10"><i class="fas fa-phone-alt f16"></i> {{ $employer['phone'] }}</span>--}}
                        {{--@endif--}}
                    </i>
                </p>
                <div class="descriptionPostSale mbdsNone">


                    <div class=" text-left starItemEmployer">
                        <span class="rate-product mgr10" style="">
                             <a href="{{ route('detail_employer',['slug'=>$employer['slug'] ]) }}" class="link">Chi tiết</a>
                        </span>


                        @if(!empty($employer['view']))
                            <span class="green  f14 dsInline mgr10 relative-4px"><i class="fas fa-eye f16"></i> {{ $employer['view'] }} lượt xem</span>
                        @endif




                        @if(!empty($employer->type_of_business_id))
                            <?php
                            $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
                            ?>
                            <span class="clhome  f14 dsInline mgr10 relative-4px"> <i class="far fa-building f16"></i> {{ isset($type_of_business->type_of_business_name) ? $type_of_business->type_of_business_name : '' }} </span>
                        @endif



                    </div>
                </div>

                <div class="descriptionPostSale dsNone mbdsBlock">

                    <div class=" text-left starItemEmployer">


                        @if(!empty($employer->type_of_business_id))
                            <?php
                            $type_of_business = \App\Entity\TypeOfBusiness::getIdTypeBusiness($employer->type_of_business_id);
                            ?>
                            <span class="clhome  f14 dsInline mgr10 relative-4px"> <i class="far fa-building f16"></i> {{ isset($type_of_business->type_of_business_name) ? $type_of_business->type_of_business_name : ''}} </span>
                        @endif
                            @if(!empty($employer['view']))
                                <span class="green  f14 dsInline mgr10 relative-4px"><i class="fas fa-eye f16"></i> {{ $employer['view'] }} lượt xem</span>
                            @endif
                            <span class="rate-product mgr10" style="display:block">
                             <a href="{{ route('detail_employer',['slug'=>$employer['slug'] ]) }}" class="link">Chi tiết</a>
                        </span>



                    </div>
                </div>

            </div>

        </div>
    </div>

</div>


