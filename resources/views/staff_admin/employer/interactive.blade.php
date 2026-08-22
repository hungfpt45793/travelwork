@extends('staff_admin.layouts.master')

@section('title', 'Chi tiết nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
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
                    <h5 class="text-info" style="display: inline-block">Danh sách lịch sử tương tác nhà tuyển dụng
                        &nbsp; </h5>
                    <h5 style="display: inline-block" class="text-success"> {{ $employer['enterprise_name'] }}</h5>
                    <form action="{{route('Create_Interactive_Employer',$employer['employer_id'])}}" class="row"
                        method="GET">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nội dung tương tác</label>
                                <textarea name="content" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ngày tương tác</label>
                                <input type="date" value="{{ date('Y-m-d') }}" name="interactive_day"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn mt-1 btn-success">Lưu</button>
                            <a href="{{ route('staff_employer_edit_form',  $employer['employer_id']) }}"
                                class="btn mt-1 btn-info">Sửa</a>
                            @if($check == 0)
                            <a href="{{ route('staff_employer_delete_request', $employer['employer_id']) }}"
                                class="btn mt-1 btn-danger delete_request">Đề nghị xóa</a>
                            @else
                            <a href="{{ route('staff_employer_undelete_request',  $employer['employer_id']) }}"
                                class="btn mt-1 btn-danger undelete_request">Bỏ đề nghị xóa</a>
                            @endif
                            <button type="button" class="btn mt-1 btn-warning" data-toggle="modal"
                                data-target="#myModal"
                                href="{{ route('SendFeedbackEmployer',$employer['employer_id']) }}"
                                onclick="return submitDelete(this);">Phản hồi</button>
                            @if($employer['status_employer'] == 0)
                            <a href="{{ route('approved_employer',$employer['employer_id']) }}"
                                class="btn mt-1 btn-primary approved_employer">
                                Duyệt
                            </a>
                            @endif
                            @php
                            $id = Auth::id();
                            $staff_id = App\Entity\Staff::where('user_id', $id)->value('staff_id');
                            $user_id = App\Entity\Employer::where('employer_id',
                            $employer['employer_id'])->value('user_id');
                            $status_follow = App\Entity\Staff_follow::where('staff_id', $staff_id)->where('user_id',
                            $user_id)->value('status_follow');
                            @endphp
                            <a class="btn mt-1 mt-1 {{ ($status_follow==1) ? 'btn-success' : 'btn-danger' }}"
                                href="{{ route('follow_user', $employer->user_id) }}">{{ ($status_follow==1) ? 'Đang theo dõi' : 'Theo dõi' }}</a>
                        </div>
                    </form>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" action="" method="POST" id="send_feedback_employer">
                                {!! csrf_field() !!}
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Phản hồi</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control error_border_feedback" id="feedback"
                                            name="feedback" id="feedback" rows="6" cols="80" required
                                            placeholder="Nhập phản hồi" /></textarea>
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
                                            <th scope="col ">id</th>
                                            <th scope="col ">Ngày tương tác</th>
                                            <th scope="col ">Người tt</th>
                                            <th scope="col ">Nội dung</th>
                                            <th scope="col ">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interactives as $interactive)
                                        <tr>
                                            <td>{{ $interactive->id }}</td>
                                            <td>{{ date('d-m-Y',strtotime($interactive->interactive_day)) }}</td>
                                            <td>{{ $interactive->user_name }}</td>
                                            <td>{{ $interactive->content }}</td>
                                            <td>
                                                @if (Auth::id() == $interactive->user_id)
                                                <button type="button" class="btn btn-primary update_interactive"
                                                    href="{{route('staff_employer_update_interactive',  $interactive->id)}}"
                                                    content="{{$interactive->content}}"
                                                    interactive_day="{{date('Y-m-d',strtotime($interactive->interactive_day))}}"
                                                    data-toggle="modal" data-target="#myModal">Sửa</button>
                                                <a href="{{ route('staff_employer_delete_interactive',  $interactive->id) }}"
                                                    class="btn btn-danger btnDelete">Xóa</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">
                    <!-- <hr class="hr">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive" style="padding-bottom:20px;">
                                <table class="table table-bordered table-hover ">
                                    <thead>
                                        <tr>
                                            <th scope="col ">id</th>
                                            <th scope="col ">Ngày tương tác</th>
                                            <th scope="col ">NV tương tác</th>
                                            <th scope="col ">Nội dung</th>
                                            <th scope="col ">trạng thái</th>
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
                                                    Chưa duyệt
                                                @else Đã duyệt
                                                @endif
                                            </td>
                                         </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                                <div class="pull-right">{{ $history->links() }}</div>
                            </div>
                        </div>
                    </div> -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form role="form" action="" method="POST" id="form_update_interactive">
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
                                            <textarea name="content" id="content" class="form-control"
                                                rows="4"></textarea>
                                        </div>
                                        {{-- </div>   --}}
                                        {{-- <div class="col-6"> --}}
                                        <div class="form-group">
                                            <label for="">Ngày tương tác</label>
                                            <input type="date" name="interactive_day" id="interactive_day"
                                                class="form-control">
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
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-general-tab" data-toggle="tab" href="#info-general"
                                role="tab" aria-controls="info-general" aria-selected="true">Thông tin chung</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-contact-tab" data-toggle="tab" href="#info-contact" role="tab"
                                aria-controls="info-contact" aria-selected="false">Thông tin liên lạc</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info-general" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="main row">
                                <div class="col-xl-3">
                                    <div class="CropImg CropImg60 CropImgMB60">
                                        <div class="thumbs">
                                            <?php $external_link = asset($employer['image']);?>
                                            @if(@GetImageSize($external_link))
                                            <img class="responsive-img w-100"
                                                src="{{ !empty($employer['image']) ? asset($employer['image']) : 'assets/image/avatarEmployer.png'}}"
                                                alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"
                                                title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">
                                            @else
                                            <img class="responsive-img w-100"
                                                src="{{ asset('assets/image/avatarEmployer.png') }}"
                                                alt="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}"
                                                title="{{ isset($employer['enterprise_name']) ? $employer['enterprise_name'] : ''}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <?php
                                            $email  = 'name@example.com';
                                            $domain = strstr($email, '@@');
                                            echo $domain; 
                                            ?>
                                    <h1 class="fontBold f20"> {{$employer['enterprise_name']}}</h1>
                                    <p class="mgb5"><i class="fas fa-map-marker-alt"></i> Địa
                                        chỉ:{{$employer['address']}}</p>
                                    <p class="mgb5"><i class="fab fa-internet-explorer"></i> Website:
                                        {{ $employer['website'] }}</p>
                                    <p class="mgb5"><i class="fas fa-map-marker-alt"></i> SĐT:
                                        {{ $employer['phone'] }}</p>
                                    <p class="mgb5"><i class="fas fa-map-marker-alt"></i> Email:
                                        {{ $employer['email'] }}</p>
                                    @if(!empty($employer['my_facebook']))
                                    <p class="mgb5"> Fanpage facebook:
                                        <a class="dsInline"
                                            href="@if(strstr($employer['my_facebook'], 'http')) {{ $employer['my_facebook'] }} @else http://{{ $employer['my_facebook'] }} @endif"
                                            target="_blank">
                                            <span class="green  f14 dsInline mgr10">
                                                {{ $employer['my_facebook'] }}</span>
                                        </a>
                                    </p>
                                    @endif
                                    @if(!empty($employer['my_zalo']))
                                    <p class="mgb5"> Zalo :
                                        <a class="dsInline"
                                            href="@if(strstr($employer['my_zalo'], 'http')) {{ $employer['my_zalo'] }} @else http://{{ $employer['my_zalo'] }} @endif"
                                            target="_blank">
                                            <span class="green  f14 dsInline mgr10">
                                                {{ $employer['my_zalo'] }}</span>
                                        </a>
                                    </p>
                                    @endif
                                    {{--<p class="mgb5"><i class="far fa-envelope"></i> Email: {{$employer->email}}
                                    </p>--}}
                                    <p class="mgb5">
                                        @if($employer['status_intership'] == 1)
                                    <div class="text-left mbdsNone">
                                        <a href="{{ route('detail_intership',['slug' => $employer['slug']]) }}"
                                            class="btnGreen js_employee_follow_employer"
                                            style="padding: 5px 10px;cursor: pointer;display: inline-block;color: #fff">Xem
                                            tin tuyển thực tập</a>
                                    </div>

                                    <div class="text-center dsNone mbdsBlock">
                                        <a href="{{ route('detail_intership',['slug' => $employer['slug']]) }}"
                                            class="btnGreen js_employee_follow_employer"
                                            style="padding: 5px 10px;cursor: pointer;display: inline-block;color: #fff">Xem
                                            tin tuyển thực tập</a>
                                    </div>
                                    @endif
                                    </p>
                                    <div class="mg0 ContentEmployer">{!!$employer['introduction']!!}</div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-contact" role="tabpanel" aria-labelledby="profile-tab">
                            <h4 class="text-center">Thông tin liên lạc nhà tuyển dụng</h4>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#create_contact">
                                Thêm mới
                            </button>
                            @if(isset($employer_contacts))
                            <table class="table table-bordered table-striped table_employer_contact">
                                <thead>
                                    <tr>
                                        <td>Họ và tên</td>
                                        <td>Chức vụ</td>
                                        <td>Số điện thoại</td>
                                        <td>email</td>
                                        <td>Ghi chú</td>
                                        <td>Thao tác</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employer_contacts as $employer_contact)
                                    <tr class="tr_allow_edit" data-employer-contact-id="{{ $employer_contact->employer_contact_id }}">
                                        <td contenteditable
                                                data-col-name="contact_name">
                                                {{ $employer_contact->contact_name }}
                                        </td>
                                        <td contenteditable
                                                data-col-name="contact_office">
                                                {{ $employer_contact->contact_office }}
                                        </td>
                                        <td contenteditable
                                                data-col-name="contact_phone">
                                                {{ $employer_contact->contact_phone }}
                                        </td>
                                        <td contenteditable
                                                data-col-name="contact_email">
                                                {{ $employer_contact->contact_email }}
                                        </td>
                                        <td contenteditable
                                                data-col-name="contact_note">
                                                {{ $employer_contact->contact_note }}
                                        </td>
                                        <td>
                                                <button class="btn btn-sm btn-danger delete_employer_contact">Xóa</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                            <div class="modal fade" id="create_contact" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Thêm thông tin liên lạc
                                                nhà tuyển dụng</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" class="form_create_contact_employer">
                                                <div class="form-group">
                                                    <label for="">Họ tên:</label>
                                                    <input type="text" class="form-control" name="contact_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Chức vụ:</label>
                                                    <input type="text" class="form-control" name="contact_office">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Số điện thoại:</label>
                                                    <input type="number" class="form-control" name="contact_phone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email:</label>
                                                    <input type="email" class="form-control" name="contact_email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ghi chú:</label>
                                                    <textarea id="textarea_contact_note" name="contact_note"
                                                        class="form-control" id="" cols="30" rows="2"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-primary button_create_contact"
                                                data-employer-id="{{$employer['employer_id']}}">Thêm mới</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
$('.approved_employer').click(function() {
    var x = confirm("Bạn có chắc chắc muốn duyệt?");
    if (x)
        return true;
    else
        return false;
});
$('.send').click(function() {
    if ($.trim($('#feedback').val()).length === 0) {
        $('.note_text_feedback').hide();
        $('.error_text_feedback').html(
            '<i class="error"><span class="error_reg_mess_icon">Vui lòng nhập phản hồi</span></i>');
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
$('.btnDelete').click(function() {
    var x = confirm("Bạn có chắc chắc muốn xóa?");
    if (x)
        return true;
    else
        return false;
});
$('.delete_request').click(function() {
    var x = confirm("Bạn có chắc chắc đề nghị xóa?");
    if (x)
        return true;
    else
        return false;
});
$('.undelete_request').click(function() {
    var x = confirm("Bạn có chắc chắc bỏ đề nghị xóa?");
    if (x)
        return true;
    else
        return false;
});
$('.update_interactive').click(function() {
    var interactive_day = $(this).attr('interactive_day');
    var url = $(this).attr('href');
    var content = $(this).attr('content');
    $('#interactive_day').attr('value', interactive_day);
    document.getElementById("content").value = content;
    $('#form_update_interactive').attr('action', url);
    // return false;
});
$('.button_create_contact').on('click', function() {
    let employer_id = $(this).attr('data-employer-id');
    let contact_name = $("form.form_create_contact_employer input[name='contact_name']").val();
    let contact_office = $("form.form_create_contact_employer input[name='contact_office']").val();
    let contact_phone = $("form.form_create_contact_employer input[name='contact_phone']").val();
    let contact_email = $("form.form_create_contact_employer input[name='contact_email']").val();
    let contact_note = $("form.form_create_contact_employer #textarea_contact_note").val();
    $.ajax({
        'type': 'post',
        'url': "{{ route('add_employer_contact') }}",
        'data': {
            employer_id: employer_id,
            contact_name: contact_name,
            contact_office: contact_office,
            contact_phone: contact_phone,
            contact_email: contact_email,
            contact_note: contact_note
        },
        'success': function(res) {
            $('#create_contact').modal('hide');
            $(".form_create_contact_employer").trigger("reset");
            $('.table_employer_contact tbody').append(`
                <tr class="tr_allow_edit" data-employer-contact-id="${res.employer_contact_id}">
                    <td contenteditable data-col-name="contact_name">${res.contact_name}</td>
                    <td contenteditable data-col-name="contact_office">${res.contact_office}</td>
                    <td contenteditable data-col-name="contact_phone">${res.contact_phone}</td>
                    <td contenteditable data-col-name="contact_email">${res.contact_email}</td>
                    <td contenteditable data-col-name="contact_note">${res.contact_note}</td>
                    <td>
                            <button class="btn btn-sm btn-danger delete_employer_contact">Xóa</button>
                    </td>
                </tr>
            `)
        }
    })
})
$(document).on('keyup', 'tr.tr_allow_edit td', function(){
        let column_name = $(this).attr('data-col-name');
        let content = $(this).text();
        let employer_contact_id = $(this).parent().attr('data-employer-contact-id');
        $.ajax({
            'type': 'get',
            'url': "{{ route('update_employer_contact') }}",
            'data': {
                employer_contact_id: employer_contact_id,
                column_name: column_name,
                content: content
            },
            'success': function(res){

            }
        })
    })
    $(document).on('click', 'tr .delete_employer_contact', function(){
        let employer_contact_id = $(this).parent().parent().attr('data-employer-contact-id');
        let tr_delete = $(this).parent().parent();
        $.ajax({
            'type': 'get',
            'url': "{{ route('delete_employer_contact') }}",
            'data': {
                employer_contact_id: employer_contact_id
            },
            'success': function(res){
                tr_delete.remove();
            }
        })
    })
</script>
@endsection