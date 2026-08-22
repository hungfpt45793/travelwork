@extends('site.layout.site')

{{--@section('type_meta', 'website')--}}
@section('title',  $categories_exam['name_cate_exam'])
@section('meta_description',  $categories_exam['name_cate_exam'])
@section('keywords', $categories_exam['name_cate_exam'])
{{--@section('meta_image', !empty($category->image) ?  asset($category->image) : $information['logo'] )--}}
{{--@section('meta_url', '/danh-muc/'.$category->slug)--}}
<?php
$id_cate = $categories_exam['id_cate_exam'];
$categore = \App\Entity\CategoriesExam::getParent($id_cate);

//echo $categore->parent_cate_exam;
?>
<style>

    .active{{ $categore['parent_cate_exam'] }}
     {

    }
    .active{{ $categore['parent_cate_exam'] }}
    {
        background-color: #009385;
        color: #fff !important;
    }

    .active{{ $categore['parent_cate_exam'] }} a
    {
        color: #fff !important;
    }
    .active{{ $categore['parent_cate_exam'] }} i
    {
        color: #fff !important;
    }
    .active{{ $categore['parent_cate_exam'] }} ul.menu-sub
    {
        background-color: #fff;
        color: #333 !important;
    }
    .sidebarHome .active{{ $categore['parent_cate_exam'] }} .menusub2 {
        background: #fff !important;
    }
    .sidebarHome .active{{ $categore['parent_cate_exam'] }} .menusub2 li a {
        color: #009385 !important;
    }
    .sidebarHome .active{{ $categore['parent_cate_exam'] }} .menusub2 li a i{
        color: #009385 !important;
    }
    .sidebarHome .active{{ $categore['parent_cate_exam'] }} .menusub2 li.active{{ $categories_exam['id_cate_exam'] }}
    {
        background: #f5f2f2 !important;
        border-top: 1px solid #009385;
        border-bottom: 1px solid #009385;
    }
    /*#f5f2f2 !important*/



    /*.sidebarHome .menusub3*/
    /*{*/

        /*background: #f5f2f2 !important;*/
    /*}*/
    /*.sidebarHome .menusub3 li a*/
    /*{*/
        /*color: #009385 !important;*/
    /*}*/
    /*.sidebarHome .menusub3 li a i*/
    /*{*/
        /*color: #009385 !important;*/
    /*}*/
</style>


@section('content')
    <section class="main">
        <div class="container">
            <div class="row">
                @include('site.partials.sidebar')

                <div class="col-lg-9 col-md-9 col-sm-12 col-12 categoryQuestion" id="scollExam">
                    <h2 class="clHome dsInline">Các đề thi mới nhất</h2>
                    <form class="dsInline pull-right mbdsBlock" action="{{ route('searchExam') }}" method="GET">
                        {{ csrf_field() }}
                        <input type="text" name="word" placeholder="Tìm kiếm đề thi" class="pd-010">
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

    <script>
        $(document).ready(function(){
         // alert(1);
         //    $('.menusub2').show();
         //    $('.menusub2').show()
            $('.active{{ $categories_exam['id_cate_exam']}}').parent().parent().find('.menusub2').show();

        })
    </script>
@endsection
