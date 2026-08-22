<section class="tabfillter_intership  mbdsNone">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs mbdsNone" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thực tập theo loại hình doanh nghiệp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Thực tập theo tỉnh thành</a>
                </li>
            </ul>
            <ul class="nav nav-tabs dsNone mbdsBlock" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Doanh nghiệp</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tỉnh thành</a>
                </li>
            </ul>
            <div class="tab-content pd20" id="myTabContent">

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <?php
                        $listtype = \App\Entity\TypeOfBusiness::getAllTypeBusiness();
                        ?>
                        @foreach($listtype as $type)
                            {{--<option value="{{ $type->type_of_business_slug }}"--}}
                            {{--@if($type_of_business_id_get == $type->type_of_business_id) selected @endif--}}
                            {{-->{{ $type->type_of_business_name }}</option>--}}
                            <?php
                            $text = 'tuyen-thuc-tap-ke-toan-cho-'.$type->type_of_business_slug.'?&t='.$type->type_of_business_id;
                            $total_type_of_business_id = 0;
                            //                                                    $total_type_of_business_id = \App\Entity\Employer::getTotalEmployerTypeBusiness($type->type_of_business_id);
                            ?>


                            <div class="col-lg-4 col-md-6 col-6">

                                <a class="linkFillter" href="{{ route('search_intership',['slug'=> $text]) }}"> <p class=" mgb10"><i class="far fa-building f14 mgr5"></i>{{ $type->type_of_business_name }}
                                    </p>
                                </a>
                            </div>

                        @endforeach
                    </div>

                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="remoreBusiness">
                        <div class="row">
                            <?php
                            $getAllProvince = \App\Entity\Province::GetAllProvinces();
                            ?>
                            @foreach($getAllProvince as $province)
                                <?php
                                $text_province = 'tuyen-thuc-tap-ke-toan-tai-'.$province->province_slug.'?&p='.$province->province_id;

                                $total_province = 0;
                                //                                                    $total_province = \App\Entity\Employer::getTotalEmployerProvince($province->province_id);
                                ?>

                                <div class="col-lg-3 col-md-4 col-6">

                                    <a class="linkFillter" href="{{ route('search_intership',['slug'=> $text_province]) }}">
                                        <p class=" mgb10"><i class="fas fa-map-marker-alt f14 mgr5"></i>{{$province->province_name}}
                                        </p>
                                    </a>
                                </div>


                            @endforeach


                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

</section>