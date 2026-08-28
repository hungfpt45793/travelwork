<div class="item_box_exam">
    @if((int) ($exam['status_exam'] ?? 0) === 1)
        <a href="{{ route('getTestQuestion', ['slug_exam' => $exam['slug_exam']]) }}">
    @else
        <a href="{{ route('getQuestion', ['slug_exam' => $exam['slug_exam']]) }}">
    @endif
                    <p class="item_box_exam_title ">
                        {{ $exam['name_exam'] }}
                    </p>
                    <p class="item_box_exam_des  ">
                        {!! isset($exam['intro_exam']) ? $exam['intro_exam'] : '' !!}
                    </p>

                    <?php $total_question = 0;
                    $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                    ?>
                    <div class="box_list_icon_exam">
                        <div class="left_box_exam">
                            <span class="left_icon_exam"><i class="far fa-file-alt"></i>{{ $exam['code_exam'] }}</span>
                            <span class="left_icon_exam"><i class="fas fa-question"></i>{{ $total_question }} câu</span>
                            <span class="left_icon_exam"><i class="far fa-clock"></i>{{ $exam['time_exam'] }} phút</span>
                        </div>

                        <div class="right_box_exam">
                            <?php
                            $view = 0;
                            if (!empty($exam['view_exam'])) {
                                $view = $exam['view_exam'];
                            }
                            ?>
                            <span class="right_icon_exam"><i class="fa fa-eye" aria-hidden="true"></i>{{ $view }}</span>
                                @if((int) ($exam['status_exam'] ?? 0) === 1)
                                    <span class="right_icon_exam right_icon_exam_test"><i class="fa fa-user-times" aria-hidden="true"></i></span>
                                @else
                                    <span class="right_icon_exam"><i class="fa fa-user" aria-hidden="true"></i></span>
                                @endif
                        </div>
                    </div>
                </a>


</div>
