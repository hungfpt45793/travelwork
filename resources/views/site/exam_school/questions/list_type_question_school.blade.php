@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Chuyển câu hỏi')
@section('meta_description',  'Chuyển câu hỏi')


@section('content')

    <section class="content bgrGray pdt5 UpdateUserTab">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>

                                    <li class="nav-item pd8">
                                        <?php
                                        $link_url = '#';
                                        $link_url = \App\Ultility\Ultility::getUrl();
                                        ?>
                                        <a href="{{ $link_url }}" class="f18 md-f14 blueDN hvBlueDN">Chuyển câu hỏi (
                                            @if($type_ques == 0)
                                                dễ
                                            @endif
                                            @if($type_ques == 1)
                                                trung bình
                                            @endif
                                            @if($type_ques == 2)
                                                khó
                                            @endif
                                            )</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <div class="CV bgrWhite radius5 pd20  mgb20 pdb5 pdt10">
                                        <div class="arror bgrWhite radius5 pd5 bdLightGray  mgb15 pd10 row">
                                            <div class="col-md-4">
                                                <p>Có tất cả {{ !empty($total_question) ? $total_question  : '0' }} câu hỏi (
                                                    @if($type_ques == 0)
                                                        dễ
                                                    @endif
                                                    @if($type_ques == 1)
                                                        trung bình
                                                    @endif
                                                    @if($type_ques == 2)
                                                        khó
                                                    @endif
                                                )</p>
                                                <p class="mgb5">
                                                    <a class="infoStudent_button">Chuyển câu hỏi</a>
                                                </p>
                                            </div>
                                            <div class="col-md-8">
                                                <?php
                                                $school_subject = \App\Exam\School_subject::getAll();
                                                $user = \Illuminate\Support\Facades\Auth::user();
                                                $teacher_school = \App\Entity\Teacher_schools::getTeacher_id($user->id);
                                                ?>
                                                @foreach($school_subject as $sub)
                                                    <?php
                                                    $count_total = 0;
                                                    $count_total  = \App\Exam\School_subject::getTotal($type_ques,$teacher_school->teacher_sc_id,$sub->sub_id);
                                                    ?>
                                                        @if($count_total > 0)
                                                    <p class="mgb5">
                                                        {{ $sub->sub_name }} <sup class="clred">({{ $count_total }} câu)</sup>
                                                    </p>
                                                        @endif
                                                @endforeach
                                            </div>

                                        </div>


                                        <div class="text-center col-lg-12 ">
                                            <form action="" method="GET" id="submitFormSearchRoom" class="mgTop20 " style="margin:  0 auto">
                                                {{ csrf_field() }}
                                                <div class="row mgBottom15 justify-content-md-center">
                                                    <div class="col-lg-6 borderSelect2">
                                                        <?php
                                                        $school_subject = \App\Exam\School_subject::getAll();
                                                        $sub_id = isset($_GET['sub_id']) ? $_GET['sub_id'] : '0';
                                                        ?>
                                                        <select class="form-control select2  " id="" name="sub_id">
                                                            <option value="0" @if($sub_id == '0') selected @endif>-- Chọn môn học --</option>
                                                            @foreach($school_subject as $sub)
                                                                <option value="{{ $sub->sub_id }}" @if($sub_id == $sub->sub_id) selected @endif>{{ $sub->sub_name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-lg-3">

                                                        <button type="submit" class="btnAddQuestionSchool w100" style="">
                                                            Lọc tìm câu hỏi
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="content">

                                            <table id="example" class="table table-striped table-bordered mbdsNone" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tiêu đề câu hỏi</th>
                                                    <th>Môn học</th>
                                                    <th>Chuyển câu hỏi</th>


                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($list_question as $id_ques=>$question)
                                                    <tr>
                                                        <td width="5%">
                                                           {{ $id_ques + 1 }}
                                                        </td>
                                                        <td width="">
                                                               {!! isset($question['name_ques']) ? $question['name_ques'] : '' !!}
                                                        </td>
                                                        <td width="15%">
                                                            <?php
                                                            $sub = \App\Exam\School_subject::get_sub_id($question->sub_id);
                                                            ?>
                                                            @if(!empty($sub))
                                                                {{ $sub->sub_name }}
                                                                @else
                                                                Chưa chọn môn học
                                                            @endif
                                                        </td>
                                                        <td width="15%">
                                                            <select class="form-control js_change_select" id="" name="id_ques" data_id_ques="{{ $question->id_ques }}">
                                                                <option @if($question->type_ques == 0) selected @endif value="0">Dễ</option>
                                                                <option @if($question->type_ques == 1) selected @endif value="1">Trung bình</option>
                                                                <option @if($question->type_ques == 2) selected @endif value="2">Khó</option>

                                                            </select>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>

                                            <div class="linkPage">
                                                <nav aria-label="Page navigation example" class="text-right">
                                                    {{ $list_question->links() }}
                                                </nav>
                                            </div>




                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </section>

                    {{--@include('site.module_index.dang-ky-tu-van')--}}

                </div>
            </div>
            {{--@include('site.module_index.hotline')--}}
        </div>
    </section>


    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.js"></script>--}}
    <div class="modal fade" id="myModalDelete0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 60px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="submitDelete" method="post" >
                    {!! csrf_field() !!}
                    <div class="modal-footer" style="border-top: 0px">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function submitDelete(e) {
            var url = $(e).attr('href');
            console.log(url);
            $('.submitDelete').attr('action', url);
            return false;
        }
    </script>
    <style>
        .modal-content_1 {
            background: #fff;
        }
    </style>


    <script>
        $('.js_change_select').change(function(){
            var type_ques = $(this).val();
            var id_ques = $(this).attr('data_id_ques');

            var type_name = '';
            if(type_ques == 0)
            {
                type_name = 'dễ';
            } if(type_ques == 1)
            {
                type_name = 'trung bình';
            } if(type_ques == 2)
            {
                type_name = 'khó';
            }

            $('#data_name_modal').html('Chuyển câu hỏi thành '+ '<i class="fas fa-caret-right"> </i> ' + type_name);
            $('#showStatus').modal('show');

            $('.btnChangeSelect').click(function(){
                console.log(id_ques);
                // $('#showStatusSucces').modal('show');
                $.ajax({
                    type: "post",
                    url: '{!! route('ajax_change_type_question') !!}',
                    data: {
                        id_ques: id_ques,
                        type_ques: type_ques,
                    },
                    success: function (result) {

                        $('#showStatus').modal('hide');
                        // var html = " <div class='alert alert-success alert-dismissible fade show' role='alert'>";
                        //     html += "Lưu trạng thái thành công !";
                        //     html += "<button type='button' class='close' data-dismiss='alert'  aria-label='Close'>";
                        //     html += "<span aria-hidden='true'>&times;</span>";
                        //     html += " </button>";
                        //     html += " </div>";
                        // $('.show_message_status').append(html);
                        // $('#showStatusEroor').modal('show');
                        $('#showStatusSucces').modal('show');
                        console.log('Chuyển câu hỏi thành công');
                        location.reload();

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#showStatus').modal('hide');
                        $('#showStatusEroor').modal('show');
                        location.reload();
                        console.log('Chuyển câu hỏi thất bại');
                    }
                });
                // $('#showStatus').modal('hide');
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="showStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="data_name_modal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--<div class="modal-body">--}}
                {{--...--}}
                {{--</div>--}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary bgorang border-0 btnChangeSelect">Chuyển câu hỏi</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showStatusSucces" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        Chuyển câu hỏi thành công !
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showStatusEroor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái hồ sơ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show"
                         role="alert">
                        Chuyển câu hỏi thất bại !
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary border-0 reloadPage" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection




