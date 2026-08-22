@extends('staff_admin.layouts.master')

@section('title', 'Danh sách ứng viên đăng ký tư vấn' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.archives')
            </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting  col-f14 ">
                    <div class="row ">
                        <div class="col-md-12 ">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('staff_archives.create') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                <a href="{{ route('staff_archives.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $listcates->links() }}
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

                            <b></b>
                        </div>
                        <div class="col-md-12 ">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($listcates as $id => $listcate )
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{$listcate->id_cate_voucher }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td>
                                                <p><input type="checkbox" id="master"></p>
                                            </td> --}}
                                            <td class="lid_1"><p style="width:50px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_2"><p style="width:300px">Tên kho tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:500px">Slug kho tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width:60px">Sửa<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($listcates as $id => $listcate )
                                        <tr>
                                            {{-- <td>
                                                <input type="checkbox" class="sub_chk" data-id="{{$listcate->id_cate_voucher }}">
                                            </td> --}}
                                            <td class="lid_1">{{ $listcate->id_cate_voucher }}</td>
                                            <td class="lid_2">{{ $listcate->name_cate_voucher }}</td>
                                            <td class="lid_3">{{ $listcate->slug_cate_voucher }}</td>
                                            <td class="lid_4">
                                                <a class="btn btn-sm btn-primary" href="{{ route('staff_archives.edit',['id_cate_voucher' => $listcate->id_cate_voucher]) }}">Sửa</a>
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
            @include('site.partials.popup_delete')
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
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
            url: '{{ route('delete_all_archives') }}',
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
</script>
@endsection
