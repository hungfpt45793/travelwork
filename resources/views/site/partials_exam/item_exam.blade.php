<div class="boxItem">
    <div class="boxItemTop  clwhite">
        <div class="pull-left">
            <ul>
                <?php
                $view = 0;
                if (!empty($exam['view_exam'])) {
                    $view = $exam['view_exam'];
                }
                ?>
                <li class="" style="padding-left: 0"><span class="mgRight15"><i class="fa fa-eye"
                                                                                aria-hidden="true"></i> <span
                                class="mbdsNone">Lượt xem :</span>{{ $view }}</span>
                </li>
                <?php
                $countStar = \App\Exam\StarExam::countExam($exam['id_exam']);
                $starAll = \App\Exam\StarExam::getStarExam($exam['id_exam']);
                $aumAll = 0;
                foreach ($starAll as $star) {
                    $aumAll += $star['qty_stars'];
                }
                if ($countStar > 0) {
                    $avgStar = $aumAll / $countStar;
                } else {
                    $avgStar = 0;
                }
                ?>
                <li class=""><span class="mgRight15"> <span class="mbdsNone">Đánh giá :</span>  <span
                                class="rate-product" style=" vertical-align:text-top;"></span>
                        <script>
                            $(".rate-product").starRating({
                                initialRating: '{{ $avgStar }}',
                                useFullStars: true,
                                starSize: 18,
                                readOnly: true,
                                strokeColor: '#894A00',
                            });
                        </script>
                    </span>
                </li>

                <?php
                $countComemnt = 0;
                $countComemnt = \App\Exam\CommentExam::countCommentExam($exam['id_exam']);
                ?>
                <li class=""><span class="mgRight15"><i class="fa fa-commenting-o mgRight5" aria-hidden="true"></i> <i
                                class="far fa-comments"></i><span
                                class="mbdsNone"> Bình luận : </span> {{ $countComemnt }}</span>
                </li>


            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="itemQuestion">
        <div class="row">
            @if($exam['status_exam'] == 1)
                <a href="{{ route('getTestExam',['slug_exam' => $exam['slug_exam'] ]) }}">
                    @else
                        <a href="{{ route('getExam',['slug_exam' => $exam['slug_exam'] ]) }}">
                            @endif
                            <div class="col-lg-12 col-md-12  pd-015">
                                <h3 class="maxHeightTitle cutTitle">{{ $exam['name_exam'] }}</h3>
                                <p class="mgBottom0 f15 "><strong class="">Mã đề thi : </strong> <span
                                            style="color: white; padding: 2px 5px;background: #009385;"
                                            class="mgr15">  {{ $exam['code_exam'] }} </span>
                                    <?php $total_question = 0;
                                    $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                                    ?>
                                    <span class="clorange f15 mgr15"><i
                                                class="fas fa-question mgr5"></i> {{ $total_question }} câu hỏi</span>
                                    <span class="clorange f15 mgr15"><i
                                                class="far fa-clock mgr5"></i>{{ $exam['time_exam'] }} phút</span>
                                </p>

                                <div class="descriptionItem maxHeightDes cutTitle2 height44" style="color: #000">
                                    {!! isset($exam['intro_exam']) ? $exam['intro_exam'] : '' !!}

                                </div>
                            </div>
                        </a>
                </a>
        </div>
    </div>
</div>