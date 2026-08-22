@extends('staff_admin.layouts.master')

@section('title', 'Chi tiết nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            @if (session('error'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-danger mg-b-0 " role="alert">
                        {{ session('error') }}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif
            @if (session('success'))
                <div class="col-12 col-xs-12 col-md-12 col-lg-12  pd-0 pd-t-15">
                    <div class="alert alert-success mg-b-0 ">
                        {{session('success')}}
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <h5 class="text-info" style="display: inline-block">Chi tiết tương tác việc làm &nbsp; </h5><h5 style="display: inline-block" class="text-success"> {{ !empty($job->title) ? $job->title : '' }}</h5>

                        <div class="col-md-12">
                            <a href="{{ route('form_edit_job',$job->job_id) }}" class="btn btn-info btn-sm">Sửa tin</a>
                            @if($check == 0)
                                <a href="{{ route('staff_job_delete_request', $job->job_id) }}" class="btn btn-danger delete_request btn-sm">Đề nghị xóa tin</a>
                            @else
                                <a href="{{ route('staff_job_undelete_request',  $job->job_id) }}" class="btn btn-danger undelete_request">Bỏ đề nghị xóa tin</a>
                            @endif
                            {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"
                            href="{{ route('SendFeedbackJob',$job->job_id) }}" onclick="return submitDelete(this);">Phản hồi</button> --}}
                            @if($job->active_job == 0)
                                <a href="{{ route('approved_job_NTD',$job->job_id) }}" class="btn btn-primary approved_job_NTD">
                                    Duyệt
                                </a>
                            @endif

                            <a href="{{ route('send_email_job',$job->job_id) }}" class="btn btn-info btn-sm">Mời ứng viên ứng tuyển</a>
                        </div>
                        <div class="col-md-12 mt-3">
                            <form action="{{ route('SendFeedbackJob',$job->job_id) }}" class="row" method="post">
                                <div class="col-6">
                                    <div class="form-group text-warning">
                                        <label for="">Nội dung phản hồi</label>
                                        <textarea name="feedback" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-warning">
                                        <label for="">Ngày phản hồi</label>
                                        <input type="date"  value="{{ date('Y-m-d') }}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn mt-1 btn-warning">Gửi phản hồi</button>
                                </div>
                            </form>
                        </div>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" action=""  method="POST" id="send_feedback_employer">
                                {!! csrf_field() !!}
                          <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Phản hồi</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control error_border_feedback" id="feedback" name="feedback" id="feedback" rows="6" cols="80" required placeholder="Nhập phản hồi"/></textarea>
                                        <div class="mess_notice_feedback clearfix note_text_feedback"></div>
                                        <div class="error_reg_mess clearfix error_text_feedback"></div>

                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary send">Gửi</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                      </div>
                    <hr class="hr">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive" style="padding-bottom:20px;">
                                <table class="table table-bordered table-hover ">
                                    <thead>
                                        <tr>
                                            <th scope="col ">ID</th>
                                            <th scope="col ">Ngày phản hồi</th>
                                            <th scope="col ">Người phản hồi</th>
                                            <th scope="col ">Nội dung phản hồi</th>
                                            <th scope="col ">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach ($history as $item)
                                         <tr>
                                             <td>{{ $item->id }}</td>
                                             <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                                             <td>{{ $item->user_name }}</td>
                                             <td>{{ $item->feedback }}</td>
                                             <td>
                                                @if($item->status == 0)
                                                    <span class="text-danger">
                                                        Chưa duyệt
                                                    </span>
                                                @else
                                                    <span class="text-success">
                                                        Đã duyệt
                                                    </span>
                                                @endif
                                            </td>
                                         </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-bootstrap">{{ $history->links() }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" action=""  method="POST" id="form_update_interactive">
                                {!! csrf_field() !!}
                          <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cập nhật tương tác</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- <div class="col-6"> --}}
                                            <div class="form-group">
                                                <label for="">Nội dung tương tác</label>
                                                <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                                            </div>
                                        {{-- </div>   --}}
                                        {{-- <div class="col-6"> --}}
                                            <div class="form-group">
                                                <label for="">Ngày tương tác</label>
                                                <input type="date" name="interactive_day" id="interactive_day" class="form-control" >
                                            </div>

                                        {{-- </div> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-success">Lưu</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                      </div>
                    {{-- <div class="col-xl-9 col-lg-8 col-md-12 col-12 col-12"> --}}
                        {{-- @include('site.modum_sidebar.detail_employee') --}}
                    {{-- </div> --}}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('.approved_job_NTD').click(function(){
            var x = confirm("Bạn có chắc chắc muốn duyệt?");
            if (x)
                return true;
            else
                return false;
        });
        $('.send').click(function() {
            if($.trim($('#feedback').val()).length === 0){
                $('.note_text_feedback').hide();
                $('.error_text_feedback').html('<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
                $('.error_reg_mess_icon').css("color", "#ff0000");
                $('.error_border_feedback').css("cssText", "border: 1px solid #ff0000  !important;");
                event.preventDefault();
            }
        });
        function submitDelete(e) {
            var url = $(e).attr('href');

            var Ids = [];
            console.log(url);
            $('#send_feedback_employer').attr('action', url);
            return false;
        }
        $('.btnDelete').click(function(){
            var x = confirm("Bạn có chắc chắc muốn xóa?");
            if (x)
                return true;
            else
                return false;
        });
        $('.delete_request').click(function(){
            var x = confirm("Bạn có chắc chắc đề nghị xóa?");
            if (x)
                return true;
            else
                return false;
        });
        $('.undelete_request').click(function(){
            var x = confirm("Bạn có chắc chắc bỏ đề nghị xóa?");
            if (x)
                return true;
            else
                return false;
        });
        $('.update_interactive').click(function(){
            var interactive_day = $(this).attr('interactive_day');
            var url = $(this).attr('href');
            var content = $(this).attr('content');
            $('#interactive_day').attr('value', interactive_day);
            document.getElementById("content").value = content;
            $('#form_update_interactive').attr('action', url);
            // return false;
        });
</script>
@endsection
