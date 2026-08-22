{{--//phuong thuc tu include--}}
{{--<?php $infomation_coin_employer = \App\Entity\Coin_type_information_employer::get_coin_info(); ?>--}}
{{--//truong hop chua dang nhap--}}
{{--<!-- modal cv ung vien -->--}}
{{--<div class="modal detailEmployee fade" id="detailEmployeeCv" tabindex="-1" role="dialog"--}}
    {{--aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-dialog-centered" role="document">--}}
        {{--<div class="modal-content">--}}
            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
            {{--<div class="container-fluid">--}}
                {{--<div class="row">--}}
                    {{--<div--}}
                        {{--class="col-sm-12 col-12 col-md-12 col-lg-8 col-xl-8 col_pdf pl-0 order-sm-12 order-12 order-md-12 order-lg-1 order-xl-1 d-flex justify-content-center align-items-center">--}}
                        {{--<h3 class="text-center loading_cv"  style="display:none"><i class="fas fa-spinner fa-pulse"></i> Đang tải CV...</h3>--}}
                        {{--<div class="show_cv" style="width:100%">--}}
                           {{----}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-12 col-12 col-md-12 col-lg-4 col-xl-4 pl-0 col_info order-1 order-xl-12 order-md-1 order-xs-1 order-lg-12" style="overflow: scroll">--}}
                        {{--<button style="background:#f7921a; color:#fff" class="btn btn-sm reload_cv disOnMobile">Tải lại cv</button>--}}
                        {{--<table class="table table-bordered table_info mb-0" style="margin-top:0rem">--}}
                            {{--<tbody class="info_contact">--}}
                            {{--</tbody>--}}
                            {{--<tbody class="info_different">--}}

                            {{--</tbody>--}}
                        {{--</table>--}}
                        {{--<table class="table table-bordered table_coin">--}}
                            {{--<tbody>--}}

                            {{--</tbody>--}}
                        {{--</table>--}}
                        {{--<ul class="list-group ul_action">--}}
                            {{--<li class="list-group-item cus-list-group-item">--}}
                                {{--<i class="fas fa-hand-spock text-success"></i>--}}
                                {{--<!-- <span type="button" class="invite_employee" data-toggle="modal"--}}
                                    {{--data-target="#invite_employee">--}}
                                    {{--Mời ứng tuyển--}}
                                {{--</span> -->--}}
                                {{--<a class="a_invite_employee" target="_blank" href="#">--}}
                                    {{--Mời ứng tuyển--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="list-group-item cus-list-group-item">--}}
                                {{--<i class="fas fa-star text-warning"></i>--}}
                                {{--<span type="button" class="vote_employee">--}}
                                    {{--Đánh giá ứng viên--}}
                                {{--</span>--}}
                            {{--</li>--}}
                            {{--<li class="list-group-item cus-list-group-item">--}}
                                {{--<i class="fas fa-reply-all text-success"></i>--}}
                                {{--<span type="button" class="response_employee" data-toggle="modal"--}}
                                    {{--data-target="#response_employee">--}}
                                    {{--Phản hồi chất lượng CV--}}
                                {{--</span>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<button style="background:#f7921a; color:#fff" class="btn btn-sm reload_cv disOnDes showOnMobile">Tải lại cv</button>--}}
                        {{--<div class="title_employer_response mt-2">--}}
                            {{----}}
                        {{--</div>--}}
                        {{--<div class="employer_response mt-2">--}}
                            {{----}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<!-- modal danh gia ung vien  -->--}}
{{--<div id="vote_employee" class="modal fade" role="dialog">--}}
    {{--<div class="modal-dialog">--}}
        {{--{!! csrf_field() !!}--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<h4 class="modal-title">Đánh giá ứng viên</h4>--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<div class="employer_vote_star"></div>--}}
                {{--<input type="hidden" name="vote_star">--}}
                {{--<!-- <span class="live-rating"></span> -->--}}
                {{--<div class="form-group">--}}
                    {{--<label for="">Nhận xét</label>--}}
                    {{--<textarea name="comment" id="textarea_comment_star" cols="30" rows="5" class="form-control"></textarea>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>--}}
                {{--<button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<!-- modal phan hoi chat luong cv  -->--}}
{{--<div id="modal_response_employee" class="modal fade" role="dialog">--}}
    {{--<div class="modal-dialog">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<h4 class="modal-title">Phản hồi chất lượng CV</h4>--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<div class="form-group">--}}
                    {{--<label for="">Chọn phản hồi</label>--}}
                    {{--<select name="response[]" id="response" class="select2 form-control" multiple="multiple">--}}
                        {{--<?php $responses = \App\Entity\Employer_select_response::all(); ?>--}}
                        {{--@foreach($responses as $response)--}}
                            {{--<option value="{{ $response->employer_select_response_id }}">--}}
                                {{--{{ $response->response }}--}}
                            {{--</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="">Nội dung</label>--}}
                    {{--<textarea name="response_diff" id="response_diff" cols="30" rows="5" class="form-control"></textarea>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>--}}
                {{--<button type="submit" class="btn btn-primary send_response_cv">Phản hồi</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
































{{--<!-- @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 2)--}}

{{--<div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >--}}

        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                {{--</div>--}}

                {{--<div class="modal-body">--}}

                    {{--<?php--}}
                    {{--//  $employer = \App\Entity\Employer::getIdUser(\Illuminate\Support\Facades\Auth::user()->id); --}}
                    {{--?>--}}

                    {{--@if(!empty($employer->total_employer_coin))--}}
                        {{--<p class="mgb0 clgreen">--}}
                            {{--Nhà tuyển dụng còn  : {{ number_format($employer->employer_coin )}} điểm--}}

                        {{--</p>--}}
                    {{--@else--}}
                        {{--<p class="mgb0 clgreen">--}}
                            {{--<?php--}}
                            {{--// $coin_infomation = \App\Entity\Coin_type_information_employer::get_coin_info();--}}
                            {{--// $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);--}}
                            {{--// $coin_money = $coin_infomation['so-diem-mien-phi-theo-ngay'] - $history_coin;--}}
                            {{--?>--}}
                            {{--Điểm miễn phí : {{ isset($coin_money) ? $coin_money : '0' }} điểm--}}
                        {{--</p>--}}
                    {{--@endif--}}

                    {{--@if(!empty($check_contact_employee))--}}


                        {{--<p class="mgb0"><span>Thông tin liên hệ của ứng viên : <strong>{{ isset($employee->employee_name) ? $employee->employee_name : '' }}</strong></span>--}}
                        {{--</p>  <p class="mgb0"><span>Email : <strong>{{ isset($employee->email) ? $employee->email : '' }}</strong></span>--}}
                        {{--</p>--}}
                        {{--<p class="mgb0">--}}
                            {{--<span>Số điện thoại : <strong>{{ isset($employee->phone) ? $employee->phone : '' }}</strong></span>--}}
                        {{--</p>--}}
                        {{--<p class="mgb10">--}}
                            {{--<span>Link facebook : <strong>{{ isset($employee->my_facebook) ? $employee->my_facebook : '' }}</strong></span>--}}
                        {{--</p>--}}
                        {{--@else--}}

                        {{--@endif--}}

                        {{--{!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}--}}


                {{--</div>--}}

                {{--<div class="modal-footer" style="text-align: center;display: block">--}}
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@else -->--}}
    {{--<div class="modal fade" id="contac_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title" id="exampleModalLabel">Thông tin liên hệ</h5>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                {{--</div>--}}

                {{--<div class="modal-body">--}}
                    {{--<p>Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin liên hệ ứng viên ! <a href="#"--}}
                                                                                                          {{--data-toggle="modal"--}}
                                                                                                          {{--data-target="#loginTiva">--}}
                            {{--Đăng nhập tại đây !</a></p>--}}
                    {{--<p>Nếu bạn chưa có tài khoản bạn có thể <a href="{{ route('employer_register') }}"> Đăng kí tại--}}
                            {{--đây</a></p>--}}
                    {{--{!! isset($infomation_coin_employer['huong-dan-nap-diem-xem-ho-so']) ? $infomation_coin_employer['huong-dan-nap-diem-xem-ho-so'] : 'Đang cập nhật thông tin' !!}--}}
                {{--</div>--}}

                {{--<div class="modal-footer" style="text-align: center;display: block">--}}
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--<!-- @endif -->--}}