@extends('site.layout.site')

@section('title','Quản lý tin tuyển dụng')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 createProfileOnline ">
                    <div class="notificationBox bkwhite formJobLarge ">
                        <div class="headBox">
                            <p class="colorFont fontBold font18">Bạn đã tạo <span class="redColor">{{$jobs->count()}}</span> tin tuyển
                                dụng</p>
                        </div>
                        <div class="bodyBox">
                            <div class="row">
                                <div class="col-md-4">
                                    - Tin còn hạn : <span class="redColor">{{$countStill}}</span>
                                </div>
                                <div class="col-md-4 redColor">
                                    - Tin sắp hết hạn : <span>{{$countExpiring}}</span>
                                </div>
                                <div class="col-md-4 redColor">
                                    - Tin đã hết hạn : <span>{{$countExpire}}</span>
                                </div>
                            </div>
                            <br>
                            <button class="btn bkg btn-block whiteText fontBold"><i class="fas fa-plus"></i><a href="{{route('show_create_job')}}" style="text-decoration: none; color: #ffffff"> TẠO TIN
                                TUYỂN DỤNG MỚI</a></button>
                        </div>
                    </div>
                    <div class="main mgt20">

                        <div class="notificationBox bkwhite formJobLarge mb30">
                            <p class="text-title ">
                                Quản lý tin tuyển dụng
                            </p>
                            <div class="headBox ">
                                <div class="form-group has-search">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control" placeholder="Tìm kiếm tin tuyển dụng">
                                </div>
                            </div>
                            <div class="bodyBox">
                                <table class="table table-bordered mgb0 table table-striped">
                                    <thead class="workHeadTable bkg whiteText">
                                    <tr>
                                        <th class="text-center" style="width:30%">Vị trí tuyển dụng</th>
                                        <th class="text-center">Lượt nộp</th>
                                        <th class="text-center">Loại gói</th>
                                        <th class="text-center">Cập nhật</th>
                                        <th class="text-center">Mời ứng viên</th>
                                    </tr>
                                    </thead>
                                    <tbody class="workBodyTable">
                                        @foreach($jobs as $job)
                                            <tr>
                                                <td scope="row">{{$job->position}}</td>
                                                <td class="text-center">3</td>
                                                <td class="text-center">{{!empty($jobs->sale_package) ? $jobs->sale_package : ''}}</td>
                                                <td class="text-center">
                                                    <a href="{{route('delete_job',['slug'=>$job->slug])}}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            <i class="far fa-trash-alt"></i>
                                                    </a>
                                                    &emsp;
                                                    <a href="{{route('edit_job',['slug'=>$job->slug])}}">
                                                        <button class="btn btn-primary">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                                <td class="text-center"><Button class="btn btn-info">Mời ứng viên</Button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$jobs->links()}}
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