@extends('admin.layout.admin')
@section('title', 'Sửa đề thi')
@section('content')

    <section class="content-header">
        <h1>
            Sửa đề thi
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--  <li><a href="#"></a></li> -->
            <li class="active">Sửa đề thi</li>
        </ol>
        <div style="margin:10px 0 ">
            <a href="{{ route('exam.index') }}">
                <button class="btn btn-primary">Danh sách đề thi</button>
            </a>
            <a href="#TabQuestion">
                <button class="btn btn-primary">Danh sách câu hỏi</button>
            </a>
            @if (session('suscees'))
                <div class="infoAlert">
                    <div class="alert alert-success">
                        <span>Bạn đã cập nhật đề thi thành công ! Bạn có thể tạo câu hỏi cho đê thi này !</span>
                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x</button>
                    </div>
                </div>
            @endif

            @if (session('suscees_edit'))
                <?php
                $name_ques = session('suscees_edit')
                ?>
                <div class="alert alert-success alert-dismissible alertQuesion">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h4><i class="icon fa fa-check"></i> <a href="#">Bạn đã sửa câu hỏi thành công !</a> <span class="AlertAdd">  {!!  isset($name_ques) ? $name_ques : ''  !!}  </span></h4>
                </div>
            @endif
            @if (session('suscees_desrtroy'))
                <?php
                     $name_ques = session('suscees_desrtroy');
                ?>
                    <div class="alert alert-success alert-dismissible alertQuesion">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <h4><i class="icon fa fa-check"></i> <a href="#">Bạn đã xóa câu hỏi thành công !</a> <span class="AlertAdd">  {!!  isset($name_ques) ? $name_ques : ''  !!}  </span></h4>
                    </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible alertQuesion">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h4><a href="" style="color:#fff;">Trường có dấu (*) không được để trống</a>
                    </h4>
                </div>
            @endif

        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Đề thi</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show/hidden">
                            <i class="fa fa-minus"></i></button>
                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
                        {{--<i class="fa fa-times"></i></button>--}}
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="{{ route('exam.update', ['id_cate_exam' => $e_xam->id_exam]) }}" method="POST">
                        {{--
                        <form role="form" action="{{ route('categories.update', ['category_id' => $categoriesExam->id_cate_exam]) }}" method="POST">--}} {!! csrf_field() !!} {{ method_field('PUT') }}

                        <div class="col-xs-8">
                            <div class="">

                                <!-- /.box-header -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">Đề thi</div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label for="inputEmail3" class=" control-label">Mã đề thi <span
                                                        class="red">(*)</span></label>

                                            <div class="">
                                                <input type="text" class="form-control" id="inputEmail3" placeholder="Mã đề thi"
                                                       name="code_exam" required value="{{ $e_xam['code_exam'] }}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class=" control-label">Tên đề thi <span
                                                        class="red">(*)</span></label>

                                            <div class="">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Tên đề thi" name="name_exam" required
                                                       value="{{ $e_xam['name_exam'] }}">
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
                                            <label for="inputEmail3" class=" control-label">Slug đề thi <span
                                                        class="red">(*)</span></label>

                                            <div class="">
                                                <input type="text" class="form-control" id="inputEmail3"
                                                       placeholder="Slug đề thi" name="slug_exam"
                                                       value="{{ $e_xam['slug_exam'] }}">
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <label for="inputEmail3" class=" control-label">Hình ảnh<span class="red">(*)</span></label>

                                            <div class="">
                                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                       size="20"/>
                                                <img src="{{ asset($e_xam['image_exam']) }}" width="80" height="70"/>
                                                <input name="image_exam" type="hidden" value="{{  $e_xam['image_exam'] }}"/>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label for="inputEmail3" class=" control-label">Giới thiệu<span--}}
                                        {{--class="red">(*)</span></label>--}}

                                        {{--<div class="">--}}
                                        {{--<textarea class="w100 form-control" id="" name="intro_exam" rows="5"--}}
                                        {{--cols="100"/>{{ $e_xam['intro_exam'] }}</textarea>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="form-group">
                                            <label for="inputEmail3" class=" control-label">Mô tả ngắn gọn đề thi<span
                                                        class="red">(*)</span></label>
                                            <div class="">
                                    <textarea class="w100" id="" name="intro_exam" rows="3"
                                              cols="80" style="padding: 10px;"/>{{ $e_xam['intro_exam'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class=" control-label">Quy chế thi<span
                                                        class="red">(*)</span></label>

                                            <div class="">

                                    <textarea class="editor" id="properties" name="content_exam" rows="10"
                                              cols="80"/>{!! $e_xam['content_exam'] !!}</textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Cấu hình đề thi</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="inputEmail3" class=" control-label">Thời gian làm bài tính bằng phút
                                                <span class="red">(*)</span></label>
                                            <div class="">
                                                <input type="number" class="form-control " id="inputEmail3"
                                                       placeholder="Thời gian làm bài" required="required" name="time_exam"
                                                       pattern="[0-9]" title="Vui lòng nhập số phút"
                                                       value="{{  $e_xam['time_exam'] }}"
                                                       style="width: 100px;display: inline-block">
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
                                            <label for="inputEmail3" class=" control-label">Xếp loại đề bài <span class="red">(*)</span></label>
                                            <div class="">
                                                <select class="form-control select2" name="level_exam" style="width: 100%;">
                                                    <option value="0" {{ ($e_xam['level_exam']==0 ) ? 'selected="selected"' : '' }}>
                                                        Dễ
                                                    </option>
                                                    <option value="1" {{ ($e_xam['level_exam']==1 ) ? 'selected="selected"' : '' }}>
                                                        Khó
                                                    </option>
                                                    <option value="2" {{ ($e_xam['level_exam']==2 ) ? 'selected="selected"' : '' }}>
                                                        Nâng cao
                                                    </option>

                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label style="margin-right: 40px">
                                                <input type="radio" name="status_exam" value="0" class="flat-red" @if($e_xam['status_exam'] == 0) checked @endif>
                                                Không thi thử
                                            </label>

                                            <label>
                                                <input type="radio" name="status_exam" value="1" class="flat-red" @if($e_xam['status_exam'] == 1) checked @endif>
                                                Thi thử
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label style="margin-right: 40px">
                                                <input type="radio" name="bank_exam" value="1" class="flat-red" @if($e_xam['bank_exam'] == 1) checked @endif >
                                                Đề thi thuộc ngân hàng đề thi
                                            </label>

                                            <label>
                                                <input type="radio" name="bank_exam" value="0" class="flat-red" @if($e_xam['bank_exam'] == 0) checked @endif>
                                                Đề thi không thuộc ngân hàng đề thi
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <button class=" btn btn-primary pull-left mgRight5 w100">Lưu đề thi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->

                            <!-- /.box -->
                        </div>
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
                                                       value="{{$typeBusiness->type_of_business_id}}" @if($e_xam['exam_type_id'] == $typeBusiness->type_of_business_id) checked @endif>

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
                                                       value="{{$career->career_category_id}}" @if($e_xam['exam_local_job_id'] == $career->career_category_id) checked @endif>
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
                <!-- /.box-body -->

                <!-- /.box-footer-->
            </div>


        </div>

        <!-- phan tạo cau hoi -->








    </section>
    <script>
        $(document).ready(function() {
            $('#valiadateForm').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name_ques: {
                        validators: {
                            notEmpty: {
                                message: 'Câu hỏi không được để trống'
                            }
                        }
                    },
                    answer1: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập đáp án'
                            }

                        }
                    },
                    answer2: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập đáp án'
                            }

                        }
                    },
                }
            });
        });
    </script>



    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection