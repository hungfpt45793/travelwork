<?php
    $name = '';
    if(isset($_GET['name'])){
        $name = $_GET['name'];
    }
    $user = '';
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    }
?>
@extends('staff_admin.layouts.master')
@section('title', 'Danh sách tương tác ứng viên' )
@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employee')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                <a href="{{ route('interactive_employee_all') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm ứng viên</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row employee-search ">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationDefault01">Từ ngày(ngày ứng tuyển)</label>
                                                            @php
                                                                  $d=strtotime("-1 Months");
                                                                  $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                            <input type="hidden" name="num" value="{{ (isset($_GET['num'])) ? $_GET['num'] : '' }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="validationDefault02">Đến ngày(ngày ứng tuyển)</label>
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                        </div>
                                                          <!-- myDatetime -->
                                                        <div class="col-md-4 offset-md-4 mb-3">
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày">
                                                        </div>
                                                        <div class="col-md-4 col-xs-6  "></div>
                                                        <div class="col-md-12 col-xs-12  ">
                                                            <div class="form-group">
                                                                <label for="">Tên ứng viên</label>
                                                                <?php $name_get = isset($_GET['name']) ? $_GET['name'] : '';?>
                                                                <input type="text "  placeholder="Tên ứng viên" class="form-control " name="name" value="{{ $name_get }}">
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
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                    {{ $interactive_employee_all->links() }}
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
                            <div class="d-flex justify-content-start mb-1 flex-wrap">
                                <form action="">
                                @php
                                    $arr = [];
                                @endphp
                                @foreach ($interactive_employee_user as $user)
                                    @if (!in_array($user->id, $arr))
                                        <button type="submit" class="btn btn-outline-primary btn-sm mr-1 mt-1 {{ (!empty($_GET['user']) && $_GET['user'] == $user->id) ? 'annut' : '' }}" name="user" value="{{ $user->id }}"><span>{{ $user->name }}</span></button>
                                        @php
                                            $arr[] = $user->id;
                                        @endphp
                                    @endif
                                @endforeach
                                </form>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <table id="locker" class="custom-table tableFixHead table-bordered table-striped" data-fl-scrolls style="overflow: scroll;height:100vh;display:block;table-layout:fixed;"></table>
                                <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                    <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                <td scope="col" class="lid_1"><p style="width:33px">ID<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                <td scope="col" class="lid_4"><p style="width:145px">Ngày tương tác<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                <td scope="col" class="lid_5"><p style="width:135px">Người tương tác<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td scope="col" class="lid_2"><p style="width:145px">Ứng viên<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                                <td scope="col" class="lid_3"><p>Nội dung tương tác<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                <td scope="col" class="lid_5"><p style="width:101px">Số điện thoại<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td scope="col" class="lid_5"><p style="width:135px">Email<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($interactive_employee_all as $submit)
                                            <tr>
                                                <td>{{ $submit->id}}</td>
                                                <td>
                                                    <?php
                                                    $date=date_create($submit->interactive_day);
                                                    echo date_format($date,"d/m/Y");
                                                    ?>
                                                </td>
                                                <td class="crop">{{ $submit->name }}</td>
                                                <td><a target="_blank" href="{{ route('staff_employee_edit_form',$submit->employee_id) }}">{{ $submit->employee_name }}</a></td>
                                                <td>
                                                    <a class="interactive" data-employee-id="{{ $submit->employee_id}}" data-user-id="{{ $submit->user_id }}" data-toggle="modal" data-target="#interactive">
                                                        <p class="crop text-primary" style="width: 300px">
                                                            {{ $submit->content }}
                                                        </p>
                                                    </a>
                                                </td>
                                                <td>{{ $submit->phone }}</td>
                                                <td>{{ $submit->email }}</td>
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
<!-- Modal -->
<div class="modal fade" id="interactive" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nội dung tương tác</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead style="background-color: #53b55a">
                        <tr>
                            <td style="width:94px">Ngày T/Tác</td>
                            <td>Người T/Tác</td>
                            <td>Nội dung T/Tác</td>
                        </tr>
                    </thead>
                    <tbody class="foreach_interactive">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#interactive').on('hidden.bs.modal', function (e) {
        $('#interactive .foreach_interactive').html('')
    })
    $('.interactive').on('click', function() {
        var employee_id = $(this).data('employee-id')
        var user_id = $(this).data('user-id')
        $.ajax({
            'type': 'get',
            'url': "{{ route('show_modal_interactive') }}",
            'data': {
                employee_id,
                user_id
            },
            'success': (req) => {
                let html =''
                req.forEach(element => {
                    let created_at = new Date(element.created_at)
                    let formatted_created_at = created_at.getDate() + "-" + (created_at
                    .getMonth() + 1) + "-" + created_at.getFullYear()
                    html += `
                    <tr>
                        <td><p class="crop">${formatted_created_at}</p></td>
                        <td><p class="crop">${element.name}</p></td>
                        <td><p>${element.content}</p></td>
                    </tr>
                    `
                });
                $('#interactive .foreach_interactive').html(html)
            }
        })
    })
</script>
@endsection
