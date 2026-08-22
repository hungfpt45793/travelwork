@extends('staff_admin.layouts.master')

@section('title', 'Tạo mới tin tuyển dụng' )

@section('content')
<div class="container-fluid">
    <div class="row row-content">
        {{-- sitebar --}}
        <div class="col-xl-3 col-lg-3 d-parent col-md-12 d-sidebarfull col-sidebar" id="js_toogle_sidebar">
            @include('staff_admin.sidebars.job')
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 d-THScontent createProfileOnline col-content">
            <section class="jobsInteresting bgrWhite bdLightGray radius5 ">
                <div class="contentJobsInteresting pd15 col-f14 ">
                    <form class="custom-form" role="form" action="{{ route('staff_job-ntd.store') }}" method="POST"
                        enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('POST') }}
                        <div class="row">
                            <div class="col-xs-12 col-md-7">
                                <!-- Nội dung thêm mới -->
                                <div class="box box-primary">
                                    @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $error }}</strong>
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Thông tin tuyển dụng</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tiêu đề</label>
                                            <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                                value="{{ old('title') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email nhận thông báo</label>
                                            <input type="text" class="form-control" name="email_to_profile" placeholder="Email nhận thông báo"
                                                value="{{ old('email_to_profile') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Độ tuổi yêu cầu</label>

                                            <select class="form-control select22" name="age_id">
                                                <option value="0">Không yêu cầu</option>
                                                <?php $ages = \App\Entity\Age::getAllAge()?>
                                                @foreach($ages as $age)
                                                <option value="{{ $age->id_age }}" @if(old('age_id')==$age->id_age)
                                                    selected @endif
                                                    >{{ $age->name_age }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Loại tin tuyển dụng</label>

                                            <select class="form-control select22" name="status_select_job">
                                                <option value="0" @if(old('status_select_job')==0) selected @endif>Tin
                                                    bình thường</option>
                                                <option value="1" @if(old('status_select_job')==1) selected @endif>Tin
                                                    tuyển hộ</option>
                                                <option value="2" @if(old('status_select_job')==2) selected @endif>Tin
                                                    của đơn hàng</option>

                                            </select>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1"
                                                value="0" @if(old('gender')==0) checked @endif>
                                            <label class="form-check-label" for="inlineRadio1">Không yêu cầu giới
                                                tính</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2"
                                                value="1" @if(old('gender')==1) checked @endif>
                                            <label class="form-check-label" for="inlineRadio2">Nữ</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="inlineRadio3"
                                                value="2" @if(old('gender')==2) checked @endif>
                                            <label class="form-check-label" for="inlineRadio3">Nam</label>
                                        </div>
                                        <div class="form-group" style="color: red;">
                                            @if ($errors->has('title'))
                                            <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Nội dung</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nội dung tin tuyển dụng</label>
                                            <textarea class="editor" id="content" name="content" rows="10"
                                                cols="80" />{{ old('content') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phúc lợi xã hội</label>
                                            <textarea class="editor" id="content_welfare" name="welfare" rows="10"
                                                cols="80" />{{ old('welfare') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả</label>
                                            <textarea rows="4" class="form-control editor" name="description"
                                                id="description" placeholder="">{{ old('description') }}</textarea>
                                        </div>

                                        {{-- từ khóa --}}
                                        @php
                                        foreach ($input_tags as $tag) {
                                        $tag_type = $tag['tag_type'];
                                        }
                                        @endphp
                                        @include('admin.layout.themtukhoa')
                                        {{-- END từ khóa --}}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Hạn của tin tuyển dụng</label>
                                            <input type="date" class="form-control" name="date_end"
                                                value="{{ old('date_end') }}">
                                        </div>
                                        <div class="form-group" style="color: red;">
                                            @if ($errors->has('title'))
                                            <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-5">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Chi tiết tuyển dụng</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row detail-employer">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nhà tuyển dụng</label>
                                                    <select name="employer_id" id="select2_employer" class="">
                                                        @if(old('employer_id'))
                                                        <?php
                                                            $old_employer = \App\Entity\Employer::select('employer_id', 'email', 'enterprise_name')->where('employer_id', old('employer_id'))->first();
                                                        ?>
                                                        <option selected value="{{ old('employer_id') }}">
                                                            {{$old_employer->email}}-{{$old_employer->enterprise_name}}
                                                        </option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mức lương</label>
                                                    <select class="form-control select22" name="salary_id">
                                                        <option> -- Chọn mức lương --</option>
                                                        @foreach($salaries as $salary)
                                                        <option value="{{$salary->salary_id}}">
                                                            {{number_format($salary->salary_from)}} -
                                                            {{number_format($salary->salary_to)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Phần mềm YC</label>
                                                    <select class="form-control select22" name="software">
                                                        <option value="" selected>Chọn phần mềm</option>
                                                        @foreach($softwares as $software)
                                                        <option value="{{$software->software_id}}">
                                                            {{$software->software_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Hạn nộp hồ sơ</label>
                                                    <input type="date" class="form-control"
                                                        name="deadline_submit_profile" value="{{ old('deadline_submit_profile') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Kinh nghiệm</label>
                                                    <select class="form-control select22" name='experience_id'>
                                                        <?php
                                                            $experience = \App\Entity\Experience::getAllEx();
                                                        ?>
                                                        <option value="0" selected>Không yêu cầu</option>
                                                        @foreach ($experience as $ex)

                                                        <option value="{{ $ex->experience_id }}">
                                                            {{ $ex->experience_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Trình độ học vấn</label>
                                                    <select class="form-control select22" name="literacy_id">
                                                        <option value="0"> -- Chọn trình độ học vấn -- </option>
                                                        @foreach($literacies as $literacy)
                                                        <option value="{{$literacy->literacy_id}}">
                                                            {{$literacy->literacy_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                                    <input type="text" class="form-control" name="number_recruit"
                                                        placeholder="Số lượng tuyển dụng" value="" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Khu vực cần tuyển dụng</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                                        <select class="js-example-basic-single form-control select22"
                                                            id="province" name="province">
                                                            <option value="">--Chọn Tỉnh/Thành phố--</option>
                                                            @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                            <option value="{{$province->province_id}}"
                                                                {{$province->province_id == old('province') ? 'selected' : ''}}>
                                                                {{$province->province_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Quận/Huyện</label>
                                                        <select class="js-example-basic-single form-control select22"
                                                            id="district" name="district">
                                                            <option value="">--Chọn Quận/huyện--</option>
                                                            @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                            <option value="{{$district->district_id}}"
                                                                {{$district->district_id == old('district') ? 'selected' : ''}}>
                                                                {{$district->district_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Địa chỉ nơi làm việc</label>
                                            <textarea rows="4" class="form-control" name="address"
                                                placeholder="Địa chỉ nơi làm việc"></textarea>

                                        </div>
                                    </div>
                                </div>
                                <!-- Nội dung thêm mới -->
                                <div class="box box-primary boxCateScoll">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Nhóm Công Việc</h4>
                                    </div>

                                    <div class="box-body scrollGroup">
                                        @foreach($jobgroups as $jobgroup)
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="jobgroup_id"
                                                    value="{{$jobgroup->job_group_id}}" class="flat-red">
                                                {{$jobgroup->job_group_name}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="box box-primary boxCateScoll">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Danh mục ngành nghề</h4>
                                    </div>

                                    <div class="box-body scrollGroup">
                                        @foreach(\App\Entity\Career::get() as $career)
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="career_category_id"
                                                    value="{{$career->career_category_id}}" class="flat-red"
                                                    id="salePackage">
                                                {{$career->career_category_name}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="box box-primary boxCateScoll">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Gói bán hàng</h4>
                                    </div>

                                    <div class="box-body">
                                        <select class="form-control" name="salePackages" id="salePackages">
                                            <option value="0"> -- Chọn gói bán hàng -- </option>
                                            @foreach($salePackages as $salePackage)
                                            <option value="{{$salePackage->sale_package_id}}"
                                                {{!empty(\App\Entity\JobSalePackage::where('sale_package_id', $salePackage->sale_package_id)->first()) ? 'selected' : ''}}>
                                                {{$salePackage->sale_package_name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <div class="form-group">
                                                <label style="margin-right: 20px">
                                                    <input type="radio" name="vip" class="flat-red" value="0"
                                                        @if(old('vip')==0) checked @endif @if(!old('vip')) checked
                                                        @endif>
                                                    Tin thường
                                                </label>
                                                <label>
                                                    <input type="radio" name="vip" class="flat-red" value="1"
                                                        @if(old('vip')==1) checked @endif>
                                                    Tin vip
                                                </label>
                                                <label>
                                                    <input type="radio" name="vip" class="flat-red" value="2"
                                                        @if(old('vip')==2) checked @endif>
                                                    Tin vip 2
                                                </label>

                                            </div>


                                            <div class="form-group">
                                                <label style="margin-right: 15px">
                                                    <input type="radio" name="sale_money" value="0" class="flat-red" />
                                                    Không chia sẻ
                                                </label>
                                                <label style="margin-right: 15px">
                                                    <input type="radio" name="sale_money" value="1" class="flat-red" checked />
                                                    Chia sẻ bài viết
                                                </label>
                                                <label>
                                                    <input type="radio" name="sale_money" value="2" class="flat-red" />
                                                    Tạm dừng chia sẻ
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nội dung thêm mới -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-warning">Lưu</button>
                                </div>
                                <!-- /.box -->
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
var filter_row = 0;

function addFilterRow() {
    html = '<tr id="filter-row' + filter_row + '">';
    html += '  <td class="text-left" style="width: 90%;">';
    html += '  <div class="form-group">';
    html += '<input type="text" name="address[]" value="" class="form-control" placeholder="Địa chỉ nơi làm việc" >'
    html += '  </div>';
    html += '  </td>';
    html += '  <td ><button type="button" onclick="$(\'#filter-row' + filter_row +
        '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

    $('#filter tbody').append(html);

    filter_row++;
};
$(document).ready(function() {
    $('#employer').change(function() {
        $.get('/admin/ajax-employer-province/' + $(this).val(), function(result) {
            $('#province').html(result);
        });
        $.get('/admin/ajax-employer-district/' + $(this).val(), function(result) {
            $('#district').html(result);
        });
        $.get('/admin/ajax-employer-businessType/' + $(this).val(), function(result) {
            $('#businessType').html(result);
        });
        $.get('/admin/ajax-employer-typeBusiness/' + $(this).val(), function(result) {
            $('#typeBusiness').html(result);
        });
    });

    $('#salePackages').change(function() {
        $.get('/admin/ajax-sale/' + $(this).val(), function(data) {
            $('#employer').html(data);
            $.get('/admin/ajax-employer-province/' + $('#employer').val(), function(result) {
                $('#province').html(result);
            });
            $.get('/admin/ajax-employer-district/' + $('#employer').val(), function(result) {
                $('#district').html(result);
            });
            $.get('/admin/ajax-employer-businessType/' + $('#employer').val(), function(
                result) {
                $('#businessType').html(result);
            });
            $.get('/admin/ajax-employer-typeBusiness/' + $('#employer').val(), function(
                result) {
                $('#typeBusiness').html(result);
            });
        });
    });
    $('#province').change(function() {
        $.get('/admin/ajax-district/' + $(this).val(), function(data) {
            $('#district').html(data);
        })
    });
});
</script>
@endsection
