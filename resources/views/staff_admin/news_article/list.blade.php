<?php
//1
$date_search_start = '';
if(isset($_GET['date_search_start'])){
    $date_search_start = $_GET['date_search_start'];
}
//2
$date_search_end = '';
if(isset($_GET['date_search_end'])){
    $date_search_end = $_GET['date_search_end'];
}
//3
$post_question = '';
if(isset($_GET['post_question'])){
    $post_question = $_GET['post_question'];
}
//4
$title = '';
if(isset($_GET['title'])){
    $title = $_GET['title'];
}
//6
$sale_money = '';
if(isset($_GET['sale_money'])){
    $sale_money = $_GET['sale_money'];
}
//7
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>

@extends('staff_admin.layouts.master')

@section('title', 'Danh sách bài viết' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.news_article')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
                <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                    <div class="contentJobsInteresting  col-f14 ">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                    <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                    <a href="{{ route('staff_article.create') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                    <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm bài viết</h5>
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
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        <input type="hidden" value="{{ $num }}" name="num">
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $post_question_get = '';
                                                            if(isset($_GET['post_question']))
                                                            {
                                                                $post_question_get = $_GET['post_question'];
                                                            }
                                                            ?>
                                                            <select class="form-control select2" name="post_question">
                                                                <option value="">-- Tạo câu hỏi cho bài viết--</option>
                                                                <option value="0" @if($post_question_get == '0') selected @endif>-- Chưa tạo câu hỏi --</option>
                                                                <option value="1" @if($post_question_get == '1') selected @endif>-- Đã tạo câu hỏi --</option>
                                                            </select>

                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $title_get = '';
                                                            if(isset($_GET['title']))
                                                            {
                                                                $title_get = $_GET['title'];
                                                            }
                                                            ?>
                                                            <input style="height: 28px;" type="text" placeholder="Tên bài viết" class="form-control" name="title" value="@if(!empty($title_get)) {{$title_get}} @endif">

                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $sale_money_get = '';
                                                            if(isset($_GET['sale_money']))
                                                            {
                                                                $sale_money_get = $_GET['sale_money'];
                                                            }
                                                            ?>
                                                            <select class="form-control select2" name="sale_money">
                                                                <option value="">-- Chia sẻ bài viết --</option>
                                                                <option value="0" @if($sale_money_get == '0') selected @endif>-- Không --</option>
                                                                <option value="1" @if($sale_money_get == '1') selected @endif>-- Có--</option>
                                                            </select>
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
                                    <a href="{{ route('staff_article.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                    <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                                </div>
                                    <!-- form tim kiem theo id bài viết -->
                                    <div>
                                        <form action="" class="">
                                            <div class="group-form border border-primary">
                                                <input class="border-0 input-lg" type="text"
                                                    name="post_id" style="width:80px"
                                                    value="{{ (!empty($_GET['post_id'])) ? $_GET['post_id'] : ''  }}"
                                                    placeholder="ID Bài viết">
                                                <button class="search border-0" type="submit"><i class="fa fa-search "
                                                        aria-hidden="true"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="custom-paginate ml-1 mt-1 row">
                                    {{ $posts->links() }}
                                    số bản ghi của một trang:
                                    <span class="input-submit">
                                        <form action="" class="inline">
                                            <input type="submit" value="200" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==200) ? 'active' : '' }}">
                                            <input type="submit" value="50" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==50) ? 'active' : '' }}">
                                            <input type="submit" value="40" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==40) ? 'active' : '' }}">
                                            <input type="submit" value="30" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==30) ? 'active' : '' }}">
                                            <input type="submit" value="20" name="num"  class="{{ (!isset($_GET['num'])) ? 'active' : '' }} {{ (isset($_GET['num']) && $_GET['num']==20) ? 'active' : '' }}">
                                            <input type="submit" value="10" name="num" class="{{ (isset($_GET['num']) && $_GET['num']==10) ? 'active' : '' }}">
                                            <input type="hidden" value="{{ $date_search_start }}" name="date_search_start">
                                            <input type="hidden" value="{{ $date_search_end }}" name="date_search_end">
                                            <input type="hidden" value="{{ $post_question }}" name="post_question">
                                            <input type="hidden" value="{{ $title }}" name="title">
                                            <input type="hidden" value="{{ $sale_money }}" name="sale_money">
                                        </form>
                                    </span>
                                    | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $total_post }} bản ghi
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <div class="lockedWrap lockedWrap-first">
                                        <div class="cellWrap cellWrap-first">
                                            <p><input type="checkbox" id="master"></p>
                                        </div>
                                        @foreach ($posts as $post)
                                        <div class="cellWrap">
                                            <input type="checkbox" class="sub_chk" data-id="{{ $post->post_id }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-wrapper tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                {{-- <td scope="col">
                                                    <p><input type="checkbox" id="master"></p>
                                                </td> --}}
                                                <td scope="col " class="lid_1"><p style="width:40px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                <td scope="col " class="lid_8"><p style="width:50px">Sửa<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                                <td scope="col " class="lid_9"><p style="width:70px">Câu hỏi<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                                <td scope="col " class="lid_2"><p style="width:80px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                <td scope="col " class="lid_3"><p style="width:400px">Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                <td scope="col " class="lid_4"><p style="width:50px">Link<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                <td scope="col " class="lid_5"><p style="width:300px">Danh mục<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td scope="col " class="lid_6"><p style="width:80px">Hình ảnh<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                                <td scope="col " class="lid_7"><p style="width:80px">Chia sẻ?<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                            <tr>
                                                {{-- <td class="numeric">
                                                    <input type="checkbox" class="sub_chk" data-id="{{ $post->post_id }}">
                                                </td> --}}
                                                <td class="lid_1" scope="col ">{{ $post->post_id }}</td>
                                                <td class="lid_8" scope="col ">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('staff_article.edit', ['post_id' => $post->post_id]) }}">
                                                        sửa
                                                    </a>
                                                </td>
                                                <td class="lid_9">
                                                    <a class="btn btn-sm btn-info" href="{{ route('staff_add_question', ['post_id' => $post->post_id]) }}">
                                                        câu hỏi
                                                    </a>
                                                </td>
                                                <td class="lid_2" scope="col ">
                                                @if (isset($post->updated_at))
                                                <?php
                                                $date=date_create($post->updated_at);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                                @else
                                                <?php
                                                $date=date_create($post->created_at);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                                @endif
                                                </td>
                                                <td class="lid_3" scope="col ">
                                                    <?php
                                                    $total = 0;
                                                    $total = \App\Entity\Post_question::get_total_question($post->post_id);
                                                    ?>
                                                    <p class="crop" style="width:400px">{{ $post->title }}</p>
                                                    @if(!empty($total))
                                                    <span style="color: red">({{ $total }} câu hỏi được tạo)</span>
                                                    @endif
                                                </td>
                                                <td class="lid_4" scope="col ">
                                                    <a target="_blank" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}">
                                                        Link
                                                    </a>
                                                </td>
                                                <td class="lid_5" scope="col ">{{ $post->category_string }}</td>
                                                <td class="lid_6" scope="col "><img src="{{ $post->image }}" style="width: 50px"></td>
                                                <td class="lid_7" scope="col ">
                                                    @if($post->sale_money == 1)
                                                    <p class="text-success">có</p>
                                                    @elseif($post->sale_money == 0)
                                                    <p class="text-danger">không</p>
                                                    @endif
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
                        url: '{{ route('delete_all_post') }}',
                        type: 'DELETE',
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
                                alert('Có lỗi Không xóa thành công!!');
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
