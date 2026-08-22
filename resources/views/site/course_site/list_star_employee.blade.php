@extends('site.layout.site')
@section('type_meta', 'danh sách khóa học ứng viên')
@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">


                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">
                            Danh sách đánh giá khóa học của ứng viên
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                @if(empty($month_star_learn)) <a data-toggle="modal" data-target="#addStarLearn"
                                                                  class="btnOrange mgt15 mgb12 mgLeft15">Đánh giá khóa
                                    học tháng {{ date("m/Y") }}</a>
                                @endif

                                <div class="col-md-12">
                                    @if(!empty($list_star_learn))
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Đánh giá (tháng)</th>
                                                <th scope="col">Chất lượng dạy của giáo viên</th>
                                                <th scope="col">Nội dung đánh giá</th>
                                                <th scope="col">Thao tác</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list_star_learn as $id_star=>$learn)
                                                <tr>
                                                    <th scope="row">{{ $id_star + 1 }}</th>
                                                    <td><?php
                                                        $date_month = date_create($learn->date_month);
                                                        echo date_format($date_month, "m/Y");
                                                        ?></td>

                                                    <td>@if($learn->status_star == 1)
                                                            <a style="padding: 5px 9px; background: green;color: #fff;border-radius: 5px;">Đạt tiêu chuẩn</a>
                                                        @else
                                                            <a style="padding: 5px 9px;background: red; color:#fff;border-radius: 5px;">Không đạt</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $learn->content_star }}</td>
                                                    <td><a data-toggle="modal" data-target="#updateStarLearn{{$id_star}}"  style="background: red;color: #fff;padding: 5px 10px;">Sửa đánh giá</a></td>

                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    @endif


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

    @if(empty($month_star_learn))
        <div class="modal fade" id="addStarLearn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content UpdateUserTab ">
                    <form action="{{ route('addstarlearn') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Đánh giá khóa học
                                tháng {{ date("m/Y") }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body gruopRadio">
                            <label for="exampleFormControlTextarea1">Chất lượng dạy của giáo viên : </label>
                            <div class="switch-field">
                                <input type="radio" id="radio-one" name="status_star" value="1" checked/>
                                <label for="radio-one" class="radioOne">Đạt tiêu chuẩn</label>
                                <input type="radio" id="radio-two" name="status_star" value="0"/>
                                <label for="radio-two" class="radioTwo"> Không đạt</label>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Nội dung đánh giá : </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"
                                          name="content_star"></textarea>
                                <input type="hidden" value="{{ $id_teacher_learn }}" name="id_teacher_learn">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu đánh giá</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif

    @foreach($list_star_learn as $id_star=>$learn)
    <div class="modal fade" id="updateStarLearn{{$id_star}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content UpdateUserTab ">
                <form action="{{ route('updatestarlearn') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Sửa đánh giá khóa học
                            tháng {{ date("m/Y") }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body gruopRadio">
                        <label for="exampleFormControlTextarea1">Chất lượng dạy của giáo viên : </label>
                        <div class="switch-field">
                            <input type="radio" id="radio-one" name="status_star" value="1" @if($learn->status_star == 1) checked @endif/>
                            <label for="radio-one" class="radioOne">Đạt tiêu chuẩn</label>
                            <input type="radio" id="radio-two" name="status_star" value="0" @if($learn->status_star == 0) checked @endif/>
                            <label for="radio-two" class="radioTwo"> Không đạt</label>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Nội dung đánh giá : </label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"
                                      name="content_star">{{ $learn->content_star }}</textarea>
                            <input type="hidden" value="{{ $id_teacher_learn }}" name="id_teacher_learn">
                            <input type="hidden" value="{{ $learn->id_teacher_star_learn }}" name="id_teacher_star_learn">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu đánh giá</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @endforeach



@endsection
