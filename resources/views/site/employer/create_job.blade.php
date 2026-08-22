@extends('site.layout.site')

@section('title','Thêm mới tin tuyển dụng')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<section class="content">
   <div class="container">
   <div class="row ">
   
    <div class="col-xl-12 col-lg-12 col-md-12 JobSeeker">
        <div class="main">
            <div class="notificationBox mb30">
                <p class="text-title">
                    Đăng tin tuyển dụng
                </p>
                <hr>
                <div class="bodyBox">
                    <div class="accountInfo">
                        <form action="{{route('create_job')}}" method="post">
                            {!! csrf_field() !!}
                            {{method_field('POST')}}
                            <div class="form-group row">
                                <label class="col-sm-3 lable">Tên công việc <span>*</span> </label>
                                <div class="col-sm-9">
                                    <input type="text" name='title' class="form-control" placeholder="Tên công việc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Vị trí tuyển dụng
                                    <span>*</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" name='position' class="form-control" placeholder="Vị trí tuyển dụng ">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Địa điểm làm việc
                                    <span>*</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" name='address' class="form-control" placeholder="Địa điểm làm việc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Hình thức làm việc
                                    <span>*</span>
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-control jobGroup" name='job_group[]' multiple="true">
                                        @foreach (\App\Entity\JobGroup::ShowJobGroup() as $jobGroup)
                                            <option value="{{$jobGroup->job_group_id}}">{{$jobGroup->job_group_name}}</option>
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
                                            <option value="{{$carrer->career_category_id}}">{{$carrer->career_category_name}}</option>
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
                                            <option value="{{$salary->salary_id}}">{{number_format($salary->salary_from)}} VNĐ - {{number_format($salary->salary_to) }} VNĐ</option>
                                        @endforeach   
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Số lượng cần tuyển
                                    <span>*</span> </label>
                                <div class="col-sm-9">
                                    <input type="number" name="number_recruited" class="form-control" placeholder="Số lượng nhân viên cần tuyển">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Kinh nghiệm <span>*</span>
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='experience'>
                                        <option value="Không yêu cầu">Không yêu cầu</option>
                                        <option value="Dưới 1 năm">Dưới 1 năm</option>
                                        <option value="1 năm">1 năm</option>
                                        <option value="2 năm">2 năm</option>
                                        <option value="3 năm">3 năm</option>
                                        <option value="4 năm">4 năm</option>
                                        <option value="5 năm">5 năm</option>
                                        <option value="Hơn 5 năm">Hơn 5 năm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Yêu cầu bằng cấp
                                    <span>*</span> </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='literacy'>
                                        @foreach (\App\Entity\Literacy::showAllLiteracies() as $literacy)
                                            <option value="{{$literacy->literacy_id}}">{{$literacy->literacy_name}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Giới tính
                                    <span>*</span> </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='gender'>
                                        <option value="0">Không yêu cầu</option>
                                        <option value="1">Nữ</option>
                                        <option value="2">Nam</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 lable">Độ tuổi
                                    <span>*</span> </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='age'>
                                        <option value="Không yêu cầu">Không yêu cầu</option>
                                        <option value="15 - 24 tuổi">15 - 24 tuổi</option>
                                        <option value="25 - 29 tuổi">25 - 29 tuổi</option>
                                        <option value="30 - 34 tuổi">30 - 34 tuổi</option>
                                        <option value="35 - 39 tuổi">35 - 39 tuổi</option>
                                        <option value="40 - 44 tuổi">40 - 44 tuổi</option>
                                        <option value="Trên 45 tuổi">Trên 45 tuổi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 lable">Mô tả công việc <span>*</span> </label>
                                <div class="col-sm-9">
                                    <textarea class="w100 form-control" name="description" id="" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 lable">Nội dung tin tuyển dụng<span>*</span> </label>
                                <div class="col-sm-9">
                                <textarea class="editor w100" id='content1' name="content" class="form-control" id="" rows="5"></textarea>
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
                                    <!-- <div class="col-sm-3">
                                       <select class="form-control date" id="day" >
                                          <option>Ngày</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                          <option value="6">6</option>
                                          <option value="7">7</option>
                                          <option value="8">8</option>
                                          <option value="9">9</option>
                                          <option value="10">10</option>
                                          <option value="11">11</option>
                                          <option value="12">12</option>
                                          <option value="13">13</option>
                                          <option value="14">14</option>
                                          <option value="15">15</option>
                                          <option value="16">16</option>
                                          <option value="17">17</option>
                                          <option value="18">18</option>
                                          <option value="19">19</option>
                                          <option value="20">20</option>
                                          <option value="21">21</option>
                                          <option value="22">22</option>
                                          <option value="23">23</option>
                                          <option value="24">24</option>
                                          <option value="25">15</option>
                                          <option value="26">26</option>
                                          <option value="27">27</option>
                                          <option value="28">28</option>
                                          <option value="29">29</option>
                                          <option value="30">30</option>
                                          <option value="31">31</option>
                                         
                                       </select>
                                    </div>
                                    <div class="col-sm-3">
                                       <select class="form-control month"  id="month">
                                          <option>Tháng</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                          <option value="6">6</option>
                                          <option value="7">7</option>
                                          <option value="8">8</option>
                                          <option value="9">9</option>
                                          <option value="10">10</option>
                                          <option value="11">11</option>
                                          <option value="12">12</option>
                                       </select>
                                    </div>
                                    <div class="col-sm-3">
                                       <select class="form-control" id="year">
                                          <option>Năm</option>
                                          <option value="2019">2019</option>
                                          <option value="2020">2020</option>
                                          <option value="2021">2021</option>
                                          <option value="2022">2022</option>
                                          <option value="2023">2023</option>
                                          <option value="2024">2024</option>
                                          <option value="2025">2025</option>
                                          <option value="2026">2026</option>
                                          <option value="2027">2028</option>
                                          <option value="2029">2029</option>
                                          <option value="2030">2030</option>
                                          <option value="2031">2031</option>
                                       </select>
                                    </div> -->
                                    <div class="col-sm-3">
                                        <input id='alltime' class="form-control" type="date" value="" name='deadline_submit_profile' >
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
                                        ĐĂNG TIN
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
        placeholder: "Select a state",
        allowClear: true,
        tokenSeparators: [',','']
     })
</script>

@endsection
