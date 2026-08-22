
<?php  $public_link_employee = \App\Entity\Category::getDetailCategory('ke-toan-di-tim-viec'); ?>
<div class="dnav col-xl-3 col-lg-4 col-md-12 sidebar_job active_show_sidebar" id="js_toogle_sidebar">
    <div class="d-toggle">
        <div id="body-row" class="side-bar-left formJobLarge  sidebarJobFacebook">
            <div class="sidebar_job_title text-center clWhite bgHome">
                <p class="f20 mgb0"><i class="fas disInBlock fa-paper-plane mgr5 "></i> Thông tin</p>
            </div>
            <div class="tab-content mgb20" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="account dnavnone mgb5 mbdsNone">
                        <div class="employee dnavnone">
                            @if(!\Illuminate\Support\Facades\Auth::check())
                                <form action="{{ route('login_home') }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email đăng ký <span
                                                        class="clRed">(*)</span></label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder="Nhập vào email của bạn">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mật khẩu <span class="clRed">(*)</span></label>
                                            <input type="password" name="password" class="form-control"
                                                   id="exampleInputPassword1" placeholder="Nhập mật khẩu của bạn">
                                        </div>
                                        @if($errors->any() && $errors->has('loginFail') )
                                            <div class="alert alert-danger" role="alert">
                                                <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                            </div>
                                        @endif
                                        @if (\Request::is('/'))
                                            <input type="hidden" name="home" class="form-control" id="exampleInputPassword1"
                                                   placeholder="" value="home">
                                        @endif
                                        @if(session('error_login'))
                                            <div class="form-group mgb0" style="margin-bottom: 10px">
                                                <p class="red mgb0" style="margin-bottom: 10px">{{ session('error_login') }}</p>
                                            </div>
                                        @endif
                                        @if($errors->any() && $errors->has('loginFail') )
                                            <div class="alert alert-danger" role="alert">
                                                <strong>Mật khẩu hoặc Email đăng nhập không đúng.</strong>
                                            </div>
                                        @endif
                                        <div class="form-group mgb0">
                                            <label class="mgb0" for="exampleInputPassword1"> <a
                                                        href="{{ route('reset_passwrod') }}">Quên
                                                    mật
                                                    khẩu</a></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Chưa có tài khoản?
                                                <a href="{{route('register')}}"> Đăng ký tài khoản</a>
                                            </label>
                                        </div>
                                        <button type="submit" class="btn bgHome clWhite">ĐĂNG NHẬP</button>
                                    </div>

                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="item">
                        @include('site.sidebar_site.login_info_employer')
                    </div>
                </div>
            </div>
        </div>











        <div class="fillterJobSubmit">
            <h5 class="title_job_submit">
                Lọc hồ sơ
            </h5>
            <?php
            $id_status_submit_get = array();
            if(isset($_GET['id_status_submit']))
            {
                $id_status_submit_get = $_GET['id_status_submit'];
            }

            ?>
            <form action="" method="get" class="form_filter_submit_job">
                <div class="">
                    <label class="f16 dnavnone">Trạng thái hồ sơ</label>
                </div>
                <?php
                $list_status_submit = \App\Entity\Status_submit_job::getAll();
                ?>
                @if(!empty($list_status_submit ))

                    <div class="dsBlock">

                        <label class="f16">
                            <input type="checkbox" value="0" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array('0', $id_status_submit_get)) checked @endif>
                            <span class="mgl5 dsInline dnavnone">Trạng thái</span>

                            <?php
                            //
                            $count_status = 0;
                            $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,0);
                            ?>
                            @if(!empty($count_status))
                                <sup class="clHome dnavnone">{{ $count_status }} hồ sơ</sup>
                            @endif
                        </label>

                    </div>


                    @foreach($list_status_submit as $status_submit)
                        <div class="dsBlock">

                            <label class="f16">
                                <input type="checkbox" value="{{ $status_submit->id_status }}" class="checkboxFilter mgr5" name="id_status_submit[]" @if(in_array($status_submit->id_status, $id_status_submit_get)) checked @endif>
                                <span class="mgl5 dsInline dnavnone">{{ $status_submit->name_status }}</span>

                                <?php
                                //
                                $count_status = 0;
                                $count_status = \App\Entity\EmployerIntership::getTotalStatus($employer->employer_id,$status_submit->id_status);
                                ?>
                                @if(!empty($count_status))
                                    <sup class="clHome dnavnone">{{ $count_status }} hồ sơ</sup>
                                @endif
                            </label>

                        </div>


                    @endforeach
                    <div class="dsBlock">
                        <button data-toggle="tooltip" data-placement="right" title="Lọc hồ sơ" type="submit" class="btnGreen" style="display: block;width: 100%;padding: 5px" id="btnloading_frofile"><i class="fas fa-filter"></i><span class="dnavnone">  Lọc hồ sơ</span></button>
                    </div>
                @endif

                <div>
                    <a href="{{ route('list_job_face') }}" class="dsBlock mgt15 f18 clHome text-center" data-toggle="tooltip" data-placement="right" title="Quay về  tủ hồ sơ"><i class="fas fa-long-arrow-alt-left"></i> <span class="dnavnone"> Quay về  tủ hồ sơ  <i class="fas fa-long-arrow-alt-right"></i></span></a>
                </div>
            </form>


            <script>
                $('#btnloading_frofile').click(function() {
                    $(this).html( '<i class="fas fa-spinner fa-spin mgr5"></i>' + 'Đang lọc hồ sơ...');
                    $btn.attr('disabled', false);
                });
                $('.checkboxFilter').iCheck({
                    checkboxClass: 'icheckbox_square-red',
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                });

            </script>
        </div>



       



    </div>
</div>








