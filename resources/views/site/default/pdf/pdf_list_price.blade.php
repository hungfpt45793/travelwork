<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    table{
        border-collapse: collapse
    }
    tr th, tr td{
        border:1px solid #333;
        padding:8px 4px;
    }
    tr th{
        text-align: center;
    }
    td.price{
        text-align:right;
    }
    td.ck{
        text-align:center;
    }
    table.document-header,
    table.document-header tr,
    table.document-header td {
        border: 0;
        padding: 0;
    }
    footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                text-align: center;
                line-height: 1.5cm;
            }
</style>
</head>
<body>
    <table class="document-header" style="width:100%">
        <tr>
            <td><img style="height:40px;width:220px" src="{{ public_path('assets/image/logo2.jpg') }}" alt="Sàn Kế Toán"></td>
            <td style="text-align:right;vertical-align:top">Ngày <?php echo date("d") ?> Tháng <?php echo date("m") ?> Năm <?php echo date("Y") ?></td>
        </tr>
    </table>
    <h2 style="text-align: center">BẢNG BÁO GIÁ</h2>
    <p style="text-align: center; font-size:1.2em;text-transform:uppercase">
        @php
        echo title_case($list_price->service_price_title);
        @endphp
    </p>
    <table style="border:1px solid #333;width:100%">
        <thead>
            <tr>
                <th>Số tuần</th>
                <th>Giá (vnđ)</th>
                <th>Chiết khấu</th>
                <th>Giá sau CK (vnđ)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $table_prices =
            \App\Entity\Service_table_price::getTablePrices($list_price->service_price_id);
            @endphp
            @foreach ($table_prices as $table_price)
            <tr>
                <td>
                    <label>{{ $table_price->package_name }}</label>
                </td>
                <td class="price">{{ $table_price->package_price }}</td>
                <td class="ck">{{ $table_price->package_discount }}</td>
                <td class="price">{{ $table_price->package_vat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <p style="font-size:1em;font-weight:400;text-transform:uppercase">{{ $table_prices[0]->package_name }}:</p>
        <p>
            {!! strip_tags(nl2br($table_prices[0]->benifit)) !!}
        </p>
        <p>
            {!! strip_tags(nl2br($table_prices[0]->endow)) !!}
        </p>
    </div>
    <div style="text-align:center;margin-bottom:10px">
    <span>BÁO GIÁ NÀY ĐƯỢC ÁP DỤNG TRONG 30 NGÀY</span>
    </div>
    {{-- <footer> --}}
        {{-- <div style="float:right"> --}}
            Liên hệ: Mrs Dương 0945.254.186 (zalo)
            <br>
            Địa chỉ: Nhà C2 ngõ 206 Thanh Bình, P.Mỗ Lao, Q.Hà Đông, TP Hà Nội
        {{-- </div> --}}
    {{-- </footer> --}}
</body>
</html>
