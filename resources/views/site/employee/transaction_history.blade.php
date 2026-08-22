@extends('site.layout.site')

@section('title', 'Lịch sử giao dịch')
@section('meta_description', 'Lịch sử giao dịch')
@section('keywords', 'Lịch sử giao dịch')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">



                <div class="col-xl-12 col-lg-12 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20 mgb10">
                        <ul class="nav">
                            <li class="nav-item pd8">

                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">

                                <a href="{{ route('post_sale_employee') }}" class="f18 md-f14 blueDN hvBlueDN"> <i
                                            class="fas fa-donate mgr5"></i>Kiếm tiền từ chia sẻ bài</a>
                            </li>
                        </ul>
                    </div>
                    @include('site.employee.item_list_redeem')
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs textUpper fw7 f18 white bgrBlueN pd10-20 col-f14">

                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">

                                    <div class="CV bgrWhite radius5 pd20 mbpd0  pdb5">
                                        @include('site.employee.item_total_money')
                                    </div>
                                </div>
                                {{--lich sử giao dịch thẻ dt--}}
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt10">
                                        Lịch sử đổi thẻ
                                    </h5>
                                    @if(!empty($transaction_history_card))
                                        <table id="jobfb" class="table table-hover text-center table-bordered mbdsNone">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên nhà mạng</th>
                                                <th>Giá trị tiền nạp</th>
                                                <th>Số điện thoại được nạp</th>
                                                <th>Ghi chú</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đổi thẻ</th>
                                                <th>Admin trả lời</th>
                                                <th>Ngày duyệt</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_card as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>{{ $transaction_history->transaction_card_name }}</td>
                                                    <td>{{ number_format($transaction_history->transaction_card_price) }} VND</td>
                                                    <td>{{ $transaction_history->transaction_card_phone }}</td>

                                                    <td>{{ $transaction_history->transaction_content }}</td>
                                                    <td>
                                                        @if($transaction_history->transaction_status == 0)
                                                            <span class="btnOrang">Chưa duyệt </span>
                                                       @endif
                                                       @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                       @endif
                                                       @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?></p>
                                                        <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?></p>

                                                    </td>
                                                    <td>
                                                        @if(!empty($transaction_history->transaction_admin_reply))
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_card{{$id_tran}}">Xem nội dung </span>
                                                            @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($transaction_history->updated_at))
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->updated_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <table id="jobfb" class="table table-hover text-left table-bordered dsNone mbdsBlock">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th class="w100impotar">Thông tin đổi thẻ</th>
                                                {{--<th>Giá trị tiền nạp</th>--}}
                                                {{--<th>Số điện thoại được nạp</th>--}}
                                                {{--<th>Ghi chú</th>--}}
                                                {{--<th>Trạng thái</th>--}}
                                                {{--<th>Ngày đổi thẻ</th>--}}
                                                {{--<th>Admin trả lời</th>--}}
                                                {{--<th>Ngày duyệt</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_card as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>
                                                        <p class="mgb5">Tên nhà mạng : {{ $transaction_history->transaction_card_name }} </p>
                                                        <p class="mgb5">Giá trị tiền nạp : {{ number_format($transaction_history->transaction_card_price) }} VND </p>
                                                        <p class="mgb5">Số điện thoại được nạp : {{ $transaction_history->transaction_card_phone }}</p>
                                                        <p class="mgb5">Ghi chú : {{ $transaction_history->transaction_content }}</p>
                                                        <p class="mgb5">Trạng thái :
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </p>
                                                        <p class="mgb5">Ngày đổi thẻ :
                                                            <i class="far fa-clock"></i>
                                                            <span class="mgr5">
                                                            <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>
                                                            </span>
                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                        <p class="mgb5">Admin trả lời :
                                                            @if(!empty($transaction_history->transaction_admin_reply))
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_card{{$id_tran}}">Xem nội dung </span>
                                                                @endif
                                                        </p>
                                                        <p class="mgb5">Ngày duyệt :
                                                            @if(!empty($transaction_history->updated_at))
                                                            <i class="far fa-clock"></i>
                                                            <span class="mgr5"><?php
                                                            $date = date_create($transaction_history->updated_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>
                                                            </span>

                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                                @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                </div>
                                {{--lịch sử giao dịch chuyển khoản--}}
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt10">
                                        Lịch sử chuyển khoản
                                    </h5>
                                    @if(!empty($transaction_history_bank))
                                        <table id="jobfb" class="table table-hover text-center table-bordered mbdsNone">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên ngân hàng</th>
                                                <th>Số tiền chuyển khoản</th>
                                                <th>Số tài khoản</th>
                                                <th>Tên chủ tài khoản</th>
                                                <th>Ghi chú</th>
                                                <th>Trạng thái</th>

                                                <th>Ngày đổi thẻ</th>
                                                <th>Admin trả lời</th>
                                                <th>Ngày duyệt</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_bank as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>{{ $transaction_history->transaction_bank_name }}</td>
                                                    <td>{{ number_format($transaction_history->transaction_bank_price) }} VND</td>
                                                    <td>{{ $transaction_history->transaction_bank_number }}</td>
                                                    <td>{{ $transaction_history->transaction_home_name }}</td>
                                                    <td>{{ $transaction_history->transaction_content }}</td>
                                                    <td>
                                                        @if($transaction_history->transaction_status == 0)
                                                            <span class="btnOrang">Chưa duyệt </span>
                                                        @endif
                                                        @if($transaction_history->transaction_status == 1)
                                                            <span class="btnRed">Hủy giao dịch </span>
                                                        @endif
                                                        @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?></p>
                                                        <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?></p>

                                                    </td>
                                                    <td>
                                                        @if(!empty($transaction_history->transaction_admin_reply))
                                                        <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_bank{{$id_tran}}">Xem nội dung </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($transaction_history->updated_at))
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->updated_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <table id="jobfb" class="table table-hover text-left table-bordered dsNone mbdsBlock">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <td class="w100impotar">Thông tin chuyển khoản</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_bank as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>
                                                        <p class="mgb5">Tên ngân hàng : {{ $transaction_history->transaction_bank_name }}</p>
                                                        <p class="mgb5">Số tiền chuyển khoản : {{ number_format($transaction_history->transaction_bank_price) }} VND</p>
                                                        <p class="mgb5">Số tài khoản : {{ $transaction_history->transaction_bank_number }} </p>
                                                        <p class="mgb5">Tên chủ tài khoản : {{ $transaction_history->transaction_home_name }}</p>
                                                        <p class="mgb5">Ghi chú : {{ $transaction_history->transaction_content }}</p>
                                                        <p class="mgb5">Trạng thái :
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif

                                                        </p>
                                                        <p class="mgb5">Ngày đổi thẻ :
                                                            <span class="mgr5">
                                                            <i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>
                                                            </span>
                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                        <p class="mgb5">Admin trả lời :
                                                            @if(!empty($transaction_history->transaction_admin_reply))
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_bank{{$id_tran}}">Xem nội dung </span>
                                                                @endif
                                                        </p>
                                                        <p class="mgb5">Ngày duyệt :
                                                            @if(!empty($transaction_history->updated_at))
                                                                <span class="mgr5">
                                                                    <i class="far fa-clock"></i> <?php
                                                                    $date = date_create($transaction_history->updated_at);
                                                                    echo date_format($date, "H:i:s");
                                                                    ?>
                                                                </span>
                                                                <i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?>
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                </div>
                                {{--lịch sử giao dịch đổi phần mềm--}}
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12">
                                    <h5 class="lt-f18  fw7 bdLeftBlueN5x pdl10 blueN mgb10 mgt10">
                                        Lịch sử đổi phần mềm
                                    </h5>
                                    @if(!empty($transaction_history_product))
                                        <table id="jobfb" class="table table-hover text-center table-bordered mbdsNone">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên phần mềm</th>
                                                <th>Giá thị trường</th>
                                                <th>Giá đổi sản phẩm</th>
                                                <th>Link chi tiết</th>
                                                <th>Ghi chú</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày đổi thẻ</th>
                                                <th>Admin trả lời</th>
                                                <th>Ngày duyệt</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_product as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td class="text-left">{{ $transaction_history->transaction_product_name }}</td>

                                                    <?php $product_link = \App\Transaction\List_product::get_product_id($transaction_history->transaction_product_id)?>

                                                    <td>
                                                        @if(!empty($product_link->product_discount))
                                                            {{ number_format($product_link->product_discount) }}
                                                            @else
                                                            {{ number_format($product_link->product_price) }}
                                                            @endif
                                                        VND

                                                    </td>
                                                    <td>{{ number_format($transaction_history->transaction_product_price) }} VND</td>

                                                    <td>
                                                        <a href="{{ $product_link->product_link }}">Xem chi tiết</a>
                                                    </td>

                                                    <td>{{ $transaction_history->transaction_content }}</td>
                                                    <td>
                                                        @if($transaction_history->transaction_status == 0)
                                                            <span class="btnOrang">Chưa duyệt </span>
                                                        @endif
                                                        @if($transaction_history->transaction_status == 1)
                                                            <span class="btnRed">Hủy giao dịch </span>
                                                        @endif
                                                        @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline" style="padding: 3px 10px;">Đã duyệt </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?></p>
                                                        <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?></p>

                                                    </td>
                                                    <td>   @if(!empty($transaction_history->transaction_admin_reply))
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal"
                                                             data-target="#transaction_product{{$id_tran}}">Xem nội dung </span>
                                                               @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($transaction_history->updated_at))
                                                            <p class="mgb0"><i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->updated_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?></p>
                                                            <p class="mgb0"><i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?></p>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <table id="jobfb" class="table table-hover text-left table-bordered dsNone mbdsBlock">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th class="w100impotar">Thông tin đổi phần mềm</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                                            @foreach($transaction_history_product as $id_tran=>$transaction_history)
                                                <tr>
                                                    <td>{{ $id_tran + 1 }}</td>
                                                    <td>
                                                        <p class="mgb5">Tên phần mềm : {{ $transaction_history->transaction_product_name }}</p>
                                                        <?php $product_link = \App\Transaction\List_product::get_product_id($transaction_history->transaction_product_id)?>
                                                        <p class="mgb5">Giá thị trường :
                                                            @if(!empty($product_link->product_discount))
                                                                {{ number_format($product_link->product_discount) }}
                                                                @else
                                                                {{ number_format($product_link->product_price) }}
                                                                @endif
                                                            VND
                                                            </p>
                                                        <p class="mgb5">Giá đổi sản phẩm : {{ number_format($transaction_history->transaction_product_price) }} VND
                                                        </p>
                                                        <p class="mgb5">Link chi tiết : <a href="{{ $product_link->product_link }}">Xem chi tiết</a> </p>
                                                        <p class="mgb5">Ghi chú : {{ $transaction_history->transaction_content }} </p>
                                                        <p class="mgb5">Trạng thái :
                                                            @if($transaction_history->transaction_status == 0)
                                                                <span class="btnOrang">Chưa duyệt </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 1)
                                                                <span class="btnRed">Hủy giao dịch </span>
                                                            @endif
                                                            @if($transaction_history->transaction_status == 2)
                                                                <span class="btnGreen dsInline"style="padding: 3px 10px;">Đã duyệt </span>
                                                            @endif
                                                        </p>
                                                        <p class="mgb5">Ngày đổi thẻ :
                                                        <span class="mgr5">
                                                            <i class="far fa-clock"></i> <?php
                                                            $date = date_create($transaction_history->created_at);
                                                            echo date_format($date, "H:i:s");
                                                            ?>
                                                        </span>
                                                            <i class="far fa-calendar-times"></i> <?php
                                                            echo date_format($date, "d/m/Y");
                                                            ?>
                                                        </p>
                                                        <p class="mgb5">Admin trả lời :
                                                            @if(!empty($transaction_history->transaction_admin_reply))
                                                            <span class="btnGreen dsInline" style="padding: 3px 10px;" data-toggle="modal" data-target="#transaction_product{{$id_tran}}">Xem nội dung </span>
                                                                @endif
                                                        </p>
                                                        <p class="mgb5">Ngày duyệt :
                                                            @if(!empty($transaction_history->updated_at))

                                                                <i class="far fa-clock"></i> <?php
                                                                $date = date_create($transaction_history->updated_at);
                                                                echo date_format($date, "H:i:s");
                                                                ?>
                                                                <i class="far fa-calendar-times"></i> <?php
                                                                echo date_format($date, "d/m/Y");
                                                                ?>
                                                                @endif
                                                        </p>
                                                    </td>
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

                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    @include('site.partials.delete')




    @if(!empty($transaction_history_card))
        @foreach($transaction_history_card as $id_tran=>$transaction_history)
            <div class="modal fade bd-example-modal-lg" id="transaction_card{{$id_tran}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xem nội dung đổi thẻ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           {!! isset($transaction_history->transaction_admin_reply) ? $transaction_history->transaction_admin_reply  : ''!!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@if(!empty($transaction_history_bank))
        @foreach($transaction_history_bank as $id_tran=>$transaction_history)
            <div class="modal fade bd-example-modal-lg" id="transaction_bank{{$id_tran}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xem nội dung chuyển khoản</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           {!! isset($transaction_history->transaction_admin_reply) ? $transaction_history->transaction_admin_reply  : ''!!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@if(!empty($transaction_history_product))
        @foreach($transaction_history_product as $id_tran=>$transaction_history)
            <div class="modal fade bd-example-modal-lg" id="transaction_product{{$id_tran}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xem nội dung đổi phần mềm </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           {!! isset($transaction_history->transaction_admin_reply) ? $transaction_history->transaction_admin_reply  : ''!!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection