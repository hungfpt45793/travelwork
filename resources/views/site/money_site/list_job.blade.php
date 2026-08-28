@extends('site.layout_site.site')

@section('title', 'Danh sách chia sẻ tin tuyển dụng')
@section('meta_description', 'Danh sách chia sẻ tin tuyển dụng')
@section('keywords', 'Danh sách chia sẻ tin tuyển dụng')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/assets/web/css/money.css"/>
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
                                <a href="{{ route('list_course') }}">Kiếm tiền từ chia sẻ tin tuyển dụng</a>
                            </li>
                        </ul>
                    </div>

                    {{--@include('site.employee.item_list_redeem')--}}
                    @include('site.employee.item_total_money')

                    <section class="tab_link" id="js_tab_link">
                        <ul>
                            <li>
                                <a href="{{ route('list_post') }}#js_tab_link" > Bài viết</a>
                            </li>
                            <li>
                                <a href="{{ route('list_course') }}#js_tab_link">Khóa học</a>
                            </li>
                            <li>
                                <a href="{{ route('list_voucher') }}#js_tab_link">Tài liệu</a>
                            </li>
                            <li>
                                <a href="{{ route('list_job') }}#js_tab_link" class="active"> <i class="fa fa-check mgr5" aria-hidden="true"></i>Tin tuyển dụng</a>
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
                                   aria-controls="home" aria-selected="true">Danh sách tin tuyển dụng</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                   aria-controls="profile" aria-selected="false">Thống kê</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @if(!empty($list_jobs))
                                    @foreach($list_jobs as $id=>$job)
                                        <div class="row itemPostSale">
                                            <a href="{{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}">
                                                <?php $distinct = \App\Entity\District::getId($job['district']) ?>
                                                <?php $province = \App\Entity\Province::getId($job['province']) ?>
                                                <div class="col-md-12 contentPostSale">
                                                    <a href="{{ route('job_detail',['slug' => $job->slug ]) }}"
                                                       class="" title="{{ $job['title'] }}">
                                                        <h3 class="cutTitle clorang f18 fw6"
                                                                style="text-transform: unset">
                                                            @if($job->vip == 1)
                                                                <img class="lazy" src="{{ asset('assets/image/vip1.png') }}" width="40px">
                                                            @endif
                                                            {{ $job['title'] }}
                                                        </h3>
                                                    </a>
                                                    <?php
                                                    $employer_id = $job['employer_id'];
                                                    $employer = \App\Entity\Employer::getIdemployer($employer_id);
                                                    ?>
                                                    <p class="mgb5 cutTitle"> Đăng bởi:
                                                        <span class="fw6">
                                                            {{ isset($employer['enterprise_name']) ? \App\Ultility\Ultility::textLimit($employer['enterprise_name'], 15) : '' }}
                                                        </span>
                                                    </p>
                                                    <p class="mgb5">
                                                        <span class="black">
                                                             <i>
                                                                    <span class="block"><i class="fas fa-map-marker-alt blueN "></i>
                                                                        @if(isset($distinct->district_name))
                                                                            {{ $distinct->district_name }}
                                                                        @endif
                                                                        @if(!empty($distinct->district_name))
                                                                            -
                                                                        @endif
                                                                        @if(isset($province->province_name))
                                                                            {{ $province->province_name }}
                                                                        @endif
                                                                    </span>
                                                            </i>
                                                        </span>

                                                        <span class="block">
                                                            <span class="black">
                                                                <i class="fas fa-hand-holding-usd money"></i>
                                                                Lương:
                                                                @if(!empty($job->salary_description))
                                                                    {{$job->salary_description}}
                                                                    &nbsp;&nbsp;&nbsp;
                                                                @else
                                                                    Đang cập nhật
                                                                @endif
                                                            </span>
                                                            <span class="sm-block pull-right float-right clOrange">
                                                                <i class="far fa-clock"></i> Ngày đăng tin:
                                                                <?php
                                                                    $date_facebook = \App\Ultility\Ultility::getdateFacebook($job['updated_at']);
                                                                    echo $date_facebook;
                                                                    ?>
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <p class="mgb5">
                                                        <?php
                                                        $total_sum_share = \App\Entity\Job_sale_statistical::getTotalShare($job->job_id);
                                                        //
                                                        $total_sum_view_share = \App\Entity\Job_sale_statistical::getTotalViewSale($job->job_id);
                                                        ?>
                                                        Lượt chia sẻ : <span class="fw6">{{ number_format($total_sum_share) }}</span>
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
                                                             data-href="{{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                             data-layout="button" data-size="large">
                                                            <a target="_blank"
                                                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}&amp;src=sdkpreparse"
                                                               class="fb-xfbml-parse-ignore js_add_employee_money share_facebook" job_id="{{ $job->job_id }}">
                                                                <i class="fas fa-dollar-sign"></i> Chia sẻ lên facebook
                                                            </a>
                                                        </div>

                                                        <div class="zalo-share-button"
                                                             data-href="{{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                             data-oaid="579745863508352884" data-layout="3" data-color="blue" data-customize="false" style="height: 40px;
    vertical-align: top;">
                                                        </div>

                                                        <div class="input-group mb-3 copy_link_post">
                                                            <input type="text"
                                                                   id="myInput{{$id}}"
                                                                   value="{{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}"
                                                                   class="form-control js_add_employee_money css_no_copy"
                                                                   placeholder="copy link chia sẻ" job_id="{{ $job->job_id }}"
                                                                   readonly style="">

                                                            <div class="input-group-append">
                                                                <button onclick="myFunction{{$id}}()"
                                                                        class="btn btn-outline-secondary copylink js_add_employee_money" job_id="{{ $job->job_id }}">
                                                                    Copy link bài viết
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a href="{{ route('job_detail',['slug' => $job->slug ]) }}?user_id_sale={{$employee_coints->employee_id}}" class="link">
                                                        Xem thêm
                                                    </a>

                                                </div>
                                            </a>

                                        </div>
                                    @endforeach
                                @endif
                                <div class="row pagePostSale">
                                    <div class="col-12 text-center">
                                        @include('site.default.item_pani',['page_link' => $list_jobs])
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
                                                <th>Tiêu đề tin tuyển dụng</th>
                                                <th class="text-center">Link tin tuyển dụng</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th class="text-center">Số lần chia sẻ</th>
                                                <th class="text-center">Số lượt xem</th>
                                                <th class="text-center">Tổng xu</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            <?php $total = 0;
                                            $total_money = 0;
                                            ?>
                                            @foreach($list_staticals as $id_stt=>$statical)
                                                <?php
                                                //                                                    $post_staticals = \App\Entity\Post::get_post_id($statical->post_id);
                                                $post_staticals = \App\Entity\Job::get_post_id($statical->job_id);
                                                $job_status = \App\Entity\Job::get_status_money($statical->job_id);
                                                ?>
                                                <tr>
                                                    <td class="text-center">{{ $id_stt + 1 }}</td>
                                                    <td>{{ !empty($post_staticals['title']) ? $post_staticals['title'] : '' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('job_detail',['slug'=> !empty($post_staticals['slug']) ? $post_staticals['slug'] : '']) }}"
                                                           target="_blank">Link
                                                            bài viết</a></td>
                                                    <td class="textCenter">
                                                        @if(!empty($job_status))
                                                            <span class="btngreen"> Đang chia sẻ</span>

                                                        @else
                                                            <span class="btnred"> Đã dừng chia sẻ</span>

                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ !empty($statical->total_share) ? $statical->total_share : '' }}</td>
                                                    <td class="text-center">{{ number_format($statical->total_view_sale) }}</td>
                                                    <td class="text-center">
                                                        {{ !empty(number_format($statical->total_coin)) ? number_format($statical->total_coin) : 0 }} xu

                                                    </td>
                                                </tr>

                                            @endforeach
                                            <tr>
                                                <?php
                                                if(!empty($employee_coints))
                                                {
                                                    $employee_total_sale = \App\Entity\Job_sale_statistical::Employee_TotalShare($employee_coints->employee_id);
                                                    $employee_total_view = \App\Entity\Job_sale_statistical::Employee_TotalView($employee_coints->employee_id);
                                                    $employee_total_view_money = \App\Entity\Job_sale_statistical::Employee_TotalCoin($employee_coints->employee_id);
                                                }

                                                ?>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số chia sẻ : {{ !empty($employee_total_sale) ? $employee_total_sale : '0' }} lượt
                                                    </p>
                                                </td>
                                                <td colspan="2" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số lượt xem : {{ !empty($employee_total_view) ? $employee_total_view : '0' }} lượt
                                                    </p>
                                                </td>
                                                <td colspan="3" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng xu : {{ isset($employee_total_view_money) ? number_format($employee_total_view_money) : '' }} xu
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
        $(document).ready(function () {
            $('.js_add_employee_money').click(function () {
                var job_id_val = $(this).attr('job_id');
                $.ajax({
                    url: "{!! route('create_employee_share_job') !!}", // gửi ajax đến file result.php
                    type: "get", // chọn phương thức gửi là get
                    dateType: "json", // dữ liệu trả về dạng text
                    data: { // Danh sách các thuộc tính sẽ gửi đi
                        employee_id: '{{ $employee_coints->employee_id }}',
                        job_id: job_id_val,
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
        @foreach($list_jobs as $id=>$get_link)
        function myFunction{{$id}}() {
            var copyText = document.getElementById("myInput{{$id}}");
            copyText.select();
            document.execCommand("copy");
        }
        @endforeach
    </script>
@endsection
