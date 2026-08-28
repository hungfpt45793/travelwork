@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Sửa đề thi')
@section('meta_description',  'mô tả để thi')


@section('content')
    @include('site.exam_admin_site.include-CSS-JS')
    <section class="main bgUser">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 RightLink">


                    <div class="mgTB15">

                    </div>
                    <div class="mgTB15">
                        <a href="{{ route('getAllQuestionsZero' ,['id_exam' => $exam->id_exam]) }}" class="btnLage btnloadding btnGreen" target="_blank"> <i class="fa fa-list" aria-hidden="true"></i> Danh sách câu hỏi <i class="fa fa-question" aria-hidden="true"></i></a>
                    </div>
                    @if(session('suscees'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $value = session('suscees') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $value = session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row hiddenShowSidebar">
                <div class="col-lg-12 col-md-12 categoryQuestion userRight">
                        <div class="row">
                            <div class="col-lg-12" style="padding: 0">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="clHome"  href="{{ route('showExam') }}">Đề thi</a></li>
                                        {{--<li class="breadcrumb-item"><a href="#">Library</a></li>--}}
                                        <li class="breadcrumb-item active" aria-current="page">Sửa đề thi</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    <section class="content contentMain">
                        <div class="clearfix"></div>

                         <form role="form" action="{{ route('site_exam.update', ['site_exam' => $exam->id_exam]) }}" method="POST">
                             {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-lg-8 col-md-8 pd CategoryLeft" >
                                    <div class="">
                                        <!-- /.box-header -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Thông tin đề thi</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Mã đề thi <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <input type="text" class="form-control" id="inputEmail3" placeholder="Mã đề thi"
                                                               name="code_exam" required value="{{ $exam['code_exam'] }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Tên đề thi <span
                                                                class="clred">(*)</span></label>
                                                    <div class="">
                                                        <input type="text" class="form-control" id="inputEmail3"
                                                               placeholder="Tên đề thi" name="name_exam"
                                                               required  value="{{ $exam['name_exam'] }}">
                                                    </div>
                                                    @if ($errors->has('name_exam'))
                                                        <div class="form-group">
                                                            <div class="alert alert-danger">
                                                                <i>Tên đề thi không được để trống !</i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class=" control-label">Mô tả ngắn gọn đề thi <span
                                                            class="clred">(*)</span></label>
                                                <div class="">
                                    <textarea class="w100" id="" name="intro_exam" rows="3"
                                              cols="80" style="padding: 10px;"/>{{ $exam['intro_exam'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class=" control-label">Quy chế thi <span
                                                            class="clred">(*)</span></label>

                                                <div class="">

                                    <textarea class="editor" id="properties" name="content_exam" rows="10"
                                              cols="80"/>
                                                        {!! $exam['content_exam'] !!}
                                                    </textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Cấu hình đề thi</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="inputEmail3" class=" control-label">Thời gian làm bài tính bằng phút <span
                                                            class="clred">(*)</span></label>
                                                <div class="">
                                                    <input type="number" class="form-control " id="inputEmail3"
                                                           placeholder="Thời gian làm bài" required="required" name="time_exam"
                                                           pattern="[0-9]" title="Vui lòng nhập số phút"
                                                           value="{{ $exam['time_exam'] }}" style="width: 200px;display: inline-block">
                                                    <span>(phút)</span>

                                                </div>
                                            </div>
                                            @if ($errors->has('time_exam'))
                                                <div class="form-group">
                                                    <div class="alert alert-danger">
                                                        <i>Thời gian không được để trống và lớn hơn 1</i>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="inputEmail3" class=" control-label">Xếp loại đề bài <span
                                                            class="red">(*)</span></label>
                                                <div class="">
                                                    <select class="custom-select" id="inputGroupSelect03" name="level_exam">
                                                        <option value="0" {{ ($exam['level_exam'] == 0) ? 'selected' : '' }}>Dễ</option>
                                                        <option value="1" {{ ($exam['level_exam'] == 1) ? 'selected' : '' }}>Khó</option>
                                                        <option value="2" {{ ($exam['level_exam'] == 2) ? 'selected' : '' }}>Nâng cao</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{--<div class="form-group">--}}
                                                {{--<label style="margin-right: 40px">--}}
                                                    {{--<input type="radio" name="status_exam" value="0" class="flat-red"  {{ ($exam['status_exam'] == 0) ? 'checked' : '' }}>--}}
                                                    {{--Công khai(publicity)--}}
                                                {{--</label>--}}
                                                {{--<label>--}}
                                                    {{--<input type="radio" name="status_exam" value="1" class="flat-red"--}}
                                                           {{--{{ ($exam['status_exam'] == 1) ? 'checked' : '' }}>--}}
                                                    {{--Riêng tư (private)--}}
                                                {{--</label>--}}
                                            {{--</div>--}}

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hình ảnh</label><br>
                                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                       size="20"/>
                                                <img src="{{ $exam['image_exam'] }}" width="80" height=""/>
                                                <input name="images" type="hidden" value="{{ $exam['image_exam'] }}"/>
                                            </div>



                                            <div class="form-group">
                                                <button class="btnloadding btnGreen btnLage w100"><i class="fa fa-pencil-square-o mgRight5" aria-hidden="true"></i> Lưu thay đổi</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!-- /.box -->
                                <!-- /.box -->
                                <div class="col-lg-4 col-md-4 CategoriesExam">


                                    @if ($errors->has('exam_type_id'))
                                        <div class="form-group">
                                            <div class="alert alert-danger">
                                                <i>Loại hình doanh nghiệp</i>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="panel panel-default">
                                        <div class="panel-heading">Loại hình doanh nghiệp</div>
                                        <div class="panel-body">
                                            {{--TypeOfBusiness--}}
                                            <?php $typeBusinessList = \App\Entity\TypeOfBusiness::getAllTypeBusiness(); ?>
                                            @foreach($typeBusinessList as $typeBusiness)
                                                <label class="show groups-test cap2 dsBlock" id="groups_6">
                                                    <input type="radio" name="exam_type_id" class="flat-red"
                                                           value="{{$typeBusiness->type_of_business_id }}" @if($exam['exam_type_id'] == $typeBusiness->type_of_business_id) checked @endif>

                                                    {{--@elseif(count(\App\Exam\CategoriesExam::getChilren($child->id_cate_exam)) > 0)--}}
                                                    {{--<input type="checkbox" name="categories[]" class="flat-red"--}}
                                                    {{--value="{{ $child->id_cate_exam }}">--}}

                                                    <strong class="pdLeft"> {{$typeBusiness->type_of_business_name}}</strong>
                                                </label>

                                            @endforeach


                                        </div>

                                    </div>

                                    @if ($errors->has('exam_local_job_id'))
                                        <div class="form-group">
                                            <div class="alert alert-danger">
                                                <i>Loại hình kinh doanh</i>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="panel panel-default">
                                        <div class="panel-heading">Vị trí công việc</div>
                                        <div class="panel-body">
                                            {{--career--}}
                                            <?php $careerList = \App\Entity\Career::getAllCareer() ;?>
                                            @foreach($careerList as $career)
                                                <label class="show groups-test cap2 dsBlock" id="groups_6">
                                                    <input type="radio" name="exam_local_job_id" class="flat-red"
                                                           value="{{$career->career_category_id}}" @if($exam['exam_local_job_id'] == $career->career_category_id) checked @endif>

                                                    {{--@elseif(count(\App\Exam\CategoriesExam::getChilren($child->id_cate_exam)) > 0)--}}
                                                    {{--<input type="checkbox" name="categories[]" class="flat-red"--}}
                                                    {{--value="{{ $child->id_cate_exam }}">--}}

                                                    <strong class="pdLeft">{{$career->career_category_name}}</strong>
                                                </label>

                                            @endforeach


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- phan tạo cau hoi -->
                    </section>
                </div>
            </div>
        </div>
    </section>





    @include('site.exam_admin_site.delete')
@endsection



