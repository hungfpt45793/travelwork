@extends('admin.layout.admin')
@section('title', 'Cập nhật công việc ' . $job->title)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập nhật công việc {{$job->title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Việc làm</a></li>
            <li class="active">Cập nhật</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('job.update',['job_id'=>$job->job_id]) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-8">
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
                            <h3 class="box-title">Thông tin tuyển dụng</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="{{$job->title}}" required>
                            </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Độ tuổi yêu cầu</label>

                                <select class="form-control select2" name="age_id">
                                    <option value="0">Không yêu cầu</option>
                                    <?php $ages = \App\Entity\Age::getAllAge()?>
                                    @foreach($ages as $age)
                                        <option value="{{ $age->id_age }}" @if($job->age_id == $age->id_age) selected @endif >{{ $age->name_age }}</option>
                                    @endforeach
                                </select>



                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giới tính yêu cầu</label>
                                <select class="form-control select2" name="gender">
                                    <option value="0" {{$job->gender == 0 ? 'selected' : ''}}>Không yêu cầu giới tính</option>
                                    <option value="1" {{$job->gender == 1 ? 'selected' : ''}}>Nữ</option>
                                    <option value="2" {{$job->gender == 2 ? 'selected' : ''}}>Nam</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chức vụ</label>
                                <input type="text" class="form-control" name="position" placeholder="Chức vụ" value="{{$job->position}}" >
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chi tiết tuyển dụng</h3>
                        </div>
                        <div class="box-body">
                            <div class="row detail-employer">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nhà tuyển dụng</label>

                                        <select class="form-control select2" name="employer_id">
                                            <option value="" selected> -- Chọn nhà tuyển dụng --</option>
                                            @foreach($employers as $emp)
                                                <option value="{{$emp['employer_id']}}" @if($emp['employer_id'] == $job->employer_id) selected @endif>
                                                    {{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group detail-employer" id="">
                                        <label for="exampleInputEmail1">Tỉnh thành</label>
                                        <?php $employer = \App\Entity\Employer::join('province','province.province_id','=','employer.province')
                                            ->join('district','district.district_id','=','employer.district')
                                            ->where('employer_id',$job->employer_id)->first(); ?>
                                        <input type="text" class="form-control" name="province" placeholder="Tỉnh thành"
                                               value="{{ !empty($employer) ? $employer->province_name : '' }}" disabled/>
                                    </div>

                                    <div class="form-group detail-employer" id="typeBusiness">
                                        <label for="exampleInputEmail1">Loại hình doanh nghiệp</label>
                                        <input type="text" class="form-control" name="type_of_business" placeholder="Loại hình doanh nghiệp"
                                               {{$string = ''}}
                                               @foreach(\App\Entity\EmployerTypeBusiness::join('employer','employer.employer_id','=','employer_typeof_business.employer_id')
                                               ->join('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
                                               ->where('employer.employer_id', $job->employer_id)->get() as $typeBusiness)
                                               {{$string .= ' ' . $typeBusiness->type_of_business_name}}
                                               @endforeach
                                               value="{{$string}}"
                                               disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mức lương</label>
                                        <select class="form-control select2" name="salary_id">
                                            <option> -- Chọn mức lương --</option>
                                            @foreach($salaries as $salary)
                                                <option value="{{$salary->salary_id}}" {{$salary->salary_id == $job->salary_id ? 'selected' : ''}}>
                                                    {{$salary->salary_from}} - {{$salary->salary_to}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phần mềm YC</label>
                                        <select class="form-control select2" name="software">
                                            <option value="" selected>Chọn phần mềm</option>
                                            @foreach($softwares as $software)
                                                <option value="{{$software->software_id}}"
                                                        @if($software->software_id = $job->software_id) selected @endif
                                                >{{$software->software_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hạn nộp hồ sơ</label>
                                        <input type="date" class="form-control" name="deadline_submit_profile" value="{{$job->deadline_submit_profile}}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group detail-employer" id="">
                                        <label for="exampleInputEmail1">Quận, Huyện</label>
                                        <input type="text" class="form-control" name="district" placeholder="Quận, Huyện"
                                               value="{{ !empty($employer) ? $employer->district_name : '' }}" disabled/>
                                    </div>

                                    <div class="form-group detail-employer" id="businessType">
                                        <label for="exampleInputEmail1">Loại hình kinh doanh</label>
                                        <input type="text" class="form-control" name="businessType" placeholder="Loại hình kinh doanh"
                                               {{$employerBusiness = ''}}
                                               @foreach(\App\Entity\EmployerBusiness::join('employer','employer.employer_id','=','employer_business_type.employer_id')
                                               ->join('business_type','business_type.business_type_id','=','employer_business_type.business_type_id')
                                               ->where('employer.employer_id', $job->employer_id)->get() as $businessType)
                                               {{$employerBusiness .= ' ' . $businessType->business_type_name }}
                                               @endforeach
                                               value="{{$employerBusiness}}"
                                               disabled />
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kinh nghiệm</label>
                                        <select class="form-control select2" name='experience_id'>
                                            <?php
                                            $experience = \App\Entity\Experience::getAllEx();
                                            ?>
                                            <option value="0" @if($job->experience_id == 0) selected @endif>Không yêu cầu</option>
                                            @foreach ($experience as $ex)

                                                <option value="{{ $ex->experience_id }}" @if($job->experience_id == $ex->experience_id) selected @endif>{{ $ex->experience_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Trình độ học vấn</label>
                                        <select class="form-control select2" name="literacy_id">
                                            <option value="0"> -- Chọn trình độ học vấn -- </option>
                                            @foreach($literacies as $literacy)
                                                <option value="{{$literacy->literacy_id}}" {{$literacy->literacy_id == $job->literacy_id ? 'selected' : ''}}>
                                                    {{$literacy->literacy_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                        <input type="text" class="form-control" name="number_recruit" placeholder="Số lượng tuyển dụng" value="{{$job->number_recruit}}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Khu vực cần tuyển dụng</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tỉnh/Thành phố</label>
                                            <select class="form-control select2" name="province" aria-label="Tỉnh/Thành phố" id="province">
                                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                            {{$province->province_id == $job->province ? 'selected' : ''}}
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Quận/Huyện</label>
                                            <select class="form-control select2" name="district" aria-label="Quận/Huyện" id="district">
                                                <option value="">-- Chọn Quận/Huyện --</option>
                                                @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                    <option value="{{$district->district_id}}"
                                                            {{$district->district_id == $job->district ? 'selected' : ''}}
                                                    >{{$district->district_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ nơi làm việc</label>
                                <textarea rows="4" class="form-control" name="address" placeholder="Địa chỉ nơi làm việc"> {{ $job->address_work }}</textarea>

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung tin tuyển dụng</label>
                                <textarea class="editor" id="content" name="content" rows="10" cols="80" >{{$job->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phúc lợi xã hội</label>
                                <textarea class="editor" id="content_welfare" name="welfare" rows="10" cols="80" >{{$job->welfare}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <textarea rows="4" class="form-control editor" name="description" id="description_job"
                                          placeholder="">{{$job->description}}</textarea>
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

                                <input type="date" class="form-control" name="date_end" value="<?php
                                $date_end=date_create($job->date_end);
                                echo date_format($date_end,"Y-m-d");
                                ?>" >
                            </div>
                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nhóm Công Việc</h3>
                        </div>
                        <div class="box-body scrollGroup">
                            @foreach($jobgroups as $jobgroup)
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="jobgroup_id" value="{{$jobgroup->job_group_id}}" class="flat-red" @if($jobgroup->job_group_id == $job->jobgroup_id) checked @endif
                                        >
                                        {{$jobgroup->job_group_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Danh mục ngành nghề</h3>
                        </div>
                        <div class="box-body scrollGroup">
                            @foreach(\App\Entity\Career::get() as $career)
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="career_category_id" value="{{$career->career_category_id}}" class="flat-red" id="salePackage"
                                               @if($career->career_category_id == $job->career_category_id) checked @endif
                                        >
                                        {{$career->career_category_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gói bán hàng</h3>
                        </div>
                        <div class="box-body">
                            <select class="form-control" name="salePackages" id="salePackages">
                                <option value="0"> -- Chọn gói bán hàng -- </option>
                                @foreach($salePackages as $salePackage)
                                    <option value="{{$salePackage->sale_package_id}}"
                                            @if($job->sale_package_id  == $salePackage->sale_package_id) selected @endif
                                    >{{$salePackage->sale_package_name}}</option>
                                @endforeach
                            </select>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label style="margin-right: 20px">
                                        <input type="radio" name="vip" class="flat-red" value="0" @if($job->vip == 0) checked @endif>
                                        Tin thường
                                    </label>
                                    <label>
                                        <input type="radio" name="vip" class="flat-red" value="1" @if($job->vip == 1) checked @endif>
                                        Tin vip
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ Seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{$job->meta_title}}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{$job->meta_description}}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{ $job->meta_keyword }}"/>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="radio" name="sale_money" value="0" class="flat-red" @if($job->sale_money == 0) checked @endif
                                    />Không chia sẻ
                                </label>
                                <label>
                                    <input type="radio" name="sale_money" value="1" class="flat-red" @if($job->sale_money == 1) checked @endif
                                    /> Chia sẻ bài viết
                                </label>
                                <label>
                                    <input type="radio" name="sale_money" value="2" class="flat-red" @if($job->sale_money == 2) checked @endif
                                    /> Tạm dừng chia sẻ
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
    <script type="text/javascript">
        var filter_row = 0;

        function addFilterRow() {
            html  = '<tr id="filter-row' + filter_row + '">';
            html += '  <td class="text-left" style="width: 90%;">';
            html += '  <div class="form-group">';
            html += '<input type="text" name="address[]" value="" class="form-control" placeholder="Địa chỉ nơi làm việc" >'
            html += '  </div>';
            html += '  </td>';
            html += '  <td ><button type="button" onclick="$(\'#filter-row' + filter_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#filter tbody').append(html);

            filter_row++;
        }
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#employer').change(function () {
                $.get('/admin/ajax-employer-province/' + $(this).val(), function (result) {
                    $('#province').html(result);
                });
                $.get('/admin/ajax-employer-district/' + $(this).val(), function (result) {
                    $('#district').html(result);
                });
                $.get('/admin/ajax-employer-businessType/' + $(this).val(), function (result) {
                    $('#businessType').html(result);
                });
                $.get('/admin/ajax-employer-typeBusiness/' + $(this).val(), function (result) {
                    $('#typeBusiness').html(result);
                });
            });

            $('#salePackages').change(function () {
                $.get('/admin/ajax-sale/' + $(this).val(), function (data) {
                    $('#employer').html(data);
                    $.get('/admin/ajax-employer-province/' + $('#employer').val(), function (result) {
                        $('#province').html(result);
                    });
                    $.get('/admin/ajax-employer-district/' + $('#employer').val(), function (result) {
                        $('#district').html(result);
                    });
                    $.get('/admin/ajax-employer-businessType/' + $('#employer').val(), function (result) {
                        $('#businessType').html(result);
                    });
                    $.get('/admin/ajax-employer-typeBusiness/' + $('#employer').val(), function (result) {
                        $('#typeBusiness').html(result);
                    });
                });
            });

            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
        });
    </script>
@endpush