@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', 'Danh sách tốp chia sẻ bài viết')
@section('meta_description','Danh sách bài viết có lượng chia sẻ lớn')
@section('keywords', 'Danh sách bài viết có lượng chia sẻ lớn' )
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
                            <a class="f18 md-f14 mgb0 clorange"
                               href="#">Danh sách tốp chia sẻ bài viết</a>
                        </li>

                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="contentInfoNews bkwhite pd20 bdLightGray">
                        <h1 class="title fontBold mgb10 blueN f18">Danh sách tốp chia sẻ bài viết</h1>

                        <table id="jobfb" class="table table-hover table-bordered list_top_post_sale mbdsNone">
                            <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="">Thông tin người chia sẻ / Nội dung bài viết</th>
                                <th class="text-center">Tổng lượt chia sẻ</th>
                                <th class="text-center">Tổng lượt xem </th>
                                <th class="text-center">Số tiền nhận được</th>
                                <th class="text-center">Thời gian</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                            @foreach($list_post as $id_list=>$post_sale)
                                <tr>
                                    <td class="text-center">{{ $id_list + 1 }}</td>
                                    <?php
//                                        $employee = \App\Entity\Employee::getIdEmployee($post_sale->employee_id);
//                                        $post_money = \App\Entity\Post::get_post_id($post_sale->post_id);
                                    ?>
                                    <td>
                                        <p class="mgb5">
                                            <img class="lazy" data-src="{{ !empty($post_sale->employee_image) ? $post_sale->employee_image : asset('assets/image/avatarUser.png') }}" width="20px" title="{{ $post_sale->employee_name }}" alt="{{$post_sale->employee_name}}"><span>{{ $post_sale->employee_name }}</span>
                                        </p>
                                        <a class="clHome" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_sale->slug]) }}" target="_blank" title="{{ isset($post_sale->title) ? $post_sale->title : '' }}">{{ isset($post_sale->title) ? $post_sale->title : '' }}</a>
                                    </td>
                                    <td class="text-center">{{ number_format($post_sale->total_share) }}  <i class="fas fa-share"></i></td>
                                    <td class="text-center"> {{ number_format($post_sale->total_view_sale) }} <i class="far fa-eye"></i></td>

                                    <td class="text-center">{{ number_format($post_sale->total_money_view) }} VND </td>

                                    <?php $date_day = \App\Ultility\Ultility::getdateFacebook($post_sale->created_at)?>
                                    <td class="text-center"><i class="far fa-clock"></i> {{ $date_day }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table id="jobfb" class="table table-hover table-bordered list_top_post_sale dsNone mbdsBlock">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thông tin</th>
                                {{--<th>Share / Views </th>--}}
                                {{--<th>Số tiền / thời gian</th>--}}
                                {{--<th>Thời gian</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            {{--Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');--}}
                            @foreach($list_post as $id_list=>$post_sale)
                                <tr>
                                    <td>{{ $id_list + 1 }}</td>
                                    <?php
//                                    $employee = \App\Entity\Employee::getIdEmployee($post_sale->employee_id);
//                                    $post_money = \App\Entity\Post::get_post_id($post_sale->post_id);
                                    ?>
                                    <td>
                                        <p class="mgb5">
                                            <img class="lazy" data-src="{{ !empty($post_sale->employee_image) ? $post_sale->employee_image : asset('assets/image/avatarUser.png') }}" width="20px" title="{{ $post_sale->employee_name }}" alt="{{$post_sale->employee_name}}"><span>{{ $post_sale->employee_name }}</span>
                                        </p>
                                        <a class="clHome mgb10" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post_sale->slug]) }}" target="_blank" title="{{ isset($post_sale->title) ? $post_sale->title : '' }}">{{ isset($post_sale->title) ? $post_sale->title : '' }}</a>
                                        <p class="mgb0"> <i class="fas fa-share"></i> Tổng số lượt chia sẻ : {{ number_format($post_sale->total_share) }} </p>
                                        <p class="mgb0"><i class="far fa-eye"></i> Tổng số lượt xem : {{ number_format($post_sale->total_view_sale) }}</p>

                                        <?php $date_day = \App\Ultility\Ultility::getdateFacebook($post_sale->created_at)?>
                                        <p class="mgb0">
                                            <i class="fas fa-money-bill-alt"></i> Số tiền nhận được : {{ number_format($post_sale->total_money_view) }} VND
                                        </p>
                                        <p class="mgb0"><i class="far fa-clock"></i> Thời gian : {{ $date_day }}</p>
                                    </td>
                                    {{--<td>{{ number_format($post_sale->total_share) }} / {{ number_format($post_sale->total_view_sale) }}</td>--}}





                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <nav aria-label="Page navigation example" class="">
                                {{ $list_post->links() }}
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






@endsection
