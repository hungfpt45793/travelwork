@extends('admin.layout.admin')
@section('title', 'Danh sách nhà tuyển dụng' )

@section('content')
<section class="content-header">
    <h1>
        Nhà tuyển dụng
    </h1>
</section>
<section class="content">
    <div class="row box">
        <div class="col-xl-12 col-lg-12 col-md-12 ">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <form role="search" class="form-plus" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                            </div>
        
                            <div class="row" style="margin-top: 1%">
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <?php
                                        $province_get = '';
                                        if(isset($_GET['province']))
                                        {
                                            $province_get = $_GET['province'];
                                        }
                                        ?>
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
        
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
                                <div class="col-md-3">
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
                            <div class="col-md-12 text-center" style="margin-top: 20px">
                                <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                <span class="btn btn-success notexpan-form"><i class="fa fa-minus"></i></span>
                            </div>
                        </div>
                    </form>
                    <form role="search" class="form-short" method="GET" id="submitForm">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-5 col-xs-5">
                                    <?php
                                    $enterprise_name_get = '';
                                    if(isset($_GET['enterprise_name']))
                                    {
                                        $enterprise_name_get = $_GET['enterprise_name'];
                                    }
                                    ?>
                                    <input type="text" placeholder="Tên nhà tuyển dụng" class="form-control" name="enterprise_name" value="@if(!empty($enterprise_name_get)) {{$enterprise_name_get}} @endif">
                                </div>
                                <div class="col-xs-5 col-md-5">
                                    <?php
                                    $email_get = '';
                                    if(isset($_GET['email']))
                                    {
                                        $email_get = $_GET['email'];
                                    }
                                    ?>
                                    <input type="text" placeholder="Email nhà tuyển dụng" class="form-control" name="email" value="@if(!empty($email_get)) {{$email_get}} @endif">
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <button type="submit" class="btn btn-success">Tìm Kiếm</button>
                                    <span class="btn btn-success float-right expan-form"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row ">
                        <div class="col-md-12 space-b">
                            <a class="btn btn-success mgb30 "  href="{{ route('staff_employer.create') }}">Thêm mới</a>
                            <b>Tổng({{ $total }})</b>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="table-responsive" style="padding-bottom:100px;">
                                <table class="table table-bordered table-hover d-table-respon " style="overflow-x: auto;">
                                    <thead>
                                        <tr>
                                            <th scope="col ">id</th>
                                            <th scope="col ">Thêm ĐH</th>
                                            <th scope="col "  style="width:100px" >Ngày tạo</th>
                                            <th scope="col ">Tên NTD</th>
                                            <th scope="col ">Địa chỉ</th>
                                            <th scope="col ">Số tin TD</th>
                                            <th scope="col ">Số tin TD facebook</th>
                                            <th scope="col ">Đề nghị xóa</th>
                                            {{-- <th scope="col ">Liên lạc</th> --}}
                                            <th scope="col ">Tuyển thực tập</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employers as $employer)
                                        <tr>
                                            <td scope="row ">{{ $employer->employer_id }}</td>
                                            <td>
                                                <div class="button-group">
                                                    <a href="{{ route('service_order_icon.create') }}?employer_id={{ $employer->employer_id }}">
                                                        <p type="button" class="btn btn-info">Thêm ĐH</p>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if (!empty($employer->updated_at))
                                                @php
                                                    $date = date_create($employer->updated_at);
                                                    echo date_format($date,"d-m-Y");
                                                @endphp
                                                @else
                                                @php
                                                    $date = date_create($employer->created_at);
                                                    echo date_format($date,"d-m-Y");
                                                @endphp
                                                @endif
                                            </td>
                                            <td>{{ $employer->enterprise_name }}</td>
                                            <td>
                                                @php
                                                    $province_name = App\Entity\Province::where('province_id', $employer->province)->value('province_name');
                                                    $district_name = App\Entity\District::where('district_id', $employer->district)->value('district_name');
                                                @endphp
                                                {{ $province_name }} | {{ $district_name }}
                                            </td>
                                            <td>
                                                <?php
                                                $totalJobfacebook = 0;
                                                $totalJobfacebook = \App\Entity\JobFacebook::getAllJobFacebookEmployer($employer['employer_id']);
                                                ?>
                                                {{ $totalJobfacebook }} (tin NTD)
                                            </td>
                                            <td>
                                                <?php
                                                $totalJob = 0;
                                                $totalJob = \App\Entity\Job::getAllJobEmployer($employer['employer_id']);
                                                ?>
                                                {{ $totalJob }} (tin Facebook)
                                            </td>
                                            <td>
                                                <?php
                                                $check_delete = \App\Entity\Employer_delete_request::where('employer_id',$employer['employer_id'])->first();
                                                ?>
                                                @if($check_delete == null)
                                                   <span style="color: green">Không</span> 
                                                @else <span style="color: red">Có</span>
                                                @endif
                                            </td>
                                            <td>
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
                                {{ $employers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- The Modal -->
        </div>
    </div>
</section>
<script>
     $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
    //
    $('.form-plus').hide();
            $('.expan-form').click(function(){
                $('.form-plus').show();
                $('.form-short').hide();
            })
            $('.notexpan-form').click(function(){
                $('.form-plus').hide();
                $('.form-short').show();
            })
</script>
@endsection