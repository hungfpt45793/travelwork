@extends('staff_admin.layouts.master')
@section('title', 'Danh sách đơn hàng' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="log_error">
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
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm</a>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="" style="width:100%;height:100%">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm đơn hàng</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-5 mb-3">
                                                            <label for="validationDefault01">Từ ngày(ngày tạo)</label>
                                                            @php
                                                                  $d=strtotime("-1 Months");
                                                                  $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                        </div>
                                                        <div class="col-md-5 mb-3">
                                                            <label for="validationDefault02">Đến ngày(ngày tạo)</label>
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                        </div>
                                                        <!-- myDatetime -->
                                                        <div class="col-md-2 mb-3">
                                                            <label for="validationDefault2" class="text-light">sd</label>
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        </div>
                                                        @php
                                                            $service_prices = App\Entity\Service_price::where('service_price_type',0)->get();
                                                        @endphp
                                                        <div class="col-md-6 mb-3 ">
                                                            <select class="form-control js-example-basic-single select2" name="service_price">
                                                                <option value="">--Chọn dịch vụ--</option>
                                                                @foreach ($service_prices as $service_price)
                                                                @php
                                                                    $count = App\Entity\Service_order::where('service_price_id',$service_price->service_price_id)->count();
                                                                @endphp
                                                                <option value="{{ $service_price->service_price_id  }}"
                                                                    @if(isset($_GET['service_price']) &&
                                                                    $_GET['service_price']==$service_price->service_price_id) selected @endif
                                                                    >{{ $service_price->service_price_title }}-<b class="btn btn-sm btn-success">{{ $count }}</b></option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input  class="form-control" placeholder="Email NTD" value="{{ isset($_GET['email']) ? $_GET['email'] : "" }}" id="" name="email">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input  class="form-control" placeholder="Tên NTD" value="{{ isset($_GET['name']) ? $_GET['name'] : "" }}" id="" name="name">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input  class="form-control" placeholder="SĐT NTD" value="{{ isset($_GET['number_phone']) ? $_GET['number_phone'] : "" }}" id="" name="number_phone">
                                                        </div>
                                                        {{-- <div class="col-md-6 mb-3">
                                                            <div class="form-group form-check">
                                                                <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox" {{ ( isset($_GET['not_interactive']) ) ? 'checked' : '' }} name="not_interactive"> Đơn hàng chưa tương tác
                                                                </label>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <a href="{{ route('delete_order') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button  type="button" class="btn btn-sm btn-danger delete_all mr-1">Xóa</button>
                            </div>
                                <!-- form tim kiem theo id NTD -->
                                <div>
                                    <form action="" class="">
                                        <div class="group-form border border-primary">
                                            <input class="border-0 input-lg" type="text"
                                                name="service_order_id" style="width:80px"
                                                value="{{ (!empty($_GET['service_order_id'])) ? $_GET['service_order_id'] : ''  }}"
                                                placeholder="ID Đơn hàng">
                                            <button class="search border-0" type="submit"><i class="fa fa-search "
                                                    aria-hidden="true"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="custom-paginate ml-1 mt-1 row">
                                {{ $service_orders->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($service_orders as $service_order)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $service_order->service_order_id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <td class="lid_14"><p style="width:50px">ID<button class="lockButton btn btn-sm btn-success" id="lid_14">L</button></p></td>
                                        <td class="lid_13"><p style="width:80px">TT<button class="lockButton btn btn-sm btn-success" id="lid_13">L</button></p></td>
                                        <td class="lid_2"><p style="width:120px">Mã đơn hàng<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                        <td class="lid_3"><p style="width:90px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                        <td class="lid_12"><p style="width:300px">Ghi chú<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                        <td class="lid_4"><p style="width:50px">NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                        <td class="lid_5"><p style="width:50px">TT<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                        <td class="lid_6"><p style="width:100px">Chi phí<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                        <td class="lid_7"><p style="width:50px">CK<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                        <td class="lid_8"><p style="width:120px">Chi phí có vat<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                        <td class="lid_9"><p style="width:250px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                        <td class="lid_10"><p style="width:100px">SĐT NTD<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                        <td class="lid_11"><p style="width:300px">Email NTD<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service_orders as $key => $service_order)
                                    <tr>
                                        <!-- <td class="lid_14">{{ ++$key }}</td> -->
                                        <td class="lid_2">{{ $service_order->service_order_id }}</td>
                                        <td class="lid_13">
                                            <a href="{{ route('delete_order_hard', $service_order->service_order_id) }}">
                                                <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                                            </a>
                                            <a href="{{ route('delete_order_restore', $service_order->service_order_id) }}">
                                                <button type="button" class="btn btn-sm btn-success">KP</button>
                                            </a>
                                        </td>
                                        <td class="lid_2">{{ $service_order->service_order_code }}</td>
                                        <td class="lid_3">

                                            @php
                                                $date = date_create($service_order->created_at);
                                                echo date_format($date,"d/m/Y");
                                            @endphp
                                        </td>
                                        <td class="lid_12"><p class="crop" style="width:300px">{!! $service_order->service_order_content !!}</p></td>
                                        <td class="lid_4 text-center">
                                            @if ($service_order->employer_id == 0)
                                            <i class="fa fa-times text-danger"></i>
                                            @else
                                            <i class="fa fa-check text-success"></i>
                                            @endif
                                        </td>
                                        <td class="lid_5 text-center">

                                            @if($service_order->status==0)
                                            <i class="fa fa-times text-danger"></i>

                                            @elseif($service_order->status==1)
                                            <i class="fa fa-check text-success"></i>

                                            @else
                                            @endif

                                        </td>
                                        <td class="lid_6"><span style="float:right">{{ $service_order->service_order_price }}</span></td>
                                        <td class="lid_7 text-center">{{ $service_order->service_order_discount }}</td>
                                        <td class="lid_8"><span style="float:right">{{ $service_order->service_order_vat }}</span></td>
                                        <td class="lid_9"><p class="crop">{{ $service_order->employer_name }}</p></td>
                                        <td class="lid_10">{{ $service_order->employer_phone }}</td>
                                        <td class="lid_11">{{ $service_order->employer_email }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2({width: '100%', dropdownParent: $("#timkiem"),});

        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))
         {
            $(".sub_chk").prop('checked', true);
         } else {
            $(".sub_chk").prop('checked',false);
         }
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });


            if(allVals.length <=0)
            {
                alert("Bạn chưa chọn bản ghi nào.");
            }  else {


                var check = confirm("Bạn có chắc muốn xóa?");
                if(check == true){


                    var join_selected_values = allVals.join(",");
                    console.log(join_selected_values)

                    $.ajax({
                        url: '{{ route('delete_all_hard_service_order') }}',
                        type: 'delete',
                        data: 'ids='+join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                location.reload()
                                alert(data['success'])
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }
            }
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>
@endpush
@endsection
