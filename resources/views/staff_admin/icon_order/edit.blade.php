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
                                            <input type="hidden" value="3" name="type_order">
                                            <input type="hidden" value="{{$service_order_icon->service_order_icon_id}}" name="order_id">
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
                                        $order_interactives = App\Entity\Order_interactive::where('type_order', 3)->where('order_id', $service_order_icon->service_order_icon_id)->get();
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
                                <form action="{{ route('staff_icon_order.update', $service_order_icon->service_order_icon_id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        <label for="service_price_id">Chọn dịch vụ</label>
                                        <select name="service_price_id" class="select22 form-control" id="service_price_id">
                                            <option value="">--Chọn dịch vụ--</option>
                                            @php
                                            $service_prices = \App\Entity\Service_price::where('service_price_type', 1)->get();
                                            @endphp
                                            @foreach ($service_prices as $service_price)
                                            <option value="{{ $service_price->service_price_id }}" selected>{{ $service_price->service_price_title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_icon_id">Chọn icon</label>
                                        <select name="service_icon_id" class="select22 form-control" id="service_icon_id">
                                            <option value="0">--Chọn icon--</option>
                                            @php
                                            $service_icons = \App\Entity\Service_icon::get();
                                            @endphp
                                            @foreach ($service_icons as $service_icon)
                                            <option value="{{ $service_icon->service_icon_id}}"
                                                {{ ($service_order_icon->service_icon_id==$service_icon->service_icon_id) ? 'selected' : '' }}
                                                >
                                                {{ $service_icon->service_icon_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Thanh toán</label>
                                        <select name="status" class="select22 form-control" id="status">
                                            <option value="">--Chọn trạng thái đơn hàng--</option>
                                            <option value="0" {{ ($service_order_icon->status==0) ? 'selected' : '' }} >Chưa TT</option>
                                            <option value="1" {{ ($service_order_icon->status==1) ? 'selected' : '' }} >Đã TT</option>
                                        </select>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="service_order_icon_price">Giá đơn hàng</label>
                                        <input type="text" class="form-control" name="service_order_icon_price" value="{{ old('service_order_icon_price') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="service_order_icon_discount">Chiết khấu</label>
                                        <input type="text" class="form-control" name="service_order_icon_discount" value="{{ old('service_order_icon_discount') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="service_order_icon_vat">Giá vat</label>
                                        <input type="text" class="form-control" name="service_order_icon_vat" value="{{ old('service_order_icon_vat') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="service_order_icon_benifit">Quyền lợi</label>
                                        <textarea id="service_order_icon_benifit" class="editor" name="service_order_icon_benifit" cols="80"
                                            rows="10">
                                            {{ old('service_order_icon_benifit') }}  </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_order_icon_endow">Lợi ích</label>
                                        <textarea id="service_order_icon_endow" class="editor" name="service_order_icon_endow" cols="80"
                                            rows="10">
                                            {{ old('service_order_icon_endow') }}  </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="employer_name">Tên NTD</label>
                                        <input type="text" class="form-control" name="employer_name" value="{{ old('employer_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="employer_phone">SĐT NTD</label>
                                        <input type="text" class="form-control" name="employer_phone" value="{{ old('employer_phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="employer_email">Email NTD</label>
                                        <input type="text" class="form-control" name="employer_email" value="{{ old('employer_email') }}"> --}}
                                    {{-- </div> --}}
                                    <div class="form-group">
                                        <label for="service_order_icon_content">Ghi chú</label>
                                        <textarea id="service_order_icon_content" class="editor" name="service_order_icon_content" cols="80"
                                            rows="10">
                                            {{ old('service_order_icon_content', $service_order_icon->service_order_icon_content ?? '') }}  </textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
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
@endsection
