@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên đăng ký tư vấn' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
		{{-- sitebar --}}
		<div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
			@include('staff_admin.sidebars.order')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting  col-f14 ">
                    <div class="d-flex justify-content-start">
                        <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>

                        <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                <form action="">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên đăng ký tư vấn</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="form-row employee-search ">
                                                <div class="col-md-5 mb-3">
                                                <label for="validationDefault01">Từ ngày</label>
                                                @php
                                                        $d=strtotime("-1 Months");
                                                        $date = date("Y-m-d", $d)
                                                @endphp
                                                <input value="{{ $date }}" class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : '' }}" type="date" id="" name="date_search_start">
                                                </div>
                                                <div class="col-md-5 mb-3">
                                                <label for="validationDefault02">Đến ngày</label>
                                                <input value="{{ date('Y-m-d') }}" class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : '' }}" type="date" id="" name="date_search_end">
                                                </div>
                                                    <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                        <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                    </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php $name = !empty($_GET['name_search']) ? $_GET['name_search'] : '';
                                                            ?>
                                                        <input type="text " placeholder="Tên ứng viên" class="form-control" value="{{ isset($_GET['name_search'])  ? $name : '' }}" name="name_search">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class=" form-control " name="id_sort">

                                                            @php
                                                                if(!empty($_GET['id_sort'])){
                                                                    $id_sort = $_GET['id_sort'];
                                                                }
                                                                else $id_sort = '3';
                                                            @endphp
                                                            <option value="" {{ ($id_sort == 3) ? 'selected' : '' }}>--Sắp xếp theo id--</option>
                                                            <option value="0" {{ ($id_sort == 0) ? 'selected' : '' }}>--Giảm dần--</option>
                                                            <option value="1" {{ ($id_sort == 1) ? 'selected' : '' }}>--Tăng dần--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class=" form-control " name="status_view_search">
                                                            @php
                                                                if(!empty($_GET['status_view_search'])){
                                                                    $status_view_search = $_GET['status_view_search'];
                                                                }
                                                                else $status_view_search = '3';
                                                            @endphp
                                                            <option {{ ($status_view_search == 3) ? 'selected' : '' }}>--Trạng thái--</option>
                                                            <option value="0" {{ ($status_view_search == 0) ? 'selected' : '' }}>--Chưa xem--</option>
                                                            <option value="1" {{ ($status_view_search == 1) ? 'selected' : '' }}>--Đã xem--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group form-check">
                                                        <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" {{ ( isset($_GET['not_interactive']) ) ? 'checked' : '' }} name="not_interactive"> UV chưa tương tác
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit " class="btn btn-primary">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <a href="{{ route('staff_advisory_employee.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                        <button data-url="{{ url('delete/all-advisory_employer') }}" class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                    </div>
                    <div class="custom-paginate row mt-1 ml-1">
                        {{ $res_ads->links() }}
                        số bản ghi của một trang:
                        <span class="input-submit">
                            <form action="{{ route('staff_advisory_employee.index') }}" class="inline">
                                <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                            </form>
                        </span>
                        | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $count }} bản ghi
                    </div>
                    <div class="row ">
                        <div class="col-md-12 ">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($res_ads as $res)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $res->id_res }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_2"><p style="width:50px">TT<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_1"><p style="width:40px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_3"><p style="width:75px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_7"><p style="width:300px">Công việc mong muốn<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_4"><p style="width:200px">Tên ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p> </td>
                                            <td class="lid_5"><p style="width:110px">SĐT<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p style="width:200px">Email<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($res_ads as $id => $res )
                                        <tr>
                                        <td class="lid_2">
                                                <a class="text-dark" href="{{ route('staff_advisory_employee.edit', ['id_res' => $res->id_res]) }}">
                                                    @if($res->status_view == 0)
                                                    <span class="btn btn-sm btn-danger">Thao tác</span>
                                                    @else
                                                    <span class="btn btn-sm btn-success">Thao tác</span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="lid_1">
                                                <a class="text-dark" href="{{ route('staff_advisory_employee.edit', ['id_res' => $res->id_res]) }}">
                                                {{ $res->id_res }}
                                                </a>
                                            </td>

                                            <td class="lid_3">
                                                <a class="text-dark" href="{{ route('staff_advisory_employee.edit', ['id_res' => $res->id_res]) }}"><?php
                                                $date=date_create($res->created_at);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                                </a>
                                            </td>
                                            <td class="lid_7">
                                                @php
                                                    $text = $res->message_res;
                                                    $replace = array('<p>','</p>','<h2>','<h1>','<h3>','<h4>','<h5>','<h6>');
                                                    $text =  str_replace($replace,'',$text);
                                                @endphp
                                                <p style="width:300px" class="crop"> {!! $text !!}</p>
                                            </td>
                                            <td class="lid_4">
                                                <a class="text-dark" href="{{ route('staff_advisory_employee.edit', ['id_res' => $res->id_res]) }}">
                                                {{ $res->name_res }}
                                                </a>
                                            </td>
                                            <td class="lid_5">
                                                {{ $res->phone_res }}
                                            </td>
                                            <td class="lid_6">
                                                <p style="width:200px" class="crop">{{  $res->email_res  }}</p>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                @include('site.partials.popup_delete')
                            </div>
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
                        url: '{{ route('delete_all_advisory_employer') }}',
                        type: 'DELETE',
                        data: 'ids='+join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                location.reload()
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
