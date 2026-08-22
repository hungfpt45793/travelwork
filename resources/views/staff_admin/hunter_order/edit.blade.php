@extends('staff_admin.layouts.master')
@section('title', 'Sửa đơn hàng tuyển dụng' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="col-md-12 col-12">
                                @if($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ $error }}</strong>
                                </div>
                                @endforeach
                                @endif
                                @if(session('msg'))
                                <div class="alert alert-danger" role="alert" style="padding: 5px;margin: 2px;display: inline-block;">
                                    <strong>{{ session('msg') }}</strong>
                                </div>
                                @endif
                                <h5 class="text-info" style="display: inline-block;">Danh sách lịch sử tương tác đơn hàng &nbsp;</h5>
                                <form role="form" action="{{ route('order_interactive.store') }}" method="POST">
                                {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" value="2" name="type_order">
                                            <input type="hidden" value="{{$hunter_order->hunter_regis_id}}" name="order_id">
                                            @php $user_id = Auth::id(); $staff_id = App\Entity\Staff::where('user_id', $user_id)->value('staff_id'); @endphp
                                            <input type="hidden" value="{{$staff_id}}" name="staff_id">
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Nội dung tương tác</label>
                                                <textarea name="content" class="form-control" rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Ngày tương tác</label>
                                                <input type="date" value="{{ date('Y-m-d') }}" name="interactive_day" class="form-control" />
                                            </div>
                                            <button type="submit" class="btn mt-1 btn-success">Lưu</button>
                                        </div>
                                    </div>
                                </form>
                                <hr class="hr" />
                                <div class="table-responsive" style="padding-bottom: 20px;">
                                    <table class="table table-bordered table-hover">
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
                                        @php
                                        $order_interactives = App\Entity\Order_interactive::where('type_order', 2)->where('order_id', $hunter_order->hunter_regis_id)->get();
                                        @endphp
                                        @foreach($order_interactives as $order_interactive)
                                            <tr>
                                                <td>{{$order_interactive->id}}</td>
                                                <td>{{$order_interactive->interactive_day}}</td>
                                                @php
                                                    $staff_name = App\Entity\Staff::where('staff_id',$order_interactive->staff_id)->value('staff_name');
                                                    $user_id = App\Entity\Staff::where('staff_id', $order_interactive->staff_id)->value('user_id');
                                                @endphp
                                                <td>{{$staff_name}}</td>
                                                <td>{{$order_interactive->content}}</td>
                                                @if($user_id==Auth::id())
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sua{{$order_interactive->id}}">Sửa</button>
                                                    <div class="modal fade" id="sua{{$order_interactive->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <form method="post" action="{{route('order_interactive.update',$order_interactive->id)}}">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-body">

                                                                {!! csrf_field() !!}
                                                                {!! method_field('put') !!}
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">Nội dung tương tác</label>
                                                                        <textarea name="content" class="form-control" rows="4" required>{{$order_interactive->content}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>

                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#xoa{{$order_interactive->id}}">
                                                    Xóa
                                                    </button>
                                                    <div class="modal fade" id="xoa{{$order_interactive->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Chắc chắn xóa chứ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <form method="post" action="{{route('order_interactive.destroy',$order_interactive->id)}}">
                                                            {!! csrf_field() !!}
                                                            {!! method_field('delete') !!}
                                                            <button type="submit" class="btn btn-primary">Delete</button>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="hr">
                                <form action="{{ route('staff_hunter_order.update', $hunter_order->hunter_regis_id) }}" method="POST" class="row custom-form">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="text" hidden name="employer_id" value="{{ $employer_id }}">
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for=""><span class="float-right">Tên nhà tuyển dụng</span></label>
                                        <input type="text" class="form-control" value="{{ old('hunter_regis_name',$hunter_order->hunter_regis_name) }}" name="hunter_regis_name" >
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for=""><span class="float-right">Email</span></label>
                                        <input type="text" class="form-control " value="{{  old('hunter_regis_email',$hunter_order->hunter_regis_email) }}"  name="hunter_regis_email">
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for=""><span class="float-right">Số điện thoại</span></label>
                                        <input type="number" class="form-control " value="{{ old('hunter_regis_phone',$hunter_order->hunter_regis_phone) }}"  name="hunter_regis_phone">
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for=""><span class="">Thanh toán</span></label>
                                        <select name="hunter_regis_status" class="form-control select22" >
                                            <option value="0" {{ ($hunter_order->hunter_regis_status==0) ? 'selected' : '' }}>Chưa thanh toán</option>
                                            <option value="1" {{ ($hunter_order->hunter_regis_status==1) ? 'selected' : '' }}>Đã thanh toán</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label for=""><span class="">Tỉnh/Thành phố</span></label>
                                        <select class="form-control select22"  aria-label="Tỉnh/Thành phố"
                                            id="province" required name="hunter_regis_province">
                                            <option value=""> -- Tất cả các tỉnh/thành phố --</option>
                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                            <option
                                            {{ ($hunter_order->hunter_regis_province==$province->province_id) ? 'selected' : ''}}
                                            value="{{$province->province_id}}">{{$province->province_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <label for=""><span class="t">Quận/huyện</span></label>
                                        <select class="form-control select22"
                                            aria-label="Quận/Huyện" id="district" required name="hunter_regis_district">
                                            <option value=""> -- Tất cả các quận/huyện --</option>
                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                            <option
                                            {{ ($hunter_order->hunter_regis_district==$district->district_id) ? 'selected' : ''}}
                                            value="{{$district->district_id}}">{{$district->district_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12">
                                        <label for=""><span class="float-right">Địa chỉ</span></label>
                                        <input type="text" class="form-control" value="{{ $hunter_order->hunter_regis_address }}" required name="hunter_regis_address">
                                    </div>


                                    <div class="form-group col-md-12 col-lg-12">
                                        <label for=""><span class="float-right">Ghi chú</span></label>
                                        <textarea type="text" class="form-control " placeholder="" rows="5" name="hunter_regis_note">{{ old('hunter_regis_note',$hunter_order->hunter_regis_note) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-bordered custom-table p-3">
                                                    <tr>
                                                        <th rowspan="2" class="text-center">Vị trí cần tuyển</th>
                                                        <th colspan="{{ $hunters_time->count() }}" class="text-center">Thời gian</th>
                                                    </tr>
                                                    <tr>
                                                        @foreach ($hunters_time as $hunter_time)
                                                        <th class="text-center">{{ $hunter_time->hunter_time_name }}</th>
                                                        @endforeach
                                                    </tr>
                                                    @foreach ($hunters_pos as $hunter_pos)
                                                    <tr>
                                                        @php
                                                        $hunters_price =
                                                        \App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
                                                        @endphp
                                                        <td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>
                                                        @foreach ($hunters_price as $hunter_price)
                                                        <td><span class="float-right hunter_regis_price"><input type="radio"
                                                                    data="btn{{ $hunter_pos->hunter_pos_id }}"
                                                                    name="hunter_regis_price"
                                                                    id="id{{ $hunter_price->hunter_price_id }}"
                                                                    value="{{ $hunter_price->hunter_price_id }}"
                                                                    {{ ($hunter_order->hunter_regis_price==$hunter_price->hunter_price_id) ? 'checked' : '' }}
                                                                    > <label
                                                                    for="id{{ $hunter_price->hunter_price_id }}">{{ $hunter_price->hunter_price_name }}</label></span>
                                                        </td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-12">
                                        <label for=""><span class="float-right"></span></label>
                                        <button type="submit" class="btn btn-success ">Lưu thông tin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#province').change(function () {
        $.get('/ajax-district/' + $(this).val(), function (data) {
            $('#district').html(data);
        });
    });
});
</script>
@endsection
