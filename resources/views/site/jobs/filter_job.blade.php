
<figure class="staticMapContainer" data-selenium="static-map-container">
    <div class="tileMapWrapper">
        <img class="static-map-paper lazy" src="https://cdn6.agoda.net/images/MAPS-1213/default/bkg-map-entry.svg">
        <img class="static-map-pin lazy" src="https://cdn6.agoda.net/images/MAPS-1213/default/img-map-pin-red.svg">
    </div>
    <a href=""></a>
    <figcaption class="captionOverImage " data-selenium="static-map-caption">
        <a href="{{route('view_map')}}" class="btn btn-outline-primary">TRÊN BẢN ĐỒ</a>
    </figcaption>
</figure>
<form method="get" action="" id="formFiler">
<div class="hideOnMobile">
        <div id="form_box_search_employer_left" name="form_box_search_employer_left" method="post" role="form" enctype="multipart/form-data" novalidate="novalidate" class="bgrWhite mgb20">
            <div class="righttil bgrTim colorWhite">Ngành nghề</div>
            <div class="box_statistic_nature readmoreCareer">
                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $id => $career)
                    <div class="col {{ ($id > 4) ? !isset($_GET['careers']) ? 'col4 hide' : 'col4' : '' }}">
                        <div class="item">
                            <div class="checkbox checkbox-success">
                                <input name="careers[]" id="checkbox_233" onChange="$('#formFiler').submit();"
                                       class="styled" type="checkbox"
                                       @if (isset($_GET['careers']) && in_array($career->career_category_id, $_GET['careers']) != false)
                                               checked
                                       @endif
                                       value="{{$career->career_category_id}}" data-type="nature">
                                <label for="checkbox_233">{{$career->career_category_name}}</label>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="view_all pd10">
                @if (!isset($_GET['careers']))
                     <a  id="readmoreCareer" onclick="return readmoreCareer(this);">Xem thêm</a>
                    @else
                    <a  id="readmoreCareer" onclick="return readmoreCareer(this);">Đóng</a>
                @endif
            </div>
            <script>
                function readmoreCareer (e) {
                    // xem thêm
                    if ($(e).text() == 'Xem thêm') {
                        $(e).text('Đóng')
                        $('.readmoreCareer').find('.col').removeClass('hide');

                        return ;
                    }
                    // đóng
                    $(e).text('Xem thêm')
                    $('.readmoreCareer').find('.col4').addClass('hide');
                }
            </script>
        </div>
        <div id="form_box_search_employer_left" name="form_box_search_employer_left" method="post" role="form" enctype="multipart/form-data" novalidate="novalidate" class="bgrWhite mgb20">
            <div class="righttil bgrTim colorWhite">Mức lương</div>
            <div class="box_statistic_nature">
                @foreach(\App\Entity\Salary::get() as $salary)
                <div class="col">
                    <div class="item">
                        <div class="checkbox checkbox-success">
                            <input name="salaries[]" id="checkbox_165" onChange="$('#formFiler').submit();"
                                   class="styled" type="checkbox" value="{{$salary->salary_id}}"
                                   @if (isset($_GET['salaries']) && in_array($salary->salary_id, $_GET['salaries']) != false)
                                         checked
                                   @endif
                                   data-type="nature">
                            <label for="checkbox_165">{{ $salary->description }}</label>
                            {{--<span>1281</span>--}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div id="form_box_search_employer_left"  class="bgrWhite mgb20">
            <div class="righttil bgrTim colorWhite">Địa điểm</div>
            <div class="box_statistic_nature moreProvince">
                @foreach(\App\Entity\Province::orderBy('province_name')->get() as $id => $province)
                <div class="col  {{ ($id > 4) ? !isset($_GET['province']) ? 'col4 hide' : 'col4' : '' }}">
                    <div class="item">
                        <div class="checkbox checkbox-success">
                            <input name="province[]" id="checkbox_01" onChange="$('#formFiler').submit();"
                                   class="styled" type="checkbox" value="{{ $province->province_id }}"
                                   @if (isset($_GET['province']) && in_array($province->province_id, $_GET['province']) != false)
                                         checked
                                   @endif
                                   data-type="province">
                            <label for="checkbox_01">{{$province->province_name}}</label>
                            {{--<span>1972</span>--}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="view_all pd10">
                @if (!isset($_GET['careers']))
                    <a  id="readmoreProvince" onclick="return readmoreProvince(this);">Xem thêm</a>
                @else
                    <a  id="readmoreProvince" onclick="return readmoreProvince(this);">Đóng</a>
                @endif
            </div>
        </div>
        @if (isset($_GET['word']))
             <input type="hidden" value="{{ $_GET['word'] }}" name="word">
        @endif

        @if (isset($_GET['city_id']))
            <input type="hidden" value="{{ $_GET['city_id'] }}" name="city_id">
        @endif

</div>
<div class="hideOnDesktop">
	<div class="container">
		<div class="row">
		   <div class="col-md-12 col-sm-12 col-12 mgb20">
			  <p class="titlefil font28 pdb25 textCenter">Tìm kiếm nhanh</p>
			  <div class="row">

				 <div class="col-md-4 col-sm-12 col-12">
					<label>Ngành nghề</label>
					<select class="selectFastJob" name="careers[]" multiple="multiple" placeholder="12hyaklsdl" onChange="$('#formFiler').submit();">
                        @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $id => $career)
                            <option value="{{$career->career_category_id}}"
                            @if (isset($_GET['careers']) && in_array($career->career_category_id, $_GET['careers']) != false)
                            selected
                            @endif
                            >
                                {{ $career->career_category_name }}
                            </option>
                        @endforeach
                   </select>
				 </div>
				 <div class="col-md-4 col-sm-12 col-12">
					<label>Mức lương</label>
					<select class="selectFastDolar" name="salaries[]" multiple="multiple" placeholder="12hyaklsdl" onChange="$('#formFiler').submit();">
                        @foreach(\App\Entity\Salary::get() as $salary)
                            <option value="{{ $salary->salary_id }}"
                                @if (isset($_GET['salaries']) && in_array($salary->salary_id, $_GET['salaries']) != false)
                                selected
                                @endif>
                                {{ $salary->description }}
                            </option>
                        @endforeach
                    </select>
				 </div>
				 <div class="col-md-4 col-sm-12 col-12">
					<label>Địa điểm</label>
					<select class="selectFastCity" name="province[]" multiple="multiple" placeholder="12hyaklsdl" onChange="$('#formFiler').submit();">
                        @foreach(\App\Entity\Province::orderBy('province_name')->get() as $id => $province)
                            <option value="{{ $province->province_id }}"
                                @if (isset($_GET['province']) && in_array($province->province_id, $_GET['province']) != false)
                                selected
                                @endif>
                                {{$province->province_name}}
                            </option>
                        @endforeach
                    </select>
				 </div>
			  </div>      
		   </div>
		</div>
    </div>
</div>
</form>

<style>
    .hide {
        display: none;
    }
</style>
<script>
    function readmoreProvince (e) {
        // xem thêm
        if ($(e).text() == 'Xem thêm') {
            $(e).text('Đóng')
            $('.moreProvince').find('.col').removeClass('hide');

            return ;
        }
        // đóng
        $(e).text('Xem thêm')
        $('.moreProvince').find('.col4').addClass('hide');
    }
	
	$(document).ready(function() {
             $('.selectFastJob').select2({
               placeholder: "Chọn ngành nghề",
               allowClear: true
             });
             $('.selectFastDolar').select2({
               placeholder: "Chọn mức lương",
               allowClear: true
             });
             $('.selectFastCity').select2({
               placeholder: "Chọn tỉnh thành",
               allowClear: true
             });
         });
	
	
</script>
