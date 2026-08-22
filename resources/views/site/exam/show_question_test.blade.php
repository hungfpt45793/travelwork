<!DOCTYPE html >
<html mlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#" class="no-js">
<head>
    <title>{{ isset($exam['name_exam']) ? $exam['name_exam'] : 'Thông tin đề thi' }}</title>
    <!-- meta -->
    <meta name="ROBOTS" content="index, follow"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi' }}"/>
    <meta name="keywords" content="'Đề thi trắc nghiệm du lịch"/>
    <!-- facebook gooogle -->
    <!-- <meta property="fb:app_id" content="" />
    <meta property="fb:admins" content=""> -->

    <link rel="icon" href="{{ !empty($information['icon']) ?  asset($information['icon']) : '' }}" type="image/x-icon"/>

    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:locale" content="vi_VN"/>
    <meta property="og:type" content="{{ isset($exam['name_exam']) ? $exam['name_exam'] : 'Thông tin đề thi' }}"/>
    <meta property="og:title" content="{{ isset($exam['name_exam']) ? $exam['name_exam'] : 'Thông tin đề thi' }}"/>
    <meta property="og:description" content="{{ isset( $exam['intro_exam']) ? $exam['intro_exam']  : 'Mô tả đề thi' }}"/>
    <meta property="og:url" content="{{ !empty($exam['id_exam']) ? route('getTestExam',['slug_exam' => $exam['slug_exam']]) : '' }}"/>
    <meta property="og:image" content="{{ !empty($exam['image_exam']) ? asset($exam['image_exam']) : '' }}"/>
    <meta property="og:image:secure_url" content="{{ !empty($exam['image_exam']) ? asset($exam['image_exam']) : '' }}"/>
    <meta property="og:image:width" content="300"/>
    <meta property="og:image:height" content="300"/>




    @include('site.partials_exam.include-CSS-JS')
    <link rel="stylesheet" href="{{ asset('tracnghiem/') }}/css/examStyle.css">
</head>
<body>
<section class="main" id="toTop">
    <div class="container">
        <form action="{{ route('createTestResult') }} " method="POST" id="submitQuenstion">
            {!! csrf_field() !!}
            {{ method_field('POST') }}
            <input type="hidden" name="id_exam" value="{{ $exam['id_exam'] }}">
            <div class="row mgTop15">
                <div class="col-lg-12 col-md123 leftSidebar" id="timeHeader">
                    <div class="row bgTopQueestion">
                        <div class="panelBox col-lg-4 col-md-4 col-sm-12">
                            <div id="timer-box" class="template2">
                                <span class="f18 ScrollNone clwhite" id="endtime">Thời gian còn lại</span>
                                <div id="defaultCountdown"></div>
                            {{--<div id="divCounter"></div>--}}
                            <!--  <div id="countdown" data-seconds-left="5"></div> -->
                            </div>
                        </div>
                        <div class="panelBox col-lg-4 col-md-4 col-sm-6 col-6">
                            <?php $total_question = 0;
                            $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                            ?>
                            <p style="margin-top: 0;margin-bottom: 5px "
                               class="f18  mgBottom10 mgTop0 ScrollNone text-center clwhite maxHieghtShowQuestion" id="">Tổng số câu hỏi
                                : {{ $total_question }}</p>
                                <button type="button" name="" class="btn bgHome" id="btn_submit_exam" onclick="nv_save_test(0);">
                                    <em class="fa fa-floppy-o">&nbsp;</em>Nộp bài
                                </button>

                            &nbsp;
                        </div>
                        <div class="panelBox col-lg-4 col-md-4 col-md-4 col-sm-6 col-6">
                            <h1 class="ScrollNone clwhite maxHieghtShowQuestion">{{ $exam['name_exam'] }}</h1>
                            <button type="button" name="" class="btn bgHome" data-toggle="modal"
                                    data-target="#exam_rules">Quy chế thi
                            </button>
                        </div>
                    </div >
                </div>
            </div>
            <div class="row mgTop15" id="ContentExam">
                <div class="col-lg-10 col-md-10 guide pdLeft0 maxHeightSiderbar">
                    <div class="panel panel-default">
                        <!-- <div class="panel-heading">Hướng dẫn làm bài</div>
                           <div class="panel-body"><h2>Hướng dẫn làm bài thi trắc nghiệm:</h2>
                           1. Đợi đến khi đến thời gian làm bài<br>
                           2. Click vào nút "Bắt đầu làm bài" để tiến hành làm bài thi<br>
                           3. Ở mỗi câu hỏi, chọn đáp án đúng<br>
                           4. Hết thời gian làm bài, hệ thống sẽ tự thu bài. Bạn có thể nộp bài trước khi thời gian kết thúc bằng cách nhấn nút <strong>Nộp bài</strong>
                           </div> -->
                        <div class="testing test-gird m-bottom">
                            <div id="questionlist" data-exam-id="27" class="m-bottom">
                                @foreach($questions as $id => $question )
                                    <div id="question_{{ $id + 1 }}" id_data="question_number_{{ $id + 1 }}"
                                         class="listquestion question-box" style="">
                                        <div class="panel panel-default  @if($question['type_ques'] == 2) question-item2 @else question-item @endif"
                                             data-question-number="{{ $id + 1 }}">
                                            <div class="panel-body">
                                                <div class="titleQuestionRight">
                                                    <h3><strong class="mgBottom10 dsBlock">Câu hỏi {{ $id + 1 }}
                                                            :</strong> {!! isset($question['name_ques'])  ? $question['name_ques'] : '' !!}
                                                    </h3>
                                                </div>
                                                @if($question['type_ques'] == 0)
                                                    <div class="row answer
                                                    @if($question['show_answer_ques'] == 0)
                                                            show_answer0
@elseif($question['show_answer_ques'] == 1)
                                                            show_answer1
@elseif($question['show_answer_ques'] == 2)
                                                            show_answer2
@endif
                                                            ">

                                                        <div class="answer-item col-lg-6">
                                                            <label class="answerRadio">
                                                                <input type="radio"
                                                                       name="answer[{{ $question['id_ques'] }}]"
                                                                       value="answer1"
                                                                       class="flat-red resetchecked">
                                                                A. {{ $question['answer1'] }}
                                                            </label>
                                                        </div>
                                                        <div class="answer-item col-lg-6">
                                                            <label class="answerRadio">
                                                                <input type="radio"
                                                                       name="answer[{{ $question['id_ques'] }}]"
                                                                       value="answer2"
                                                                       class="flat-red resetchecked ">
                                                                B. {{ $question['answer2'] }}
                                                            </label>
                                                        </div>
                                                        @if(!empty($question['answer3']))
                                                            <div class="answer-item col-lg-6">
                                                                <label class="answerRadio">
                                                                    <input type="radio"
                                                                           name="answer[{{ $question['id_ques'] }}]"
                                                                           value="answer3"
                                                                           class="flat-red resetchecked ">
                                                                    C. {{ $question['answer3'] }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if(!empty($question['answer4']))
                                                            <div class="answer-item col-lg-6">
                                                                <label class="answerRadio">
                                                                    <input type="radio"
                                                                           name="answer[{{ $question['id_ques'] }}]"
                                                                           value="answer4"
                                                                           class="flat-red resetchecked ">
                                                                    D. {{ $question['answer4'] }}
                                                                </label>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @elseif($question['type_ques'] == 1)
                                                    <div class="row answer
                                                    @if($question['show_answer_ques'] == 0)
                                                            show_answer0
@elseif($question['show_answer_ques'] == 1)
                                                            show_answer1
@elseif($question['show_answer_ques'] == 2)
                                                            show_answer2
@endif
                                                            ">

                                                        <div class="answer-item col-lg-6">
                                                            <label class="answerRadio">
                                                                <input type="radio"
                                                                       name="answer[{{ $question['id_ques'] }}]"
                                                                       value="answer1"
                                                                       class="flat-red resetchecked ">
                                                                A. {{ $question['answer1'] }}
                                                            </label>
                                                        </div>
                                                        <div class="answer-item col-lg-6">
                                                            <label class="answerRadio">
                                                                <input type="radio"
                                                                       name="answer[{{ $question['id_ques'] }}]"
                                                                       value="answer2"
                                                                       class="flat-red resetchecked ">
                                                                B. {{ $question['answer2'] }}
                                                            </label>
                                                        </div>


                                                    </div>
                                                @elseif($question['type_ques'] == 2)
                                                    <div class="answer-item w100">
                                                        <label class="" style="width: 100%;">
                                                            Đáp án :
                                                            <textarea style="width: 100%;padding: 10px;" rows="5"
                                                                      name="answer[{{ $question['id_ques'] }}]"
                                                                      class="answerTextArea"></textarea>
                                                        </label>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                <div class="text-center clear">

                                    <button id="ShowAllQuestion" type="button" class="btn bgHome clwhite item-next"
                                            title="Kế tiếp">
                                        <span class="btn-label">Hiển thị tất cả câu hỏi</span>
                                    </button>

                                    <button onclick="previous_question();" type="button"
                                            class="btn btn-danger item-prev" title="Trước đó" disabled="disabled">
                                        <span>Câu trước đó</span>
                                    </button>
                                    &nbsp;
                                    <button onclick="next_question();" type="button"
                                            class="btn btn-primary item-next" title="Kế tiếp">
                                        <span class="btn-label">Câu sau đó</span>
                                    </button>

                                </div>
                            </div>

                            <div class="text-center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 panelBox maxHeightSiderbar" id="sidebar" style="border: none">Danh sách câu hỏi
                    <div class="col-md-24">
                        <ul class="slides-vertical-pagination">
                            @foreach($questions as $id => $question )
                                {{--@if($id == 0)--}}
                                {{--<li class="question_number pagination-active" id="question_number_{{$id + 1}}" onclick="scrolltoQuestion(1),ser_process_bar({{$id + 1}}, {{ $total_question }})"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;{{$id + 1}}</span></li>--}}
                                {{--@else--}}
                                <li class="question_number" id="question_number_{{$id + 1}}"
                                    onclick="scrolltoQuestion({{$id + 1}}),ser_process_bar({{$id + 1}}, {{ $total_question }})">
                                    <a href="#toTop"><span
                                                class="pagination-item-name"
                                                aria-hidden="true">Câu&nbsp;{{$id + 1}}</span></a></li>
                                {{--@endif--}}
                            @endforeach


                            {{--<li class="question_number" id="question_number_3" onclick="scrolltoQuestion(3),ser_process_bar(3, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;3</span></li>--}}
                            {{--<li class="question_number" id="question_number_4" onclick="scrolltoQuestion(4),ser_process_bar(4, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;4</span></li>--}}
                            {{--<li class="question_number" id="question_number_5" onclick="scrolltoQuestion(5),ser_process_bar(5, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;5</span></li>--}}
                            {{--<li class="question_number" id="question_number_6" onclick="scrolltoQuestion(6),ser_process_bar(6, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;6</span></li>--}}
                            {{--<li class="question_number" id="question_number_7" onclick="scrolltoQuestion(7),ser_process_bar(7, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;7</span></li>--}}
                            {{--<li class="question_number" id="question_number_8" onclick="scrolltoQuestion(8),ser_process_bar(8, 8)"><span class="pagination-item-name" aria-hidden="true">Câu&nbsp;8</span></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

</section>

<section>
    <!-- SiteModal Required!!! -->
    <div id="sitemodal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <em class="fa fa-spinner fa-spin">&nbsp;</em>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        </div>
    </div>
    {{--<div id="openidResult" class="nv-alert" style="display:none"></div>--}}
    {{--<div id="openidBt" data-result="" data-redirect=""></div>--}}
    {{--<div id="run_cronjobs" style="visibility:hidden;display:none;"><img alt="" src="./Tin học 6_files/index.php" width="1" height="1"></div>--}}
    {{--<script src="{{ asset('tracnghiem/') }}/js/jquery.min.js"></script>--}}
    <script src="{{ asset('tracnghiem/') }}/js/vi.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/global.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/test.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/main.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/jquery.simple.timer.js"></script>


    <script type="text/javascript">
        //phan show cau hoi theo tung cau
        $('.listquestion').hide();
        var quesnumber_current = 1;
        var total_ques = '{{ $total_question }}';
        scrolltoQuestion(quesnumber_current);
        ser_process_bar(quesnumber_current, total_ques);
    </script>
    <script src="{{ asset('tracnghiem/') }}/js/jquery.plugin.min.js"></script>
    <script src="{{ asset('tracnghiem/') }}/js/jquery.countdown.js"></script>
    {{--mỗi lần f5 reset lại form--}}

    <script>
        $(document).ready(function () {
            function myFunction() {
                document.getElementById("submitQuenstion").reset();
            }

            $('.resetchecked').prop('checked', false);
        });

    </script>
    <script>
        $(document).ready(function () {
            $('.answerTextArea').blur(function () {
                var dataid = $(this).parent().parent().parent().parent().parent().attr('id_data');
                var idtextarea = $(this).parent().parent().parent().parent().parent().attr('id');
                var valtextarea = $(this).val();
                if(valtextarea == '')
                {
                    $('#'+ idtextarea +'').find('.question-item2').removeClass('answered');
                    $('#'+ dataid +'').removeClass('item-answed');
                }
                else
                {
                    $('#'+ idtextarea +'').find('.question-item2').addClass('answered');
                    $('#'+ dataid +'').addClass('item-answed');
                }

            })
            $('.answerRadio').blur(function () {
                var nameinput = $(this).parent().find('input').attr('name');
                var answer = $(this).parent().parent().parent().parent().parent().attr('id_data');
                $('#'+ answer + '').addClass('item-answed');
                // alert(nameinput + answer);
            });
            $('.listquestion').click(function(){
                var dataid_radio = $(this).attr('id_data');
                if ($(this).find('input').is(':checked')) {
                    $('#'+dataid_radio+'').addClass('item-answed');
                }
                else
                {
                    $('#'+dataid_radio+'').removeClass('item-answed');
                }

                // $(this).parent().find('.answer-item').each(function () {
                //     if ($(this).find('input').is(':checked')) {
                //         // $(this).find('label').addClass('selected');
                //         // var name = $(this).parent().parent().parent().parent().attr('id_data');
                //         // $('#'+ name + '').addClass('item-answed');
                //         // alert(name);
                //     } else {
                //         // alert(2);
                //         $(this).find('label').removeClass('selected');
                //     }
                // });
                //
                // alert(dataid_radio);
            })
            $('.resetchecked').click(function () {
                // alert(1);
                // var  answer = $(this).parent().parent().parent().parent().parent().parent().parent().attr('id_data');
                //  alert(answer);
            });
            $('.answer-item').click(function () {
                $(this).parent().find('.answer-item').each(function () {
                    if ($(this).find('input').is(':checked')) {
                        // $(this).find('label').addClass('selected');
                        // var name = $(this).parent().parent().parent().parent().attr('id_data');
                        // $('#'+ name + '').addClass('item-answed');
                        // alert(name);
                    } else {
                        // alert(2);
                        $(this).parent().parent().parent().parent().attr('id_data');
                        $(this).find('label').removeClass('selected');
                    }
                });
                // if ($(this).find('input').is(':checked')) {
                //     $(this).find('label').addClass('selected');
                // } else {
                //     $(this).find('label').removeClass('selected');
                // }
                $(this).closest('.question-item').addClass('answered');
                var questionid = $(this).closest('.question-item').data('question-number');
                var answerid = {};
                $(this).closest('.question-item').find('.answer-item').find('input:checked').each(function (index) {
                    answerid[index] = $(this).val();
                });
                nv_test_set_answer(questionid, answerid);
            });
        });

        function nv_save_test() {
            //check cau hoi
            var list = [];
            var submit_confirm = '';
            $('.question-item').each(function () {
                if (!$(this).hasClass('answered')) {
                    list.push($(this).data('question-number'));
                }
            });
            $('.question-item2').each(function () {
                if (!$(this).hasClass('answered')) {
                    list.push($(this).data('question-number'));
                }
            });
            if (list.length > 0) {
                submit_confirm = 'Các câu hỏi số ' + list.join(", ") + ' chưa được trả lời. Bạn có chắc chắn muốn nộp bài?';
            } else {
                submit_confirm = 'Bạn có chắc chắn muốn nộp bài?';
            }
            if (confirm(submit_confirm)) {
                $('#btn_submit_exam').html('Đang Nộp bài...');
                $('#btn_submit_exam').css('color','#fff');
                $("#btn_submit_exam").attr("disabled", true);
                $('#submitQuenstion').submit();
            }
            else {
            }
        }
        $('.question_number').click(function(){

        });
    </script>
</section>


<div class="modal fade" id="exam_rules" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Quy chế thi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $exam['content_exam'] !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bgHome clwhite" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>




<script>
    // menu chay theo khi scrool chuot
    $(document).ready(function () {
        $(this).scrollTop(0);
        var s1 = $("#timeHeader");

        var s2 = $(".submenu1");
        var pos = s1.position();
        var posheight = s1.height();
        var heightbody = $('body').height();
        var heightwindow = $(window).height();
        // alert('body ' + heightbody +'---------' + 'window' + heightwindow + '+++++++' + posheight);

        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();
            if (windowpos > pos.top) {
                s1.addClass("sticky");
                $('#timeHeader ').css('background', '#fff');
                $('#ContentExam').css('margin-top', '200px');
                $('.ScrollNone').css('display', 'none');
                $('.leftSidebar #defaultCountdown').css('font-size', '28px');
            } else {
                s1.removeClass("sticky");
                $('#ContentExam').css('margin-top', '0px');
                $('.ScrollNone').css('display', 'block');
                $('.leftSidebar #defaultCountdown').css('font-size', '40px');
            }
            if (windowpos > (pos.top)) {
                s2.addClass("ds-none");
                $('.submenuPC').click(function () {
                    s2.removeClass("ds-none");
                });

                $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '0');
            } else {
                s2.removeClass("ds-none");
                $('.Mbsubmenu .Mobilemenu .navbar').css('margin-top', '50px');


            }
        });
        $('.listquestion').show();
        $('#ShowAllQuestion').click(function () {
            $('.listquestion').show();
            $('.listquestion .question-item .panel-body').css('margin-top','0px');
        });
    });


</script>
<script>
    //var sticky = new Sticky('[data-sticky]');
    $(document).ready(function () {
        // Optimalisation: Store the references outside the event handler:
        var $window = $(window);

        var windowsize = $window.width();
        if (windowsize >= 1000) {
            var stickySidebar = new StickySidebar('#sidebar', {
                topSpacing: 40,
                bottomSpacing: 40,
                containerSelector: '#ContentExam',
                innerWrapperSelector: '.sidebar__inner'
            });
        }
    });
</script>
<script>
    //Đồng bộ chiều cao các div
    $(function () {
        $('.maxHeightSiderbar').matchHeight();
        $('.maxHieghtShowQuestion').matchHeight();
    });
</script>
<script>

    var time = <?php echo $exam['time_exam']; ?> *
    60;
    var id = 'time' + '<?php echo $exam['id_exam']; ?>';
    if (localStorage.getItem(id)) {
        if (localStorage.getItem(id) >= time) {
            var value = time;
        } else {
            var value = localStorage.getItem(id);
            //neu nhu het gio quay lai thi xoa bo nho tam localStorage
        }
    } else {
        var value = time;
        localStorage.removeItem(id);
    }
    var counter = function () {
        if (value <= 0) {
            // localStorage.removeItem('counter');
            // localStorage.setItem(id, 0);
            localStorage.removeItem(id);
            $('#endtime').html('Hết Giờ!');
            $('#submitQuenstion').submit();
            // alert('Bạn đã hết thời gian thi ! Hệ thống sẽ tự động nộp bài của bạn')
            // value = time;
        } else {
            value = value - 1;
            var d = new Date();
            d = new Date(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes() + 0, d.getSeconds() + value);
            $('#defaultCountdown').countdown({until: d, format: 'MS'});
            localStorage.setItem(id, value);
            var set_timeuot = value * 1000;
            var myVar = setInterval(myTimer, set_timeuot);

            setTimeout(function(){
                $('#btn_submit_exam').html('Đang Nộp bài...');
                $('#btn_submit_exam').css('color','#fff');
                $("#btn_submit_exam").attr("disabled", true);
                $('#submitQuenstion').submit();
                $('#submitQuenstion').submit(function(event){
                    event.preventDefault();
                    //add stuff here
                });
            }, set_timeuot);
            // console(value);
        }

        // alert(value);
        // $('#endtime').html('Hết Gi');
        // document.getElementById('divCounter').innerHTML = value;
    };
    var interval = setInterval(function () {
        counter();
    }, 1000);
    var check;

    function myTimer() {
        check = 0;
        // alert('Bạn đã hết thời gian làm bài ! ')

    }

</script>
</body>
</html>


