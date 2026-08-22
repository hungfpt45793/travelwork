@extends('admin.layout.admin')

@section('title', 'Thêm mới công việc')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới công việc
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc làm</a></li>
            <li><a href="#">Việc làm</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form role="form" action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('POST') }}

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
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Độ tuổi yêu cầu</label>

                                <select class="form-control select2" name="age_id">
                                    <option value="0">Không yêu cầu</option>
                                    <?php $ages = \App\Entity\Age::getAllAge()?>
                                    @foreach($ages as $age)
                                        <option value="{{ $age->id_age }}">{{ $age->name_age }}</option>
                                    @endforeach
                                </select>



                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giới tính yêu cầu</label>
                                <select class="form-control select2" name="gender">
                                    <option value="0">Không yêu cầu giới tính</option>
                                    <option value="1"}>Nữ</option>
                                    <option value="2">Nam</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chức vụ</label>
                                <input type="text" class="form-control" name="position" placeholder="Chức vụ" value="" >
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
                                                <option value="{{$emp['employer_id']}}">
                                                    {{ isset($emp['enterprise_name']) ? $emp['enterprise_name'] : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mức lương</label>
                                        <select class="form-control select2" name="salary_id">
                                            <option> -- Chọn mức lương --</option>
                                            @foreach($salaries as $salary)
                                                <option value="{{$salary->salary_id}}">
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

                                                >{{$software->software_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hạn nộp hồ sơ</label>
                                        <input type="date" class="form-control" name="deadline_submit_profile" value="" />
                                    </div>
                                </div>

                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kinh nghiệm</label>
                                        <select class="form-control select2" name='experience_id'>
                                            <?php
                                            $experience = \App\Entity\Experience::getAllEx();
                                            ?>
                                            <option value="0" selected>Không yêu cầu</option>
                                            @foreach ($experience as $ex)
                                                <option value="{{ $ex->experience_id }}">{{ $ex->experience_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Trình độ học vấn</label>
                                        <select class="form-control select2" name="literacy_id">
                                            <option value="0"> -- Chọn trình độ học vấn -- </option>
                                            @foreach($literacies as $literacy)
                                                <option value="{{$literacy->literacy_id}}" >
                                                    {{$literacy->literacy_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số lượng cần tuyển</label>
                                        <input type="text" class="form-control" name="number_recruit" placeholder="Số lượng tuyển dụng" value="" />
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
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ nơi làm việc</label>
                                <textarea rows="4" class="form-control" name="address" placeholder="Địa chỉ nơi làm việc"></textarea>

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
                                <textarea class="editor" id="content" name="content" rows="10" cols="80" /></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phúc lợi xã hội</label>
                                <textarea class="editor" id="content_welfare" name="welfare" rows="10" cols="80" /></textarea>
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mô tả</label>
							<textarea rows="4" 
                                class="form-control editor" 
                                name="description" 
                                id="description_job"
                                placeholder="">
                            </textarea>
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
                            <input type="date" class="form-control" name="date_end" value="" >
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
                                        <input type="radio" name="jobgroup_id" value="{{$jobgroup->job_group_id}}" class="flat-red"
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
                                            {{!empty(\App\Entity\JobSalePackage::where('sale_package_id', $salePackage->sale_package_id)->first()) ? 'selected' : ''}}
                                    >{{$salePackage->sale_package_name}}</option>
                                @endforeach
                            </select>

                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label style="margin-right: 20px">
                                        <input type="radio" name="vip" class="flat-red" value="0" @if(old('vip') == 0) checked @endif @if(!old('vip')) checked @endif>
                                        Tin thường
                                    </label>
                                    <label>
                                        <input type="radio" name="vip" class="flat-red" value="1" @if(old('vip') == 1) checked @endif>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value=""/>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="sale_money" value="0" class="flat-red"
                                    />Không chia sẻ
                                </label>
                                <label>
                                    <input type="radio" name="sale_money" value="1" class="flat-red" checked
                                    /> Chia sẻ bài viết
                                </label>
                                <label>
                                    <input type="radio" name="sale_money" value="2" class="flat-red"
                                    /> Tạm dừng chia sẻ
                                </label>
                            </div>



                        </div>



                    </div>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
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
            $('#province').change(function () {
                $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                    $('#district').html(data);
                })
            });
        });
    </script>
@endpush