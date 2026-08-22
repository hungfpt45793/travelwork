@extends('staff_admin.layouts.master')
@section('title', 'Danh sách NTD' )
@section('content')
<section class="content">
    <div class="row box row-content">
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.order')
            </div>
        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting col-f14 ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="">
                                <a  class="btn btn-sm btn-secondary mr-1 text-white"  data-toggle="modal" data-target="#timkiem"><i class="fas fa-search text-primary"></i> Tìm</a>
                                <div class="modal fade" id="timkiem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog custom-modal-dialog modal-dialog-centered" role="document">
                                        <form action="" style="width:100%;height:100%">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Tìm kiếm nhà tuyển dụng</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-5 mb-3">
                                                            <div class="col-md-12">
                                                            <label for="validationDefault01">Từ ngày(ngày tạo)</label>
                                                            @php
                                                                  $d=strtotime("-1 Months");
                                                                  $date = date("Y-m-d", $d)
                                                            @endphp
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_start']) ? $_GET['date_search_start'] : $date }}" type="date" id="" name="date_search_start">
                                                          </div>
                                                        </div>
                                                          <div class="col-md-5 mb-3">
                                                            <div class="col-md-12">
                                                            <label for="validationDefault02">Đến ngày(ngày tạo)</label>
                                                            <input  class="form-control myDatetime" max="9999-12-31" value="{{ isset($_GET['date_search_end']) ? $_GET['date_search_end'] : date("Y-m-d") }}" type="date" id="" name="date_search_end">
                                                          </div>
                                                        </div>
                                                        <!-- myDatetime -->
                                                        <div class="col-md-2 mb-3">
                                                            <label for="validationDefault2" class="text-light">sd</label>
                                                            <input type="button" class="form-control pass_date btn btn-primary" value="Bỏ qua ngày"></input>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $type_of_business_id_get = '';
                                                                if(isset($_GET['type_of_business_id']))
                                                                {
                                                                    $type_of_business_id_get = $_GET['type_of_business_id'];
                                                                }
                                                                ?>
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
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $business_get = '';
                                                                if(isset($_GET['business']))
                                                                {
                                                                    $business_get = $_GET['business'];
                                                                }
                                                                ?>
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
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $enterprise_name_get = '';
                                                                if(isset($_GET['enterprise_name']))
                                                                {
                                                                    $enterprise_name_get = $_GET['enterprise_name'];
                                                                }
                                                                ?>
                                                                <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control" name="enterprise_name" value="@if(!empty($enterprise_name_get)) {{$enterprise_name_get}} @endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $status_agency_get = '';
                                                                if(isset($_GET['status_agency']))
                                                                {
                                                                    $status_agency_get = $_GET['status_agency'];
                                                                }
                                                                ?>
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
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $province_get = '';
                                                                if(isset($_GET['province']))
                                                                {
                                                                    $province_get = $_GET['province'];
                                                                }
                                                                ?>
                                                                <select class="js-example-basic-single form-control select2" id="province" name="province">
                                                                    <option value="s">--Tỉnh/Thành phố--</option>
                                                                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                                    <option value="{{$province->province_id}}" @if(isset($_GET['province']) && $_GET['province'] == $province->province_id) selected @endif>
                                                                        {{$province->province_name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
                                                                <?php
                                                                $district_get = '';
                                                                if (isset($_GET['district'])) {
                                                                    $district_get = $_GET['district'];
                                                                }
                                                            ?>
                                                           <select class="js-example-basic-single form-control select2" name="district" id="district">
                                                            <option value="0">--Chọn quận/huyện</option>
                                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            <option value="{{$district->district_id}}"
                                                                @if(isset($_GET['district']) &&
                                                                $_GET['district']==$district->district_id) selected @endif>
                                                                {{$district->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">

                                                            <div class="col-md-12">
                                                                <?php
                                                                $email_get = '';
                                                                if(isset($_GET['email']))
                                                                {
                                                                    $email_get = $_GET['email'];
                                                                }
                                                                ?>
                                                                <input type="text" placeholder="Email nhà tuyển dụng" class="form-control" name="email" value="@if(!empty($email_get)) {{$email_get}} @endif">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="col-md-12">
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
                                <a href="{{ route('list_employer_to_add_service_order_in_staff') }}" class="btn btn-sm btn-secondary mr-1 text-white"><i class="fas fa-sync-alt text-success"></i> Làm tươi</a>
                                {{-- <button  type="button" class="btn btn-sm btn-danger delete_all mr-1">Xóa</button> --}}
                            </div>
                            <div class="custom-paginate row mt-1 ml-1">
                                {{ $employers->links() }}
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
                        <div class="col-md-12">
                            <div data-fl-scrolls id="locker" class="custom-table  table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                <div class="lockedWrap lockedWrap-first">
                                    <div class="cellWrap cellWrap-first">
                                        <p><input type="checkbox" id="master"></p>
                                    </div>
                                    @foreach ($employers as $employer)
                                    <div class="cellWrap">
                                        <input type="checkbox" class="sub_chk" data-id="{{ $employer->employer_id }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tableFixHead" style="padding-bottom:100px;overflow-x:auto;">
                                <table data-fl-scrolls class="custom-table table-scroll table-bordered table-striped" style="overflow: scroll;height:100vh;display:block;table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <td class="lid_1"><p style="width: 50px">id<button class="lockButton btn btn-sm btn-success" id="lid_1">L</button></p></td>
                                            <td class="lid_2"><p style="width: 80px">Thêm ĐH<button class="lockButton btn btn-sm btn-success" id="lid_2">L</button></p></td>
                                            <td class="lid_4"><p style="width: 300px">Tên NTD<button class="lockButton btn btn-sm btn-success" id="lid_4">L</button></p></td>
                                            <td class="lid_5"><p style="width: 300px">Địa chỉ<button class="lockButton btn btn-sm btn-success" id="lid_5">L</button></p></td>
                                            <td class="lid_6"><p style="width: 100px">Số tin TD<button class="lockButton btn btn-sm btn-success" id="lid_6">L</button></p></td>
                                            <td class="lid_7"><p style="width: 120px">Số tin TD FB<button class="lockButton btn btn-sm btn-success" id="lid_7">L</button></p></td>
                                            <td class="lid_3"><p style="width: 100px">Ngày tạo<button class="lockButton btn btn-sm btn-success" id="lid_3">L</button></p></td>
                                            <td class="lid_8"><p style="width: 100px">ĐN/XÓA<button class="lockButton btn btn-sm btn-success" id="lid_8">L</button></p></td>
                                            <td class="lid_9"><p style="width: 120px">Tuyển thực tập<button class="lockButton btn btn-sm btn-success" id="lid_9">L</button></p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employers as $employer)
                                        <tr>
                                            <td class="lid_1">{{ $employer->employer_id }}</td>
                                            <td class="lid_2">
                                                    <a class="btn btn-sm btn-info" href="{{ route('staff_hunter_order.create') }}?employer_id={{ $employer->employer_id }}">
                                                       Thêm ĐH
                                                    </a>
                                            </td>

                                            <td class="lid_4">{{ $employer->enterprise_name }}</td>
                                            <td class="lid_5">
                                                @php
                                                    $province_name = App\Entity\Province::where('province_id', $employer->province)->value('province_name');
                                                    $district_name = App\Entity\District::where('district_id', $employer->district)->value('district_name');
                                                @endphp
                                                {{ $province_name }} | {{ $district_name }}
                                            </td>
                                            <td class="lid_6">
                                                <?php
                                                $totalJobfacebook = 0;
                                                $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($employer['employer_id']);
                                                ?>
                                                {{ $totalJobfacebook }} (tin NTD)
                                            </td>
                                            <td class="lid_7">
                                                <?php
                                                $totalJob = 0;
                                                $totalJob = \App\Entity\Job::getAllJobEmployer($employer['employer_id']);
                                                ?>
                                                {{ $totalJob }} (tin Facebook)
                                            </td>
                                            <td class="lid_3">
                                                @if (isset($employer->created_at))
                                                    {{ date_format($employer->created_at,"d-m-Y") }}
                                                @endif

                                            </td>
                                            <td class="lid_8">
                                                <?php
                                                $check_delete = \App\Entity\Employer_delete_request::where('employer_id',$employer['employer_id'])->first();
                                                ?>
                                                @if($check_delete == null)
                                                   <span style="color: green">Không</span>
                                                @else <span style="color: red">Có</span>
                                                @endif
                                            </td>
                                            <td class="lid_9">
                                                @if($employer->status_intership == 0)
                                                <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                                @elseif($employer->status_intership == 1)
                                                <button class="btn btn-success"><i class="fa fa-check"></i>  </button>
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
</section>
@push('custom-scripts')
<script>
    $('#province').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#district').html(data);
            })
        });
        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))
         {
            $(".sub_chk").prop('checked', true);
         } else {
            $(".sub_chk").prop('checked',false);
         }
        });
</script>
@endpush
@endsection
