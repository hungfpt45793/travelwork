@extends('admin.layout.admin')

@section('title', 'Tìm kiếm nhà tuyển dụng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhà tuyển dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Khách hàng</a></li>
            <li><a href="#">Nhà tuyển dụng</a></li>
            <li class="active"><a href="#">Tìm kiếm</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form role="search" action="{{route('searchEmployer')}}" method="GET">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Loại hình doanh nghiệp</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="type">
                                            <option value="">-- Loại hình doanh nghiệp --</option>
                                            @foreach(\App\Entity\TypeOfBusiness::orderBy('type_of_business_name')->get() as $type)
                                                <option value="{{$type->type_of_business_id}}"
                                                {{$type->type_of_business_id == $typeSearch ? 'selected' : ''}}
                                                >{{$type->type_of_business_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Loại hình kinh doanh</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="business">
                                            <option value="">-- Loại hình kinh doanh --</option>
                                            @foreach(\App\Entity\Business::get() as $business)
                                                <option value="{{$business->business_type_id}}"
                                                {{$business->business_type_id == $businessSearch ? 'selected' : ''}}
                                                >{{$business->business_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <a href="{{route('employer.create')}}"><button class="btn btn-info" style="float:right;" type="button">Thêm mới</button></a>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Trạng thái NTD</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="status">
                                            <option value="-1">-- Trạng thái NTD --</option>
                                            <option value="0" {{$statusSearch == 0 ? 'selected' : ''}}>Chưa có nhu cầu</option>
                                            <option value="1" {{$statusSearch == 1 ? 'selected' : ''}}>Có nhu cầu</option>
                                            <option value="2" {{$statusSearch == 2 ? 'selected' : ''}}>Đã lên đơn hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Tỉnh/Thành phố</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="province" id="province">
                                            <option value="">-- Tỉnh/Thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                <option value="{{$province->province_id}}"
                                                {{$province->province_id == $provinceSearch ? 'selected' : ''}}
                                                >{{$province->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">

                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Tìm kiếm theo từ khóa (Tên NTD)</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control" name="keyword"
                                        value="{{isset($keywordSearch) ? $keywordSearch : ''}}"
                                        >
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <div class="col-xs-4 col-md-4">
                                        <label>Quận/Huyện</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <select class="form-control select2" name="district" id="district">
                                            <option value="">-- Quận/Huyện --</option>
                                            @foreach(\App\Entity\District::where('province_id',$provinceSearch)->get() as $district)
                                                <option value="{{$district->district_id}}"
                                                {{$district->district_id == $districtSearch ? 'selected' : ''}}
                                                >{{$district->district_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">

                                </div>
                            </div>

                            <div class="row" style="margin-top: 1%">
                                <div class="col-xs-5 col-md-5">
                                </div>

                                <div class="col-xs-5 col-md-5">
                                    <button class="btn btn-success" type="submit">Tìm Kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="box-body">
                        <table id="employers" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Mã NTD</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Logo</th>
                                <th>Loại hình DN</th>
                                <th>Loại hình KD</th>
                                <th>Trạng thái</th>
                                <th>Tổng số tiền</th>
                                <th>Số ứng viên cần tuyển</th>
                                <th>Số ứng viên đã tuyển</th>
                                <th colspan="2">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employers as $employer)
                                <tr>
                                    <td>{{$employer->enterprise_id}}</td>
                                    <td>{{$employer->enterprise_name}}</td>
                                    <td><img class="lazy" src="{{$employer->image}}" width="100" alt="logo"></td>
                                    <td>{{$employer->type_of_business_name}}</td>
                                    <td>{{$employer->business_type_name}}</td>
                                    <td>
                                        @if($employer->status == 0)
                                            Chưa có nhu cầu
                                        @elseif($employer->status == 1)
                                            Có nhu cầu
                                        @else
                                            Đã lên đơn hàng
                                        @endif
                                    </td>
                                    <td class="quantity">{{$employer->total_money}}</td>
                                    <td class="quantity">{{$employer->number_recruit_require}}</td>
                                    <td class="quantity">{{$employer->recruited}}</td>
                                    <td>
                                        <a href="{{route('employer.edit',['employer' => $employer->employer_id])}}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('employer.destroy',['employer' => $employer->employer_id])}}" class="btn btn-danger btnDelete"
                                           data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Mã NTD</th>
                                <th>Nhà tuyển dụng</th>
                                <th>Logo</th>
                                <th>Loại hình DN</th>
                                <th>Loại hình KD</th>
                                <th>Trạng thái</th>
                                <th>Tổng số tiền</th>
                                <th>Số ứng viên cần tuyển</th>
                                <th>Số ứng viên đã tuyển</th>
                                <th colspan="2">Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                        {!! $employers->links() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
    <script>
        $(document).ready(function () {
            numeral($('.quantity').val()).format('0,0');
        })
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
        })
    </script>
@endpush
