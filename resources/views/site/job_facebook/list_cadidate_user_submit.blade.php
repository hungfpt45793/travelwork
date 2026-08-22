@extends('site.layout.site')

@section('title', 'Danh sách ứng viên nộp hồ sơ')
@section('meta_description', 'Danh sách ứng viên nộp hồ sơ')
@section('keywords', 'Danh sách ứng viên nộp hồ sơ')

@section('content')
    <section class="content bgrGray pdt5">
        <div class="container-fluid ">
            <div class="row ">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline ">
                    <section class="jobsInteresting bgrWhite bdLightGray radius5 mgt20">
                        <div class="titleJobs f18 white  pd10-20 col-f14">
                            <div class="link bgrWhite md-mgt20 disOnMobile">
                                <ul class="nav">
                                    <li class="nav-item pd8">
                                        <a href="/" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                                    </li>
                                    <li class="nav-item pd8">
                                    <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                                    </li>
                                    <li class="nav-item pd8">
                                    <a href="{{ route('list_Job_Candidate_Employee') }}" class=" f18 md-f14 mgb0">Danh sách ứng viên ứng tuyển</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="contentJobsInteresting pdl15 pdr15 col-f14">
                            {{--ứng viên--}}
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-12 borderTop">

                                    <div class="CV bgrWhite radius5 pd20 mgb30 pdb5">
                                        <div class="title mgb20">
                                            <h5 class="lt-f18 textUpper fw7 bdLeftBlueN5x pdl10 blueN mgb0">
                                                Danh sách ứng viên nộp hồ sơ
                                            </h5>


                                        </div>
                                        <div>
                                            @if(session('success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('erorr'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert">
                                                    {{ session('erorr') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>


                                        <table id="jobfb" class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên ứng viên</th>
                                                <th>Email ứng viên</th>
                                                <th>Số điện thoại</th>
                                                <th>Tỉnh / TP</th>
                                                <th>Quận / Huyện</th>
                                                <th>Địa chỉ</th>

                                                <th>Chi tiết</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list_employee as $ide=>$employee)
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;

                                                        ?>
                                                        @if($page == 1)
                                                            {{ $ide + 1 }}
                                                        @else
                                                            {{ ($page * 15) + $ide }}
                                                        @endif

                                                    </td>
                                                    <td>{{ isset($employee['employee_name']) ? $employee['employee_name'] : '' }}</td>
                                                    <td>{{ isset($employee['email']) ? $employee['email'] : '' }}</td>
                                                    <td>{{ isset($employee['phone']) ? $employee['phone'] : '' }}</td>
                                                    <td>
                                                        <?php
                                                        $provice = \App\Entity\Province::getId($employee['province']);
                                                        ?>
                                                        {{ isset($provice->province_name) ? $provice->province_name : '' }}

                                                    </td>
                                                    <td>
                                                        <?php
                                                        $district = \App\Entity\District::getId($employee['district']);
                                                        ?>
                                                        {{ isset( $district['district_name']) ?  $district['district_name'] : '' }}
                                                    </td>
                                                    <td>{{ isset($employee['address']) ? $employee['address'] : '' }}</td>
                                                    <td>
                                                        <div class="EditDelete">
                                                            <a href="{{ route('detail_Submit_Employee',['employee_id'=>$employee['employee_id']]) }}"
                                                               title="Danh sách hồ sơ" class="btnOrange "
                                                               style="    padding: 4px 7px">Hồ sơ ứng viên</a>
                                                        </div>
                                                        <div class="EditDelete mgt10">
                                                            <a href="{{ route('detail_exam_employee',['employee_id'=>$employee['employee_id'],'job_facebook_id'=>$job_facebook_id]) }}"
                                                               title="Danh sách hồ sơ" class="btnGreen clwhite"
                                                               style="    padding: 4px 7px">Kết quả đề thi</a>
                                                        </div>


                                                    </td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    {{ $list_employee->links() }}
                                </div>
                            </div>


                        </div>
                    </section>

                    @include('site.module_index.dang-ky-tu-van')
                    @include('site.module_index.hotline')
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#city').change(function () {
            $.get('/admin/ajax-district/' + $(this).val(), function (data) {
                $('#county').html(data);
            });
        });
    </script>
    @include('site.partials.delete')


@endsection