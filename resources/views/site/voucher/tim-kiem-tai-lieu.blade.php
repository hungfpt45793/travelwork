@extends('site.layout.site')
@section('title', 'tim-kiem-tai-lieu')
@section('meta_description', 'tim-kiem-tai-lieu')
@section('keywords', 'tim-kiem-tai-lieu')
@section('content')
    <style>
        .MenudsNone
        {
            width: 100%;
            display: inline-flex;
            margin: 0 auto;
            text-align: center;
        }
        .MenudsBlock
        {
            display: none;
        }

        @media(max-width: 500px)
        {
            .MenudsNone
            {
                width: 100%;
                display: block !important;
                margin: 0 auto;
                text-align: center;
            }
            .MenudsBlock
            {
                display: none !important;
            }
        }
    </style>

    <section class="content pdt20 bgrGray">
        <div class="container bg-white">
            <div class="row"style="padding-bottom: 30px">
                <div class="col-12">
                    <h1 class="white fw7 mgb0 f24" style="color: #009385;padding: 15px 0">Từ khóa tìm kiếm :  {{ isset($_GET['name_voucher']) ? $_GET['name_voucher'] : '' }}</h1>
                </div>
                @foreach($vouchers as $voucher)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12 pd0">
                        @include('site.voucher.item_voucher')
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 pull-right text-right">
                    <nav aria-label="Page navigation example">
                        {{ $vouchers->links() }}

                    </nav>
                </div>
            </div>
            <style>
                .pagination li {
                    padding: 4px 12px;
                    color: #333;
                    border: 1px solid #eee;
                    margin: 5px;
                    cursor: pointer;
                }
            </style>



        </div>
    </section>
@endsection

