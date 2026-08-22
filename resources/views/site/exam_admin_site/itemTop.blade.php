@if($checklever == 1)
<div class="col-lg-3">
    <div class="bg-white pd15 text-center">
        <div class="">
            <p class="mgBottom0">

                <span class="btnGreen btn clwhite">{{ $exam->code_exam }}</span>
            </p>
        </div>

    </div>
</div>
<div class="col-lg-3">
    <div class="bg-white pd15 text-center">
        <div class="">
            <p class="mgBottom0">
                <a href="{{ route('showcopyExam',['id_exam' => $exam->id_exam]) }}" class="btnGreen btn clwhite"> <i class="fa fa-clone" aria-hidden="true"></i> copy đề thi</a>
                {{--<br>--}}
                {{--<span>Chức năng copy từ ngân hàng đề thi thành đề thi của bạn <i>(đề thi của bạn thì bạn có thể sửa câu hỏi)</i></span>--}}
            </p>
        </div>

    </div>
</div>
<div class="col-lg-3">
    <div class="bg-white pd15 text-center">
        <div class="">
            <p class="mgBottom0">
                <a href="{{ route('site_exam.edit',['id_exam' => $exam->id_exam]) }}" class="btnGreen btn clwhite"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa đề thi</a>
            </p>
        </div>

    </div>
</div>
<div class="col-lg-3">
    <div class="bg-white pd15 text-center">
        <div class="">
            <p class="mgBottom0">
                <a href="{{ route('showExam') }}" class="btnGreen btn clwhite"><i class="fa fa-list mgRight5" aria-hidden="true"></i>Danh sách đề thi</a>
            </p>
        </div>

    </div>
</div>
    @else
    <div class="col-lg-4">
        <div class="bg-white pd15 text-center">
            <div class="">
                <p class="mgBottom0">

                    <span class="btnGreen btn clwhite">{{ $exam->code_exam }}</span>
                </p>
            </div>

        </div>
    </div>
    <div class="col-lg-4">
        <div class="bg-white pd15 text-center">
            <div class="">
                <p class="mgBottom0">
                    <a href="{{ route('showcopyExam',['id_exam' => $exam->id_exam]) }}" class="btnGreen btn clwhite"> <i class="fa fa-clone" aria-hidden="true"></i> copy đề thi</a>
                    <br>
                    <span>Chức năng copy từ ngân hàng đề thi thành đề thi của bạn <i>(đề thi của bạn thì bạn có thể sửa câu hỏi)</i></span>
                </p>
            </div>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="bg-white pd15 text-center">
            <div class="">
                <p class="mgBottom0">
                    <a href="{{ route('showExam') }}" class="btnGreen btn clwhite"><i class="fa fa-list mgRight5" aria-hidden="true"></i>Danh sách đề thi</a>
                </p>
            </div>

        </div>
    </div>
 @endif