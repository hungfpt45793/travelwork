<div class="row bg_list_price_pree">
    {{--<div class="bg_list_price_pree">--}}
        <div class="col-md-12 text-center title_price_pree">
            <h1>ĐĂNG TIN MIỄN PHÍ - TÌM ỨNG VIÊN CHẤT</h1>
        </div>

            <div class="col-md-6 ">
                <div class="item_box_price box_price_left">
                    <h2 class="text-center">
                        GÓI ĐĂNG TIN MIỄN PHÍ
                    </h2>
                    <div class="list_box_price">
                        {!! !empty($information['goi-dang-tin-mien-phi'])? $information['goi-dang-tin-mien-phi'] : 'Đang cập nhật' !!}
                    </div>
                    <div class="button_list_price text-center">
                        @if (\Illuminate\Support\Facades\Auth::check())
                            @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                                <a href="{{ route('getAllJobs') }}">ĐĂNG KÝ NGAY <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ route('employer_register') }}">ĐĂNG KÝ NGAY <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                            {{--<a data-toggle="modal" data-target="#show_modal_login_res">ĐĂNG KÝ NGAY <i class="fa fa-caret-right" aria-hidden="true"></i></a>--}}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="item_box_price box_price_right">
                    <h2 class="text-center">
                        GÓI ĐĂNG TIN CÓ PHÍ
                    </h2>
                    <div class="list_box_price">
                        {!! !empty($information['goi-dang-tin-co-phi'])? $information['goi-dang-tin-co-phi'] : 'Đang cập nhật' !!}
                    </div>

                    <div class="button_list_price text-center">
                        <a href="{{ route('detail_list_price',['slug'=>'goi-dich-vu-loc-ho-so']) }}#href_table_combo_profile" >XEM CHI TIẾT <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                    </div>
                </div>

            </div>

    {{--</div>--}}
</div>

<div class="modal show_modal_login_res" tabindex="-1" role="dialog" id="show_modal_login_res">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            {{--<div class="modal-header">--}}
            {{--<h5 class="modal-title">Modal title</h5>--}}
            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
            {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
            {{--</div>--}}
            <div class="modal-body">
                <div class="text-center modal_button_header">
                    <img class="lazy" alt="" width="100%" src="https://sanketoan.vn/public/library/images/home_new/Logo.png" style="">
                    <a data-toggle="modal" >Bạn cần phải đăng nhập để đăng ký dịch vụ này</a>
                </div>

                <div class="modal_button_res">
                    <a data-toggle="modal" title="Đăng nhập" data-target="#loginTiva">Đăng nhập</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Để sau</button>
                </div>

            </div>
            {{--<div class="modal-footer">--}}

            {{--</div>--}}
        </div>
    </div>
</div>