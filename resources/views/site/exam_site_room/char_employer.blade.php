@extends('site.layout.site')
@section('type_meta', 'website')
@section('title', isset($room['name_room']) ? $room['name_room'] : 'Thông tin phòng thi')
@section('meta_description', isset( $room['des_room']) ? $room['des_room']  : 'Mô tả phòng thi')
@section('keywords', 'Đề thi trắc nghiệm du lịch')

@section('meta_image', ''  )
@section('meta_url', !empty($room['id_exam']) ? route('getExamRoom',['id_room' => $room['id_room']]) : '' )


@section('content')
    <style>
        .table td, .table th {
            border-left: 1px solid #ccc;
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>
    <section class="main">
        <div class="container-fluid">
            <div class="row">
                @include('site.sidebar.sidebar_job_face')
                <div class="col-xl-9 col-lg-8 col-md-12 createProfileOnline">
                    <div class="link bgrWhite md-mgt20">
                        <ul class="nav">
                            <li class="nav-item pd8">
                                <a href="#" class="f18 md-f14 blueDN hvBlueDN"><i class="fas fa-home"></i> Trang chủ</a>
                            </li>
                            <li class="nav-item pd8">
                                <p class="mgb0 md-f13 md-mgt2 blueDN"><i class="fas fa-chevron-right"></i></p>
                            </li>
                            <li class="nav-item pd8">
                                <a href="#" class=" f18 md-f14 mgb0">Kết quả phòng thi</a>
                            </li>
                        </ul>
                    </div>


                    <p class="mgBottom0 f15 text-center f20">Kết quả thi của {{ isset($room['name_room']) ? $room['name_room'] : '' }}</span>
                    </p>

                    <div id="chart"></div>


                    <p class="mgBottom0 f15 text-center f20">Chi tiết thi của {{ isset($room['name_room']) ? $room['name_room'] : '' }}</span>
                    </p>

                    <table class="table table-hover mgt20" style="border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Đề thi</th>
                            <th scope="col">Ứng viên</th>
                            <th scope="col">Số câu trả lời (đúng / tổng số)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result_room_exam as $id=>$result)
                        <tr>
                            <th scope="row">{{ $id + 1 }}</th>
                            <td>{{ $result['code_exam'] }} - {{ $result['name_exam']  }}</td>
                            <td>{{ $result['employee_name']  }}</td>
                            <td>
                                <?php
                                $total_question = 0;
                                $total_question = \App\Exam\Questions::countQuestion($result['id_exam']);
                                $total_anser = 0;
                                $total_anser = $result['correct_question_1'] + $result['correct_question_2'] + $result['correct_question_3']
                                ?>
                                <span>{{ $total_anser }} / {{ $total_question }}</span>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </section>

    <script src="{{ asset('assets/js/frappe-charts.min.iife.js') }}"></script>
    <!-- or -->
    @if(!empty($result_room_exam))
    <script>
        let chart = new frappe.Chart( "#chart", { // or DOM element
            data: {
                labels:[ @foreach($result_room_exam as $result) "{{ $result['code_exam'] }}-{{ $result['employee_name']  }}",  @endforeach ],

                datasets: [
                    {
                        name: "Tổng số câu", chartType: 'bar',
                        values: [ @foreach($result_room_exam as $result)
                                    <?php
                                        $total_question = 0;
                                        $total_question = \App\Exam\Questions::countQuestion($result['id_exam']);
                                        $total_anser = 0;
                                        $total_anser = $result['correct_question_1'] + $result['correct_question_2'] + $result['correct_question_3']
                                        ?>
                                    {{ $total_question }},
                                @endforeach ]
                    },
                    {
                        name: "Câu trả lời đúng", chartType: 'bar',
                        values: [ @foreach($result_room_exam as $result)
                             <?php
                            $total_question = 0;
                            $total_question = \App\Exam\Questions::countQuestion($result['id_exam']);
                            $total_anser = 0;
                            $total_anser = $result['correct_question_1'] + $result['correct_question_2'] + $result['correct_question_3']
                            ?>
                                {{ $total_anser }}, @endforeach]
                    },
                    // {
                    //     name: "Đồ thị", chartType: 'line',
                    //     values: [25, 50, 0, 15, 18, 32, 27, 14,25, 50, 0, 15, 18, 32, 27, 14,25, 50, 0, 15, 18, 32, 27, 14,25, 50, 0, 15, 18, 32, 27, 14]
                    // },

                ],


                yMarkers: [{ label: "Max", value: 100,
                    options: { labelPos: 'left' }}],
                yRegions: [{ label: "Min", start: 0, end: 100,
                    options: { labelPos: 'right' }}]
            },

            title: "Biểu đồ kết quả thi",
            type: 'axis-mixed', // or 'bar', 'line', 'pie', 'percentage'
            height: 400,
            colors: ['purple', '#ffa3ef', 'light-blue','red'],
            footerFontSize : 16,
            borderWidth :20,
            titleFontSize :30,
            footerFontSize :20,

            tooltipOptions: {
                formatTooltipX: d => (d + '').toUpperCase(),
                formatTooltipY: d => d + ' câu',
            },
            // barOptions: {
            //     spaceRatio: 0.2 // default: 1
            // },
        });
    </script>
    @endif
@endsection

