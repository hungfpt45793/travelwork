@extends('site.layout.site')

@section('title', isset($information['meta_title']) ? $information['meta_title'] : '')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
              <h1>Lỗi 404 </h1>

            </div>
        </div>
    </section>

@endsection


<!--END  MODAL -->