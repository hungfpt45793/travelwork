@extends('site.layout.site')

@section('title', 'Sửa khóa học')
@section('meta_description', 'Sửa khóa học')
@section('keywords', 'Sửa khóa học')

@section('content')
    <script src="{{ asset('adminstration/jquery.priceformat.js') }}"></script>
    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">

                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="arror bgrWhite radius5 pd5 bdLightGray textCenter">
                                        <p class="mg0 fw6 red">Để đảm bảo khóa học hợp lệ, Quý khách vui lòng nhập đầy đủ thông tin </p>
                                    </div>
                                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5">
                                        <a href="{{ route('course.index') }}" class="btnOrange mgb15 d-sm-inline-block">Danh sách khóa học</a>
                                        <div class="title">
                                            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                sửa KHÓA HỌC
                                            </h5>
                                        </div>

                                        <div class="content">

                                            @if(!empty($errors->all()))
                                                @foreach($errors->all() as $erorr)
                                                    <span style="background-color: red;display: inline-block;color: #fff;padding: 3px 5px;margin:3px 5px;">{{ $erorr }}</span>
                                                @endforeach
                                            @endif

                                            <form role="form" action="{{ route('course.update',['course_id' => $cours->course_id]) }}" method="POST" class="">
                                                {!! csrf_field() !!}
                                                {{ method_field('PUT') }}
                                                <div class="form-group mgt15">
                                                    <label for="exampleInputEmail1">Tên Khóa học</label>
                                                    <input type="text" class="form-control" name="course_name" placeholder="Tên khóa học" value="{{ $cours->course_name}} " >
                                                </div>
                                                <div class="form-group mgt15">
                                                    <label for="exampleInputEmail1">Thời gian khóa học</label>
                                                    <input type="text" class="form-control" name="course_time" placeholder="Thời gian khóa học" value="{{ $cours->course_time }}" >
                                                </div>

                                                <div class="form-group Giá khóa học">
                                                    <label for="exampleInputEmail1">Giá khóa học ( đ )</label>
                                                    <input type="text" class="form-control formatPrice" name="course_price" placeholder="0" min="1" value="{{ $cours->course_price }}" >
                                                </div>
                                                <script>
                                                    $('.formatPrice').priceFormat({
                                                        prefix: '',
                                                        centsLimit: 0,
                                                        thousandsSeparator: '.'
                                                    });
                                                </script>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class=" control-label">Hình ảnh<span class="clred">(*)</span></label>
                                                    <div class="">

                                                        <div id="uploadImage" style="display: inline-block">

                                                            <img data-src="{{ $cours->course_image }}" class="thumbnail lazy" style="width: 70px">
                                                            <input type="hidden" value="{{ $cours->course_image }}" name="images"  />
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
                                                                            $('#uploadImage').append("<img class='lazy thumbnail' src='" + picFile.result + "'" +
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
                                                    <label for="exampleInputEmail1">Giới thiệu khóa học</label>

                                                    <textarea name="course_intro" class="w-100" id="" rows="5" cols="80">{{ $cours->course_intro }}</textarea>

                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mô tả khóa học</label>
                                                    <textarea name="course_content" class="editor" id="editor1" rows="10" cols="80">{!!  $cours->course_content !!}</textarea>
                                                    {{--<textarea id="txtNote" name="content" rows="6" class="textarea col-12 bdLightGray radius5"></textarea>--}}
                                                </div>


                                                <div class="form-group">
                                                    <!-- Google reCaptcha -->
                                                    <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ '6Le9trIUAAAAALrCbKEVd_fFCOjZm13bNMk9DmZP'  }}"></div>
                                                    <!-- End Google reCaptcha -->
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btnOrange">Lưu thay đổi </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')
                    @include('site.module_index.hotline')
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>



@endsection