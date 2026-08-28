@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', 'Việc làm mong muốn')

@section('content')

    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Việc làm mong muốn</a>
                            </li>

                        </ul>
                    </div>

                    @if(session('success_job_desired'))
                        <div id="job_desired_success_message"
                             class="alert alert-success alert-dismissible fade show mgt20" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success_job_desired') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{--@include('site.filter.filter_job')--}}
                    <div class="titleDoor">
                        <!-- <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                        <!--  <div class="text-center inBlock textUpper f20 w32 xl-w37 lg-w38 lg-f16 sm-f14 sm-w57 col-w100 blueDN fw7">
                             <p>DANH SÁCH TẤT CẢ VIỆC LÀM</p>
                         </div> -->
                        <!--  <div class="underLineX h1x w32 xl-w31 lg-w30 sm-w20 bgrBlueN inBlock mgb5 col-none"></div> -->
                    </div>

                    <section class="jobsInteresting bgrWhite  radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                           Tìm kiếm việc làm
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                <div class="col-lg-12">

                                    <?php
                                    $array_career_category_id = isset($jobs_desired['career_category_id']) ? explode(',', $jobs_desired['career_category_id']) : array();
                                    $array_salary_id = isset($jobs_desired['salary_id']) ? explode(',', $jobs_desired['salary_id']) : array();
                                    $array_district_id = isset($jobs_desired['district_id']) ? explode(',', $jobs_desired['district_id']) : array();
//                                    echo '<pre>';
//                                    print_r($array_district_id);
//                                    print_r($array_career_category_id);
                                    ?>

                                <form role="form" action="{{ route('check_job_desired') }}" method="POST" class="pd15">
                                    {!! csrf_field() !!}
                                    {{ method_field('POST') }}

                                    <div class="form-row borderSelect2 mgb15">
                                        <div class="col">
                                            <label class="fw6" for="exampleInputEmail1">Chọn vị trí tuyển dụng</label>
                                            <select class="js-example-basic-single select2 form-control " name="career_category_id[]" multiple>
                                                <option value=""> -- Chọn vị trí --</option>
                                                @foreach(\App\Entity\Career::orderBy('career_category_name')->get() as $career)
                                                    <option value="{{$career->career_category_id}}"
                                                            @if(in_array($career->career_category_id, $array_career_category_id)) selected @endif
                                                    >{{$career->career_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="fw6" for="exampleInputEmail1">Chọn mức lương</label>
                                            <select class="js-example-basic-single select2 form-control" name="salary_id[]" multiple>
                                                <?php
                                                $salaries = \App\Entity\Salary::showAllSalary();
                                                ?>
                                                <option value=""> -- Chọn mức lương --</option>
                                                @foreach($salaries as $salary)
                                                    <option value="{{$salary->salary_id}}"
                                                            @if(in_array($salary->salary_id, $array_salary_id)) selected @endif
                                                    >{{$salary->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row borderSelect2 mgb15">
                                        <div class="col">
                                            <label class="fw6" for="exampleInputEmail1">Chọn tỉnh / thành tuyển dụng</label>
                                            <select class="form-control select2 " name="province" aria-label="Tỉnh/Thành phố" id="city">
                                                <option value="0">-- Chọn Tỉnh/Thành phố --</option>
                                                @foreach(\App\Entity\Province::orderBy('sort_id')->get() as $province)
                                                    <option value="{{$province->province_id}}"
                                                            @if(!empty($jobs_desired['province_id']) && $jobs_desired['province_id'] == $province->province_id ) selected @endif
                                                    >{{$province->province_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="fw6" for="exampleInputEmail1">Chọn quận / huyện tuyển dụng</label>
                                            <select class="form-control select2 " name="district[]" aria-label="Quận/Huyện" id="county" multiple>
                                                <option value="0">-- Chọn Quận/Huyện --</option>
                                                @if(!empty($jobs_desired['province_id']))
                                                    @foreach(\App\Entity\District::get_province_id($jobs_desired['province_id']) as $district)
                                                        <option value="{{$district->district_id}}"
                                                                @if(in_array($district->district_id, $array_district_id)) selected @endif
                                                        >{{$district->district_name}}</option>
                                                    @endforeach

                                                @else
                                                    @foreach(\App\Entity\District::orderBy('district_name')->get() as $district)
                                                        <option value="{{$district->district_id}}"
                                                                @if(in_array($district->district_id, $array_district_id)) selected @endif
                                                        >{{$district->district_name}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btnOrange">Lưu thông tin</button>
                                    </div>

                                </form>
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function() {

                                        $(".select2").select2({
                                            maximumSelectionLength: 3,
                                            language: {
                                                // You can find all of the options in the language files provided in the
                                                // build. They all must be functions that return the string that should be
                                                // displayed.
                                                maximumSelected: function (e) {
                                                    return 'Bạn chỉ có thể chọn tối đa 3 giá trị !';
                                                }
                                            }
                                        });

                                    });
                                </script>
                            </div>


                        </div>
                    </section>


                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs  fw6 f20 white bgrBlueN pd10-20 col-f14">
                            <h1 class="titleJobs  fw6 f20 mgb0 col-f14">
                                Việc làm du lịch
                            </h1>

                            {{--( {{ isset($total) ? $total : '0'  }} việc làm)--}}
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            <div class="row">
                                {{--//truyen bien hien thi image trng serach de biet tin la tin gi--}}
                                @foreach($list_jobs as $job)
                                    @include('site.jobs.item_job',['image'=>'job'])
                                @endforeach

                                @foreach ($list_job_fb as $jobFacebook)
                                    @include('site.job_facebook.item_job_facebook',['image'=>'job_fb'])
                                @endforeach
                            </div>
                        </div>



                    </section>
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="row">
                            <div class="col-12 text-center">
                                @if($total_jobs < 10 && $total_job_fb < 10)
                                @elseif($total_jobs >= $total_job_fb && $total_jobs == 0)
                                    @include('site.default.item_pani',['page_link' => $total_jobs])
                                @else
                                    @include('site.default.item_pani',['page_link' => $list_job_fb])
                                @endif

                            </div>
                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')


                </div>
            </div>
            @include('site.module_index.hotline')
        </div>
    </section>
    <script>
        // chon thanh pho ra quan huyen
        $('#city').change(function () {
            var city = $(this).val();
            $.get('/tim-kiem-huyen/' + city , function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
        });
    </script>
    @if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role == 1)

        <?php
        $employee = '';
        $employee = \App\Entity\Employee::getEmployee_id(\Illuminate\Support\Facades\Auth::user()->id);
        ?>

        <script>
            // $('.js_employee_follow_employer').click(function () {
            $('.js_delete_follow_employer').click(function () {

                var elenment_hide =$(this).parent();

                var employer_id = $(this).attr('id_employer');
                console.log(employer_id);
                console.log({{ $employee['employee_id'] }});
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    url: '{!! route('ajax_delete_employee_follow_employer') !!}',
                    data: {
                        employer_id : employer_id,
                        employee_id : '{{ $employee['employee_id'] }}',
                    },
                    success: function (result) {
                        console.log('thanh coong');
                        elenment_hide.hide();
                    },
                    error: function (result) {
                        console.log('xoa theo doi ntd thất bại');
                        console.log('that baij');
                    }
                });
            });
        </script>
    @endif


@endsection
