
@extends('site.layout.site')

@section('title', 'Ứng tuyển ngay '.$job->title)
@section('meta_description', 'Ứng tuyển ngay '.$job->description)
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    @include('site.general.search_job')

    @include('site.module_index.province')

    <section class="contentIndex">
        <div class="container">
            <div class="row">
                <!-- BÊN PHẢI -->
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 righcont pdl0Im">
                    @include('site.jobs.filter_job')
                </div>
                <!-- BÊN TRÁI -->
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 leftcont pdl0">
                    <!-- BANNER -->
                    <!-- LIST-JOB -->
                    <ul class="listjobs borderRadius5 borderLight mgt0Im">
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                        <li>
                            <a href="tuyen-dung/bao-ve-dien-may-xanh.html">
                                <div>
                                    <img class="lazy" src="./image/logox.jpg" alt="">
                                </div>
                                <div style="float:left;border:none">
                                    <h3>Nhân viên bảo vệ</h3>
                                    <span class="mgb5">Công ty Cổ phần Thế giới di động</span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-map-marker-alt colorAddress"></i> Thanh Xuân - Hà Nội
                              </span>
                                    <span class="mgr20 dsInBlock">
                              <i class="fas fa-coins colorCoin"></i> Lương: 5-10 triệu
                              </span>
                                    <span class="mgr20 dsInBlock bulk">
                              <i class="fas fa-user-friends"></i> Số lượng: 50
                              </span>
                                    <span class="dsInBlock views">
                              <i class="far fa-eye"></i> 2.568
                              </span>
                                </div>
                            </a>
                            <strong><a href="" class="btn pd5-10 colorWhite fontBold hoverBgrTim hoverWhite">Ứng tuyển ngay</a></strong>
                        </li>
                    </ul>
                    <!-- KHÁCH HÀNG NHẬN XÉT -->
                </div>
            </div>
        </div>
    </section>
@endsection
