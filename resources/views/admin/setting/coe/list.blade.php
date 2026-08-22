@extends('admin.layout.admin')

@section('title', ' Tổng hệ số lương')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tổng hệ số lương
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Việc Làm</a></li>
            <li><a href="#"> Tổng hệ số lương</a></li>
        </ol>
    </section>
    <style>
        .s_tag
        {
            border: 1px solid #ccc;
            padding: 5px 3px;
            margin-right: 5px;
        }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            {{--<div class="col-xs-12 col-md-12">--}}
                            {{--<a href="{{route('com.create')}}"><button class="btn btn-info" style="float:right;">Thêm mới</button></a>--}}

                            {{--</div>--}}
                        </div>
                        @if(!empty(session('error')))
                            <div class="alert alert-warning" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(!empty(session('success')))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="job_career" class="table table-bordered table-striped">
                            <thead>

                            <tr>
                                <th width="5%">ID</th>
                                <th>Trọng số lương</th>
                                <th>Thông số - TP 13-1-2-3-4-5-6-7-8-9-10-11-12-14 </th>
                                <th>IP</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($coe as $c)
                                <tr>
                                    <th width="5%">{{ $c->coe_id }}</th>
                                    <th>{{ $c->total_salary }} triệu VNĐ</th>
                                    <th>
                                        <?php
                                        $career_category_name = \App\Entity\Career::where('career_category_id', $c->career_category_id)->value('career_category_name');
                                        $type_of_business_name = \App\Entity\TypeOfBusiness::where('type_of_business_id', $c->type_of_business_id)->value('type_of_business_name');
                                        $business_type_name = \App\Entity\Business::where('business_type_id', $c->business_type_id)->value('business_type_name');
                                        $literacy_name = \App\Entity\Literacy::where('literacy_id', $c->literacy_id)->value('literacy_name');
                                        $office_name = \App\Entity\Office_information::where('office_id', $c->office_id)->value('office_name');
                                        $exp_name = \App\Entity\Experience_postion::where('exp_id', $c->exp_id)->value('exp_name');
                                        $exp_bus_name = \App\Entity\Experience_business::where('exp_bus_id', $c->exp_bus_id)->value('exp_bus_name');
                                        $software_name = \App\Entity\Software::where('software_id', $c->software_id)->value('software_name');
                                        $lang_name = \App\Entity\LanguageLiteracy::where('lang_id', $c->lang_id)->value('lang_name');
                                        $soft_name = \App\Entity\SoftSkills::where('soft_id', $c->soft_id)->value('soft_name');
                                        $cer_name = \App\Entity\Certificate::where('cer_id', $c->cer_id)->value('cer_name');
                                        $work_name = \App\Entity\WorkPressure::where('work_id', $c->work_id)->value('work_name');
                                        $province_name = \App\Entity\Province::where('province_id', $c->province_id)->value('province_name');
                                        $com_name = \App\Entity\CommitCompany::where('com_id', $c->com_id)->value('com_name');
                                        $list_exp_name = \App\Entity\Coefficients_exp::select('experience_postion.exp_name')->where('coe_id', $c->coe_id)->join('experience_postion', 'experience_postion.exp_id', '=', 'coefficients_exp.exp_id')->get();
                                        $string_exp_name = '';
                                        if (!empty($list_exp_name)) {
                                            foreach ($list_exp_name as $exp) {
                                                $string_exp_name .= $exp->exp_name . ',';
                                            }
                                        }
                                        ?>
                                        <span class="s_tag">
                                            {{ $province_name }}
                                        </span>
                                            <span class="s_tag">
                                            {{ $career_category_name }}
                                        </span>
                                        <span class="s_tag">
                                            {{ $type_of_business_name }}
                                        </span>
                                        <span class="s_tag">
                                            {{ $business_type_name }}
                                        </span>
                                        <span class="s_tag">
                                            {{ $literacy_name }}
                                        </span> <span class="s_tag">
                                            {{ $office_name }}
                                        </span>
                                            <span class="s_tag">
                                            {{ $string_exp_name }}
                                        </span>


                                            <span class="s_tag">
                                            {{ $exp_name }}
                                        </span><span class="s_tag">
                                            {{ $exp_bus_name }}
                                        </span><span class="s_tag">
                                            {{ $software_name }}
                                        </span><span class="s_tag">
                                            {{ $lang_name }}
                                        </span><span class="s_tag">
                                            {{ $soft_name }}
                                        </span><span class="s_tag">
                                            {{ $cer_name }}
                                        </span><span class="s_tag">
                                            {{ $work_name }}
                                        </span><span class="s_tag">
                                            {{ $com_name }}
                                        </span>
                                    </th>
                                    <th>{{ $c->ip }}</th>
                                </tr>
                            @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#job_career').DataTable();
        });
    </script>
@endpush
