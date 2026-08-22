<div class="row">
    <div class="col-md-12 ">
        <h1 style="text-transform: uppercase">Bảng giá dịch vụ</h1>
    </div>
    <div class="col-md-12" id="quyenloi_dichvu">
        <h2 class="fw6 mgb15" style="text-transform: uppercase">Quyền lợi khi sử dụng dịch vụ</h2>
        <div class="row">
            @foreach ($service_benifits as $service_benifit)
                <div class="col-md-6">
                    <div class="item_title_service">
                        <h3 class="text-center">  {{ $service_benifit->service_benifit_name }}</h3>
                        <div class="item_content_service">
                            @php
                                $tiems = \App\Entity\Service_name_benifit::where('service_benifit_id', $service_benifit->service_benifit_id)->get();
                            @endphp
                            @foreach ($tiems as $a)
                                <div class="item_border_service">
                                    {!! $a->service_name_benifit_title !!}
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>