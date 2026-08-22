@extends('site.layout.site')

@section('title','Quản lý ứng viên đã mời')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 createProfileOnline ">
                    <div class="notificationBox bkwhite formJobLarge ">
                        <div class="headBox">
                            <p class="colorFont fontBold font18">Bạn đã mời <span class="redColor">{{$employees->count()}}</span> ứng viên.</p><br>
                        </div>
                        <div class="bodyBox">
{{--                            <div class="row">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    - Ứng viên đã mời : <span class="redColor"></span>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 redColor">--}}
{{--                                    - Tin sắp hết hạn : <span></span>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 redColor">--}}
{{--                                    - Tin đã hết hạn : <span></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <br>
                            <button class="btn bkg btn-block whiteText fontBold"><i class="fas fa-user-plus"></i>
                                <a href="{{route('show_candidates')}}" style="text-decoration: none; color: #ffffff"> MỜI ỨNG VIÊN </a>
                            </button>
                        </div>
                    </div>
                    <div class="main mgt20">

                        <div class="notificationBox bkwhite formJobLarge mb30">
                            <p class="text-title ">
                                Ứng viên đã mời
                            </p>
{{--                            <div class="headBox ">--}}
{{--                                <div class="form-group has-search">--}}
{{--                                    <span class="fa fa-search form-control-feedback"></span>--}}
{{--                                    <input type="text" class="form-control" placeholder="Tìm kiếm tin tuyển dụng">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="bodyBox">
                                <table class="table table-bordered mgb0 table table-striped">
                                    <thead class="workHeadTable bkg whiteText">
                                    <tr>
                                        <th class="text-center" style="width:30%">Họ và tên ứng viên</th>
                                        <th class="text-center">Công việc</th>
                                        <th class="text-center">Ngày mời</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody class="workBodyTable">
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td scope="row">{{$employee->employee_name}}</td>
                                            <td class="text-center">{{$employee->title}}</td>
                                            <td class="text-center">{{$employee->created_at}}</td>
                                            <td class="text-center">
                                                @if($employee->status == 0)
                                                    Ứng viên chưa xác nhận
                                                @else
                                                    Ứng viên đã xác nhận
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('delete_invite',['employee'=>$employee->employee_id, 'job' => $employee->job_id])}}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$employees->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('site.partials.popup_delete')
    @include('site.partials.visiable')

    <script>
        $(document).ready(
            function () {
                $(".select2").select2();
            }
        );
    </script>
@endsection