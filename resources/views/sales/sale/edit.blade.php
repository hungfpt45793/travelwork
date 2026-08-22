@extends('admin.layout.admin')

@section('title', 'Cập nhật gói bán hàng ' . $sale->sale_package_name)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật gói bán hàng {{$sale->sale_package_name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bán hàng</a></li>
            <li><a href="#">Gói bán hàng</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('sale.update',['sale_package_id'=>$sale->sale_package_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-8">

                    <div class="box box-primary">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $error }}</strong>
                                </div>
                            @endforeach
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên gói bán hàng</label>
                                <input type="text" class="form-control" name="sale_package_name" placeholder="Tên gói bán hàng" value="{{$sale->sale_package_name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="">{{$sale->description}}</textarea>
                            </div>


                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chi tiết gói bán hàng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="form-control select2" name="status">
                                    <option value="0" {{$sale->status == 0 ? 'selected' : ''}}>Chưa xác định</option>
                                    <option value="1" {{$sale->status == 1 ? 'selected' : ''}}>Đang chăm sóc</option>
                                    <option value="2" {{$sale->status == 2 ? 'selected' : ''}}>Thất bại</option>
                                    <option value="3" {{$sale->status == 3 ? 'selected' : ''}}>Thành công</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control" name="price" value="{{$sale->price}}" placeholder="Giá" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                <input type="text" class="form-control" name="recruit_number" placeholder="Số lượng tuyển dụng" value="{{$sale->recruit_number}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Khu vực cần tuyển dụng</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                    {{$province->province_id == $sale->province ? 'selected' : ''}}>{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
                                                <option value="">-- Chọn Quận/Huyện --</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                    <option value="{{$district->district_id}}"
                                                    {{$district->district_id == $sale->district ? 'selected' : ''}}>{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày ký hợp đồng</label>
                                <input type="date" class="form-control" name="contract_signing_date" value="{{$sale->contract_signing_date}}" placeholder="Ngày ký hợp đồng" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Đã thanh toán</label>
                                <input type="text" class="form-control" name="paid" value="{{$sale->paid}}" placeholder="Đã thanh toán" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chiết khấu</label>
                                <input type="text" class="form-control" name="discount" value="{{$sale->discount}}" placeholder="% chiết khấu" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn mã giảm giá</label>
                                <select class="form-control select2" name="affiliate_id">
{{--                                    <option>Giảm giá 10%</option>--}}
{{--                                    <option>Giảm giá 5%</option>--}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn nhóm gói bán hàng</h3>
                        </div>

                        <div class="box-body scrollGroup">
                            @foreach($saleGroups as $saleGroup)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="list_sales_packages[]" value="{{$saleGroup->list_sales_packages_id}}" class="flat-red"
                                        {{!empty(\App\Entity\SalePackageSaleGroup::where('sale_package_id', $sale->sale_package_id)
                                        ->where('list_sales_packages_id', $saleGroup->list_sales_packages_id)->first()) ? 'checked' : ''}}
                                        >
                                        {{$saleGroup->	list_sales_packages_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhà tuyển dụng</label>
                                <select class="form-control select2" id="employer" name="employer_id">
                                    <option>-- Chọn Nhà Tuyển Dụng --</option>
                                    @foreach($employers as $employer)
                                        <option value="{{$employer->employer_id}}"
                                        {{$employer->employer_id == $sale->employer_id ? 'selected' : ''}}
                                        >{{$employer->enterprise_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="detail">
                                <label>{{\App\Entity\Employer::where('employer_id', $sale->employer_id)->first()->enterprise_name}}</label>
                                <p>Địa chỉ: {{\App\Entity\Employer::join('district','district.district_id','=','employer.district')->where('employer_id', $sale->employer_id)->first()->district_name . ' - ' .
                                 \App\Entity\Employer::join('province','province.province_id','=','employer.province')->where('employer_id', $sale->employer_id)->first()->province_name }}</p>
                                <p>Hotline: {{\App\Entity\Employer::where('employer_id', $sale->employer_id)->first()->phone}}</p>
                                <p>Người đại diện: {{\App\Entity\EmployerRepresentative::where('employer_id', $sale->employer_id)->first()->representative_name}}</p>
                                <p>Doanh nghiệp: {{\App\Entity\Employer::where('employer_id', $sale->employer_id)->first()->enterprise_name}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhân viên phụ trách</label>
                                <select class="form-control select2" id="chooseStaff" name="user_id">
                                    <option value="0">-- Chọn nhân viên phụ trách --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}"
                                        {{ $user->id == $sale->user_id ? 'selected' : ''}}
                                        >{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="staff">
                                <label>Họ và tên: {{\App\Entity\User::where('id', $sale->user_id)->first()->name}}</label>
                                <p>Địa chỉ: {{\App\Entity\User::where('id', $sale->user_id)->first()->address}}</p>
                                <p>Hotline: {{\App\Entity\User::where('id', $sale->user_id)->first()->phone}}</p>
                                <p>Email: {{\App\Entity\User::where('id', $sale->user_id)->first()->email}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                        <div class="box-header"><h3 class="box-title">Thông tin CSKH</h3></div>
                        <div class="box-body">
                            @foreach(\App\Entity\NoteSales::where('sale_package_id', $sale->sale_package_id)->get() as $note)
                                <div class="form-group">
                                    <p>- {{$note->note}}.</p>
                                </div>
                            @endforeach
                            <div class="form-group" id="noteContent">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea rows="4" class="form-control" name="note"
                                          id="note-sale" placeholder="Ghi chú"></textarea>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" id="note">Ghi</button>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#chooseStaff').change(function () {
                var staff = $(this).val();
                $.get('/admin/ajax-staff/' + staff, function (data) {
                    $('#staff').html(data);
                })
            });

            $('#employer').change(function () {
                var employer = $(this).val();
                $.get('/admin/ajax-employer/' + employer, function (data) {
                    $('#detail').html(data);
                })
            });

            $('#note').click(function () {
                $.ajax({
                    url: '{{route('note-sale')}}',
                    method: 'GET',
                    data:{
                        content: $('#note-sale').val()
                    },
                    success: function (data) {
                        $('#noteContent').html(data);
                        $('#note-sale').val('');
                    }
                })
            });

            $('#note-sale').keypress(function(event){
                if ((event.keyCode ? event.keyCode : event.which) == '13') {
                    $.ajax({
                        url: '{{route('note-sale')}}',
                        method: 'GET',
                        data:{
                            content: $('#note-sale').val()
                        },
                        success: function (data) {
                            $('#noteContent').html(data);
                            $('#note-sale').val('');
                        }
                    })
                }
            });

            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
        })
    </script>
@endpush