@extends('admin.layout.admin')

@section('title', 'Thêm mới danh mục bài viết')

@section('content')

    <section class="content-header">
        <h1>
            Thêm nhóm đề thi

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--  <li><a href="#"></a></li> -->
            <li class="active">Thêm nhóm đề thi</li>
        </ol>
    </section>
    <form role="form" action="{{ route('categories-exam.store') }}" method="POST">
        {!! csrf_field() !!}
        {{ method_field('POST') }}
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="">

                        <!-- /.box-header -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Thông tin nhóm đề thi</div>
                            <div class="panel-body">
                                @if ($errors->has('code_cate_exam'))
                                    <div class="form-group">
                                        <div class="alert alert-danger">
                                            <i>Mã nhóm đề thi đã tồn tại !</i>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Danh mục cha</label>
                                    <select class="form-control" name="parent_cate_exam">
                                        <option value="0">Danh mục cha</option>
                                        @foreach($categories_exam as $cate_exam)
                                            <option value="{{ $cate_exam->id_cate_exam }}" {{ old('parent_cate_exam') == $cate_exam['id_cate_exam'] ? 'selected' : ''  }}>  {{ $cate_exam->name_cate_exam }}</option>


                                            @foreach(\App\Exam\CategoriesExam::getChilren($cate_exam->id_cate_exam) as $child)
                                                <option value="{{ $child['id_cate_exam']}}" {{ old('parent_cate_exam') == $child['id_cate_exam'] ? 'selected' : ''  }}>
                                                    -- {{ $child['name_cate_exam'] }}</option>

                                                @foreach(\App\Exam\CategoriesExam::getChilren($child->id_cate_exam) as $child2)
                                                    <option value="{{ $child2['id_cate_exam']}}" {{ old('parent_cate_exam') == $child2['id_cate_exam'] ? 'selected' : ''  }}>
                                                        --- {{ $child2['name_cate_exam'] }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Mã nhóm đề thi <span
                                                class="red">(*)</span></label>

                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3" name="code_cate_exam"
                                               placeholder="Mã nhóm" required value="{{ old('code_cate_exam') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Tên nhóm đề thi<span
                                                class="red">(*)</span></label>

                                    <div class="">
                                        <input type="text" class="form-control" id="inputEmail3" name="name_cate_exam"
                                               placeholder="Tên nhóm" required value="{{ old('name_cate_exam') }}">
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class=" control-label">Slug nhóm đề thi</label>

                                        <div class="">
                                            <input type="text" class="form-control" id="inputEmail3" name="slug_cate_exam"
                                                   placeholder="Slug nhóm đề thi" value="{{ old('slug_cate_exam') }}">
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Giới thiệu
                                    </label>

                                    <div class="">
                                        <textarea class="w100 pd010" name="into_cate_exam" rows="4"
                                                  cols="80"/>{{ old('into_cate_exam') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class=" control-label">Nội dung
                                    </label>

                                    <div class="">
                                        <textarea class="editor content" id="properties" name="content_cate_exam"
                                                  rows="10" cols="80"/> {{ old('content_cate_exam') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="inputEmail3" class=" control-label">Hình ảnh<span class="red">(*)</span></label>

                                    <div class="">
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{  old('image_cate_exam') }}" width="80" height="70"/>
                                        <input name="image_cate_exam" type="hidden"
                                               value="{{  old('image_cate_exam') }}"/>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class=" control-label">Icon<span
                                                    class="red">(*)</span></label>

                                        <div class="">
                                            <input type="text" class="form-control" id="inputEmail3" name="icon"
                                                   placeholder="chọn icon" required value="{{ old('icon') }}">
                                        </div>
                                    </div>


                                <div class="button_fixed_bottom text-center">

                                    <input type="hidden" name="submit" value="1">
                                    <input class="btn btn-primary submit-post" name="status1" type="submit"
                                           value="Thêm nhóm đề thi">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection