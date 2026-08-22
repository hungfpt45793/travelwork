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
                    <section class="content contentMain">
                        <div class="clearfix"></div>
                        <form role="form" action="{{ route('copyExam') }}" method="POST">
                            {!! csrf_field() !!}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-lg-8 col-md-8 pd CategoryLeft" >
                                    <div class="">
                                        <!-- /.box-header -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Copy từ đề thi <span class="btn btnGreen btn-small f16" style="padding: 3px 10px;">{{ $exam['code_exam'] }}</span></div>
                                            <div class="panel-body">


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
                                              cols="80"/>@if(!empty($exam['content_exam']))
                                                    {!! isset($information['quy-che-thi']) ?  $information['quy-che-thi'] : '' !!}
                                                    @else
                                                    {!! $exam['content_exam'] !!}
                                                    @endif
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

                                            <div class="form-group">
                                                <label for="inputEmail3" class=" control-label">Hình ảnh<span class="clred">(*)</span></label>
                                                <div class="">

                                                    <div id="uploadImage" style="display: inline-block">

                                                        <img src="{{  $exam['image_exam'] }}" class="thumbnail" style="width: 70px">
                                                        <input type="hidden" value="{{  $exam['image_exam'] }}" name="images"  />
                                                    </div>

                                                    <div style="display: inline-block;align-items: center; "><button class="btn btn-default addAvatar" style="height: 40px;margin-left: 30px;">Ảnh mô tả</button></div>
                                                    <input type='file' id="imgInp" accept="image/*" onchange="readURL(this)" style="display: none" multiple/>
                                                    <script>
                                                        function readURL(input) {
                                                            $('#uploadImage').empty();
                                                            if (input.files && input.files[0]) {
                                                                for(var i = 0; i< input.files.length; i++)
                                                                {
                                                                    var file = input.files[i];
                                                                    var picReader = new FileReader();
                                                                    picReader.addEventListener("load",function(event){
                                                                        var picFile = event.target;
                                                                        $('#uploadImage').append("<img class='thumbnail' src='" + picFile.result + "'" +
                                                                            "title='" + picFile.name + "' width='70' style='float: left' />");
                                                                        $('#uploadImage').append('<input type="hidden" value="'+ picFile.result +'" name="images" />');
                                                                    });
                                                                    //Read the image
                                                                    picReader.readAsDataURL(file);
                                                                }
                                                            }
                                                        }
                                                        $('.addAvatar').click(function() {
                                                            $('#imgInp').click();
                                                            return false;
                                                        });
                                                    </script>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" name="id_exam" value="{{ $exam->id_exam }}">
                                                <button class="btnloadding btnGreen btnLage w100" type="submit"><i class="fa fa-clone mgRight5" aria-hidden="true" \></i>Lưu thay đổi</button>
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
                                                <i>Đề thi theo loại hình doanh nghiệp</i>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="panel panel-default">
                                        <div class="panel-heading">Đề thi theo loại hình doanh nghiệp</div>
                                        <div class="panel-body">
                                            <?php $exam_types = \App\Exam\ExamTypeBusiness::getAll() ;?>
                                            @foreach($exam_types as $exam_type)
                                                <label class="show groups-test cap2 dsBlock" id="groups_6">
                                                    <input type="radio" name="exam_type_id" class="flat-red"
                                                           value="{{ $exam_type->exam_type_id }}" @if($exam->exam_type_id ==$exam_type->exam_type_id) checked @endif>

                                                 
                                                    <strong class="pdLeft">{{ $exam_type->exam_type_name }}</strong>
                                                </label>

                                            @endforeach


                                        </div>

                                    </div>

                                    @if ($errors->has('exam_local_job_id'))
                                        <div class="form-group">
                                            <div class="alert alert-danger">
                                                <i>Đề thi theo vị trí công việc</i>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="panel panel-default">
                                        <div class="panel-heading">Đề thi theo vị trí công việc</div>
                                        <div class="panel-body">
                                            <?php $exam_locals = \App\Exam\ExamLocalJob::getAll() ;?>
                                            @foreach($exam_locals as $exam_local)
                                                <label class="show groups-test cap2 dsBlock" id="groups_6">
                                                    <input type="radio" name="exam_local_job_id" class="flat-red"
                                                           value="{{ $exam_local->exam_local_job_id }}" @if($exam->exam_local_job_id == $exam_local->exam_local_job_id) checked @endif>

                                                    <strong class="pdLeft">{{ $exam_local->exam_local_job }}</strong>
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




