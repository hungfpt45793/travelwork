<div class="bgcover">
    <span class="counthome mh14-pdt7 mh10-pdt10 mh76-pdt13">VIỆC BAO LA - CHỌN THẢ GA !</span>
    <div class="boxsearch">
        <form action="{{ isset($linkSearch) ? $linkSearch : '' }}" method="get">
            <input type="text" name="word" value="{{ (isset($_GET['word']) ? $_GET['word'] : '' ) }}" id="txtSearch" autocomplete="off" placeholder="Nhập chức danh, công việc, vị trí...">
            <div id="ulSugguest" class="dsInBlock"></div>
            <div class="selectContry" style="display:inline-block;width:21%;">
                <select id="selProvince" name= "city_id" style="padding:20px;font-size:16px;width:100%">
                    <option value="0">--Chọn khu vực--</option>
                    @foreach(\App\Entity\Province::orderBy('province_name')->get() as $province)
                        <option value="{{$province->province_id}}"
                                {{ (isset($_GET['city_id']) && $_GET['city_id'] == $province->province_id ? 'selected' : '' ) }}
                        >{{$province->province_name}}</option>
                    @endforeach
                </select>
            </div>
            <button id="btnSearch" type="submit"><span>Tìm Việc</span></button>
        </form>
    </div>
</div>