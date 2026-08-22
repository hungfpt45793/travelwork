@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách phần mềm đổi thưởng')
@section('meta_description','Danh sách phần mềm đổi thưởng')
@section('keywords', 'Danh sách phần mềm đổi thưởng' )
@section('meta_image', isset($information['logo']) ?  $information['logo'] : ''  )


@section('content')

    <section class="PagesNewsContent bkxam pdb20 pdt20">
        <div class="container">
            <div class="link bgrWhite mgb20">
                <ul class="nav">
                    <li class="nav-item pd8">

                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                    </li>

                    <li class="nav-item pd8">
                        <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                    </li>
                    <li class="nav-item pd8">
                        <?php
                        $link_url ='#';
                        $link_url = \App\Ultility\Ultility::getUrl();
                        ?>
                        <a class="f18 md-f14 mgb0 clorange"
                           href="{{ $link_url }}">Danh sách phần mềm đổi thưởng</a>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">Danh sách phần mềm đổi thưởng</h1>

                        <table id="jobfb"
                               class="table table-hover table-bordered list_top_product text-center mbdsNone">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên phần mềm</th>
                                <th>Ảnh phần mềm</th>

                                <th>Giá thị trường</th>
                                <th>Giá đổi phần mềm</th>
                                <th>Link chi tiết</th>

                            </tr>
                            </thead>
                            <tbody>
                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                            @foreach($list_product as $id_list=>$product)
                                <tr>
                                    <td>{{ $id_list + 1 }}</td>
                                    <td class="text-left"><a class="clHome_impotar" data-toggle="modal" data-target="#list_product{{ $id_list }}"
                                                             title="{{ isset($product->product_name) ? $product->product_name : '' }}" style="cursor: pointer"
                                        > {{ isset($product->product_name) ? $product->product_name : '' }}</a>
                                        <a class="btnModal" data-toggle="modal" data-target="#list_product{{ $id_list }}">Xem thông tin</a>
                                    </td>
                                    <td class="text-center">
                                        <img class='lazy' data-src="{{ !empty($product->product_image) ? $product->product_image : asset('assets/image/logomb.png') }}"
                                             title="{{ isset($product->product_name) ? $product->product_name : '' }}"
                                             alt="{{ isset($product->product_name) ? $product->product_name : '' }}">
                                    </td>
                                    <td>{{ isset($product->product_price) ? number_format($product->product_price) : '' }}
                                        vnđ
                                    </td>
                                    <td>{{ isset($product->product_discount) ? number_format($product->product_discount) : '' }}
                                        vnđ
                                    </td>

                                    <td>
                                        <a class="clHome"
                                           href="{{ isset($product->product_link) ? $product->product_link : '' }}"
                                           title="{{ isset($product->product_name) ? $product->product_name : '' }}"
                                           target="_blank"> Link chi tiết</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table id="jobfb" class="table table-hover table-bordered list_top_product dsNone mbdsBlock">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thông tin</th>


                            </tr>
                            </thead>
                            <tbody>
                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                            @foreach($list_product as $id_list=>$product)
                                <tr>
                                    <td>{{ $id_list + 1 }}</td>
                                    <td>
                                        <a class="clHome_impotar" data-toggle="modal" data-target="#list_product{{ $id_list }}"
                                           title="{{ isset($product->product_name) ? $product->product_name : '' }}" style="cursor: pointer"
                                        > {{ isset($product->product_name) ? $product->product_name : '' }}</a>
                                        <a class="btnModal" data-toggle="modal" data-target="#list_product{{ $id_list }}">Xem thông tin</a>
                                        <p class="mgb0">
                                            Giá thị trường
                                            :: {{ isset($product->product_price) ? number_format($product->product_price) : '' }}
                                            vnđ
                                        </p>
                                        @if(!empty($product->product_discount))
                                            <p class="mgb0">
                                                Giá đổi phần mềm :
                                                {{ isset($product->product_discount) ? number_format($product->product_discount) : '' }}
                                                vnđ
                                            </p>
                                        @endif
                                        <p class="mgb0">
                                            <a class="clHome"
                                               href="{{ isset($product->product_link) ? $product->product_link : '' }}"
                                               title="{{ isset($product->product_name) ? $product->product_name : '' }}"
                                               target="_blank"> Link chi tiết</a>
                                        </p>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <nav aria-label="Page navigation example" class="">
                                {{ $list_product->links() }}
                            </nav>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12">

                </div>
                {{--//Sider bar--}}

            </div>
        </div>
    </section>
    @if(!empty($list_product))
        @foreach($list_product as $id_list=>$product)
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                 aria-hidden="true" id="list_product{{ $id_list }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ isset($product->product_name) ? $product->product_name : '' }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="contentModalListProduct">
                                {!! isset($product->product_content) ? $product->product_content : '' !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif



@endsection
