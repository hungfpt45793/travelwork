


<section class="Support bgrWhite pd20 supportHotline">
    <div class="notificationBox formJobLarge mt30" style="">
        <div class="titleSupportHotline">
            <p class="supportTitle text-center fontBold f28 lg-f25 blueDN pdt0 mgb20 lg-mgb10 lg-f23 md-f17 sm-f16 mbf14">{{ isset($information['tieu-de-tong-dai-cham-xoc']) ? $information['tieu-de-tong-dai-cham-xoc'] : 'TỔNG ĐÀI TƯ VẤN CHĂM SÓC KHÁCH HÀNG' }}</p>

        </div>
        @php
            $link_detail_teacher = 'https://ketoandichvu.com.vn/chi-tiet-ke-toan-thue/';
            $link_mien_bac = 'https://ketoandichvu.com.vn/danh-sach-ke-toan-thue/khu-vuc-mien-bac';
            $link_mien_trung = 'https://ketoandichvu.com.vn/danh-sach-ke-toan-thue/khu-vuc-mien-trung';
            $link_mien_nam = 'https://ketoandichvu.com.vn/danh-sach-ke-toan-thue/khu-vuc-mien-nam';

            $list_teacher_mb = \App\Entity\List_teacher_agency::getAll(1);
            $list_teacher_mt = \App\Entity\List_teacher_agency::getAll(2);
            $list_teacher_mn = \App\Entity\List_teacher_agency::getAll(3);
        @endphp

        <div class="row text-center">
            @if(!empty($list_teacher_mb))
                <div class="col-lg-4 col-xl-4 col-md-12 col-12 col-sm-12">
                    <div class="itemLocation">
                        <div class="titleLocaltion titleLocaltion1">
                            <i class="fas fa-map-marker-alt"></i>
                            <a target="_blank" href="{{ $link_mien_bac }}">
                                <h3 class="to-way-block-md display-none"> Khu vực Miền Bắc
                                    : {{ isset($information['hotline-mien-bac']) ?  $information['hotline-mien-bac'] : '' }} </h3>
                            </a>
                        </div>
                        <div class="itemContent">
                            <ul class="js_content contentUl3 css_max_height_hotline" id="list-mn">
                                @foreach($list_teacher_mb as $item)
                                    <li>
                                        <a href="{{ !empty($item->teacher_slug) ? $link_detail_teacher.$item->teacher_slug : '#' }}?ktt={{ $item->teacher_id }}"
                                           target="_blank">

                                            <div class="locationMobileIp5">
                                                <i class="fas fa-map-marker-alt iconLocal"></i>
                                                <b class="clgreen" style="text-transform: capitalize;">Khu vực :</b>
                                                @php
                                                    $district_name = 0;
                                                    if (!empty($item->district)) {
                                                        $district_name = \App\Entity\District::get_ditrics($item->district);
                                                    }
                                                @endphp
                                                {{ !empty($district_name) ? $district_name : '' }} {{ $item->province_name }}
                                            </div>
                                            <div class="locationMobileIp5 text-capitalize">
                                                <i class="far fa-user" title="{{$item->teacher_name}}"></i>
                                                <b class="clgreen" style="text-transform: capitalize;">Đại
                                                    diện:</b> {{$item->teacher_name}}
                                            </div>

                                            <div>
                                                <i class="fas fa-building mgr5 iconBuilding"></i>
                                                @if($item->teacher_min > 0)
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    @php
                                                        $date_day_year=date_create();
                                                        $date_year_ex = date_format($date_day_year,"Y") - $item->teacher_min;
                                                    @endphp
                                                    {{ $date_year_ex }} năm làm về du lịch
                                                @else
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    Đang cập nhật
                                                @endif

                                            </div>
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="a_readmore"><a target="_blank" href="{{ $link_mien_bac }}">Xem tất cả du lịch</a></div>
                    </div>
                </div>
            @endif
            @if(!empty($list_teacher_mt))
                <div class="col-lg-4 col-xl-4 col-md-12 col-12 col-sm-12">
                    <div class="itemLocation">
                        <div class="titleLocaltion titleLocaltion1">
                            <i class="fas fa-map-marker-alt"></i>
                            <a target="_blank" href="{{ $link_mien_trung }}">
                                <h3 class="to-way-block-md display-none"> Khu vực Miền Trung
                                    : {{ isset($information['hotline-mien-trung']) ?  $information['hotline-mien-trung'] : '' }} </h3>
                            </a>
                        </div>
                        <div class="itemContent">
                            <ul class="js_content contentUl3 css_max_height_hotline" id="list-mn">
                                @foreach($list_teacher_mt as $item)
                                    <li>
                                        <a href="{{ !empty($item->teacher_slug) ? $link_detail_teacher.$item->teacher_slug : '#' }}?ktt={{ $item->teacher_id }}"
                                           target="_blank">

                                            <div class="locationMobileIp5">
                                                <i class="fas fa-map-marker-alt iconLocal"></i>
                                                <b class="clgreen" style="text-transform: capitalize;">Khu vực :</b>
                                                @php
                                                    $district_name = 0;
                                                    if (!empty($item->district)) {
                                                        $district_name = \App\Entity\District::get_ditrics($item->district);
                                                    }
                                                @endphp
                                                {{ !empty($district_name) ? $district_name : '' }} {{ $item->province_name }}
                                            </div>
                                            <div class="locationMobileIp5 text-capitalize">
                                                <i class="far fa-user" title="{{$item->teacher_name}}"></i>
                                                <b class="clgreen" style="text-transform: capitalize;">Đại
                                                    diện:</b> {{$item->teacher_name}}
                                            </div>
                                            <div>
                                                <i class="fas fa-building mgr5 iconBuilding"></i>
                                                @if($item->teacher_min > 0)
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    @php
                                                        $date_day_year=date_create();
                                                        $date_year_ex = date_format($date_day_year,"Y") - $item->teacher_min;
                                                    @endphp
                                                    {{ $date_year_ex }} năm làm về du lịch
                                                @else
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    Đang cập nhật
                                                @endif

                                            </div>

                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="a_readmore"><a target="_blank" href="{{ $link_mien_trung }}">Xem tất cả về du lịch</a></div>
                    </div>
                </div>
            @endif
            @if(!empty($list_teacher_mn))
                <div class="col-lg-4 col-xl-4 col-md-12 col-12 col-sm-12">
                    <div class="itemLocation">
                        <div class="titleLocaltion titleLocaltion1">
                            <i class="fas fa-map-marker-alt"></i>
                            <a target="_blank" href="{{ $link_mien_nam }}">
                                <h3 class="to-way-block-md display-none"> Khu vực Miền Nam
                                    : {{ isset($information['hotline-mien-nam']) ?  $information['hotline-mien-nam'] : '' }} </h3>
                            </a>
                        </div>
                        <div class="itemContent">
                            <ul class="js_content contentUl3 css_max_height_hotline" id="list-mn">
                                @foreach($list_teacher_mn as $item)
                                    <li>
                                        <a href="{{ !empty($item->teacher_slug) ? $link_detail_teacher.$item->teacher_slug : '#' }}?ktt={{ $item->teacher_id }}"
                                           target="_blank">

                                            <div class="locationMobileIp5">
                                                <i class="fas fa-map-marker-alt iconLocal "></i>
                                                <b class="" style="text-transform: capitalize;">Khu vực :</b>
                                                @php
                                                    $district_name = 0;
                                                    if (!empty($item->district)) {
                                                        $district_name = \App\Entity\District::get_ditrics($item->district);
                                                    }
                                                @endphp
                                                {{ !empty($district_name) ? $district_name : '' }} {{ $item->province_name }}
                                            </div>
                                            <div class="locationMobileIp5 text-capitalize">
                                                <i class="far fa-user" title="{{$item->teacher_name}}"></i>
                                                <b class="clgreen" style="text-transform: capitalize;">Đại
                                                    diện:</b> {{$item->teacher_name}}
                                            </div>
                                            <div>
                                                <i class="fas fa-building mgr5 iconBuilding"></i>
                                                @if($item->teacher_min > 0)
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    @php
                                                        $date_day_year=date_create();
                                                        $date_year_ex = date_format($date_day_year,"Y") - $item->teacher_min;
                                                    @endphp
                                                    {{ $date_year_ex }} năm làm về du lịch
                                                @else
                                                    <b class="clgreen" style="text-transform: capitalize;">

                                                        Kinh nghiệm:</b>
                                                    Đang cập nhật
                                                @endif

                                            </div>
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="a_readmore"><a target="_blank" href="{{ $link_mien_nam }}">Xem tất cả về du lịch</a></div>
                    </div>
                </div>
            @endif


        </div>


    </div>
</section>

