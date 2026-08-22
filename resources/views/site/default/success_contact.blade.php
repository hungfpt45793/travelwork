@extends('site.layout.site')

@section('title','Liên hệ thành công')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
        <section class="Contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="f24 clhome fw6 mgt20 mgb20">Hòm thư góp ý</h1>
                        <p>Cảm ơn bạn đã góp ý cho chúng tôi, chúng tôi sẽ sớm phản hồi sớm nhất đến bạn</p>

                    </div>
                </div>
            </div>

        </section>


@endsection
