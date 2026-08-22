@extends('staff_admin.layouts.master')

@section('title', 'Danh sách liên hệ' )

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
                    @if (session('success'))
                        <div class="alert alert-info">{{session('success')}}</div>
                        @elseif (session('error'))
                        <div class="alert alert-info">{{session('error')}}</div>
                    @endif
                    <div class="row ">
                        <div class="col-md-12 ">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('staff_advisory_contact.create') }}" class="btn btn-sm btn-success mr-1 text-white">Thêm mới</a>
                                <a href="{{ route('staff_advisory_contact.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                            </div>
                            <div class="custom-paginate">
                                {{ $contacts->links() }}
                                số bản ghi của một trang:
                                <span class="input-submit">
                                    <form action="{{ route('staff_advisory_employer.index') }}" class="inline">
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
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($contacts as $contact)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $contact->contact_id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr class="">
                                            <td scope="col" class="lid_1"><p style="width:50px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td scope="col" class="lid_3"><p style="width:55px">TT<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td scope="col" class="lid_4"><p style="width:115px">Ngày liên hệ<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td scope="col" class="lid_5"><p style="width:90px">Chức vụ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td scope="col" class="lid_6"><p style="width:255px">Họ & tên<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            {{-- <td scope="col" class="lid_7"><button style="width:80px">Hình ảnh</button><button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></td> --}}
                                            <td scope="col" class="lid_8"><p style="width:85px">SĐT<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                            <td scope="col" class="lid_9"><p style="width:255px">Email<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td scope="col" class="lid_10"><p style="width:305px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td scope="col" class="lid_11"><p style="width:305px">Nội dung liên hệ</p></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ( $contacts as $id => $contact )
                                        <tr>
                                            <td scope="row " class="lid_1">{{ $contact->contact_id }}</td>

                                            <td class="lid_3">
                                                <a href="{{ route('staff_advisory_contact.edit', ['contact_id' => $contact->contact_id]) }}">
                                                @if($contact->status_view == 0)
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-eye-slash "></i></button>
                                                   @else
                                                   <button class="btn btn-sm btn-success"><i class="fas fa-eye-slash "></i></button>
                                                @endif
                                                </a>
                                            </td>
                                            <td class="lid_4">
                                                <?php
                                                $date=date_create($contact->created_at);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            </td>
                                            <?php
                                        $user = \App\Entity\User::getIdUser($contact->user_id);

                                    ?>

                                    @if(!empty($user))

                                        @if($user->role == 1)
                                            <td class="lid_5"><span class=" btn btn-sm btn-success">UV</span></td>
                                            <?php $employee = \App\Entity\Employee::getEmployee_id($user->id)?>
                                            @if (isset($employee))
                                            <td class="lid_6"><p class="crop">{{ $employee->employee_name }}</p></td>
                                            {{-- <td class="lid_7"><img src="{{ $employee->employee_image }}" width="50px"></td> --}}
                                            <td class="lid_8">{{ $employee->phone }}</td>
                                            <td class="lid_9">{{ $employee->email }}</td>
                                            <td class="lid_10">{{ $employee->address }}</td>
                                            @endif

                                        @endif
                                        @if($user->role == 2)
                                            <td class="lid_5"><span class="btn btn-sm btn-primary">NTD</span></td>
                                            <?php $employer = \App\Entity\Employer::getIdUser($user->id)?>
                                            @if (isset($employer))
                                            <td class="lid_6"><p class="crop">{{ $employer->enterprise_name }}</p></td>
                                            {{-- <td class="lid_7"><img src="{{ $employer->image }}" width="50px"></td> --}}
                                            <td class="lid_8">{{ $employer->phone }}</td>
                                            <td class="lid_9">{{ $employer->email }}</td>
                                            <td class="lid_10">{{ $employer->address }}</td>
                                            @endif
                                        @endif
                                        @if($user->role == 3)
                                            <td class="lid_5"><span class="btn btn-sm btn-warning">GV</span>
                                            </td>
                                            <?php $teacher = \App\Entity\Teacher::getTeacher_id($user->id)?>
                                            @if (isset($teacher))
                                            <td class="lid_6"><p class="crop">{{ $teacher->teacher_name }}</p></td>
                                            {{-- <td class="lid_7"><img src="{{ $teacher->teacher_images }}" width="50px"></td> --}}
                                            <td class="lid_8">{{ $teacher->teacher_phone }}</td>
                                            <td class="lid_9">{{ $teacher->teacher_email }}</td>
                                            <td class="lid_10">{{ $teacher->address }}</td>
                                            @endif

                                        @endif

                                        @else
                                            <td class="lid_5"><button class="btn btn-sm btn-success">QL</button></td>
                                            <td class="lid_6"><p class="crop">{{ $contact->name }}</p></td>
                                            {{-- <td class="lid_7"></td> --}}
                                            <td class="lid_8" >{{ $contact->phone }}</td>
                                            <td class="lid_9">{{ $contact->email }}</td>
                                            <td class="lid_10">{{ $contact->address }}</td>

                                        @endif
                                    <td class="lid_11">
                                        @php
                                            $text = $contact->message;
                                            $replace = array('<p>','</p>');
                                            $text =  str_replace($replace,'',$text);
                                        @endphp
                                        <p class="crop">
                                            {{ $text }}
                                        </p>
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
                        url: '{{ route('delete_all_advisory_contact') }}',
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
