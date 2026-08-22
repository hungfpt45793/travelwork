@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Danh sách các gia sư hỗ trợ')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/style_user_support.css') }}">
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>

                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Danh sách các gia sư hỗ trợ</a>
                            </li>

                        </ul>
                    </div>
                    <div class="titleDoor">

                    </div>

                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            Danh sách các gia sư hỗ trợ
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">


                                <p style="border: 1px solid red;
    width: 100%;
    padding: 10px 15px;
    margin-top: 10px;
    font-weight: 600;
    color: red;
    font-size: 16px;">Lưu ý : Thông tin liên hệ email và số điện thoại của gia sư hỗ trợ sẽ được hiển thị khi trạng thái tư vấn -> đã được tư vấn</p>
                                <table id="salaries" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>

                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số điện thọai</th>
                                        <th>Nội dung hỗ trợ</th>
                                        <th>Ngày đăng kí</th>
                                        <th>Trạng thái tư vấn</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list_sup  as $ad)
                                        <tr>
                                            <?php
                                            $user_id = \App\Entity\User_advise::where('ad_id',$ad->ad_id)->value('user_id');
                                            $user = \App\Entity\Users::where('id',$user_id)->first();

                                            ?>
                                            @if(!empty($user))
                                            <td>{{ !empty($user->name) ? $user->name : '' }}</td>
                                            <td>@if($ad->ques_status > 0){{ !empty($user->email) ? $user->email : '' }} @else ******* @endif</td>
                                            <td>@if($ad->ques_status > 0){{ !empty($user->phone) ? $user->phone : '' }} @else ******* @endif</td>
                                                @else
                                                    <td colspan="3"><span style="color: red">Chưa có gia sư liên hệ</span></td>
                                                @endif

                                            <td>{{ !empty( $ad->title_support) ?  $ad->title_support : '' }}</td>
                                            <td>
                                                <?php
                                                echo date_format($ad->created_at, "d/m/Y");
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $message_ad = 'Chưa có gia sư liên hệ';
                                                $message_status = 'Cần được tư vấn';
                                                if ($ad->ques_status == 1) {
                                                    $message_status = 'Đã được tư vấn';
                                                }
                                                if ($ad->ques_status == 2) {
                                                    $message_status = 'Đã từ chối';
                                                }
                                                if ($ad->ques_status == 3) {
                                                    $message_status = 'Đã tư vấn xong';
                                                }
                                                if (!empty($ad->ad_id)) {
                                                    $message_ad = 'Gia sư đang liên hệ';
                                                }
                                                ?>
                                               <span class="advise_connect color_message{{$ad->ques_status}}" style="margin-bottom: 5px">{{ $message_status }}</span>
                                            </td>
                                            <td> @if(!empty($user))
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl{{$ad->ques_id}}"
                                                        style="margin-bottom: 15px">
                                                   Cập nhật trạng thái
                                                </button>
                                                     @else
                                                    <button disabled type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-xl{{$ad->ques_id}}"
                                                            style="margin-bottom: 15px">
                                                        Cập nhật trạng thái
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>


                </div>
            </div>
        </div>
    </section>

    @foreach($list_sup  as $ad)
        <div class="modal fade" id="modal-xl{{$ad->ques_id}}">
            <div class="modal-dialog">
                <form role="form" action="{{ route('list_update_support_status',['ques_id'=>$ad->ques_id]) }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cập nhật trạng thái</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body text-center" style="padding: 20px">

                            {{--<label style="margin-right: 10px"> Cần được tư vấn</label>--}}
                            <label style="margin-right: 10px"><input type="radio" name="ques_status" value="1" @if($ad->ques_status == 1) checked @endif> Đã được tư vấn</label>
                           <label style="margin-right: 10px"><input type="radio" name="ques_status" value="2" @if($ad->ques_status == 2) checked @endif> Đã từ chối</label>
                           <label style="margin-right: 10px"><input type="radio" name="ques_status" value="3" @if($ad->ques_status == 3) checked @endif> Đã tư vấn xong</label>

                            <p class="text-center" style="margin-top: 15px">
                                <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                            </p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btnOrange" data-dismiss="modal">Đóng
                            </button>

                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach


@endsection