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
        echo title_case($list_price_hunter->service_price_title);
        @endphp
    </p>
    <table style="border:1px solid #333;width:100%">
        <tr>
            <th rowspan="2" class="text-center">Vị trí cần tuyển</th>
            <th colspan="{{ $hunters_time->count() }}" class="text-center">Thời gian
            </th>
        </tr>
        <tr>
            @foreach ($hunters_time as $hunter_time)
            <th class="text-center">{{ $hunter_time->hunter_time_name }}</th>
            @endforeach
        </tr>
        @foreach ($hunters_pos as $hunter_pos)
        <tr>
            @php
            $hunters_price =
            \App\Http\Controllers\Site\ListPriceController::getHunterPrice($hunter_pos->hunter_pos_id)
            @endphp
            <td class="text-center">{{ $hunter_pos->hunter_pos_name }}</td>
                @foreach ($hunters_price as $hunter_price)
                <td>
                    {{ $hunter_price->hunter_price_name }}
                </td>
                @endforeach
        </tr>
        @endforeach
    </table>
    <div>
        @php
        $hunter = \App\Entity\Service_hunter::get_detail_hunter($list_price_hunter->service_price_id)
        @endphp
        <p style="font-size:1em;font-weight:400;text-transform:uppercase"></p>
        <p>
            {!! strip_tags(nl2br($hunter->service_hunter_info)) !!}
        </p>
        <p>
            {!! strip_tags(nl2br($hunter->service_hunter_pay)) !!}
        </p>
    </div>
    <div style="text-align:center;margin-bottom:10px">
    <span>BÁO GIÁ NÀY ĐƯỢC ÁP DỤNG TRONG 30 NGÀY</span>
    </div>
            Liên hệ: Mrs Dương 0945.254.186 (zalo)
            <br>
            Địa chỉ: Nhà C2 ngõ 206 Thanh Bình, P.Mỗ Lao, Q.Hà Đông, TP Hà Nội
</body>
</html>
