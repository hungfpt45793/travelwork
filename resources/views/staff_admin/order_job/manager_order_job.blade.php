@extends('staff_admin.layouts.master')
@section('title', 'Quản lý đơn hàng tuyển dụng' )
<style>
.drag_and_drop .status {
    min-height: 90vh;
    background: #49d4ab57;
    position: relative;
    padding: 40px .3rem 0.3rem;
    flex: 0 0 <?php echo 100/$staff_status_job_submit->count() ?>%;
    max-width: <?php echo 100/$staff_status_job_submit->count() ?>%;
}

.drag_and_drop .status:nth-child(even) {
    background: #71b0b369;
}

.drag_and_drop .status h6 {
    text-align: center;
    background-color: #343434;
    color: #f3f3f3;
    padding: 0.5rem 1rem;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%
}

.employee b {
    overflow: hidden;
    width: 100%;
    display: block;
    font-weight: 500;
}

.employee {
    background-color: #fff;
    box-shadow: rgb(15 15 15 / 10%) 0px 0px 0px 1px, rgb(15 15 15 / 10%) 0px 2px 4px;
    border-radius: 4px;
    padding: 0.5rem .5rem;
    margin: 0.5rem 0;
}

.form-floating {
    position: relative
}

.form-floating>.form-control,
.form-floating>.form-select {
    height: calc(2.5rem + 2px);
    line-height: 1.25
}

.form-floating>label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: .5rem 1.75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity .1s ease-in-out, transform .1s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .form-floating>label {
        transition: none
    }
}

.form-floating>.form-control {
    padding: 1rem .75rem
}

.form-floating>.form-control::-moz-placeholder {
    color: transparent
}

.form-floating>.form-control::placeholder {
    color: transparent
}

.form-floating>.form-control:not(:-moz-placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:-webkit-autofill {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:not(:-moz-placeholder-shown)~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label,
.form-floating>.form-select~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

</style>
@section('content')
<!-- modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm mới hồ sơ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-floating col-6">
                    <input type="text" class="form-control" name="employee_id" id="input_employee_id" placeholder="Mã ứng viên"
                        autocomplete="off" autofocus>
                    <label for="input_employee_id">Mã ứng viên</label>
                </div>
                <div class="form-floating col-6 pl-0">
                    <input type="text" class="form-control" name="phone" id="input_phone" placeholder="Số điện thoại"
                        autocomplete="off">
                    <label for="input_phone" style="padding-left:.5rem!important">Số điện thoại</label>
                </div>
                <div class="form-floating col-12 mt-2">
                    <input type="text" class="form-control" name="email" id="input_email" placeholder="Email"
                        autocomplete="off">
                    <label for="input_email">Email</label>
                </div>
                <div class="col-12 list_employee_add_order_job">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success search_employee">Tìm</button>
            </div>
        </div>
    </div>
</div>
<!-- het modal -->
<div class="container-fluid">
    <div class="row row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="row drag_and_drop">
                    @foreach($staff_status_job_submit as $status)
                    <div class="status" id="no_status" data-status-job="{{$status->staff_job_id}}">
                        <h6>{{$status->staff_title}}</h6>
                        @if($status->staff_job_id == 1)
                        <button style="margin-top:0.5rem" type="button" class="btn btn-secondary w-100"
                            data-toggle="modal" data-target=".bd-example-modal-lg">Thêm mới hồ sơ</button>
                        @endif
                        <?php
                        $employees_progress = $staff_status_job_submit_employee->where('staff_job_id', $status->staff_job_id);
                        ?>
                        @foreach($employees_progress as $employee_progress)
                        <?php
                        $employee = \App\Entity\Employee::select('employee_id','employee_name', 'phone', 'email')
                        ->where('employee_id', $employee_progress->employee_id)
                        ->first();
                        ?>
                        <div class="employee" data-staff-employee-id="{{ $employee_progress->staff_employee_id }}"
                            draggable="true"
                        @if($employee_progress->status_change_profile==1)style="background:#ff8e8ea8"@endif
                        >
                            @if($status->staff_job_id == 1)
                            <b class="status_one">Ngày nộp hs:
                                <?php
                                    $date=date_create($employee_progress->date_submit_cv);
                                    echo date_format($date,"d-m-Y");
                                ?>
                            </b>
                            @else
                            <b class="status_dif_one">Ngày xử lý:
                                <?php
                                        $date=date_create($employee_progress->date_move_state);
                                        echo date_format($date,"d-m-Y");
                                    ?>

                            </b>
                            <b class="status_dif_one">Người xử lý:
                                <?php
                                        $staff_name = \App\Entity\Staff::where('staff_id', $employee_progress->staff_id)->value('staff_name');
                                    ?>
                                {{ $staff_name }}
                            </b>
                            @endif
                            <b>{{ $employee->employee_name }} - {{ $employee->employee_id }}</b>
                            <b>{{ $employee->phone }}</b>
                            <b>{{ $employee->email }}</b>
                            <div class="btn-group">
                                <span class="btn btn-success pt-0 pb-0 btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Thao tác
                                </span>
                                <div class="dropdown-menu">
                                    <span class="modal_status dropdown-item"
                                        data-staff-employee-id="{{ $employee_progress->staff_employee_id }}">
                                        Trạng thái
                                    </span>
                                    @if($employee_progress->status_change_profile==1)
                                    <a class="dropdown-item" href="{{ route('delete_employer_in_order', [$employee_progress->staff_employee_id, $employee_progress->submit_job_fb_id]) }}">Xóa</a>
                                    @endif
                                </div>
                                <a class="btn btn-success btn-sm ml-1 d-inline" target="_blank"
                                    href="{{ route('staff_employee.show', $employee->employee_id) }}">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="modal_status" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('form_change_staff_status_job_submit') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="staff_employee_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Chuyển trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <select class="form-control select22" name="staff_job_id">

                        </select>
                        <div class="form-group">
                            <label for="">Đánh giá ứng viên</label>
                            <textarea class="form-control" rows="2" name="staff_id_comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
const employees = document.querySelectorAll(".employee");
const all_status = document.querySelectorAll(".status");
let draggableTodo = null;

employees.forEach((employee) => {
    employee.addEventListener("dragstart", dragStart);
    employee.addEventListener("dragend", dragEnd);
});

function dragStart() {
    draggableTodo = this;
    setTimeout(() => {
        this.style.display = "none";
    }, 0);
    console.log("dragStart");
}

function dragEnd() {
    draggableTodo = null;
    setTimeout(() => {
        this.style.display = "block";
    }, 0);
    console.log("dragEnd");
    let staff_employee_id = $(this).attr('data-staff-employee-id');
    let status_job = $(this).parent().attr('data-status-job');
    let div_employee = $(this);
    $.ajax({
        'type': 'post',
        'url': "{{ route('change_staff_status_job_submit') }}",
        'data': {
            staff_employee_id: staff_employee_id,
            status_job: status_job
        },
        'success': function(res) {
            let date_submit_cv = new Date(res.date_submit_cv);
            let formatted_date_submit_cv = date_submit_cv.getDate() + "-" + (date_submit_cv
                .getMonth() + 1) + "-" + date_submit_cv.getFullYear();

            let date_move_state = new Date(res.date_move_state);
            let formatted_date_move_state = date_move_state.getDate() + "-" + (date_move_state
                .getMonth() + 1) + "-" + date_move_state.getFullYear();
            if (status_job == 1) {

                div_employee.find('.status_one').remove();
                div_employee.find('.status_dif_one').remove();
                div_employee.prepend(`
                    <b class="status_one">Ngày nộp hs: ${formatted_date_submit_cv}
                    </b>
                `);
            } else {
                div_employee.find('.status_dif_one').remove();
                div_employee.find('.status_one').remove();
                div_employee.prepend(`
                    <b class="status_dif_one">Ngày xử lý: 
                        ${formatted_date_move_state}
                    </b>
                    <b class="status_dif_one">Người xử lý: 
                        ${res.staff_name}
                    </b>
                `);
            }
        }
    })
}

all_status.forEach((status) => {
    status.addEventListener("dragover", dragOver);
    status.addEventListener("dragenter", dragEnter);
    status.addEventListener("dragleave", dragLeave);
    status.addEventListener("drop", dragDrop);
});

function dragOver(e) {
    e.preventDefault();
    //   console.log("dragOver");
}

function dragEnter() {
    this.style.border = "1px dashed #ccc";
    console.log("dragEnter");
}

function dragLeave() {
    this.style.border = "none";
    console.log("dragLeave");
}

function dragDrop() {
    this.style.border = "none";
    this.appendChild(draggableTodo);
    console.log("dropped");
}

//modal
$('.modal_status').on('click', function() {
    $('#modal_status').modal('show');
    let staff_employee_id = $(this).attr('data-staff-employee-id');
    $.ajax({
        'type': 'post',
        'url': "{{ route('get_status_job_employee') }}",
        'data': {
            staff_employee_id: staff_employee_id
        },
        'success': function(res) {

            let staff_status_job_submit = res.staff_status_job_submit;
            let select = '';
            let selected = '';
            staff_status_job_submit.forEach(ele => {
                if (ele.staff_job_id == res.staff_employee.staff_job_id) {
                    selected = 'selected';
                } else {
                    selected = '';
                }
                select += `
                    <option value="${ele.staff_job_id}" ${selected}>
                        ${ele.staff_title}
                    </option>
                `;
            })
            $('#modal_status select').html(select);
            $('#modal_status textarea').html(res.staff_employee.staff_id_comment);
            $('#modal_status input').val(res.staff_employee.staff_employee_id);
        }
    })
});

$('.search_employee').on('click', function(){
    let employee_id = $('input#input_employee_id').val();
    let phone = $('input#input_phone').val();
    let email = $('input#input_email').val();
    $.ajax({
        'type': 'post',
        'url': "{{ route('search_employee_order_job') }}",
        'data': {
            employee_id: employee_id,
            phone: phone,
            email: email
        },
        'success': function(res){
            
            let html = '';
            res.forEach(ele => {
                html += `
                    <tr>
                        <td>${ele.employee_id}</td>
                        <td>${ele.employee_name}</td>
                        <td>${ele.phone}</td>
                        <td>${ele.email}</td>
                        <td>
                            <button class="btn-sm btn btn-success add_employee_apply_order_job"
                            data-employee-id="${ele.employee_id}"
                            >
                                Thêm
                            </button>
                        </td>
                    </tr>
                `;
            })
            let html1 = `
                <table class="table">
                    ${html}
                </table>
            `;
            $('.list_employee_add_order_job').html(html1);
        }
    })
});

$(document).on('click', '.add_employee_apply_order_job', function(){
    let employee_id = $(this).attr('data-employee-id');
    let job_id = <?php echo $job_id; ?>;
    $.ajax({
        'type': 'post',
        'url': "{{ route('add_employee_apply_order_job') }}",
        'data': {
            employee_id: employee_id,
            job_id: job_id
        },
        'success': function(res){
            location.reload();
        }
    })
})
</script>
@endpush
@endsection