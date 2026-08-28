<div class="col-xl-3 col-lg-4 col-md-12 dsmbNone sidebar_show_hidden" id="js_toogle_sidebar">
    <div id="dismiss">
        <i class="fas fa-arrow-left"></i>
    </div>
    <div class="side-bar-left formJobLarge ">
        <nav>
            <div class="nav nav-tabs textCenter" id="nav-tab" role="tablist">
                <a class="nav-item nav-link bgrBlueN white hvWhite w50 fw7 active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                <a class="nav-item nav-link w50 fw7 bgrBlueN white hvWhite show" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Bộ lọc nâng cao</a>
            </div>
        </nav>
        <div class="tab-content mgb20" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="account ">
                    <br>
                    <div class="employee">

                        @if (\Illuminate\Support\Facades\Auth::check())
                            <div class="row ">
                                <div class="col-md-4 ">
                                    <div class="accountThumbnail ">
                                        <img class="lazy" src="{{isset($user->image) ? $user->image : '/CV/Profile.jpg'}}" alt="" width="100% ">
                                    </div>
                                </div>
                                <div class="col-md-8 " style="padding:0 ">
                                    <div class="accountInfo ">
                                        <h5>{{$user->name}}</h5>
                                        <a href="{{route('logoutHome')}}">Thoát</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('login_home') }}" method="post">
                                {!! csrf_field() !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email đăng ký <span class="red">(*)</span></label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mật khẩu <span class="red">(*)</span></label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                               placeholder="Nhập mật khẩu của bạn">
                                    </div>
                                    @if($errors->any() && $errors->has('loginFail') )
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Bạn chưa có tài khoản?
                                            <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn bgrBlueN white">ĐĂNG NHẬP</button>
                                </div>

                            </form>
                        @endif
                    </div>

                    @if(!empty($employer))
                        <div class="employer">
                            <div class="logoSidebar mgt20">
                                <img class="lazy" style="width: 100px" src="{{isset($employer->image) ? $employer->image : '/CV/noimage.png'}}" alt="" class="w90 block mg">
                            </div>

                            <div class="nameCompanySidebar pd20 pdb0">
                                <p class="fw5 f18">
                                    {{$employer->enterprise_name}}
                                </p>
                                <p class="addressCompanySidebar mgb5">
                                    {{$employer->employer_address}}
                                </p>
                                <p>Hưởng nhiều chế độ ưu đãi lớn khi đi làm ngay</p>

                                <a href="{{route('detail_employer',['slug' => $employer->slug])}}" class="fw5">Thông tin chi tiết <i class="fas fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>

                <hr>

                @if(!empty($employer->employer_id))
                    <div class="withCompany pd20 pdt0 pdb0">
                        <h5 class="textUpper fontBold mgb10 bgrBlueN white pd10 sm-f15">CÙNG NHÀ TUYỂN DỤNG</h5>
                        <ul class="pdl20 lineHeight35 col-f14">
                            @foreach(App\Entity\Job::showJobWithEmployerId($employer->employer_id, 5) as $jobRelative)
                                <li>
                                    <a style="color: #333;" href="/cong-viec/{{$jobRelative->slug}}">
                                        {{isset($jobRelative->title) ? $jobRelative->title : ''}}
                                    </a>

                                </li>
                            @endforeach

                        </ul>
                        <a href="{{route('detail_employer',['slug' => $employer->slug])}}" class="fw5">Xem thêm <i class="fas fa-angle-double-right"></i></a>
                    </div>
                @endif
                <hr>

                <div class="createNew text-center bgrBlueN">

                    @if (\Illuminate\Support\Facades\Auth::check())
                        @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                            <a href="{{route('member_infomation')}}" class="createNewButton ">
                                <i class="fas disInBlock fa-paper-plane "></i>
                                <p class="disInBlock font20 fontBold ">Tạo hồ sơ</p>
                                <span class="disBlock font16 ">Có hồ sơ là có việc ngay</span>
                            </a>
                        @else
                            <a href="" data-toggle="modal"
                               data-target="#loginTiva" class="createNewButton white">
                                <i class="fas disInBlock fa-paper-plane "></i>
                                <p class="disInBlock font20 fontBold ">Tạo hồ sơ</p>
                            </a>
                        @endif
                    @else
                        <a href="" data-toggle="modal"
                           data-target="#loginTiva" class="createNewButton white">
                            <i class="fas disInBlock fa-paper-plane "></i>
                            <p class="disInBlock font20 fontBold ">Tạo hồ sơ</p>
                            <!--  <span class="disBlock font16 ">Có hồ sơ là có việc ngay</span> -->
                        </a>

                    @endif
                </div>

                @if (\Illuminate\Support\Facades\Auth::check())
                    @if (\Illuminate\Support\Facades\Auth::user()->role == 1)
                        <div class="item ">
                            <ul>
                                <li class="hvbgrBlueN">
                                    <a href="{{route('member_infomation')}}" class="block hvWhite pd8-20">
                                        <i class="fas fa-id-card "></i> <span>Quản lý hồ sơ</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Thông báo việc làm</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-list "></i> <span>Việc làm phù hợp với bạn</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-briefcase "></i> <span>Việc làm theo ngành
                        nghề</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-map-marker-alt "></i> <span>Việc làm theo tỉnh
                        thành</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-money-bill-alt"></i> <span>Việc làm theo mức lương </span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Việc làm đã tuyển</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Việc làm Đã Lưu</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                    @if (\Illuminate\Support\Facades\Auth::user()->role >= 2)
                        <div class="item ">
                            <ul>
                                <li class="hvbgrBlueN">
                                    <a href="{{route('employer_information')}}" class="block hvWhite pd8-20">
                                        <i class="fas fa-user-circle "></i> <span>Quản lý tài khoản</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-id-card "></i> <span>Quản lý hồ sơ</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Thông báo việc làm</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-list "></i> <span>Việc làm phù hợp với bạn</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-briefcase "></i> <span>Việc làm theo ngành
                          nghề</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="fas fa-map-marker-alt "></i> <span>Việc làm theo tỉnh
                          thành</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-money-bill-alt"></i> <span>Việc làm theo mức lương </span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Việc làm đã tuyển</span>
                                    </a>
                                </li>
                                <li class="hvbgrBlueN">
                                    <a href="" class="block hvWhite pd8-20">
                                        <i class="far fa-bell "></i> <span>Việc làm Đã Lưu</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif

                @else
                    <div class="item ">
                        <ul>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="fas fa-user-circle "></i> <span>Quản lý tài khoản</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="fas fa-id-card "></i> <span>Quản lý hồ sơ</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="far fa-bell "></i> <span>Thông báo việc làm</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="fas fa-list "></i> <span>Việc làm phù hợp với bạn</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="fas fa-briefcase "></i> <span>Việc làm theo ngành
                  nghề</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="fas fa-map-marker-alt "></i> <span>Việc làm theo tỉnh
                  thành</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="far fa-money-bill-alt"></i> <span>Việc làm theo mức lương </span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="far fa-bell "></i> <span>Việc làm đã tuyển</span>
                                </a>
                            </li>
                            <li class="hvbgrBlueN">
                                <a href="{{route('register')}}" class="block hvWhite pd8-20">
                                    <i class="far fa-bell "></i> <span>Việc làm Đã Lưu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>

            @includeIf('site.module_index.filter_job_sidebar')
        </div>
    </div>
    @include('site.sidebar.list_banner')
</div>

