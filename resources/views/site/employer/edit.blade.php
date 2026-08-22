@extends('site.layout.site')

@section('title','Cập nhật tin tuyển dụng ' . $job->title)
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

    <section class="content">
        <div class="container">
            <div class="row ">

                <div class="col-xl-9 col-lg-9 col-md-12 JobSeeker">
                    <div class="main">
                        <div class="notificationBox mb30">
                            <p class="text-title">
                                Cập nhật tin tuyển dụng {{$job->title}}
                            </p>
                            <hr>
                            <div class="bodyBox">
                                <div class="accountInfo">
                                    <form action="{{route('update_job',['slug'=> $job->slug])}}" method="post">
                                        {!! csrf_field() !!}
                                        {{method_field('PUT')}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Tên công việc <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="text" name='title' class="form-control" placeholder="Tên công việc"
                                                value="{{$job->title}}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Vị trí tuyển dụng
                                                <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name='position' class="form-control" placeholder="Vị trí tuyển dụng "
                                                value="{{$job->position}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Địa điểm làm việc
                                                <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name='address' class="form-control" placeholder="Địa điểm làm việc" value="{{!empty(\App\Entity\Workplace::where('job_id', $job->job_id)->first()) ? \App\Entity\Workplace::where('job_id', $job->job_id)->first()->address : ''}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Hình thức làm việc
                                                <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control jobGroups" name='job_group[]' multiple="true">
                                                    @foreach (\App\Entity\JobGroup::ShowJobGroup() as $jobGroup)
                                                        <option value="{{$jobGroup->job_group_id}}"
                                                        {{!empty(\App\Entity\JobJobGroup::where('job_group_id', $jobGroup->job_group_id)
                                                        ->where('job_id', $job->job_id)->first()) ? 'selected' : ''}}
                                                        >{{$jobGroup->job_group_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Chọn ngành nghề việc làm
                                                <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control jobGroup" name='careers[]' multiple="true">
                                                    @foreach (\App\Entity\Career::getAllCareer() as $carrer)
                                                        <option value="{{$carrer->career_category_id}}"
                                                        {{ !empty(\App\Entity\JobCareer::where('career_category_id', $carrer->career_category_id)
                                                        ->where('job_id', $job->job_id)->first()) ? 'selected' : '' }}
                                                        >{{$carrer->career_category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Mức lương
                                                <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name='salary'>
                                                    @foreach (\App\Entity\Salary::showAllSalary() as $salary)
                                                        <option value="{{$salary->salary_id}}"
                                                        {{$job->salary_id == $salary->salary_id ? 'selected' : ''}}
                                                        >{{number_format($salary->salary_from)}} VNĐ - {{number_format($salary->salary_to) }} VNĐ</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Số lượng cần tuyển
                                                <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="number" name="number_recruited" class="form-control" placeholder="Số lượng nhân viên cần tuyển"
                                                value="{{$job->number_recruit}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Kinh nghiệm <span>*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name='experience'>
                                                    <option value="Không yêu cầu" {{$job->experience == 'Không yêu cầu' ? 'selected' : ''}}>Không yêu cầu</option>
                                                    <option value="Dưới 1 năm" {{$job->experience == 'Dưới 1 năm' ? 'selected' : ''}}>Dưới 1 năm</option>
                                                    <option value="1 năm" {{$job->experience == '1 năm' ? 'selected' : ''}}>1 năm</option>
                                                    <option value="2 năm" {{$job->experience == '2 năm' ? 'selected' : ''}}>2 năm</option>
                                                    <option value="3 năm" {{$job->experience == '3 năm' ? 'selected' : ''}}>3 năm</option>
                                                    <option value="4 năm" {{$job->experience == '4 năm' ? 'selected' : ''}}>4 năm</option>
                                                    <option value="5 năm" {{$job->experience == '5 năm' ? 'selected' : ''}}>5 năm</option>
                                                    <option value="Hơn 5 năm" {{$job->experience == 'Hơn 5 năm' ? 'selected' : ''}}>Hơn 5 năm</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Yêu cầu bằng cấp
                                                <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name='literacy'>
                                                    @foreach (\App\Entity\Literacy::showAllLiteracies() as $literacy)
                                                        <option value="{{$literacy->literacy_id}}"
                                                        {{$job->literacy_id == $literacy->literacy_id ? 'selected' : ''}}
                                                        >{{$literacy->literacy_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Giới tính
                                                <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name='gender'>
                                                    <option value="0" {{$job->gender == 0 ? 'selected' : ''}}>Không yêu cầu</option>
                                                    <option value="1" {{$job->gender == 1 ? 'selected' : ''}}>Nữ</option>
                                                    <option value="2" {{$job->gender == 2 ? 'selected' : ''}}>Nam</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable">Độ tuổi
                                                <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name='age'>
                                                    <option value="Không yêu cầu" {{$job->age == 'Không yêu cầu' ? 'selected' : ''}}>Không yêu cầu</option>
                                                    <option value="15 - 24 tuổi" {{$job->age == '15 - 24 tuổi' ? 'selected' : ''}}>15 - 24 tuổi</option>
                                                    <option value="25 - 29 tuổi" {{$job->age == '25 - 29 tuổi' ? 'selected' : ''}}>25 - 29 tuổi</option>
                                                    <option value="30 - 34 tuổi" {{$job->age == '30 - 34 tuổi' ? 'selected' : ''}}>30 - 34 tuổi</option>
                                                    <option value="35 - 39 tuổi" {{$job->age == '35 - 39 tuổi' ? 'selected' : ''}}>35 - 39 tuổi</option>
                                                    <option value="40 - 44 tuổi" {{$job->age == '40 - 44 tuổi' ? 'selected' : ''}}>40 - 44 tuổi</option>
                                                    <option value="Trên 45 tuổi" {{$job->age == 'Trên 45 tuổi' ? 'selected' : ''}}>Trên 45 tuổi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Mô tả công việc <span>*</span></label>
                                            <div class="col-sm-9">
                                                <textarea class="w100 form-control" name="description" rows="5">
                                                    {{ $job->description }}
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Nội dung tin tuyển dụng<span>*</span> </label>
                                            <div class="col-sm-9">
                                                <textarea class="editor w100" id='content1' name="content" class="form-control" id="" rows="5">
                                                    {!! $job->content !!}
                                                </textarea>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label class="col-sm-3 lable">Yêu cầu khác </label>
                                            <div class="col-sm-9">
                                                <textarea name="" class="form-control" id="" rows="5"></textarea>
                                            </div>
                                        </div> -->

                                        <div class="form-group row datetime" >
                                            <label class="col-sm-3 lable">Hạn nộp hồ sơ<span>*</span> </label>
                                            <div class="col-sm-3">
                                                <input id='alltime' class="form-control" type="date" value="{{$job->deadline_submit_profile}}" name='deadline_submit_profile'>
                                            </div>

                                        </div>
                                        <!-- <p class="text-title mt10">
                                            Thông tin liên hệ
                                        </p>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Tên Người liên hệ <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Tên người liên hệ">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Địa chỉ liên hệ <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="địa chỉ liên hệ">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Số điện thoại liên hệ <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Số điện thoại liên hệ">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 lable">Email liên hệ <span>*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="Email liên hệ">
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 lable"></label>
                                            <div class="col-sm-9">
                                                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                    CẬP NHẬT TIN
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="form-group error">
                                        @if ($errors->has('title'))
                                            <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                        @endif
                                        @if ($errors->has('position'))
                                            <label for="exampleInputEmail1">{{ $errors->first('position') }}</label>
                                        @endif
                                        @if ($errors->has('address'))
                                            <label for="exampleInputEmail1">{{ $errors->first('address') }}</label>
                                        @endif
                                        @if ($errors->has('number_recruited'))
                                            <label for="exampleInputEmail1">{{ $errors->first('number_recruited') }}</label>
                                        @endif
                                        @if ($errors->has('description'))
                                            <label for="exampleInputEmail1">{{ $errors->first('description') }}</label>
                                        @endif
                                        @if ($errors->has('content'))
                                            <label for="exampleInputEmail1">{{ $errors->first('content') }}</label>
                                        @endif
                                        @if ($errors->has('deadline_submit_profile'))
                                            <label for="exampleInputEmail1">{{ $errors->first('deadline_submit_profile') }}</label>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
    @if (Session::has('sucsses'))
        <script>
            alert ('{!! Session::get('sucsses') !!}')
        </script>
    @endif
    <script>
        $(".jobGroup").select2({
            placeholder: "Chọn ngành nghề việc làm",
            allowClear: true,
            tokenSeparators: [',','']
        });

        $(".jobGroups").select2({
            placeholder: "Hình thức làm việc",
            allowClear: true,
            tokenSeparators: [',','']
        })
    </script>

@endsection
