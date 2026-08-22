@extends('site.layout.site')
{{--@section('type_meta', 'website')--}}
@section('title', isset($room['name_room']) ? $room['name_room'] : 'Thông tin phòng thi')
@section('meta_description', isset( $room['des_room']) ? $room['des_room']  : 'Mô tả phòng thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', ''  )
@section('meta_url', !empty($room['id_exam']) ? route('getExamRoom',['id_room' => $room['id_room']]) : '' )
@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-12 categoryQuestion text-center">

                    <h2 class="clHome dsInline"></h2>
                    <p class="mgBottom0 f15">
                    </p>
                </div>
            </div>
            <div class="row mgTop15">
                <div class="col-lg-4 col-md-4 leftSidebar">
                    <div class="panelBox InfoExam_nav mgb15">

                        <?php $total_question = 0;
                        $total_question = \App\Exam\Questions_school::countQuestion($exam['id_exam']);
                        ?>
                        <p><strong>Đề thi số : </strong>{{ $exam['name_exam'] }}</p>
                        <p><strong>Thời gian thi : </strong><span> {{ $exam['time_exam'] }} phút </span></p>
                        <p><strong>Số câu hỏi : </strong><span>{{ $total_question }} câu</span></p>
                        <p><strong>Thông tin SV : </strong></p>
                        <ul class="infoStudent_ul">
                            <li>
                                Mã SV : <span>{{ $student_school->student_code }}</span>
                            </li>
                            <li>
                                Tên SV : <span>{{ $student_school->student_name }}</span>
                            </li>
                            <li>
                                Lớp hành chính : <span>{{ $student_school->class_primakey }}</span>
                            </li>
                            <li>
                                Lớp học phần : <span>{{ $student_school->class_section }}</span>
                            </li>
                            <li>
                                Email SV : <span>{{ $student_school->student_email }}</span>
                            </li>
                            <li>
                                Điện thoại SV : <span>{{ $student_school->student_phone }}</span>
                            </li>

                        </ul>
                        <button class="infoStudent_button" data-toggle="modal" data-target="#editInfo">Sửa thông tin
                        </button>


                    </div>

                    <div class="panelBox">
                        <a href="{{ route('getSchoolQuestionRoom',['id_room' => $room->id_room] ) }}"
                           class="star bgRed">Bắt đầu làm bài</a>

                    </div>

                </div>
                <div class="col-lg-8 col-md-8 guide">
                    <div class="panel panel-default mgb15 text-center infoRoom_div">

                        <div class="panel-heading bgHome text-center">Nội dung phòng thi</div>
                        <div class="panel-body" style="    border: 1px solid #ccc;"><h2></h2>
                            <p>
                                <strong>Mã phòng thi : {{ $room->code_room }}</strong>
                            </p>
                            <p>
                                <strong>Tên phòng thi : {{ $room->name_room }}</strong>
                            </p>
                            <p>
                                <strong>Mô tả phòng thi : {{ $room->des_room }}</strong>
                            </p>

                        </div>
                    </div>
                    <div class="panel panel-default text-center infoRoom_div">

                        <div class="panel-heading bgHome text-center">Quy chế thi</div>
                        <div class="panel-body" style="    border: 1px solid #ccc;"><h2></h2>
                            <div class="">{!! isset($room->exam_rules) ? $room->exam_rules : '' !!}</div>

                        </div>
                    </div>


                </div>

            </div>


        </div>
    </section>


    <div class="modal fade modal_update_info_student" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form role="form" action="{{ route('updateStudent') }}" method="POST" id=""
                  class="formQuestion">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa thông tin Sinh
                            Viên {{ $student_school->student_code }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Mã sinh viên:</label>
                            <input type="text" class="form-control" name="student_code" readonly
                                   value="{{ $student_school->student_code }}" onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                        </div>
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Tên sinh viên:</label>
                            <input type="text" class="form-control" name="student_name"
                                   value="{{ $student_school->student_name }}">
                        </div>
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Lớp hành chính:</label>
                            <input type="text" class="form-control" name="class_primakey"
                                   value="{{ $student_school->class_primakey }}" onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                        </div>
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Lớp học phần:</label>
                            <input type="text" class="form-control" name="class_section"
                                   value="{{ $student_school->class_section }}" onkeyup="
  var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);
">
                        </div>
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Email sinh viên:</label>
                            <input type="email" class="form-control" name="student_email"
                                   value="{{ $student_school->student_email }}">
                        </div>
                        <div class="form-group mgb0">
                            <label for="recipient-name" class="col-form-label">Số điện thoại:</label>
                            <input type="phone" class="form-control" name="student_phone"
                                   value="{{ $student_school->student_phone }}">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_room" value="{{ $room->id_room }}">
                        <button type="button" class="infoStudent_close" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="infoStudent_button">Lưu thông tin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

