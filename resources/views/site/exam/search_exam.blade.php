@extends('site.layout.site')

{{--@section('type_meta', 'website')--}}
@section('title', 'Tìm kiếm đề thi')
@section('meta_description',  'Mô tả đề thi')
@section('keywords', '')
{{--@section('meta_image', !empty($category->image) ?  asset($category->image) : $information['logo'] )--}}
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}


@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                @include('site.partials.sidebar')

                <div class="col-lg-9 col-md-9 col-sm-12 col-12 categoryQuestion" id="scollExam">
                    <h2 class="clHome dsInline">Từ khóa tìm kiếm : <span style="text-transform: lowercase;">{{ isset($_GET['word']) ? $_GET['word'] : '' }}</span></h2>
                    <form class="dsInline pull-right mbdsBlock" action="{{ route('searchExam') }}" method="GET">
                        {{ csrf_field() }}
                        <input type="text" name="word" placeholder="Tìm kiếm đề thi" class="pd-010" value="{{ isset($_GET['word']) ? $_GET['word'] : '' }}">
                        <button type="submit" class="bgHome clwhite btnloadding" style="border: none;padding: 3px 7px;"> Tìm kiếm </button>
                    </form>
                    <div class="clearfix"></div>
                    <!--                    --><?php //print_r($exams) ?>
                    @if(!empty($exams))
                        @foreach($exams as $exam)
                            @include('site.partials.item_exam')
                        @endforeach
                    @endif
                    <nav aria-label="Page navigation example">
                        @include('site.default.item_pani',['page_link' => $exams])
                       
                    </nav>

                </div>

            </div>
        </div>
    </section>
@endsection

