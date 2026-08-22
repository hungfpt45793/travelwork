@extends('site.layout.site')

@section('title', 'Kiếm tiền từ chia sẻ bài viết')
@section('meta_description', 'Kiếm tiền từ chia sẻ bài viết')
@section('keywords', 'Kiếm tiền từ chia sẻ bài viết')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">

                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    <div class="list_redeem row">
                        <div class="col-md-3">
                            <div class="item_redeem">
                                <a href="{{ route('post_sale_employee') }}" class="p15 dsInline active">
                                    Kiếm tiền từ chia sẻ bài viết
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="item_redeem">
                                <a href="{{ route('redeem_rewards') }}" class="p15 dsInline">
                                    Danh sách đổi thưởng
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="item_redeem">
                                <a href="{{ route('transaction_history') }}" class="p15 dsInline">
                                    Lịch sử giao dịch
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="item_redeem">
                                <a href="{{ route('list_post') }}" class="p15 dsInline">
                                    Danh sách bài viết chia sẻ kiếm tiền
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <div class="CV bgrWhite radius5 pd20  mgb30 pdb5">

                                        @include('site.employee.item_total_money')
                                        <div class="title mgb20">
                                            <?php
                                            $day_date_static = new \DateTime();
                                            ?>



                                        </div>



                                        <div class="title mgb20">
                                            <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0 mgt35">
                                                Thống kê chia sẻ bài viết theo tháng
                                            </h5>
                                        </div>
                                        <?php
                                        if (isset($_GET['start_month_year'])) {
                                            $day_date_static = date_create($_GET['start_month_year']);
                                        }

                                        ?>

                                        <form method="get" action="" class="text-center">
                                            <label for="start">Thống kê theo tháng:</label> <input type="month"
                                                                                                   id="start"
                                                                                                   name="start_month_year"
                                                                                                   min="2019"
                                                                                                   value="{{ date_format($day_date_static,'Y-m') }}">
                                            <button class="btn-primary" type="submit">Tìm kiếm</button>
                                        </form>
                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã bài viết</th>
                                                <th>Tiêu đề bài viết</th>
                                                <th>Link bài viết</th>
                                                <th>Số lần chia sẻ</th>
                                                <th>Số lượt xem</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($list_staticals as $id_stt=>$statical)
                                                <?php
                                                $post_staticals = \App\Entity\Post::get_post_id($statical->post_id);
                                                ?>
                                                <tr>
                                                    <td>{{ $id_stt + 1 }}</td>
                                                    <td>{{ $statical->post_id }}</td>
                                                    <td>{{ $post_staticals->title }}</td>
                                                    <td>
                                                        <a href="{{ route('post',['cate_slug'=>'tin-tuc','post_slug'=>$post_staticals->slug]) }}"
                                                           target="_blank">Link
                                                            bài viết</a></td>
                                                    <td>{{ $statical->total_share }}</td>
                                                    <?php
                                                    if (isset($_GET['start_month_year'])) {
                                                        $day_date_static_get = date_create($_GET['start_month_year']);
                                                    } else {
                                                        $day_date_static_get = new DateTime();
                                                    }

                                                    $total_count = 0;
                                                    $total_count = \App\Entity\Post_sale_money::getMonthView($statical->post_id, $statical->employee_id, $day_date_static_get);
                                                    ?>
                                                    <td>{{ number_format($total_count) }}</td>
                                                    <td>

                                                        <?php
                                                        $total_view = isset($information_money['luot-hien-thi-toi-da-tren-bai-viet']) ? $information_money['luot-hien-thi-toi-da-tren-bai-viet'] : '10000';

                                                        $money_view = isset($information_money['so-tien-luot-xem']) ? $information_money['so-tien-luot-xem'] : '30';
                                                        ?>



                                                        @if($total_count >= $total_view)
                                                            <?php
                                                            $total_count = $total_view
                                                            ?>
                                                        @endif
                                                        {{ number_format($total_count * $money_view) }} vnđ
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>


                                        <div class="title mgb20">
                                            <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb0 mgt35">
                                                Bảng tổng hợp thống kê chia sẻ bài viết
                                            </h5>
                                        </div>
                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã bài viết</th>
                                                <th>Tiêu đề bài viết</th>
                                                <th>Link bài viết</th>
                                                <th>Số lần chia sẻ</th>
                                                <th>Số lượt xem</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            <?php $total = 0;
                                            $total_money = 0;
                                            ?>
                                            @foreach($list_staticals as $id_stt=>$statical)
                                                <?php
                                                $post_staticals = \App\Entity\Post::get_post_id($statical->post_id);
                                                ?>
                                                <tr>
                                                    <td>{{ $id_stt + 1 }}</td>
                                                    <td>{{ $statical->post_id }}</td>
                                                    <td>{{ $post_staticals->title }}</td>
                                                    <td>
                                                        <a href="{{ route('post',['cate_slug'=>'tin-tuc','post_slug'=>$post_staticals->slug]) }}"
                                                           target="_blank">Link
                                                            bài viết</a></td>
                                                    <td>{{ $statical->total_share }}</td>
                                                    <td>{{ number_format($statical->total_view_sale) }}</td>
                                                    <td>
                                                        @if($statical->total_view_sale >= $total_view)
                                                            <?php
                                                            $statical->total_view_sale = $total_view;
                                                            ?>
                                                        @endif
                                                        {{ number_format($statical->total_view_sale * $total_view) }} vnđ
                                                    </td>
                                                </tr>
                                                <?php
                                                $total += $statical->total_view_sale;
                                                $total_money += $statical->total_view_sale * $total_view;
                                                ?>


                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng số lượt xem : {{ number_format($total) }} lượt
                                                    </p>
                                                </td>
                                                <td colspan="3" class="text-center">
                                                    <p class="f20 fw6 mgb0">
                                                        Tổng tiền : {{ number_format($total_money) }} vnđ
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb30">

                                        Biểu đồ thống kê lượt xem bài viết ( trong
                                        tháng {{ date_format($day_date_static,'m/Y') }} )
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <p class="f16 bgorange clwhite pd5">
                                                Doanh thu ngày {{ date_format($day_date_static, "d/m/Y") }} : <span
                                                        class="clred fw6">
                                                    {{ isset($view_sale_day) ? $view_sale_day : 0 }} lượt xem
                                                </span>
                                            </p>

                                        </div>
                                        <div class="col-md-6 text-center">
                                            <p class="f16 bgorange clwhite pd5">
                                                Doanh thu tháng {{ date_format($day_date_static, "m") }} : <span
                                                        class="clred fw6">{{ isset($view_sale_month) ? $view_sale_month : 0 }}
                                                    lượt xem</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div id="chartContainer" style="height: 500px; width: 100%;"></div>
                                        <script src="{{ asset('assets/js') }}/canvasjs.min.js"></script>

                                        <div>
                                            <p class="mgb0"><i>Chú thích biểu đồ</i></p>
                                            <ul>
                                                @foreach($list_statical as $statical)
                                                    <?php
                                                    $post_statical = \App\Entity\Post::get_post_id($statical->post_id);
                                                    $total_count = 0;
                                                    ?>
                                                    <li><span>Mã bài viết ( {{ $statical->post_id }}
                                                            ) : {{ $post_statical->title }}</span></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script type="text/javascript">
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "light1", // "light2", "dark1", "dark2"
                animationEnabled: false, // change to true
                title: {
                    text: "Tốp những bài viết có số lượng lượt xem cao nhất",
                    fontFamily: "Arial",
                    fontSize: 24,
                    fontColor: "red",
                    fontWeight: "bold",
                },
                axisY: {
                    title: "Số lượt xem",
                    fontFamily: "Arial",
                    fontColor: "#009385",
                    crosshair: {
                        enabled: true
                    }
                },
                culture: 'es',
                data: [
                    {
                        // Change type to "bar", "area", "spline", "pie",etc.
                        type: "column",
                        dataPoints: [
                                @foreach($list_statical as $statical)
                                <?php
                                $post_statical = \App\Entity\Post::get_post_id($statical->post_id);
                                $total_count = 0;
                                $total_count = \App\Entity\Post_sale_money::getMonthView($statical->post_id, $statical->employee_id, $day_date_static);
                                ?>
                            {
                                label: "@if(!empty($post_statical)) {{ 'Mã bài viết : '.$statical->post_id }} @endif",
                                y: {{ $total_count }}  },
                            @endforeach

                            // { label: "orange", y: 1115  },
                            // { label: "banana", y: 25  },
                            // { label: "mango",  y: 1130  },
                            // { label: "grape",  y: 28  },
                            // { label: "apple",  y: 10  },
                            // { label: "orange", y: 15  },
                        ]
                    }
                ]
            });
            chart.render();

        }
    </script>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @include('site.partials.delete')


@endsection