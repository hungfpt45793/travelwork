<?php
    $title = '';
    if(isset($_GET['name'])){
        $title = $_GET['name'];
    }
    $num = '';
    if(isset($_GET['num'])){
        $num = $_GET['num'];
    }
    $date_search_start = '';
    if(isset($_GET['date_search_start'])){
        $date_search_start = $_GET['date_search_start'];
    }
    $date_search_end = '';
    if(isset($_GET['date_search_end'])){
        $date_search_end = $_GET['date_search_end'];
    }
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách mẫu email' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.marketing')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
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
                    <div class="contentJobsInteresting  col-f14 ">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                    <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                    <a href="{{ route('create_email') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                    <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="">
                                            <div class="modal-body">
                                                <div class="form-row employee-search ">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault01">Từ ngày</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                      </div>
                                                      <div class="col-md-5 mb-3">
                                                        <label for="validationDefault02">Đến ngày</label>
                                                        <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                      </div>
                                                        <!-- myDatetime -->
                                                    <div class="col-md-2 mb-3">
                                                        <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày">
                                                        <input type="hidden" value="{{ $num }}" name="num">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Tên mẫu email</label>
                                                            <?php $title_get = isset($_GET['name']) ? $_GET['name'] : '';?>
                                                            <input type="text "  placeholder="Tên mẫu email" class="form-control " name="name" value="{{ $title_get }}">
                                                        </div>
                                                    </div>
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
                                    <a href="{{ route('form_email') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                    {{-- <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button> --}}
                                    </div>
                                    <div>
                                        <form action="" class="">
                                            <div class="group-form border border-primary">
                                                <input class="border-0 input-lg" type="text"
                                                    name="id_cate_tem" style="width:83px"
                                                    value="{{ (!empty($_GET['id_cate_tem'])) ? $_GET['id_cate_tem'] : ''  }}"
                                                    placeholder="ID Mẫu email">
                                                <button class="search border-0" type="submit"><i class="fa fa-search "
                                                        aria-hidden="true"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="custom-paginate ml-1 mt-1 row">
                                    {{ $array_category_template_email->links()  }}
                                    số bản ghi của một trang:
                                    <span class="input-submit">
                                        <form action="" class="inline">
                                            <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                            <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                            <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                            <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                            <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                            <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                            {{-- <input type="hidden" value="{{ $date_search_start }}" name="date_search_start">
                                            <input type="hidden" value="{{ $date_search_end }}" name="date_search_end">
                                            <input type="hidden" value="{{ $post_question }}" name="post_question">
                                            <input type="hidden" value="{{ $title }}" name="title">
                                            <input type="hidden" value="{{ $sale_money }}" name="sale_money"> --}}
                                        </form>
                                    </span>
                                    | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total }} bản ghi
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <div class="lockedWrap lockedWrap-first">
                                        <div class="cellWrap cellWrap-first">
                                            <p><input type="checkbox" id="master"></p>
                                        </div>
                                        @foreach ($array_category_template_email as $category_template_email)
                                        <div class="cellWrap">
                                            <input type="checkbox" class="sub_chk" data-id="{{ $category_template_email->post_id }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                <td class="lid_1"><p style="width:32px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                <td class="lid_4"><p style="width:73px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                <td class="lid_8"><p style="width:40px">Tên<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                                <td class="lid_2"><p style="width:45px">Slug<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                <td class="lid_3"><p style="width:126px">Lưu ý biến truyền<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($array_category_template_email as $category_template_email)
                                            <tr>
                                                <td class="lid_1">{{ $category_template_email->id_cate_tem }}</td>
                                                <td class="lid_4">
                                                    <a href="{{ route('list_category_template_email',['id_cate_tem'=> $category_template_email->id_cate_tem]) }}">
                                                        <button class="btn btn-primary btn-sm">
                                                        Mẫu (<span>
                                                                <?php
                                                                $total = 0;
                                                                $total = \App\Entity\Template_email::getTotal($category_template_email->id_cate_tem);
                                                                echo $total;
                                                                ?>
                                                            </span>)
                                                        </button>
                                                    </a>
                                                </td>
                                                <td class="lid_8 crop">
                                                    {{ $category_template_email->name_cate_tem}}
                                                </td>
                                                <td class="lid_2 crop">
                                                    {{ $category_template_email->slug_cate_tem}}
                                                </td>
                                                <td class="lid_3 contentP crop">
                                                    {!! $category_template_email->note_tem_var !!}
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
@include('site.partials.popup_delete')
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
                        url: "{{ route('delete_all_hard_post') }}",
                        type: 'post',
                        data: 'Ids='+join_selected_values,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                location.reload()
                                alert(data['success'])
                            } else {
                                alert('Có lỗi. Xóa không thành công!!');
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
