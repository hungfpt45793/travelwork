<?php
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
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
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                <div class="modal fade" id="timkiem" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="" method="GET">
                                            @php
                                                $code = isset($_GET['code']) ? $_GET['code'] : '';
                                                $user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
                                            @endphp
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tìm kiếm</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- tim ma cong viec --}}
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-md-3 control-label mb-0 mt-2 text-right">Mã công việc</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input name="code" placeholder="Mã công việc"
                                                                    value="@if(!empty($code)){{$code}}@endif"
                                                                    class="form-control" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- tim ten nguoi tt --}}
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-md-3 control-label mb-0 mt-2 text-right">Người T/Tác</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input name="user_name" placeholder="Người tương tác"
                                                                    value="@if(!empty($user_name)){{$user_name}}@endif"
                                                                    class="form-control" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- chon ngay tuong tac --}}
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6">
                                                            <label for="validationDefault01">Từ ngày(tương tác)</label>
                                                            @php
                                                            $d=strtotime("-1 Months");
                                                            $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input class="form-control myDatetime" max="9999-12-31"
                                                                value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}"
                                                                type="date" name="date_search_start">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="validationDefault02">Đến ngày(tương tác)</label>
                                                            <input class="form-control myDatetime" max="9999-12-31"
                                                                value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}"
                                                                type="date" name="date_search_end">
                                                            <input type="hidden" name="num" value="{{$num}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Tìm</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="custom-paginate col-12 row mt-1">
                                {{ $interactives->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="" class="inline">
                                        <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                        <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                        <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                        <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                        <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                        <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                    </form>
                                </span>
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $interactives->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{-- ô ấn nhiều --}}
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($interactives as $interactive)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $interactive->id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1"><p style="width:32px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_31"><p style="width:87px">Ngày T/Tác<button class="lockButton btn btn-sm btn-success" id="lid_31">L</button></p></td>
                                            <td class="lid_3"><p style="width:128px">Người T/Tác<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_2"><p style="width:300px">Nội dung<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_4"><p style="width:62px">Mã job<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_4"><p style="width:150px">Tiêu đề job<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_4"><p style="width:69px">Link job<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:79px">Link T/Tác<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interactives as $interactive)
                                            <tr>
                                                <td>{{ $interactive->id}}</td>
                                                <td class="text-center">
                                                    @php
                                                        $date_end = date_create($interactive->created_at);
                                                        echo date_format($date_end, "d/m/Y");
                                                    @endphp
                                                </td>
                                                <td class="crop">
                                                    {{ $interactive->name }}
                                                </td>
                                                <td class="lid_2">
                                                    <a class="content_tt" data-jobfb-id="{{ $interactive->jobfb_id }}" data-user-id="{{ $interactive->user_id }}" data-toggle="modal" data-target="#content_tt">
                                                        <p class="crop text-primary" style="width: 300px">
                                                            @if (isset($interactive->content))
                                                                {{ $interactive->content }}
                                                            @endif
                                                        </p>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $interactive->job_facebook_code }}
                                                </td>
                                                <td>
                                                    <p class="crop" style="width:150px">
                                                        {{ $interactive->title }}
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $job = App\Entity\JobFacebook::where('job_facebook_id',$interactive->jobfb_id)->first();
                                                    @endphp
                                                    @if (!empty($job->slug))
                                                        <a target="_blank" href="{{ route('detail_job_face',$job->slug) }}">link</a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a target="_blank" href="{{ route('form_edit_job_facebook',$interactive->jobfb_id) }}">link</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<div class="modal fade" id="content_tt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nội dung tương tác</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead style="background-color: #53b55a">
                        <tr>
                            <td style="width:94px">Ngày T/Tác</td>
                            <td>Người T/Tác</td>
                            <td>Nội dung T/Tác</td>
                        </tr>
                    </thead>
                    <tbody class="foreach_tt">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#content_tt').on('hidden.bs.modal', function (e) {
        $('#content_tt .foreach_tt').html('')
    })
    $('.content_tt').on('click', function() {
        var jobfb_id = $(this).data('jobfb-id')
        var user_id = $(this).data('user-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('show_modal_content_tt') }}",
            'data': {
                jobfb_id,
                user_id
            },
            'success': (req) => {
                let html =''
                req.forEach(element => {
                    let created_at = new Date(element.created_at)
                    let formatted_created_at = created_at.getDate() + "-" + (created_at
                    .getMonth() + 1) + "-" + created_at.getFullYear()
                    html += `
                    <tr>
                        <td><p class="crop">${formatted_created_at}</p></td>
                        <td><p class="crop">${element.name}</p></td>
                        <td><p>${element.content}</p></td>
                    </tr>
                    `
                });
                $('#content_tt .foreach_tt').html(html)
            }
        })
    })
</script>
@endsection
