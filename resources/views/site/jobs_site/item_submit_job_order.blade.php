<li>
    <p class="mgb0 job_submit_title">{{ $status_employee->employee_name }}</p>
    <p class="mgb0 clHome">
        <i class="fas fa-map-marker-alt mgr5"></i>
        <?php
        $provice = \App\Entity\Province::getId($status_employee['province']);
        ?>
        {{ isset($provice->province_name) ? $provice->province_name : '' }}
        <?php
        $list_district_name = \App\Entity\Employee_district::get_district_name($status_employee->employee_id)
        ?>
        @if(!empty($list_district_name))
            @foreach($list_district_name as $ids=>$district)
                <i> | {{ $district->district_name }}</i>
            @endforeach
        @endif
    </p>
    <p class="mgb0" >
        <i class="fas fa-id-badge mgr5 clGreen"></i>  Điểm hồ sơ:{{ !empty($status_employee->profile) ? $status_employee->profile : "" }}
    </p>
    <div class="option_status_show_cv">
        <div class="option_status">
            <select class="custom-select form-control form-control-sm js_change_select"
                    name="submit_job_fb_id[{{ $status_employee['submit_job_fb_id']}}]" style="width: 120px;height: 32px">
                <option value="0"
                        data_submit_job_fb_id="{{ $status_employee['submit_job_fb_id']}}"
                        @if($status_employee['id_status_submit_job'] == '0' && empty($status_employee['id_status_submit_job'] )) selected @endif>
                    Trạng thái
                </option>
                <?php
                $list_status = \App\Entity\Status_submit_job::getAll();
                ?>
                @foreach($list_status as $status)
                    <option value="{{ isset($status->id_status) ? $status->id_status : '' }}"
                            data_submit_job_fb_id="{{ $status_employee['submit_job_fb_id'] }}"
                            data_name="{{ isset($status->name_status) ? $status->name_status : '' }}"
                            @if($status_employee['id_status_submit_job'] == $status->id_status && !empty($status_employee['id_status_submit_job'] ))
                            selected
                            @endif >
                        {{ isset($status->name_status) ? $status->name_status : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="show_cv">
            <a target="_blank" href="{{ route('show_profile_Employee',['submit_job_fb_id'=>$status_employee['submit_job_fb_id']]) }}" title="Xem hồ sơ" class="btnOrange  js_show_profile_employee" style="padding: 4px 7px"
               data_submit_job_fb_id="{{ $status_employee['submit_job_fb_id']}}"
               status_submit_job="1">
                Xem hồ sơ
            </a>
        </div>
    </div>
</li>