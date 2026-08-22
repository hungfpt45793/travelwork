@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Chọn đề thi')
@section('meta_description',  'Mô tả đề thi')

@section('content')
    <style>
        input[type=checkbox] {
            width: 20px;
            height: 20px;
        }
    </style>

    <!--    --><?php
    //    $array_id = (explode(',', $room['id_exam']));
    ////    unset($array_id[6]);
    //     session()->put('code', $array_id);
    //
    ////    session()->put('code', $array_id);
    //
    //    ?>
    @include('site.exam_admin_site.include-CSS-JS')
    <section class="main bgUser">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding: 0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="clHome"  href="{{ route('room.index') }}">Danh sách phòng thi</a></li>
                            {{--<li class="breadcrumb-item"><a href="#">Library</a></li>--}}
                            <li class="breadcrumb-item active" aria-current="page">Danh sách đề thi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mgTB15">
                        <a href="{{ route('room.index') }}" class="btnLage btnloadding btnGreen"> <i class="fa fa-list"
                                                                                                     aria-hidden="true"></i>
                            Danh sách phòng thi</a>

                        <div>
                            <div class="form-group mgTop15">
                                <p class="f16 clred mgBottom5">Lưu ý : Bạn có thể chọn đề thi từ đề thi của bạn hoặc từ ngân hàng
                                    đề thi cho phòng thi</p>
                                <p class="mgBottom5">Tích vào <input type="checkbox"> bên dưới  để chọn hoặc hủy chọn đề thi</p>
                            </div>
                            @if ($errors->has('examid'))
                                <div class="form-group mgTop15">
                                    <div class="alert alert-danger">
                                        <i>Bạn chưa chọn đề thi cho phòng thi !</i>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="row hiddenShowSidebar">
                <div class="col-lg-9 col-md-9 categoryQuestion ">
                    <section class="content contentMain userRight">
                        <div class="clearfix"></div>

                        <div class="row">
                            {{--return View('site.exam_admin_site.room.chon-de-thi',compact('list_exam','list_bank_exam','id_room'));--}}

                            <div class="col-lg-12 col-md-12 CategoryLeft RoomExam">
                                <div class="">
                                    <!-- /.box-header -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Chọn đề thi cho phòng thi</div>
                                        <div class="form-group">


                                            <a class="linkButton" href="{{ route('getRomExam',['id_room' => $room->id_room]) }}">Danh sách đề thi của bạn</a>
                                            <a class="linkButton" href="{{ route('getBankRomExam',['id_room' => $room->id_room]) }}">Danh sách đề thi từ ngân hàng đề <thi></thi></a>

                                            <div class="ListExam mgTop10">
                                                <p>Có thể tìm kiếm đề thi từ chuyên mục đề thi</p>
                                                <form action="" method="GET" id="submitFormSearchRoom">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id_user" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">

                                                    <div class="row mgBottom15 borderSelect2">
                                                        <div class="col-lg-5">
                                                            <?php
                                                            if(isset($_GET['category']))
                                                            {
                                                                $category = $_GET['category'];
                                                            }
                                                            else
                                                            {
                                                                $category = 0;
                                                            }
                                                            ?>
                                                            <select class="js-example-basic-single select2 w100" name="category" id="changeCategory">
                                                                <option value="0"  @if($category == 0) selected
                                                                        @endif >Chọn danh mục</option>
                                                                @foreach(\App\Exam\CategoriesExam::getCategories_exam() as $cate_exam)
                                                                    <option value="{{  $cate_exam['id_cate_exam'] }}"  @if($cate_exam['id_cate_exam'] == $category) selected
                                                                            @endif >{{  $cate_exam['name_cate_exam'] }}</option>
                                                                    <?php $childs = \App\Exam\CategoriesExam::getChilren($cate_exam->id_cate_exam)?>

                                                                    @foreach( $childs as $child)
                                                                        <option value="{{  $child['id_cate_exam'] }}" @if($child['id_cate_exam'] == $category) selected
                                                                                @endif>-- {{  $child['name_cate_exam'] }}</option>
                                                                        <?php $childs2 = \App\Exam\CategoriesExam::getChilren($child->id_cate_exam)?>
                                                                        @foreach($childs2 as $child2)
                                                                            <option value="{{  $child2['id_cate_exam'] }}" @if($child2['id_cate_exam'] == $category) selected
                                                                                    @endif>---- {{  $child2['name_cate_exam'] }}</option>
                                                                        @endforeach
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <input class="w100" type="text" placeholder="nhập tên đề hoặc mã đê cần tìm" name="exam" style=" border-radius: 3px;padding: 6px 7px; border: 1px solid #aaa;" value="@if(isset($_GET['exam'])) <?php echo $_GET['exam'] ?> @else @endif"  onkeyup="return searchExam(this);">

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button type="submit" class="btnGreen clwhite w100 btnloadding" style="padding: 6px 0">Tìm kiếm</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <table id="" class="table table-striped table-bordered mbdsNone"
                                                       style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Mã đề thi</th>
                                                        <th>Tên đề thi</th>
                                                        <th>Thời gian thi(phút)</th>
                                                        <th>Xem đề thi</th>



                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list_exam as $exam)
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                       name="examid[{{$exam->id_exam}}]"
                                                                       value="{{$exam->id_exam}}"
                                                                       datacode="{{ $exam['code_exam'] }}"
                                                                       class="xoa{{$exam->id_exam}}"></td>
                                                            <td>
                                                                <p class="mgBottom5"><span
                                                                            class="btnGreen pd-05 pd-005 btn-small">{{ $exam['code_exam'] }}</span>
                                                                </p>


                                                            </td>
                                                            <td>
                                                                <p class="mgBottom5"> {{ $exam['name_exam'] }}</p>
                                                            </td>
                                                            <td style="text-align: center">
                                                                    <span style="color: green">
                                                                        {{ $exam['time_exam'] }}
                                                                        (phút)
                                                                    </span>
                                                                -
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
                                                            <td>
                                                                <a  href="{{ route('getAllQuestionsZero' ,['id_exam' => $exam->id_exam]) }}" class="btn btnGreen  btnSmall mgBottom5"
                                                                    title="Xem câu hỏi" data-toggle="tooltip" data-placement="bottom" target="_blank">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>


                                                <table id="" class="table table-striped table-bordered dsNone mbdsBlock"
                                                       style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Thông tin đề thi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list_exam as $exam)
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                       name="examid[{{$exam->id_exam}}]"
                                                                       value="{{$exam->id_exam}}"
                                                                       datacode="{{ $exam['code_exam'] }}"
                                                                       class="xoa{{$exam->id_exam}}"></td>
                                                            <td>
                                                                <p class="mgBottom5">Mã đề thi : <span
                                                                            class="btnGreen pd-05 pd-005 btn-small">{{ $exam['code_exam'] }}</span>
                                                                </p>
                                                                <p class="mgBottom5">Tên đề thi : {{ $exam['name_exam'] }}</p>
                                                                <p class="mgBottom5">Thời gian : <span style="color: green">
                                                                        {{ $exam['time_exam'] }}
                                                                        (phút)
                                                                    </span></p>
                                                                <p class="mgBottom5">Câu hỏi :
                                                                    <span>
                                                                        <span style="color: red;">
                                                                        <?php $total_question = 0;
                                                                            $total_question = \App\Exam\Questions::countQuestion($exam['id_exam']);
                                                                            echo $total_question;
                                                                            ?>
                                                                        </span>
                                                                        câu hỏi
                                                                    </span></p>
                                                                <p class="mgBottom5">Xem đề thi <a  href="{{ route('getAllQuestionsZero' ,['id_exam' => $exam->id_exam]) }}" class="btn btnGreen  btnSmall mgBottom5"
                                                                                                    title="Xem câu hỏi" data-toggle="tooltip" data-placement="bottom" target="_blank">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    </a></p>


                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                                <div class="pagination-right">
                                                    <nav aria-label="Page navigation example">
                                                        {{ $list_exam->links() }}
                                                    </nav>
                                                </div>
                                                {{--<script type="text/javascript">--}}
                                                    {{--$(document).ready(function () {--}}
                                                        {{--$('#example').DataTable({--}}
                                                            {{--"language": {--}}
                                                                {{--"url": "{{ asset('tracnghiem') }}/js/Vietnamese.json"--}}
                                                            {{--}--}}
                                                        {{--});--}}
                                                    {{--});--}}
                                                {{--</script>--}}
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <!-- /.box -->
                            <!-- /.box -->

                        </div>
                        </form>
                        <!-- phan tạo cau hoi -->
                    </section>
                </div>

                <div class="col-lg-3 col-md-3 categoryQuestion pdRight0 pdLeft0 ">
                    <section class="content contentMain userRight">
                        <div class="col-lg-12 col-md-12 CategoryLeft RoomExam">
                            <div class="panel panel-default">
                                <div class="panel-heading ">Đề thi bạn đã chọn cho phòng thi</div>
                            </div>
                            <form id="submitFormRoom" role="form" action="{{ route('updateExamRoom') }}" method="POST"
                                  enctype="multipart/form-data" autocomplete="off">
                                {!! csrf_field() !!}
                                {{ method_field('POST') }}
                                <div class="">
                                    {{--);--}}
                                    <p>Đề thi bạn đã chọn :</p>

                                    <?php
                                    $array_id = (explode(',', $room['id_exam']));
                                    ?>
                                    @if($room['id_exam'] == 0)

                                    @else
                                        @foreach($array_id as $id_exam)
                                            <?php  $exam = \App\Exam\Exam::getExam($id_exam);?>
                                            <p class="mgBottom5 remove{{ $exam['id_exam'] }}"><i class="fa fa-check-square-o f22 mgRight5" aria-hidden="true" style="vertical-align: bottom;"></i> <span
                                                        class="btnGreen pd-05 pd-005 btn-small mgRight5">{{ $exam['code_exam'] }}</span><a
                                                        href="#" class="deleteExamRoom" dataremovea="{{ $exam['id_exam'] }}" datacode="{{ $exam['code_exam'] }}">Xóa khỏi phòng thi</a></p>
                                        @endforeach
                                    @endif

                                    <div class="resultExam">
                                        @if($room['id_exam'] == 0)

                                        @else
                                            @foreach($array_id as $id_exam)
                                                <?php  $exam = \App\Exam\Exam::getExam($id_exam);?>
                                                <input type="hidden" name="examid[{{ $exam['id_exam'] }}]" value="{{ $exam['id_exam'] }}" class="remove{{ $exam['code_exam'] }}" >
                                            @endforeach
                                        @endif

                                        {{--<p class="mgBottom5 remove125"><span class="btnGreen pd-05 pd-005 btn-small mgRight5">MD225</span><a class="deleteExamRoom" dataremovea="remove125">Xóa khỏi phòng thi</a></p>--}}
                                    </div>
                                    <a href="{{ route('room.index') }}" class="btnSmall btnloadding btnGreen mgTop20 dsBlock text-center">
                                        Lưu phòng thi</a>
                                </div>

                                <div class="Resultinput"></div>
                                <div class="form-group">
                                    <input type="hidden" name="id_room" value="{{ $id_room }}">

                                </div>
                            </form>


                        </div>

                    </section>
                </div>
            </div>
        </div>

        <table id="table"></table>
        {{--xu ly input checkbox--}}
        <script>
            $('#changeCategory').change(function(){
                $('#submitFormSearchRoom').submit();
            });
        </script>
        <script>

            //     $('select').change(function() {
            //         $('#submitFormSearchRoom').submit();
            //     });
            //     $('#searchExam').blur(function(){
            //         $('#submitFormSearchRoom').submit();
            //     })
            //
            // function searchExam()
            // {
            //     $('#submitFormSearchRoom').submit();
            // }

            // $('tbody').remove();
            {{--@foreach(\App\Exam\CategoriesExam::getCategories_exam() as $id=>$cate_exam)--}}
            {{--$('.tabOnecategory{{$id + 1}}').change(function(){--}}
            {{--var selectval =  $(this).val();--}}
            {{--// var ma_kh = $(e).val();--}}
            {{--// $('.search .bodyCodeCustomerSearch').empty();--}}
            {{--$.ajax({--}}
            {{--type: "get",--}}
            {{--url: '{!! route('searchExamAjax') !!}',--}}
            {{--data: {--}}
            {{--selectval: selectval,--}}
            {{--},--}}
            {{--success: function(result){--}}
            {{--var obj = jQuery.parseJSON( result);--}}

            {{--$.each(obj.custommer, function(index, element) {--}}
            {{--// $('#example tbody').remove();--}}

            {{--if(((index + 1) % 2) == 0)--}}
            {{--{--}}
            {{--var odd = 'odd';--}}
            {{--}--}}
            {{--else--}}
            {{--{--}}
            {{--var odd = 'even';--}}
            {{--}--}}
            {{--var html = '<tr role="row" class="'+ odd +'">';--}}
            {{--html += '<td class="sorting_1"><input type="checkbox" name="examid['+ element.id_exam +']" value="'+ element.id_exam+'" datacode="'+ element.code_exam+'" class="xoa'+ element.id_exam +'"></td>';--}}
            {{--html += '<td><p class="mgBottom5"><span class="btnGreen pd-05 pd-005 btn-small">'+ element.code_exam+'</span></p></td>';--}}
            {{--html += '<td><p class="mgBottom5"> '+  element.name_exam +'</p></td>';--}}
            {{--html += '<td style="text-align: center"><span style="color: green">20(phút)</span>-<span> <span style="color: red;">0 </span> câu hỏi</span></td>';--}}
            {{--html += '</tr>';--}}
            {{--$('#table').append(html);--}}
            {{--});--}}

            {{--// $('.search .bodySearch ').append('<button class="btn btn-danger" onclick="return submitSearch(this);">Xem tất cả</button>')--}}
            {{--}--}}

            {{--});--}}

            {{--return true;--}}
            {{--});--}}
            {{--@endforeach--}}







            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $('input[type=checkbox]').click(function () {
                if ($(this).is(":checked")) {
                    var valuecheck = $(this).val();
                    var datacode = $(this).attr('datacode');
                    var htmlinput = '<input type="hidden" name="examid';
                    htmlinput += '[' + valuecheck + ']';
                    htmlinput += '" value =';
                    htmlinput += '"' + valuecheck + '"';
                    htmlinput += 'class="remove';
                    htmlinput += '' + datacode + '';
                    htmlinput += '"';
                    htmlinput += '>';
                    $('.Resultinput').append(htmlinput);
                    var htmlspan = '<p class="mgBottom5';
                    htmlspan += ' remove' + valuecheck + '';
                    htmlspan += '">';
                    htmlspan += '<i class="fa fa-check-square-o f22 mgRight5" aria-hidden="true" style="vertical-align: bottom;"></i>';
                    htmlspan += '<span class="btnGreen pd-05 pd-005 btn-small mgRight5">';
                    htmlspan += '' + datacode + '';
                    htmlspan += '</span>';

                    htmlspan += '<a href="#" class="deleteExamRoom" dataremovea="';
                    htmlspan += '' + valuecheck + '';
                    htmlspan += '"';
                    htmlspan += 'datacode=';
                    htmlspan += '"' + datacode + '"';
                    htmlspan += '>';
                    htmlspan += 'Xóa khỏi phòng thi';
                    htmlspan += '</a>';

                    htmlspan += '</p>';
                    $('.resultExam').append(htmlspan);

                    $('#submitFormRoom').submit();


                }
                else {
                    var valuecheck = $(this).val();
                    var datacode = $(this).attr('datacode');
                    $('.remove' + valuecheck + '').remove();
                    $('.remove' + datacode + '').remove();
                    $('#submitFormRoom').submit();


                }

                // alert(datacode);
            });
            $('.deleteExamRoom').click(function(){
                var check = confirm("Bạn có muốn xóa đề thi này khỏi phòng thi không");
                if (check) {
                    var deleteExam = $(this).attr('dataremovea');
                    var deleteCode = $(this).attr('datacode');

                    $('.remove' + deleteExam + '').remove();
                    $('.remove' + deleteCode + '').remove();

                    $('input[type=checkbox]').each(function () {
                        var iteminput = $(this).val();
                        if (iteminput == deleteExam) {
                            // alert(iteminput);
                            $('.xoa' + iteminput + '').prop('checked', false);

                        }
                        else {
                        }
                    });
                    $('#submitFormRoom').submit();
                }

                // alert(deleteExam + deleteCode)
            });
            $('.resultExam').delegate('.deleteExamRoom', 'click', function () {
                var check = confirm("Bạn có muốn xóa đề thi này khỏi phòng thi không");
                if (check) {
                    var deleteExam = $(this).attr('dataremovea');
                    var deleteCode = $(this).attr('datacode');

                    $('.remove' + deleteExam + '').remove();
                    $('.remove' + deleteCode + '').remove();

                    $('input[type=checkbox]').each(function () {
                        var iteminput = $(this).val();
                        if (iteminput == deleteExam) {
                            // alert(iteminput);
                            $('.xoa' + iteminput + '').prop('checked', false);
                            $('#submitFormRoom').submit();

                        }
                        else {

                        }
                    });
                }


                // your code here ...
            });
            @if($room['id_exam'] == 0)
            @else
            $('input[type=checkbox]').each(function(){
                var datavalue= $(this).val();
                @foreach($array_id as $id_exam)
                <?php  $exam = \App\Exam\Exam::getExam($id_exam);?>
                if(datavalue = <?php echo $exam['id_exam'] ?>)
                {
                    $('.xoa' + <?php echo $exam['id_exam'] ?> + '').prop('checked', true);

                }
                else
                {
                    $('.xoa' + <?php echo $exam['id_exam'] ?> + '').prop('checked', false);

                }
                @endforeach
            });
            @endif
            //loc danh sach

        </script>

    </section>

    @include('site.exam_admin_site.delete')
@endsection




