@extends('site.layout.site')
@section('title', 'Ngân hàng đề thi')
@section('content')

    <section class="content " style="background:#eeeeee;padding-top:5px; ">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline bg-white">


                    <div class="mgt15 mgb15">
                        @if(session('suscess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! $value = session('suscess') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('erorr'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $value = session('erorr') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    @include('site.filter.filter_exam')
                    <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                        Ngân hàng đề thi ({{ $total  }} đề thi)
                    </div>



                    <div class="">


                        <table class="table table-hover mbdsNone" style="border: 1px solid #ccc;">
                            <thead>
                            <tr>
                                <th scope="col">Mã đề thi</th>
                                <th scope="col">Tên đề thi</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exams as $exam)
                                <tr>
                                    <th scope="row"> <span class="btnGreen pd-05 pd-005 btn-small">{{ $exam['code_exam'] }}</span></th>
                                    <td>{{ $exam['name_exam'] }}</td>
                                    <td>{{ $exam['intro_exam']  }}</td>
                                    <td style="width: 10%">
                                    <span style="color: green">
                                        <i class="far fa-clock"></i> {{ $exam['time_exam'] }}
                                        (phút)</span>
                                        </br>
                                        <span>
                                        <span style="color: red;">
                                            <i class="fas fa-question-circle"></i>
                                            <?php $total_question = 0;
                                            $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                                            echo $total_question;
                                            ?>
                                        </span>
                                        câu hỏi
                                    </span>
                                    </td>
                                    <td style="width: 10%">
                                      
                                        <a  href="{{ route('getAllQuestionsZero' ,['id_exam' => $exam->id_exam]) }}" class="btn btnGreen  btnSmall mgBottom5"
                                            title="Sửa câu hỏi" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a  href="{{ route('showcopyExam',['id_exam' => $exam->id_exam]) }}" class="btn btn-info  btnSmall mgBottom5"
                                            title="Copy đề thi" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-clone" aria-hidden="true"></i>
                                        </a>
                                       
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                        <table class="table table-hover dsNone mbdsBlock" style="border: 1px solid #ccc;">
                            <thead>
                            <tr>
                                <th scope="col">Thông tin đề thi</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exams as $exam)
                                <tr>
                                    <td style="width: 70%;max-width: 70%;word-wrap: break-word;">
                                        <p class="mgBottom5">Mã đề thi : <span class="btnGreen pd-05 pd-005 btn-small">{{ $exam['code_exam'] }}</span> </p>
                                        <p class="mgBottom5">Tên đề thi : {{ $exam['name_exam'] }}</p>
                                        <p class="mgBottom5"> Mô tả : {{ $exam['intro_exam']  }}</p>


                                    </td>

                                    <td style="text-align: center">
                                    <span style="color: green">
                                        {{ $exam['time_exam'] }}
                                        (phút)</span>
                                        </br>
                                        <span>
                                        <span style="color: red;">
                                        <?php $total_question = 0;
                                            $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                                            echo $total_question;
                                            ?>
                                        </span>
                                        câu hỏi
                                    </span>

                                    </td>


                                    <td class="text-center" width="15%">


                                        <a  href="{{ route('getAllQuestionsZero' ,['id_exam' => $exam->id_exam]) }}" class="btn btnGreen  btnSmall mgBottom5"
                                            title="Sửa câu hỏi" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a  href="{{ route('showcopyExam',['id_exam' => $exam->id_exam]) }}" class="btn btn-info  btnSmall mgBottom5"
                                            title="Copy đề thi" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-clone" aria-hidden="true"></i>
                                        </a>
                                   
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="linkPage">
                        <nav aria-label="Page navigation example" class="text-right">
                            {{ $exams->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('site.exam_admin_site.delete')
    <script>
        $('#changeCategory').change(function(){
            $('#submitFormSearchRoom').submit();
        });
    </script>
@endsection



