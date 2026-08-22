<script src="{{ asset('') }}/adminstration/plugins/iCheck/icheck.min.js"></script>
<div class="col-lg-3 col-md-3 sideUser">
    <div class="sidebar-left">

        <div class="sidebar-title">
            @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{ route('showExam') }}"> <img src=" {{ \Illuminate\Support\Facades\Auth::user()->image }}"></a>
                <span class="textCt">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    <i>({{ (\Illuminate\Support\Facades\Auth::user()->level  == 0 ) ? 'ứng viên'  : 'nhà tuyển dụng' }})</i>

                </span>
                <span class="textCt"> {{ \Illuminate\Support\Facades\Auth::user()->phone }}</span>
            @endif
        </div>

        <ul class="sidebar-menu">
            <li class="has-child">
                <a><i class="fa fa-question-circle-o" aria-hidden="true"></i> Đề thi <i class="icon"><i class="fa fa-angle-double-down" aria-hidden="true"></i></i></a>
                <ul class="menu-sub" >
                    @if((\Illuminate\Support\Facades\Auth::user()->level == 1))
                    <li><a href="{{ route('showExam') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Đề thi của ban</a> </li>
                    <li><a href="{{ route('site_exam.create') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Thêm đề thi</a> </li>
                    @endif
                    <li><a href="{{ route('showAllExam') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Ngân hàng đề thi </a> </li>
                    <li><a href="#" ><i class="fa fa-caret-right" aria-hidden="true"></i>Đề thi bạn đã làm</a> </li>
                </ul>
            </li>
            @if((\Illuminate\Support\Facades\Auth::user()->level == 1))
            <li class="has-child">
                <a><i class="fa fa-question-circle-o" aria-hidden="true"></i> Phòng thi <i class="icon"><i class="fa fa-angle-double-down" aria-hidden="true"></i></i></a>
                <ul class="menu-sub" >
                        <li><a href="{{ route('room.index') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Danh sách phòng thi</a> </li>
                        <li><a href="{{ route('room.create') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Thêm phòng thi</a> </li>
                        <li><a href="{{ route('getAllRomResultExam') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Kết quả phòng thi</a> </li>
                </ul>
            </li>
            @endif



            <li class="has-child">
                <a><i class="fa fa-user-o" aria-hidden="true"></i> Tài khoản <i class="icon"><i class="fa fa-angle-double-down" aria-hidden="true"></i></i></a>
                <ul class="menu-sub">
                    <li><a href={{ route('show_edit_user') }} ><i class="fa fa-caret-right" aria-hidden="true"></i>Thông tin tài khoản</a> </li>
                    <li><a href="{{ route('show_pass_user') }}" ><i class="fa fa-caret-right" aria-hidden="true"></i>Đổi mật khẩu</a> </li>

                </ul>
            </li>

            <li class="has-child">
                <a><i class="fa fa-comment-o" aria-hidden="true"></i> Bình luận <i class="icon"><i class="fa fa-angle-double-down" aria-hidden="true"></i></i></a>
                <ul class="menu-sub">
                    <li><a href="#" ><i class="fa fa-caret-right" aria-hidden="true"></i>Bình luận đề thi</a> </li>
                    <li><a href="#" ><i class="fa fa-caret-right" aria-hidden="true"></i>Bình luận phòng thi</a> </li>

                </ul>
            </li>

            <li><a href="#" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i>Liên hệ</a> </li>
        </ul>
    </div>
    <script>
        $(document).ready(function(){
            $('.sidebar-menu li.has-child > a .icon').click(function(e){
                e.preventDefault();
                // $(this).parent().parent().toggleClass('menu-open');
                $(this).parent().toggleClass('menu-open').next('ul').slideToggle();
            });
        })
    </script>
</div>