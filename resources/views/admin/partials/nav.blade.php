<style>
    .navbar-nav > li {
        float: left;
        border-right: 1px solid #fff;
    }
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin_home')  }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">SANKETOAN</span>

    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <ul class="nav navbar-nav">
            <li class="{{ ($menuTop == 'jobs') ? 'active' : '' }}">
                <a target="" href="{{ route('job.index') }}">Việc làm</a>
            </li>
            <li class="{{ ($menuTop == 'sales') ? 'active' : '' }}">
                <a target="" href="{{ route('sale.index') }}">Bán hàng</a>
            </li>
            <li class="{{ ($menuTop == 'orders') ? 'active' : '' }}">
                <a target="" href="{{ route('service_order.index') }}">Đơn hàng</a>
            </li>
            <li class="{{ ($menuTop == 'customers') ? 'active' : '' }}">
                <a target="" href="{{ route('employer.index') }}">Tài khoản</a>
            </li>
            <li class="{{ ($menuTop == 'employer_coin') ? 'active' : '' }}">
                <a target="" href="{{ route('coin_information_employer.index') }}">Giao dịch NTD</a>
            </li>
            <li class="{{ ($menuTop == 'websites') ? 'active' : '' }}">
                <a target="" href="{{ route('admin_home') }}">Web</a>
            </li>
            <li class="{{ ($menuTop == 'promotion') ? 'active' : '' }}">
                <a target="" href="{{ route('coupon.index') }}">Khuyến mãi</a>
            </li>
            <li class="{{ ($menuTop == 'report') ? 'active' : '' }}">
                <a target="" href="{{ route('report_revenue') }}">Báo cáo</a>
            </li>
            <li class="{{ ($menuTop == 'setting') ? 'active' : '' }}">
                <a target="" href="{{ route('method_payment') }}">Cài đặt - Hệ số lương</a>
            </li>
            <li class="{{ ($menuTop == 'voucher') ? 'active' : '' }}">
                <a target="" href="{{ route('voucher-categories.index') }}">Tài liệu</a>
            </li>

            <li class="{{ ($menuTop == 'exam') ? 'active' : '' }}">
                <a target="" href="{{ route('exam.index') }}">Đề thi TN</a>
            </li>
            <li class="{{ ($menuTop == 'information_service') ? 'active' : '' }}">
                <a target="" href="{{ route('information_service.index') }}">Thông tin DV</a>
            </li>
            <li class="{{ ($menuTop == 'transaction') ? 'active' : '' }}">
                <a target="" href="{{ route('list_product.index') }}">Share bài + Rút tiền App</a>
            </li>
            <li class="{{ ($menuTop == 'template_email') ? 'active' : '' }}">
                <a target="" href="{{ route('category_template_email.index') }}">Mẫu Email - CV </a>
            </li>
            <li class="{{ ($menuTop == 'teacher_school') ? 'active' : '' }}">
                <a target="" href="{{ route('teacher_school.index') }}">GV - Tư vấn - hỗ trợ </a>
            </li>
            <li class="{{ ($menuTop == 'list_price') ? 'active' : '' }}">
                <a target="" href="{{ route('list_price.index') }}">Bảng giá</a>
            </li>
            <li class="{{ ($menuTop == 'educate') ? 'active' : '' }}">
                <a target="" href="{{ route('courses.index') }}">Đào tạo</a>
            </li>
            {{--<li class="{{ ($menuTop == 'cv_template') ? 'active' : '' }}">--}}
            {{--<a target="" href="{{ route('cv_template.index') }}">Mẫu cv</a>--}}
            {{--</li>--}}
        </ul>

        {{--<div class="navbar-custom-menu">--}}
        {{--<ul class="nav navbar-nav">--}}
        {{--notification--}}
        {{--<!-- <li class="">--}}
        {{--<a target="_blank" href="{{  \Illuminate\Support\Facades\URL::to('/') }}"> <i class="fa fa-globe" aria-hidden="true"></i> Xem Trang chủ</a>--}}
        {{--</li> -->--}}
        {{--<li class="dropdown" id="reports">--}}
        {{--<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" onclick="return seenNotification(this)">--}}
        {{--<i class="fa fa-bell" aria-hidden="true"></i> <span style="color: red"></span>--}}
        {{--</button>--}}
        {{--<script>--}}
        {{--function seenNotification(e) {--}}
        {{--// Khi click đọc thông báo thì cho số lượng thông báo về 0--}}
        {{--$('#ajax_countRp').empty();--}}
        {{--// Gọi ajax để db xử lý dữ liệu cho status về 1--}}
        {{--$.ajax({--}}
        {{--url: '{!! route('seenNotification') !!}',--}}
        {{--method: 'get',--}}
        {{--success: function(data){--}}
        {{--},--}}
        {{--error: function(){},--}}
        {{--});--}}

        {{--return true;--}}
        {{--}--}}
        {{--</script>--}}
        {{--@if (!empty($countRp))--}}
        {{--<span id="ajax_countRp" class="badge"> {!! $countRp !!} </span>--}}
        {{--@endif--}}
        {{--<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
        {{--<li>--}}
        {{--<b>THÔNG BÁO</b>--}}
        {{--</li>--}}
        {{--@foreach($notifications as $ntf)--}}
        {{--<li class="@if($ntf->status == 0 || $ntf->status == 1) blue @else white @endif ">--}}
        {{--<a id="{{ $ntf->notify_id }}" href="{{$ntf->URL}}" onclick="return readNotification(this)" >{!! '<b>'. $ntf->title.'</b>'. " : " . $ntf->content . "<br/>" !!}</a>--}}
        {{--</li>--}}
        {{--@endforeach--}}
        {{--Bắt sự kiện click vào thông báo--}}
        {{--<script>--}}
        {{--function readNotification(e) {--}}
        {{--var id = $(e).attr('id');--}}
        {{--// Gọi ajax để db xử lý dữ liệu cho status về 2--}}
        {{--$.ajax({--}}
        {{--url: '{!! route('readNotification') !!}',--}}
        {{--method: 'get',--}}
        {{--data: {--}}
        {{--id: id--}}
        {{--},--}}
        {{--success: function(data){--}}
        {{--},--}}
        {{--error: function(){},--}}
        {{--});--}}

        {{--return true;--}}
        {{--}--}}
        {{--</script>--}}
        {{--<li>--}}
        {{--<a href="{{ route('report') }}"><b><center>Xem tất cả</center></b></a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--endreport--}}
        {{--<!-- User Account: style can be found in dropdown.less -->--}}
        {{--<!-- Control Sidebar Toggle Button -->--}}
        {{--</ul>--}}
        {{--</div>--}}
    </nav>
</header>
