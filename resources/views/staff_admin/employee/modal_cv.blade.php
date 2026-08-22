<!-- modal xem cv -->
<div class="modal detailEmployee fade" id="detailEmployee" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="container-fluid">
                <div class="row">

                    <div
                        class="col-xs-12 col-md-12 col-lg-8 col_pdf pl-0 d-flex justify-content-center align-items-center">
                        <h3 class="text-center loading_cv" style="display:none"><i class="fas fa-spinner fa-pulse"></i>
                            Đang tải CV...</h3>
                        <div class="show_cv" style="width:100%">

                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-4 pl-0" style="overflow: scroll;height: 97vh">
                        <button style="background:#f7921a" class="btn btn-sm reload_cv">Tải lại cv</button>
                        <table class="table table-bordered table_info mb-0">
                            <tbody>

                            </tbody>
                        </table>
                        <table class="table table-bordered table_coin">
                            <tbody>

                            </tbody>
                        </table>
                        <ul class="list-group ul_action">
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-reply"></i>
                                <span type="button" class="response" data-toggle="modal" data-target="#response_cv">
                                    Gửi email ứng viên
                                </span>
                            </li>
                            <!-- <li class="list-group-item cus-list-group-item li_delete_request">
                                <input type="checkbox" name="delete_request" id="delete_request">
                                <label for="delete_request" class="delete_request">Đề nghị xóa</label>
							</li> -->
                            <!-- <li class="list-group-item cus-list-group-item li_status_employee">
                                <input type="checkbox" name="employee_status" id="employee_status">
                                <label for="employee_status" class="employee_status mb-0">Duyệt</label>
							</li> -->
                            <li
                                class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="employee_status"
                                        id="radio_approved" value="1">
                                    <label class="form-check-label" for="radio_approved">
                                        Duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="employee_status"
                                        id="radio_un_approved" value="0">
                                    <label class="form-check-label" for="radio_un_approved">
                                        Không duyệt
                                    </label>
                                </div>
                            </li>
                            <!-- <li class="list-group-item cus-list-group-item li_employee_cv_status d-flex justify-content-between align-items-center">
							</li> -->
                            <li
                                class="list-group-item cus-list-group-item li_status_employee d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="follow_status" id="radio_follow"
                                        value="1">
                                    <label class="form-check-label" for="radio_follow">
                                        Theo dõi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="follow_status"
                                        id="radio_un_follow" value="0">
                                    <label class="form-check-label" for="radio_un_follow">
                                        Không theo dõi
                                    </label>
                                </div>
                            </li>
                            <!-- <li class="list-group-item cus-list-group-item li_follow_employee">
                                <input type="checkbox" name="follow_status" id="follow_status">
                                <label for="follow_status" class="follow_status mb-0">Theo dõi</label>
							</li> -->
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-reply"></i>
                                <span type="button" class="evaluate" data-toggle="modal" data-target="#evaluate">
                                    Đánh giá
                                </span>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <a target="_blank" class="text-dark link_edit_form">
                                    <i class="fas fa-pen"></i>
                                    <span>
                                        Chỉnh sửa thông tin
                                    </span>
                                </a>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <a target="_blank" class="text-dark link_interactive">
                                    <i class="fas fa-sync"></i>
                                    <span>
                                        Tương tác
                                    </span>
                                </a>
                            </li>
                            <li class="list-group-item cus-list-group-item">
                                <i class="fas fa-calculator"></i>
                                <span type="button" class="calculator_profile" data-toggle="modal"
                                    data-target="#calculator_profile">
                                    Chỉnh sửa điểm hồ sơ
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal phan hoi uwng vien -->
<div id="response_cv" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phản hồi</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <textarea class="form-control error_border_feedback" name="feedback" id="feedback" rows="6" cols="80"
                    required placeholder="Nhập phản hồi" /></textarea>
                <div class="mess_notice_feedback clearfix note_text_feedback"></div>
                <div class="error_reg_mess clearfix error_text_feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_response">Gửi</button>
            </div>
        </div>
    </div>
</div>
<!-- modal danh gia ung vien -->
<div id="evaluate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đánh giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm đánh giá hồ sơ</label>
                    <input type="number" name="coin_profile" min="0" max="15" placeholder="Điểm đánh giá hồ sơ"
                        class="form-control">
                    <div class="error_coin text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="">Nhận xét</label>
                    <textarea class="form-control" name="content" id="content_evaluate" rows="6" cols="80" required
                        placeholder="Nhập đánh giá" />
                    </textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_evaluate">Đánh giá</button>
            </div>
        </div>
    </div>
</div>
<!-- modal tinh lai diem ho so ung vien -->
<div id="calculator_profile" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! csrf_field() !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa điểm hồ sơ ứng viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Điểm hồ sơ cơ bản</label>
                    <input type="number" name="profile_info" id="profile_info" data-name="Điểm hồ sơ cơ bản" min="0"
                        max="20" class="form-control">
                    <small>Error message</small>
                </div>
                <div class="form-group">
                    <label for="">Điểm CV</label>
                    <input type="number" name="profile_cv" id="profile_cv" data-name="Điểm CV" min="0" max="40"
                        class="form-control">
                    <small>Error message</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary send_caculator_profile">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>