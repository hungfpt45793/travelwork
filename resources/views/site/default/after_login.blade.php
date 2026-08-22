@extends('site.layout.site')

@section('title','Đăng tuyển')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

<div class="background">
    <div class="container">
        <div class="row">
        <div class='col-md-12 khung'>
          <h3 class="title">
            Mời ứng viên tham gia phỏng vấn ngay bây giờ ?
          </h3>
            <div class="image">
               <img width='' src="/library/images/giphy.gif" alt="">
            </div>
          <div class="button">
            <a href="{{route('show_create_job')}}" class="btn apply">
                Đăng tuyển ngay 
            </a>
            <a href="/" class="btn btn-info">
              Bỏ qua 
            </a>
          </div>
            
        </div>
    </div>
    </div>
</div>
      <style type="text/css">
        .background .khung{
          position: relative;
        }
        .khung .title{
          width: 100%;
          margin-top:30px;
          margin-bottom:30px;
          font-weight: bold;;
          text-align: center;
          color: #80298f;
          font-size: 24px;
          text-transform: uppercase;
        }
        .khung .image{

         text-align: center;
        }
       .khung .button{
        width: 100%;
        text-align: center;
        bottom: 10px;
        text-transform: uppercase;
        margin-top:30px;
        margin-bottom:30px;
        }
        .khung .apply{
              background: #80298f;
              color: #fff;


        }
      </style>
      
   @if($errors->any() && session('registerEmployee') )
    <script>
        $(document).ready(function() {
            $('#modelId').modal('show');
        });
    </script>
    @endif


@endsection
