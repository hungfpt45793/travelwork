@extends('site.layout_site.site')

@section('title', 'Đổi mật khẩu thành công')
@section('meta_description', 'Đổi mật khẩu thành công')
@section('keywords', 'Đổi mật khẩu thành công')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container container_w_1200 ">
            <div class="row ">

                <div class="col-xl-9 col-lg-12 col-md-12 col-12 col-12 dcontent">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                             style="margin-top: 15px;">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="CV bgrWhite radius5 pd20 mgt20 mgb20 pdb5 UpdateUserTab">
                        @if(!empty($message_success))
                            <p class="mgb15 clGreen f18 fw6">{{ $message_success }} ,Đăng nhập tại đây <span style="background: orange;
    display: inline-block;
    margin-block: 0;
    cursor: pointer;
    padding: 5px 18px;"  data-toggle="modal" data-target="#loginTiva">Đăng nhập </span > </p>
                        @endif

                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
