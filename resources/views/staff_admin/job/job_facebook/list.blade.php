@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
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
                <div class="contentJobsInteresting  col-f14 ">

                    <div class="row ">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-warning"></i> Tìm</a>
                                    <a href="{{ route('staff_job-facebook.index') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                    <a href="{{ route('form_create_job_facebook') }}" class="btn btn-success btn-sm mr-1 ">Thêm mới</a>
                                    <a href="{{ route('update_job_facebook_with_staff') }}" class="btn btn-warning btn-sm mr-1 ">Cập nhập mã tin</a>
                                    <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm việc làm facebook</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="">
                                            <div class="modal-body">
                                               <div class="row">
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
                                                </div>
                                                <div class="col-md-4 col-xs-4  ">
                                                    <div class="form-group">
                                                        <select class="js-example-basic-single form-control select2" name="career_category_id">
                                                            <option value="">--Danh mục nghành nghề--</option>
                                                            <?php $career_category_id_get = isset($_GET['career_category_id']) ? $_GET['career_category_id'] : '';?>
                                                            @foreach(\App\Entity\Career::get() as $career)
                                                            <option value="{{$career->career_category_id}}" @if($career->career_category_id
                                                                == $career_category_id_get) selected
                                                                @endif
                                                                >{{$career->career_category_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $salary_get = isset($_GET['salary']) ? $_GET['salary'] : '01';?>
                                                        <select class="form-control js-example-basic-single select2" name="salary"
                                                            aria-label="Mức lương">
                                                            <option value="" selected> -- Mức lương --</option>
                                                            @foreach(\App\Entity\Salary::orderBy('salary_from')->get() as $salary)
                                                            <option value="{{$salary->salary_id}}" @if($salary->salary_id == $salary_get)
                                                                selected
                                                                @endif>{{$salary->salary_from}} VNĐ
                                                                - {{$salary->salary_to}} VNĐ
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $vip_get = isset($_GET['vip']) ? $_GET['vip'] : '';?>
                                                        <select class="form-control js-example-basic-single select2" name="vip"
                                                            aria-label="Quận/Huyện" id="">
                                                            <option value="" selected> -- Loại tin --</option>
                                                            <option value="0" @if($vip_get=='0' ) selected @endif> Tin thường </option>
                                                            <option value="1" @if($vip_get=='1' ) selected @endif> Tin Vip </option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-4 ">
                                                    <div class="form-group">
                                                        <?php $province_get = isset($_GET['province']) ? $_GET['province'] : '';
                                                        ?>
                                                        <select class="form-control js-example-basic-single select2" name="province"
                                                            aria-label="Tỉnh/Thành phố" id="province">
                                                            <option value="" selected> -- Tất cả các tỉnh/thành phố --</option>
                                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                            <option value="{{$province->province_id}}" @if($province->province_id ==
                                                                $province_get) selected
                                                                @endif
                                                                >{{$province->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $district_get = isset($_GET['district']) ? $_GET['district'] : ''; ?>
                                                        <select class="form-control js-example-basic-single select2" name="district"
                                                            aria-label="Quận/Huyện" id="district">
                                                            <option value="" selected> -- Tất cả các quận/huyện --</option>
                                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            <option value="{{$district->district_id}}" @if($district->district_id ==
                                                                $district_get) selected
                                                                @endif
                                                                >{{$district->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $title_get = isset($_GET['title']) ? $_GET['title'] : '';?>
                                                        <input type="text" placeholder="Tên việc làm" class="form-control-sm form-control" name="title"
                                                            value="{{ $title_get }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-4 ">
                                                    <div class="form-group">
                                                        <select class="form-control js-example-basic-single select2" name="employer_id"
                                                            aria-label="Quận/Huyện" id="">
                                                            <option value="" selected> -- Nhà tuyển dụng --</option>
                                                            <?php $employer = \App\Entity\Employer::getselectNameId();
                                                            $employer_id_get = isset($_GET['employer_id']) ? $_GET['employer_id'] : '';
                                                            print_r($employer_id_get);
                                                            ?>
                                                            @foreach($employer as $eplo)
                                                            <option value="{{ $eplo->employer_id }}" @if($employer_id_get==$eplo->
                                                                employer_id ) selected @endif > {{ $eplo->enterprise_name }} </option>
                                                            @endforeach


                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $email_get = isset($_GET['email']) ? $_GET['email'] : '';?>
                                                        <input type="text" placeholder="Email nhà tuyển dụng" class="form-control-sm form-control"
                                                            name="email" value="{{ $email_get }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $email_job_fb_get = isset($_GET['email_job_fb']) ? $_GET['email_job_fb'] : '';
                                                                ?>
                                                        <input type="text" placeholder="Email nhận hồ sơ" class="form-control-sm form-control"
                                                            name="email_job_fb" value="{{ $email_job_fb_get }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <?php $code_get = isset($_GET['code']) ? $_GET['code'] : '';
                                                                ?>
                                                        <input type="text" placeholder="Mã tin" class="form-control-sm form-control"
                                                            name="code" value="{{ $code_get }}">
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

                                    <button class="btn btn-sm btn-secondary mr-1 text-white  delete_all"><i class="fas fa-trash text-danger"></i> Xóa</button>
                                </div>
                                <!-- form tim kiem theo id job fb -->
                                <div>
                                    <form action="" class="">
                                        <div class="group-form border border-primary">
                                            <input class="border-0 input-lg" type="text"
                                                name="job_facebook_id" style="width:80px"
                                                value="{{ (!empty($_GET['job_facebook_id'])) ? $_GET['job_facebook_id'] : ''  }}"
                                                placeholder="ID Job FB">
                                            <button class="search border-0" type="submit"><i class="fa fa-search "
                                                    aria-hidden="true"></i></button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            <div class="custom-paginate ml-1 mt-1 row">
                                {{ $jobFacebooks->links() }}
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
                                | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '20' }}/{{ $jobFacebooks->total() }} bản ghi
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($jobFacebooks as $job)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $job->job_facebook_id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                                <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            {{-- <td>
                                                <p><input type="checkbox" id="master"></p>
                                            </td> --}}
                                            <td class="lid_1"><p style="width:50px">ID<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_3"><p style="width:85px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_2"><p style="width:80px">Thao tác<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_4"><p style="width:120px">SĐT nhận HS<button class="lockButton btn btn-sm btn-success" id="lid_31">L</button></p></td>
                                            <td class="lid_5"><p style="width:250px">Email nộp hs<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_6"><p style="width:200px">Tên việc<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_7"><p style="width:45px">Link<button class="lockButton btn btn-sm btn-success" id="lid_14">L</button></p></td>
                                            <td class="lid_11"><p style="width:70px">Mã tin<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_9"><p style="width:60px">Tin<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_16"><p style="width:40px"><i class="fas fa-eye"></i><button class="lockButton btn btn-sm btn-success" id="lid_13">L</button></p></td>
                                            <td class="lid_8"><p style="width:100px">Mức lương<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td class="lid_10"><p style="width:180px">Time đăng tin<button class="lockButton btn btn-sm btn-success" id="lid_12">L</button></p></td>
                                            <td class="lid_12"><p style="width:300px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                            <td class="lid_13"><p style="width:300px">Email<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                            <td class="lid_14"><p style="width:350px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td>
                                            <td class="lid_15"><p style="width:100px">Báo tin sai<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($jobFacebooks))
                                        @foreach ($jobFacebooks as $job)

                                        <tr>
                                            <td class="lid_1">
                                                {{$job->job_facebook_id}}
                                            </td>
                                            <td class="lid_3">
                                                <?php
                                                    $date=date_create($job->created_at);
                                                    echo date_format($date,"d/m/Y");
                                                    ?>
                                            </td>
                                            <td class="lid_2">
                                                <?php
                                                $inter = \App\Entity\Interactive_history_jobfb::select('id')->where('jobfb_id', $job['job_facebook_id'])->first();
                                                ?>
                                                @if(empty($inter))
                                                    <a href="{{ route('form_edit_job_facebook',$job['job_facebook_id']) }}" class="btn btn-sm btn-primary">Thao tác</a>
                                                @else
                                                <a href="{{ route('form_edit_job_facebook',$job['job_facebook_id']) }}" class="btn btn-sm btn-success">Thao tác</a>
                                                @endif
                                            </td>
                                            <td class="lid_4">
                                                <b class="crop" style="width:120px"></b>{{ $job['phone'] }}
                                            </td>
                                            <td class="lid_5">
                                                <div class="crop">{{ $job['email'] }}</div>
                                            </td>
                                            <td class="lid_6"><div class="crop" style="width:200px">{{ $job['title'] }}</div></td>
                                            <td class="lid_7"><a target="_blank" href="{{ route('detail_job_face',$job['slug']) }}">link</a></td>
                                            <td class="lid_11">{{ $job->job_facebook_code }}</td>
                                            <td class="lid_9">
                                                @if($job['vip'] == 0)
                                                    <span>thường</span>
                                                @else
                                                    <span style="color: red">vip</span>
                                                @endif
                                            </td>
                                            <td class="lid_16">
                                                <b class="text-danger">{{ $job['view'] }}</b>
                                            </td>
                                            <td class="lid_8">
                                                <?php
                                                $salary = \App\Entity\Salary::getIdSalary($job['salary_id']);
                                                ?>
                                                {{ isset($salary->description) ? $salary->description : '' }}
                                            </td>
                                            <td class="lid_10">
                                                <?php
                                                $date_submit = date_create($job['created_at']);
                                                echo date_format($date_submit, "d/m/Y");
                                                ?>
                                                -
                                                <?php
                                                $date_end = date_create($job['date_end']);
                                                echo date_format($date_end, "d/m/Y");
                                                ?>
                                            </td>

                                            <td class="lid_12">
                                                <?php
                                                $employer = \App\Entity\Employer::getIdemployer($job['employer_id']);
                                                ?>
                                                @if(!empty($employer['enterprise_name']))
                                                <a href="{{ route('staff_employer.edit',['staff_employer'=>$employer->employer_id]) }}" target="_blank" rel="noopener noreferrer">
                                                {{ $employer['enterprise_name'] }}
                                                </a>
                                                @else
                                                Admin
                                                @endif
                                            </td>
                                            <td class="lid_13">
                                                <b>@if(!empty($job['emailNTD']))
                                                    {{ $job['emailNTD'] }}
                                                    @else
                                                    Admin
                                                    @endif
                                            </b>
                                            </td>

                                            <td class="lid_14">
                                                <?php
                                                $province = \App\Entity\Province::getId($job['province']);
                                                $district = \App\Entity\District::getId($job['district']);
                                                ?>
                                                {{ !empty($district['district_name']) ? $district['district_name'] : '' }}
                                               |
                                                {{ !empty($province['province_name']) ? $province['province_name'] : '' }}
                                            </td>
                                            <td class="lid_15">{{ $job['warning_job_fb'] }}</td>



                                        </tr>
                                        @endforeach
                                        @endif
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
@push('custom-scripts')
<script>
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
                        url: '{{ route('delete_all_job_facebook') }}',
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
