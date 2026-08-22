@extends('admin.layout.admin')

@section('title', 'Thêm mới gói bán hàng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới gói bán hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bán hàng</a></li>
            <li><a href="#">Gói bán hàng</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('sale.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
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
                                <input type="text" class="form-control" name="sale_package_name" placeholder="Tên gói bán hàng" value="{{old('sale_package_name')}}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control" name="description"
                                          placeholder="Mô tả gói bán hàng">{{old('description')}}</textarea>
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chi tiết gói bán hàng</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select class="form-control select2" name="status">
                                    <option value="0" {{old('status') == 0 ? 'selected' : ''}}>Chưa xác định</option>
                                    <option value="1" {{old('status') == 1 ? 'selected' : ''}}>Đang chăm sóc</option>
                                    <option value="2" {{old('status') == 2 ? 'selected' : ''}}>Thất bại</option>
                                    <option value="3" {{old('status') == 3 ? 'selected' : ''}}>Thành công</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá</label>
                                <input type="text" class="form-control" name="price" placeholder="Giá" value="{{old('price')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                <input type="text" class="form-control" name="recruit_number" placeholder="Số lượng tuyển dụng" value="{{old('recruit_number')}}" required/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Khu vực cần tuyển dụng</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                    {{$province->province_id == old('province') ? 'selected' : ''}}
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
                                                <option value="0">-- Chọn Quận/Huyện --</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                    <option value="{{$district->district_id}}"
                                                    {{$district->district_id == old('district') ? 'selected' : ''}}
                                                    >{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày ký hợp đồng</label>
                                <input type="date" class="form-control" name="contract_signing_date" placeholder="Ngày ký hợp đồng" value="{{old('contract_signing_date')}}" required/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Đã thanh toán</label>
                                <input type="text" class="form-control" name="paid" placeholder="Đã thanh toán" value="{{old('paid')}}" required/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chiết khấu</label>
                                <input type="text" class="form-control" name="discount" placeholder="% chiết khấu" value="{{old('discount')}}"/>
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
                                        <input type="checkbox" name="list_sales_packages[]" value="{{$saleGroup->list_sales_packages_id}}" class="flat-red">
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
                                        <option value="0">-- Chọn Nhà Tuyển Dụng --</option>
                                        @foreach($employers as $employer)
                                        <option value="{{$employer->employer_id}}"
                                        {{$employer->employer_id == old('employer_id') ? 'selected' : ''}}
                                        >{{$employer->enterprise_name}}</option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="form-group" id="detail">
                                <?php $oldEmployer = \App\Entity\Employer::where('employer_id',old('employer_id'))->first() ?>
                                <label>{{!empty($oldEmployer) ? $oldEmployer->enterprise_name : ''}}</label>
                                <p>Địa chỉ: {{!empty($oldEmployer) ? $oldEmployer->address : ''}}</p>
                                <p>Hotline: {{!empty($oldEmployer) ? $oldEmployer->phone : ''}}</p>
                                <p>Người đại diện: {{!empty($oldEmployer) ? \App\Entity\EmployerRepresentative::where('employer_id', $oldEmployer->employer_id)
                                ->first()->representative_name : ''}} </p>
                                <p>Doanh nghiệp: {{!empty($oldEmployer) ? $oldEmployer->enterprise_name : ''}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nhân viên phụ trách</label>
                                <select class="form-control select2" id="chooseStaff" name="user_id">
                                    <option>-- Chọn nhân viên phụ trách --</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="staff">
                                <?php $oldStaff = \App\Entity\User::where('id', old('user_id'))->first() ?>
                                <label>Họ và tên: {{!empty($oldStaff) ? $oldStaff->name : ''}}</label>
                                <p>Địa chỉ: {{!empty($oldStaff) ? $oldStaff->address : ''}}</p>
                                <p>Hotline: {{!empty($oldStaff) ? $oldStaff->phone : ''}}</p>
                                <p>Email: {{!empty($oldStaff) ? $oldStaff->email : ''}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <!-- Đoạn này làm bằng ajax để lưu thông tin ghi chú -->
                        <div class="box-body">
                            <div class="form-group" id="noteContent">
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea rows="4" class="form-control" name="note"
                                         id="note-sale" placeholder="Ghi chú"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="note">Ghi</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push("scripts")
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