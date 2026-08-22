@extends('site.layout.site')

{{--@section('type_meta', 'website')--}}
@section('title',  $categories_exam['name_cate_exam'])
@section('meta_description',  $categories_exam['name_cate_exam'])
@section('keywords', $categories_exam['name_cate_exam'])
{{--@section('meta_image', !empty($category->image) ?  asset($category->image) : $information['logo'] )--}}
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}

<style>
    .active{{ $categories_exam['id_cate_exam'] }}
    {
        background-color: #009385;
        color: #fff !important;
    }
    .active{{ $categories_exam['id_cate_exam'] }} a
    {
        color: #fff !important;
    }
    .active{{ $categories_exam['id_cate_exam'] }} i
    {

        color: #fff !important;
    }
    .active{{ $categories_exam['id_cate_exam'] }} ul.menu-sub
    {
        background-color: #fff;
        color: #333 !important;
    }
    .active{{ $categories_exam['id_cate_exam'] }} ul.menu-sub li a
    {
        color: #333 !important;
    }
    .active{{ $categories_exam['id_cate_exam'] }} ul.menu-sub li a i
    {
        color: #333 !important;
    }
</style>


@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                @include('site.partials.sidebar')

                <div class="col-lg-9 col-md-9 categoryQuestion" id="scollExam">
                    <h2 class="clHome dsInline">{{ $categories_exam['name_cate_exam'] }}</h2>
                    <form class="dsInline pull-right" action="{{ route('searchExam') }}" method="GET">
                        {{ csrf_field() }}
                        <input type="text" name="word" placeholder="Tìm kiếm đề thi" class="pd-010">
                        <button type="submit" class="bgHome clwhite btnloadding" style="border: none;padding: 3px 7px;"> Tìm kiếm </button>
                    </form>
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

    <script>
        $(document).ready(function(){
            // alert(1);
            //    $('.menusub2').show();
            //    $('.menusub3').show()
            $('.active{{ $categories_exam['id_cate_exam']}}').parent().parent().parent().parent().find('.menusub2').show();
            $('.active{{ $categories_exam['id_cate_exam']}}').parent().parent().find('.menusub3').show();
            {{--$('.active{{ $categories_exam['id_cate_exam']}}').parent().parent().find('.menusub2').show();--}}
            {{--$('.active{{ $categories_exam['id_cate_exam']}}').parent().parent().parent().find('.menusub2').show();--}}



            {{--$('.active{{ $categories_exam['id_cate_exam']}}').find('.menusub3').show();--}}
            // tao them 1 danh muc cap 3
        })
    </script>
@endsection
