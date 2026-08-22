@extends('site.layout.site')

@section('title', 'Ứng tuyển thành công')
@section('meta_description', 'Ứng tuyển thành công')
@section('keywords', 'Ứng tuyển thành công')

@section('content')
    <style>
        .borderTopLeftRight10 i {
            width: 24px;
        }
    </style>
    <?php
    $date = date_create($job->updated_at);
    $date_line = date_create($job->deadline_submit_profile);

    ?>
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12">
                    <div class="link bgrWhite md-mgt20 disOnMobile">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="{{ \App\Ultility\Ultility::getUrl() }}" class=" f18 md-f14 mgb0">Thông báo nộp
                                    hồ sơ</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mgt15" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('erorr'))
                            <div class="alert alert-warning alert-dismissible fade show mgt15" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>


                    <div class="cvbox borderTopLeftRight10 bg-white pd15 pdb20 mgTop20">

                        <p class="mgb5 f18 clgreen text-center"><span> <img
                                        src="{{ asset('assets/image/check_png.png') }}" width="45px"> </span>
                            NỘP HỒ SƠ THÀNH CÔNG!</p>

                        <p>Hồ sơ của bạn đã được gửi thành công đến vị trí
                            <strong>{{ isset($job->title) ? $job->title : '' }}</strong> của công ty
                            <strong>{{ isset($employer->enterprise_name) ? $employer->enterprise_name : '' }}</strong>
                        </p>
                        <p>Bạn có thể tiếp tục trang trí CV chuyên nghiệp để tạo ấn tượng hơn với Nhà tuyển dụng.</p>


                        <p class="text-center mgt20 mgb20"><a href="{{ route('create_emplyee_cv') }}"
                                                              class="text-uppercase pd15 bgrBlueN clwhite f15 fw6">Trang
                                trí
                                CV</a>

                            <a href="{{ route('list_job_face') }}"
                               class="text-uppercase pd15 bgorang clwhite f15 fw6">Xem
                                việc làm phù hợp khác</a></p>


                        <p class="pt_22 mb_6 text-center mgt20">


                           </p>


                    </div>

                </div>
            </div>
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
@endsection


