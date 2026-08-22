@extends('site.layout_site.site')

@section('title', 'Danh sách cổng thực tập')
@section('meta_description', 'Danh sách cổng thực tập')
@section('keywords', 'Danh sách cổng thực tập')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/money.css"/>

@endsection

@section('content')
    <section class="content_money">
        <div class="container container_w_1200">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link_breakcrum mbdsNone pd0" style="padding-left: 0px">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item ">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ route('list_employer') }}">Kiếm tiền từ cổng thực tập</a>
                            </li>
                        </ul>
                    </div>

                    {{--@include('site.employee.item_list_redeem')--}}
                    @include('site.employee.item_total_money')

                    <section class="tab_link" id="js_tab_link">
                        <ul>
                            <li>
                                <a href="{{ route('list_post') }}#js_tab_link"> Bài viết</a>
                            </li>
                            <li>
                                <a href="{{ route('list_course') }}#js_tab_link">Khóa học</a>
                            </li>
                            <li>
                                <a href="{{ route('list_voucher') }}#js_tab_link">Sản phẩm của dev</a>
                            </li>
                            <li>
                                <a href="{{ route('list_employer') }}#js_tab_link" class="active"> <i class="fa fa-check mgr5"
                                                                                          aria-hidden="true"></i>Cổng
                                    thực tập</a>
                            </li>
                            <li>
                                <a href="{{ route('list_job') }}#js_tab_link">Tin tuyển dụng</a>
                            </li>
                            <li>
                                <a href="{{ route('list_intership') }}#js_tab_link">Tin thực tập</a>
                            </li>
                            <li>
                                <a href="{{ route('redeem_rewards') }}#js_tab_link">Đổi thưởng</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction_history') }}#js_tab_link">Lịch sử</a>
                            </li>
                        </ul>
                    </section>
                    <section class="content_tab_money">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">Danh sách cổng thực tập</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Thống kê</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @if(!empty($list_employer))
                                    @foreach($list_employer as $id=>$employer)
                                        <div class="row itemPostSale">
                                            <div class="col-lg-2">
                                                <div class="imagePostSale">
                                                    <a class="z-depth-1"
                                                       href="{{ route('detail_intership', ['slug' => $employer->slug]) }}"
                                                       title="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}">
                                                        <div class="CropImg CropImg60 CropImgMB60">
                                                            <div class="thumbs">
                                                                @if(!empty($employer->image))
                                                                    <img class="responsive_img"
                                                                         src="{{ isset($employer->image) ? $employer->image : '' }}"
                                                                         alt="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}"
                                                                         title="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}">
                                                                @else
                                                                    <img class="responsive_img"
                                                                         src="{{ asset($information['logo']) }}"
                                                                         alt="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}"
                                                                         title="{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="contentPostSale">
                                                    <a href="{{ route('detail_intership', ['slug' => $employer->slug]) }}"
                                                       class=""><h3 class="clorang f20 fw6 cutTitle">{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}</h3>
                                                    </a>
                                                    <p class="mgb5">
                                                        <?php
                                                        $total_sum_share = \App\Entity\Employer_sale_statistical::getTotalShare($employer->employer_id);
                                                        //
                                                        $total_sum_view_share = \App\Entity\Employer_sale_statistical::getTotalViewSale($employer->employer_id);
                                                        ?>
                                                        Đăng bởi: <span class="fw6"> Admin </span>
                                                        - Ngày đăng : <span class="fw6"><?php
                                                            $date = date_create($employer->updated_at);
                                                            echo date_format($date, "d/m/Y");
                                                            ?></span> - Lượt
                                                        chia sẻ : <span
                                                                class="fw6">{{ number_format($total_sum_share) }}</span>
                                                        <i class="fas fa-share"></i> - Lượt xem : <span
                                                                class="fw6">{{ number_format($total_sum_view_share) }}</span>
                                                        <i class="far fa-eye"></i>
                                                    </p>
                                                    <div class="descriptionPostSale input_sale">
                                                        <div id="fb-root"></div>
                                                        <script async defer crossorigin="anonymous"
                                                                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0">
                                                        </script>
                                                        <div class="fb-share-button"
                                                             data-href="{{ route('detail_intership', ['slug' => $employer->slug]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                             data-layout="button" data-size="large">
                                                            <a target="_blank"
                                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail_intership', ['slug' => $employer->slug]) }}?user_id_sale={{$employee_coints->employee_id}}&amp;src=sdkpreparse"
                                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook"
                                                               employer_id="{{ $employer->employer_id }}">
                                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                                            </a>
                                                        </div>

                                                        <div class="zalo-share-button"
                                                             data-href="{{ route('detail_intership', ['slug' => $employer->slug]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                             data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="false" style="height: 40px;
    vertical-align: top;">
                                                        </div>
                                                        <div class="input-group mb-3 copy_link_post">
                                                            <input type="text"
                                                                   id="myInput{{$id}}"
                                                                   value="{{ route('detail_intership', ['slug' => $employer->slug]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                                   class="form-control js_add_employee_money css_no_copy"
                                                                   placeholder="copy link chia sẻ"
                                                                   employer_id="{{ $employer->employer_id }}"
                                                                   readonly style="">

                                                            <div class="input-group-append">
                                                                <button onclick="myFunction{{$id}}()"
                                                                        class="btn btn-outline-secondary copylink js_add_employee_money"
                                                                        employer_id="{{ $employer->employer_id }}">
                                                                    Copy link bài viết
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('detail_intership', ['slug' => $employer->slug]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                       class="link">Xem thêm</a>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_employer])
                                        </div>
                                    </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="money_table">
                                    @if(!empty($list_staticals))
                                        <div class="table-responsive">
                                        <table id="jobfb" class="table table-hover table-bordered mbdsNone">
                                            <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th>Tên công ty</th>
                                                <th class="text-center">Link bài viết</th>
                                                <th class="text-center">Số lần chia sẻ</th>
                                                <th class="text-center">Số lượt xem</th>
                                                <th class="text-center">Thành tiền</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            <?php $total = 0;
                                            $total_money = 0;
                                            ?>
                                            @foreach($list_staticals as $id_stt=>$statical)
                                                <tr>
                                                    <td class="text-center">{{ $id_stt + 1 }}</td>
                                                    <td>{{ !empty($statical->enterprise_name) ? $statical->enterprise_name : '' }}</td>
                                                    <td class="text-center">
                                                        @if(!empty($statical->slug))
                                                            <a href="{{ route('detail_intership', ['slug' => $statical->slug]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                               target="_blank">Link
                                                                bài viết</a></td>
                                                    @endif
                                                    <td class="text-center">{{ !empty($statical->total_share) ? $statical->total_share : '' }}</td>
                                                    <td class="text-center">

                                                        {{ !empty($statical->total_view_sale) ? number_format($statical->total_view_sale) : 0 }}

                                                    </td>
                                                    <td class="text-center">
                                                        @if(!empty($statical->total_money_view))
                                                            {{ number_format($statical->total_money_view) }} VND
                                                        @endif

                                                    </td>
                                                </tr>

                                            @endforeach

                                            <?php
                                            if (!empty($employee_coints)) {
                                                $employee_total_sale = \App\Entity\Employer_sale_statistical::Employee_TotalShare($employee_coints->employee_id);
                                                $employee_total_view = \App\Entity\Employer_sale_statistical::Employee_TotalView($employee_coints->employee_id);
                                                $employee_total_view_money = \App\Entity\Employer_sale_statistical::Employee_TotalMoney($employee_coints->employee_id);
                                            }

                                            ?>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số chia sẻ
                                                        : {{ isset($employee_total_sale) ?number_format($employee_total_sale) : '' }}
                                                        lượt
                                                    </p>
                                                </td>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số lượt xem
                                                        : {{ isset($employee_total_view) ? number_format($employee_total_view) : '' }}
                                                        lượt
                                                    </p>
                                                </td>
                                                <td colspan="3" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng tiền
                                                        : {{ isset($employee_total_view_money) ? number_format($employee_total_view_money) : '' }}
                                                        VND
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    @endif
                                    <div class="row pagePostSale">
                                        <div class="col-12 text-center">
                                            @include('site.default.item_pani',['page_link' => $list_staticals])
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    @include('site.money_site.video')
@endsection

@section('show_js')
    @include('site.layout_site.from')
    <script>
        $('.itemPostSale').matchHeight();
        $(document).ready(function () {
            $('.js_add_employee_money').click(function () {
                var employer_id_val = $(this).attr('employer_id');
                $.ajax({
                    url: "{!! route('create_employee_share_employer') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là get
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        employee_id: '{{ $employee_coints->employee_id }}',
                        employer_id: employer_id_val,
                    },
                    success: function (result) {
                        // Sau khi gửi và kết quả trả về thành công thì gán nội dung trả về
                        // đó vào thẻ div có id = result
                        console.log("Thêm thành công");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // When AJAX call has failed
                        console.log('Thêm thất bại');
                    },
                });
            });
        });
    </script>
    <script>
        @foreach($list_employer as $id=>$get_link)
        function myFunction{{$id}}() {
            var copyText = document.getElementById("myInput{{$id}}");
            copyText.select();
            document.execCommand("copy");
        }
        @endforeach
    </script>
@endsection
