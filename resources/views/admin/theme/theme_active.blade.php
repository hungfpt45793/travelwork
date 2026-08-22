@extends('admin.layout.admin')

@section('title', 'Thay đổi theme' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lựa chọn theme
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Lựa chọn theme</a></li>
        </ol>
    </section>
    @if ($user->role == 4 || $user->vip != 0)
    <section class="content">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @foreach ($groupThemes as $id => $group)
                <li role="presentation" class="{{ ($id == 0) ? 'active' : '' }}"><a href="#{{ $group->group_id }}" aria-controls="home" role="tab" data-toggle="tab">{{ $group->name }}</a></li>
                @endforeach
            </ul>

            <!-- Tab panes -->
            <div class="tab-content themeActive clearfix">
                @foreach ($groupThemes as $id => $group)
                <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $group->group_id }}">
                    @foreach ($themes as $theme)
                        @if ($theme->group_id == $group->group_id)
                        <div class="col-xs-12 col-md-4">
                            <div class="itemTheme tg-hover">
                                <div class="backgroundPC">
                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                </div>
								<div class="CropImg">
										<div class="image thumbs">
											<img src="{{ $theme->image }}" title="{{ $theme->name }}" style="max-width: 100%"/>
										</div>
								</div>
								
                                <div class="title">
                                    {{ $theme->name }}
                                    @if (in_array($theme->theme_id, $themeUses) != false)
                                        <i class="gray"> ( Đã sử dụng )</i>
                                    @endif
                                </div>
                                <div class="showActive">
                                    <p class="price">
                                        Giá: {{ ( empty($theme->price) || ($theme->price <= 0) ? 'Miễn phí' : $theme->price.' VND' ) }}
                                    </p>
                                    @if (in_array($theme->theme_id, $themeUses) != false)
                                        <p class="domainUse">Đã được sử dụng với domain
                                            @foreach ($domainUses as $id => $domain)
                                                @if ($theme->theme_id = $domain->theme_id)
                                                    {{ ($id != 0) ? ',' : '' }}<a href="{{ $domain->url }}" target="_blank">{{ $domain->name }}</a>
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                    <div class="button">
                                        <a href="{{ $theme->url_test }}" class="btn btn-primary" target="_blank">Xem thử</a>
                                        @if (in_array($theme->theme_id, $themeUses) != false)
                                            <a class="btn btn-danger" idTheme="{{ $theme->theme_id }}" disabled="">Đang sử dụng</a>
                                        @elseif ($user->vip == 2 || ($user->vip == 1 && count($themeCodeUse) < 3 ) )
                                            <a class="btn btn-danger" idTheme="{{ $theme->theme_id }}" onclick="return addTheme(this);">Sử dụng</a>
                                        @elseif(count($themeCodeUse) == 3 && in_array($theme->code, $themeCodeUse) != false)
                                            <a class="btn btn-danger" idTheme="{{ $theme->theme_id }}" onclick="return addTheme(this);">Sử dụng</a>
                                        @else
                                            <a class="btn btn-danger"  disabled="">Bạn không có quyền sử dụng</a>
                                        @endif
                                    </div>
                                    <div class="imagePhone">
                                        <img  src="{{ asset('image/mobile.svg') }}" />
                                        <img class="imageMainPhone" src="{{ $theme->image_phone }}" title="{{ $theme->name }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </section>
        @else
        <section class="content">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Bạn không có quyền sử dụng thêm theme</h3>

                    <p>Bạn không có quyền sử dụng thêm theme, để sử dụng thêm theme vui lòng liên hệ với chúng tôi.</p>
                    <p>Hotline: 093455 3435 - 097 456 1735</p>
                    <p><i>Trân thành cảm ơn!</i></p>
                </div>
            </div>
        </section>
    @endif
    @include('admin.partials.popup_active_theme')
@endsection
