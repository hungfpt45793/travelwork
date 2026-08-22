@extends('admin.layout.admin')

@section('title', '  Cấu hình note cv')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cấu hình note cv
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt</a></li>
            <li class="active">Thêm mới CV</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->


            <form role="form" action="{{ route('update_note_cv') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin</h3>
                        </div>

                        <div class="box-body">
                            @if (session('success'))
                                <div class="infoAlert">
                                    <div class="alert alert-success">
                                        <span>{{ session('success') }}</span>
                                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="infoAlert">
                                    <div class="alert alert-warning">
                                        <span>{{ session('error') }}</span>
                                        <button type="button" class="close iconAlert" data-dismiss="alert" aria-label="Close">x
                                        </button>
                                    </div>
                                </div>
                            @endif


                            <input type="hidden" name="cv_template_id" value="{{ $cv_employee->cv_template_id }}">
                            <input type="hidden" name="cv_note_id" value="{{ $cv_note->cv_note_id }}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý phần <span
                                                style="font-weight: bold;text-transform: uppercase">Hướng dẫn chung</span></label>
                                    <textarea class="editor" id="note_guide" name="note_guide">{!! isset($cv_note->note_guide) ? $cv_note->note_guide : '' !!}</textarea>
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">thông tin cơ bản</span></label>
                                <textarea class="editor" id="note_cv_personal" name="note_cv_personal">{!! isset($cv_note->note_cv_personal) ? $cv_note->note_cv_personal : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">mục tiêu nghề nghiệp</span></label>
                                <textarea class="editor" id="note_cv_title_career_goals"
                                          name="note_cv_title_career_goals">{!! isset($cv_note->note_cv_title_career_goals) ? $cv_note->note_cv_title_career_goals : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">Giải thưởng</span></label>
                                <textarea class="editor" id="note_cv_title_prize"
                                          name="note_cv_title_prize">{!! isset($cv_note->note_cv_title_prize) ? $cv_note->note_cv_title_prize : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">Chứng chỉ</span></label>
                                <textarea class="editor" id="note_cv_title_card"
                                          name="note_cv_title_card">{!! isset($cv_note->note_cv_title_card) ? $cv_note->note_cv_title_card : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">sở thích</span></label>
                                <textarea class="editor" id="note_cv_title_interests"
                                          name="note_cv_title_interests">{!! isset($cv_note->note_cv_title_interests) ? $cv_note->note_cv_title_interests : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">người tham chiếu</span></label>
                                <textarea class="editor" id="note_title_reference_person"
                                          name="note_title_reference_person">{!! isset($cv_note->note_title_reference_person) ? $cv_note->note_title_reference_person : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">KỸ NĂNG</span></label>
                                <textarea class="editor" id="note_title_cv_skills"
                                          name="note_title_cv_skills">{!! isset($cv_note->note_title_cv_skills) ? $cv_note->note_title_cv_skills : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">trình độ học vấn</span></label>
                                <textarea class="editor" id="note_title_cv_specialize"
                                          name="note_title_cv_specialize">{!! isset($cv_note->note_title_cv_specialize) ? $cv_note->note_title_cv_specialize : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">kinh nghiệm làm việc</span></label>
                                <textarea class="editor" id="note_title_cv_experience"
                                          name="note_title_cv_experience">{!! isset($cv_note->note_title_cv_experience) ? $cv_note->note_title_cv_experience : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">hoạt động</span></label>
                                <textarea class="editor" id="note_title_cv_work"
                                          name="note_title_cv_work">{!! isset($cv_note->note_title_cv_work) ? $cv_note->note_title_cv_work : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">dự án tham gia</span></label>
                                <textarea class="editor" id="note_title_cv_project"
                                          name="note_title_cv_project">{!! isset($cv_note->note_title_cv_project) ? $cv_note->note_title_cv_project : '' !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lưu ý phần <span
                                            style="font-weight: bold;text-transform: uppercase">Thông tin thêm</span></label>
                                <textarea class="editor" id="note_cv_info"
                                          name="note_cv_info">{!! isset($cv_note->note_cv_info) ? $cv_note->note_cv_info : '' !!}</textarea>
                            </div>


                        </div>


                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>





@endsection