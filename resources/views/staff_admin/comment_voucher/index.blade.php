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
                        @if (session('success'))
                            <div class="infoAlert">
                                <div class="alert alert-success">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="infoAlert">
                                <div class="alert alert-warning">
                                    <span>{{ session('error') }}</span>
                                    <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('staff_comment_voucher.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $voucher_comments->links() }}
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
						<div class="col-md-12 ">
                                @if(!empty($voucher_comments))
                                <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <div class="lockedWrap lockedWrap-first">
                                        <div class="cellWrap cellWrap-first">
                                            <p><input type="checkbox" id="master"></p>
                                        </div>
                                        @foreach ($voucher_comments as $id => $comment)
                                        <div class="cellWrap">
                                            <input type="checkbox" class="sub_chk" data-id="{{ $comment['id_voucher_cm'] }}">
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
                                            <td class="lid_1"><p style="width:80px">Trả lời<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_7"><p style="width:100px">Trạng thái<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_2"><p style="width:50px">ID<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:350px">Tài liệu<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_4"><p style="width:500px">Nội dung bình luận<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width:150px">User bình luận<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p style="width:150px">Thời gian bình luận<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($voucher_comments as $id => $comment )
                                            <tr>
                                                {{-- <td class="numeric">
                                                    <input type="checkbox" class="sub_chk" data-id="{{ $comment['id_voucher_cm'] }}">
                                                </td> --}}
                                                <td class="lid_1">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('staff_comment_voucher.edit', ['id_voucher_cm' => $comment['id_voucher_cm']]) }}">
                                                        Trả lời
                                                    </a>
                                                </td>
                                                <td class="lid_7">
                                                    <?php
                                                    $anser_voucher = \App\Entity\VoucherComment::getPanentId($comment['id_voucher_cm']);
                                                    ?>
                                                    @if(!empty($anser_voucher))
                                                        <span style="color: green">Đã trả lời</span>
                                                        @else
                                                        <span style="color: red">Chưa trả lời</span>
                                                    @endif
                                                </td>
                                                <td class="lid_2" class="lid_1">{{ $comment['id_voucher_cm'] }}</td>
                                                <td class="lid_3">
                                                    <?php
                                                    $voucherId = \App\Entity\Voucher::getID($comment['id_voucher']);
                                                    ?>
                                                    <p class="crop" style="width:350px">{{ $voucherId->name_voucher }}</p>
                                                </td>
                                                <td class="lid_4">
                                                    <p class="crop" style="width:500px">{{ $comment['content_voucher_cm'] }}</p>
                                                </td>

                                                <td class="lid_5">
                                                    <?php
                                                    $user_comment = \App\Entity\User::getIdUser($comment['user_id']);
                                                    if(!empty($user_comment))
                                                        {
                                                            echo $user_comment->name;
                                                        }
                                                        else

                                                            {
                                                                echo 'khong xac dinh';
                                                            }
                                                    ?>

                                                </td>
                                                <td class="lid_6">
                                                    <?php
                                                    $date = date_create($comment['day_comment']);
                                                    ?>
                                                    <span><i class="far fa-calendar-times"></i> <?php echo date_format($date, "d/m/Y")?></span>

                                                    <span><i class="far fa-clock"></i> <?php echo date_format($date, "H:i") ?></span>


                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{-- <div class="pull-right">{{ $voucher_comments->links() }}</div> --}}

                                    {{--<script type="text/javascript">--}}
                                    {{--$(document).ready(function() {--}}
                                    {{--$('#voucher').DataTable( {--}}
                                    {{--"language": {--}}
                                    {{--"url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"--}}
                                    {{--}--}}
                                    {{--} );--}}
                                    {{--} );--}}
                                    {{--</script>--}}

                                    {{--<div>{{ $vouchers->links() }}</div>--}}
                                </div>
                        @endif
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
                        url: '{{ route('delete_all_comment_voucher') }}',
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
