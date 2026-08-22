<section class="quickSearchForJobs mgt20 bgrWhite">
    <div class="formSearch pd0">
        <div class="form-group">
            <form id="searchBox" action="{{route('search_index')}}" method="get">
                <div class="content bd15white">
                    <div class="row mg0">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock pd0 bdLightGray noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87" name="career">
                                <option value="">Tất cả Ngành nghề</option>

                                @foreach(App\Entity\Career::getAllCareer() as $career)
                                    <option  value="{{$career['career_category_id']}}"  >{{$career['career_category_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87" name="province">
                                <option value="">Tất cả Tỉnh thành</option>

                                @foreach(App\Entity\Province::getAllProvince() as $province)
                                    <option  value="{{$province['province_id']}}">{{$province['province_name']}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 noBorderRightIm sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                            <select class="w85 noBorder h35x f16 xl-w84 lg-w75 lg-f12 md-w75 md-f13 sm-w87" name="salary">
                                <option value="">Tất cả Mức lương</option>
                                @foreach(App\Entity\Salary::showAllSalary() as $salary)
                                    <option  value="{{$salary['salary_id']}}">{{$salary['description']}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 widthMh14 disInBlock bdLightGray pd0 sm-bdLightGrayIm">
                            <i class="fas fa-list-ul mgl15 mgr15 lg-f12"></i>
                            <select class="w85 noBorder h35x f16 xl-w87 lg-w83 md-w75 md-f13 sm-w87" name="literacy">
                                <option disable value="disable">Trình độ học vấn</option>
                                @foreach(\App\Entity\Literacy::get() as $literacy)
                                    <option value="{{$literacy->literacy_id}}">{{$literacy->literacy_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="searchInput bdLightGray noBorderTopIm">
                        <div class="row mg0">
                            <div class="col-lg-10">
                                <input class="width85 h35x noBorder" type="text" name="word" placeholder="&nbsp; Nhập tiêu đề công việc...">
                            </div>
                            <button class="col-lg-2 text-center mg block bgrBlueN pd6 cursor whiteIm"  type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
</section>