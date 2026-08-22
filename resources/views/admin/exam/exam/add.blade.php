@extends('admin.layout.admin')
@section('title', 'Thêm mới danh mục bài viết')
@section('content')

    <section class="content-header">
        <h1>
            Thêm đề thi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--  <li><a href="#"></a></li> -->
            <li class="active">Thêm đề thi</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            @if(session('erorr'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="Thông báo" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Thông báo!</h4>
                   {{ session('erorr') }}
                </div>
            </div>

            @endif

            <form role="form" action="{{ route('exam.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-8">
                    <div class="">
                        <!-- /.box-header -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Đề thi</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Tên đề thi <span
                                                class="red">(*)</span></label>

                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3"
                                               placeholder="Tên đề thi" name="name_exam"
                                               required {{ old('name_exam') }}>
                                    </div>
                                    @if ($errors->has('name_exam'))
                                        <div class="form-group">
                                            <div class="alert alert-danger">
                                                <i>Tên đề thi không được để trống !</i>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Slug đề thi</label>

                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3"
                                               placeholder="Slug đề thi" name="slug_exam"
                                                {{ old('slug_exam') }}>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class=" control-label">Hình ảnh<span class="red">(*)</span></label>

                                    <div class="">
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{  old('image_exam') }}" width="80" height="70"/>
                                        <input name="image_exam" type="hidden" value="{{  old('image_exam') }}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Mô tả ngắn gọn đề thi<span
                                                class="red">(*)</span></label>
                                    <div class="">
                                    <textarea class="w100" id="" name="intro_exam" rows="3"
                                              cols="80" style="padding: 10px;"/></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Quy chế thi<span
                                                class="red">(*)</span></label>

                                    <div class="">

                                    <textarea class="editor" id="properties" name="content_exam" rows="10"
                                              cols="80"/>{!! isset($information['quy-che-thi']) ?  $information['quy-che-thi'] : '' !!}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Cấu hình đề thi</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail3" class=" control-label">Thời gian làm bài tính bằng phút <span
                                            class="red">(*)</span></label>
                                <div class="">
                                    <input type="number" class="form-control " id="inputEmail3"
                                           placeholder="Thời gian làm bài" required="required" name="time_exam"
                                           pattern="[0-9]" title="Vui lòng nhập số phút"
                                           value="{{  old('time_exam') }}" style="width: 100px;display: inline-block">
                                    <span>Phút</span>
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
                                    <select class="form-control select2" name="level_exam" style="width: 100%;">
                                        <option value="0" selected="selected">Dễ</option>
                                        <option value="1">Khó</option>
                                        <option value="2">Nâng cao</option>

                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label style="margin-right: 40px">
                                    <input type="radio" name="status_exam" value="0" class="flat-red" checked>
                                    Không thi thử
                                </label>

                                <label>
                                    <input type="radio" name="status_exam" value="1" class="flat-red">
                                    Thi thử
                                </label>
                            </div>

                            <div class="form-group">
                                <label style="margin-right: 40px">
                                    <input type="radio" name="bank_exam" value="1" class="flat-red" checked>
                                    Đề thi thuộc ngân hàng đề thi
                                </label>

                                <label>
                                    <input type="radio" name="bank_exam" value="0" class="flat-red">
                                    Đề thi không thuộc ngân hàng đề thi
                                </label>
                            </div>
                            <div class="form-group">
                                <button class=" btn btn-primary pull-left mgRight5 w100" type="submit">Lưu đề thi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->

                <!-- /.box -->


        <div class="col-xs-4 CategoriesExam">
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
                        <?php $typeBusinessList = \App\Entity\TypeOfBusiness::getAllTypeBusiness(); ?>
                        @foreach($typeBusinessList as $typeBusiness)
                            <label class="show groups-test cap2 dsBlock" id="groups_6">
                                <input type="radio" name="exam_type_id" class="flat-red"
                                       value="{{$typeBusiness->type_of_business_id}}">

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
                                <i>Vị trí công việc</i>
                            </div>
                        </div>
                    @endif

                <div class="panel panel-default">
                    <div class="panel-heading">Vị trí công việc</div>
                    <div class="panel-body">
                        <?php $careerList = \App\Entity\Career::getAllCareer() ;?>
                        @foreach($careerList as $career)
                            <label class="show groups-test cap2 dsBlock" id="groups_6">
                                <input type="radio" name="exam_local_job_id" class="flat-red"
                                       value="{{$career->career_category_id}}">

                                {{--@elseif(count(\App\Exam\CategoriesExam::getChilren($child->id_cate_exam)) > 0)--}}
                                {{--<input type="checkbox" name="categories[]" class="flat-red"--}}
                                {{--value="{{ $child->id_cate_exam }}">--}}

                                <strong class="pdLeft">{{$career->career_category_name}}</strong>
                            </label>

                        @endforeach


                    </div>

                </div>



        </div>
        <!-- /.col      </div>
<!-- /.row -->
        </form>
        </div>


        <!-- phan tạo cau hoi -->


    </section>

@endsection