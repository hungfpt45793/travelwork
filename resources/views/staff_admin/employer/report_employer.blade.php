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
$type_of_business_id = '';
if(isset($_GET['type_of_business_id'])){
    $type_of_business_id = $_GET['type_of_business_id'];
}
//4
$business = '';
if(isset($_GET['business'])){
    $business = $_GET['business'];
}
//5
$date_search_start = '';
if(isset($_GET['enterprise_name'])){
    $enterprise_name = $_GET['enterprise_name'];
}
//6
$date_search_start = '';
if(isset($_GET['status_agency'])){
    $status_agency = $_GET['status_agency'];
}
//7
$province = '';
if(isset($_GET['province'])){
    $province = $_GET['province'];
}
//8
$district = '';
if(isset($_GET['district'])){
    $district = $_GET['district'];
}
//9
$email = '';
if(isset($_GET['email'])){
    $email = $_GET['email'];
}
//10
$status_intership = '';
if(isset($_GET['status_intership'])){
    $status_intership = $_GET['status_intership'];
}
//11
$is_delete = '';
if(isset($_GET['is_delete'])){
    $is_delete = $_GET['is_delete'];
}
//12
$status_employer = '';
if(isset($_GET['status_employer'])){
    $status_employer = $_GET['status_employer'];
}
//13
$num = '';
if(isset($_GET['num'])){
    $num = $_GET['num'];
}
?>
@extends('staff_admin.layouts.master')

@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.employer')
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
                    <div class="custom-order">
                        <div class="custom-paginate first-order row mt-1 ml-1">
                            {{ $employers->links() }}
                            số bản ghi của một trang:
                            <span class="input-submit">
                                <form action="" class="inline">
                                    <input type="text" name="num" style="border: 1px solid #333; width: 60px;">
                                    <input type="hidden" name="type_of_business_id" value="{{ (isset($_GET['type_of_business_id'])) ? $_GET['type_of_business_id'] : '' }}">
                                    <input type="hidden" name="business" value="{{ (isset($_GET['business'])) ? $_GET['business'] : '' }}">
                                    <input type="hidden" name="enterprise_name" value="{{ (isset($_GET['enterprise_name'])) ? $_GET['enterprise_name'] : '' }}">
                                    <input type="hidden" name="status_agency" value="{{ (isset($_GET['status_agency'])) ? $_GET['status_agency'] : '' }}">
                                    <input type="hidden" name="province" value="{{ (isset($_GET['province'])) ? $_GET['province'] : '' }}">
                                    <input type="hidden" name="district" value="{{ (isset($_GET['district'])) ? $_GET['district'] : '' }}">
                                    <input type="hidden" name="email" value="{{ (isset($_GET['email'])) ? $_GET['email'] : '' }}">
                                    <input type="hidden" name="status_intership" value="{{ (isset($_GET['status_intership'])) ? $_GET['status_intership'] : '' }}">
                                    <input type="hidden" name="compare" value="{{ (isset($_GET['compare'])) ? $_GET['compare'] : '' }}">
                                    <input type="hidden" name="num_export" value="{{ (isset($_GET['num_export'])) ? $_GET['num_export'] : '' }}">
                                    <input type="submit" value="xem" style="border: 1px solid #333">
                                </form>
                            </span>
                            | xem 1-{{ isset($_GET['num']) ? $_GET['num'] : '30' }}/{{ $total }} bản ghi
                        </div>
                        <div class="d-flex justify-content-start second-order">
                            <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm({{ $total }})</a>
                            <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                    <form action="">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm nhà tuyển dụng                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="validationDefault01">Từ ngày(ngày update)</label>
                                                        @php
                                                              $d=strtotime("-1 Months");
                                                              $date = date("Y-m-d", $d)
                                                        @endphp
                                                        <input class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                      </div>
                                                      <div class="col-md-5 mb-3">
                                                        <label for="validationDefault02">Đến ngày(ngày update)</label>
                                                        <input class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                      </div>
                                                      <!-- myDatetime -->
                                                      <div class="col-md-2 mb-3">
                                                      <label for="validationDefault2" class="text-light">sd</label>
                                                        <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        <input type="hidden" name="num" value="{{ $num }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $type_of_business_id_get = '';
                                                            if(isset($_GET['type_of_business_id']))
                                                            {
                                                                $type_of_business_id_get = $_GET['type_of_business_id'];
                                                            }
                                                            ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="type_of_business_id">
                                                                <option value="">-- Loại hình doanh nghiệp --</option>
                                                                @foreach(\App\Entity\TypeOfBusiness::orderBy('type_of_business_name')->get() as $type)
                                                                    <option value="{{$type->type_of_business_id}}"
                                                                    @if($type->type_of_business_id == $type_of_business_id_get) selected @endif
                                                                    >{{$type->type_of_business_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        $business_get = '';
                                                        if(isset($_GET['business']))
                                                        {
                                                            $business_get = $_GET['business'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="business">
                                                                <option value="">-- Loại hình kinh doanh --</option>
                                                                @foreach(\App\Entity\Business::get() as $business)
                                                                    <option value="{{$business->business_type_id}}"
                                                                            @if($business->business_type_id == $business_get) selected @endif
                                                                    >{{$business->business_type_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        $enterprise_name_get = '';
                                                        if(isset($_GET['enterprise_name']))
                                                        {
                                                            $enterprise_name_get = $_GET['enterprise_name'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control " name="enterprise_name" value="@if(!empty($enterprise_name_get)) {{$enterprise_name_get}} @endif">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $status_agency_get = '';
                                                            if(isset($_GET['status_agency']))
                                                            {
                                                                $status_agency_get = $_GET['status_agency'];
                                                            }
                                                            ?>
                                                        <div class="form-group">
                                                            <select class="form-control js-example-basic-single select2" name="status_agency">
                                                                <option value="" selected>-- Đại lý --</option>

                                                                <option value="0"
                                                                        @if($status_agency_get == '0') selected @endif
                                                                > Không phải đại lý</option>
                                                                <option value="1"
                                                                        @if($status_agency_get == '1') selected @endif
                                                                > Là đại lý</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        $province_get = '';
                                                        if(isset($_GET['province']))
                                                        {
                                                            $province_get = $_GET['province'];
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <select class="js-example-basic-single form-control select2" id="province" name="province">
                                                                <option value="">--Tỉnh/Thành phố--</option>
                                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                <option value="{{$province->province_id}}" @if(isset($_GET['province']) && $_GET['province'] == $province->province_id) selected @endif>
                                                                    {{$province->province_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $district_get = '';
                                                            if (isset($_GET['district'])) {
                                                                $district_get = $_GET['district'];
                                                            }
                                                        ?>
                                                    <select class="js-example-basic-single form-control select2" name="district" id="district">
                                                        <option value="">--Chọn quận/huyện</option>
                                                        @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                            @if(isset($_GET['district']) &&
                                                            $_GET['district']==$district->district_id) selected @endif>
                                                            {{$district->district_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="col-md-4">

                                                            <?php
                                                            $email_get = '';
                                                            if(isset($_GET['email']))
                                                            {
                                                                $email_get = $_GET['email'];
                                                            }
                                                            ?>
                                                            <input type="text" placeholder="Email nhà tuyển dụng" class="form-control " name="email" value="@if(!empty($email_get)) {{$email_get}} @endif">
                                                    </div>
                                                    <div class="col-md-4">
                                                            <?php
                                                            $status_intership_get = '';
                                                            if(isset($_GET['status_intership']))
                                                            {
                                                                $status_intership_get = $_GET['status_intership'];
                                                            }
                                                            ?>
                                                            <select class="form-control js-example-basic-single select2" name="status_intership">
                                                                <option value="" selected>-- Cổng thực tập --</option>

                                                                <option value="0"
                                                                        @if($status_intership_get == '0') selected @endif
                                                                > Không tuyển thực tập</option>
                                                                <option value="1"
                                                                        @if($status_intership_get == '1') selected @endif
                                                                >  Đang tuyển thực tập</option>

                                                            </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check compare_check">
                                                            <input class="form-check-input" type="radio" name="compare" id="Radios1" checked {{ (isset($_GET['compare']) && $_GET['compare'] == 0) ? 'checked' : '' }} value="0">
                                                            <label class="form-check-label" for="Radios1">
                                                                <p class="btn btn-sm">>=</p>
                                                              </label>
                                                            <input class="form-check-input" type="radio" name="compare" id="Radios2" value="1" {{ (isset($_GET['compare']) && $_GET['compare'] == 1) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Radios2">
                                                                <p class="btn btn-sm" style="border-bottom-left-radius: 0;
                                                                border-top-left-radius: 0;"><=</p>
                                                            </label>
                                                            <input style="border-bottom-left-radius: 0;
                                                            border-top-left-radius: 0;" type="text" placeholder="Số lần export" class="form-control " name="num_export" value="{{ (isset($_GET['num_export'])) ? $_GET['num_export'] : '' }}">
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
                            <a href="{{ route('staff_employer_report_employer') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                            <?php
                            $query = '';
                            $url = Request::fullUrl();
                            $parsedUrl = parse_url($url);
                            if(!empty($parsedUrl['query'])){
                                $query = $parsedUrl['query'];
                            }

                            ?>
                            <button class="btn btn-sm btn-info export_excel">Excel</button>
                            {{-- <a href="{{route('exportExcelEmployer')}}?{{ $query }}" class="btn btn-sm btn-info">Excel</a> --}}
                        </div>
                    </div>
                        <div class="row ">

                            <div class="col-md-12">
                                <form action="{{route('exportExcelEmployer')}}" method="get" id="form_export_excel">
                                    {{ csrf_field() }}
                                    <div id="locker" data-fl-scrolls class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <div class="lockedWrap lockedWrap-first">
                                            <div class="cellWrap cellWrap-first">
                                                <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                            </div>
                                            @foreach ($employers as $employer)
                                            <div class="cellWrap">
                                                <input type="checkbox" id_customer="{{$employer->employer_id}}" class="checkItem" name="list_id[]"
                                                            value="{{$employer->employer_id}}">
                                            </div>
                                            @endforeach
                                            <input type="hidden" name="type_of_business_id" value="{{ (isset($_GET['type_of_business_id'])) ? $_GET['type_of_business_id'] : '' }}">
                                            <input type="hidden" name="business" value="{{ (isset($_GET['business'])) ? $_GET['business'] : '' }}">
                                            <input type="hidden" name="enterprise_name" value="{{ (isset($_GET['enterprise_name'])) ? $_GET['enterprise_name'] : '' }}">
                                            <input type="hidden" name="status_agency" value="{{ (isset($_GET['status_agency'])) ? $_GET['status_agency'] : '' }}">
                                            <input type="hidden" name="province" value="{{ (isset($_GET['province'])) ? $_GET['province'] : '' }}">
                                            <input type="hidden" name="district" value="{{ (isset($_GET['district'])) ? $_GET['district'] : '' }}">
                                            <input type="hidden" name="email" value="{{ (isset($_GET['email'])) ? $_GET['email'] : '' }}">
                                            <input type="hidden" name="status_intership" value="{{ (isset($_GET['status_intership'])) ? $_GET['status_intership'] : '' }}">
                                            <input type="hidden" name="compare" value="{{ (isset($_GET['compare'])) ? $_GET['compare'] : '' }}">
                                            <input type="hidden" name="num_export" value="{{ (isset($_GET['num_export'])) ? $_GET['num_export'] : '' }}">
                                        </div>
                                    </div>
                                </form>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                        <thead>
                                            <tr>
                                                {{-- <td>
                                                    <p><input type="checkbox" class="btn btn-primary" id="checkAllSendMail"></p>
                                                </td> --}}
                                                <td class="lid_1"><p style="width: 50px;">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                                <td class="lid_3"><p style="width:100px">Ngày update<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                                <td class="lid_4"><p style="width:350px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                                <td class="lid_4_1"><p style="width:80px">Nội dung<button class="lockButton btn btn-sm btn-success" id="lid_4_1">L</button></p></td>
                                                <td class="lid_10"><p style="width:80px">TT<button class="lockButton btn btn-sm btn-success" id="lid_10">L</button></p></td>
                                                <td class="lid_5"><p style="width:300px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                                <td class="lid_6"><p style="width:80px">Số tin TD<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                                <td class="lid_7"><p style="width:130px">Số tin TD/Fb<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>

                                                {{-- <td>Liên lc</td> --}}
                                                <td class="lid_9"><p style="width: 80px;">Tuyển/TT<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                                <td class="lid_11"><p style="width: 90px;">SL/Export<button class="lockButton btn btn-sm btn-success" id="lid_11">L</button></p></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employers as $employer)
                                            <tr>
                                                <td class="lid_1" scope="row ">{{ $employer->employer_id }}</td>
                                                <td class="lid_3">
                                                    @if (!empty($employer->updated_at))
                                                        @php
                                                            $date = date_create($employer->updated_at);
                                                            echo date_format($date,"d/m/Y");
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td class="lid_4">
                                                    <p class="crop" style="width: 350px">
                                                        {{ $employer->enterprise_name }}
                                                    </p>
                                                </td>
                                                <td class="lid_4_1">
                                                    @if(!empty($employer->introduction))
                                                    <a  class="btn btn-sm btn-primary mr-1 text-white"  data-toggle="modal" data-target="#noidung{{ $employer->employer_id }}">Nội dung</a>
                                                    <div class="modal fade" id="noidung{{ $employer->employer_id }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                                            <form action="">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        {!! $employer->introduction !!}
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td  class="lid_10" width="200px">
                                                    @if($employer->status_employer == 0)
                                                        <p class="text-danger crop">Chưa duyệt</p>
                                                    @else <p class="text-success crop">Đã duyệt</p>
                                                    @endif
                                                </td>
                                                <td class="lid_5">
                                                    @php
                                                        $province_name = App\Entity\Province::where('province_id', $employer->province)->value('province_name');
                                                        $district_name = App\Entity\District::where('district_id', $employer->district)->value('district_name');
                                                    @endphp
                                                    <p class="crop">
                                                        {{ $province_name }} | {{ $district_name }}
                                                    </p>
                                                </td>
                                                <td class="lid_6">
                                                    <?php
                                                    $totalJob = 0;
                                                    $totalJob = \App\Entity\Job::getAllJobEmployer($employer['employer_id']);

                                                    $jobs = \App\Entity\Job::getJobEmployer($employer['employer_id']);
                                                    ?>
                                                    @if ($totalJob>0)
                                                    <a class=" text-success" target="_blank" href="{{ route('staff_job-ntd.index') }}?employer_id={{ $employer['employer_id'] }}">
                                                        <p class="crop" data-toggle="modal" data-target="#myModal{{ $employer['employer_id'] }}">
                                                            {{ $totalJob }} (tin NTD)
                                                        </p>
                                                    </a>
                                                    @else
                                                    <p class="crop">
                                                        {{ $totalJob }} (tin NTD)
                                                    </p>
                                                    @endif
                                                </td>
                                                <td class="lid_7"  width="300px">
                                                    <?php
                                                    $totalJobfacebook = 0;
                                                    $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($employer['employer_id']);
                                                    ?>
                                                    {{ $totalJobfacebook }} (tin FB)
                                                </td>
                                                <td class="lid_9">
                                                    @if($employer->status_intership == 0)
                                                    <i class="fas fa-times btn btn-sm btn-danger"></i>
                                                    @elseif($employer->status_intership == 1)
                                                    <i class="fas fa-check btn btn-sm btn-success"></i>
                                                    @endif
                                                </td>
                                                <td class="lid_11">{{ $employer->number_export }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</div>
<script>
     $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
    $('#checkAllSendMail').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('.export_excel').click(function () {
        $('form#form_export_excel').submit();
    })
</script>
@endsection
