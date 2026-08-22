@extends('staff_admin.layouts.master')

@section('title', 'Danh sách chuyên mục' )

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
                            <div class="col-md-12 space-b">
                                <div class="d-flex justify-content-start">
                                    <a href="{{ route('staff_category_article.create') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                    {{-- <a href="{{ route('staff_category_article.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a> --}}
                                    <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                                </div>

                            </div>
                            <div class="col-md-12 ">
                                <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <div class="lockedWrap lockedWrap-first">
                                        <div class="cellWrap cellWrap-first">
                                            <p><input type="checkbox" class="btn btn-primary" id="master"></p>
                                        </div>
                                        @foreach ($categories as $id => $cate )
                                        <div class="cellWrap">
                                            <input type="checkbox" class="sub_chk" data-id="{{ $cate->category_id }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-wrapper" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="tableFixHead custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                {{-- <td>
                                                    <p><input type="checkbox" id="master"></p>
                                                </td> --}}
                                                <td class="lid_1"><p style="width:40px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></p></td>
                                                <td class="lid_2"><p style="width:50px">Sửa<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></p></td>
                                                {{-- <td class="lid_1">Ngày tạo</td> --}}
                                                <td class="lid_3"><p style="width:400px">Tiêu đề<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></p></td>
                                                <td class="lid_4"><p style="width:400px">Danh mục<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></p></td>
                                                <td class="lid_5"><p style="width:260px">Hình ảnh<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></p></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $id => $cate )
                                            <tr>
                                                {{-- <td class="numeric">
                                                    <input type="checkbox" class="sub_chk" data-id="{{ $cate->category_id }}">
                                                </td> --}}
                                                <td class="lid_1">{{ $cate->category_id }}</td>
                                                <td class="lid_2">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('staff_category_article.edit',['category_id' => $cate->category_id]) }}">
                                                        sửa
                                                    </a>
                                                </td>
                                                {{-- <td class="lid_1">
                                                    @if (isset($cate->updated_at))
                                                    @php
                                                    $date=date_create($cate->updated_at);
                                                    echo date_format($date,"d/m/Y");
                                                    @endphp
                                                    @else
                                                    @php
                                                    $date=date_create($cate->created_at);
                                                    echo date_format($date,"d/m/Y");
                                                    echo $cate->created_at;
                                                    @endphp
                                                    @endif
                                                </td> --}}
                                                <td class="lid_3">
                                                    <p class="crop" style="width:400px">{{ $cate->title }}</p>
                                                </td>
                                                <td class="lid_4">
                                                    {{ $cate->slug }}
                                                </td>
                                                <td class="lid_5">
                                                    <img width="100" src="{{ $cate->image }}" />
                                                </td>
                                            </tr>
                                            @foreach ($cate['sub_children'] as $child)
                                                <tr>
                                                    <td class="numeric">
                                                        <input type="checkbox" class="sub_chk" data-id="{{ $child['category_id'] }}">
                                                    </td>
                                                    <td class="lid_1">{{ $child['category_id'] }}</td>
                                                    {{-- <td scope="col">
                                                        @if (isset($child['updated_at']))
                                                        @php
                                                        $date=date_create($child['updated_at']);
                                                        echo date_format($child['updated_at'],"d/m/Y");
                                                        @endphp
                                                        @elseif(isset($child['created_at']))
                                                        @php
                                                        $date=date_create($child['created_at']);
                                                        echo date_format($date,"d/m/Y");
                                                        @endphp
                                                        @endif
                                                    </td> --}}
                                                    <td class="lid_2">{{ $child['title'] }}</td>
                                                    <td class="lid_3">{{ $child['slug'] }}</td>
                                                    <td class="lid_4"><img width="100" src="{{ $child['image'] }}" /></td>
                                                    <td class="lid_5">
                                                        <div class="button-group">
                                                            <button type="button" class="btn btn-info dropdown-toggle">Thao tác</button>
                                                            <div class="button-dropdown">
                                                                <a href="">
                                                                    câu hỏi
                                                                </a>
                                                                <a href="{{ route('staff_article_category.edit',['category_id' => $child['category_id']]) }}">
                                                                    sửa
                                                                </a>
                                                                <a href="{{ route('staff_article_category.destroy',['category_id' => $child['category_id']]) }}" class=" btnDelete"
                                                                    data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                                    xóa
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                        @include('site.partials.popup_delete')
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
                        url: '{{ route('delete_all_category_article') }}',
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
@endsection
