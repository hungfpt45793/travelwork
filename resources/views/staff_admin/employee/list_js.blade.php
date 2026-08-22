<script>
    // giao việc
    $('.task_giver').on('click', function() {
        let employee_id = $(this).attr('data-employee-id');
        $('#task_giver input[name="employee_id"]').val(employee_id);
    })
    $('.task_all').click(function() {
        var Ids = [];
        $.each($(".checkItem:checked"), function() {
            Ids.push($(this).val());
        });
        if (Ids.length == 0) {
            swal({
                    title: 'Vui lòng chọn ứng viên.',
                    icon: "error",
                    button: "Đóng",

                })
            event.preventDefault();
        } else {
            $('#task_all').modal('show');
        }
    });
    $('#button_task_all').on('click', function(){
        let ids = [];
        $.each($(".checkItem:checked"), function() {
            ids.push($(this).val());
        });
        let ajax_recipient_id = $('select[name="ajax_recipient_id"]').val();
        let ajax_giver_day = $('input[name="ajax_giver_day"]').val();
        let ajax_finish_day = $('input[name="ajax_finish_day"]').val();
        let ajax_note = $('#ajax_note').val();
        $.ajax({
            'type': 'get',
            'url': "{{ route('ajax_task_job') }}",
            'data': {
                ids: ids,
                ajax_recipient_id: ajax_recipient_id,
                ajax_giver_day: ajax_giver_day,
                ajax_finish_day: ajax_finish_day,
                ajax_note: ajax_note
            },
            'success': function(){
                swal({
                    title: 'Giao việc thành công.',
                    icon: "success",
                    button: "Đóng",
                })
                $('#task_all').modal('hide');
                location.reload();
            }
        })
    })
    // lay ket qua giao viec cu khi click vao giao vec
    $('.task_giver').on('click', function(){
        let employee_id = $(this).attr('data-employee-id');
        let employee_name = $(this).parent().parent().find('.employee_name').text();
        let status_employee = $(this).parent().parent().find('.status_employee').text();
        let profile = $(this).parent().parent().find('.profile').text();

        $('#task_giver .task_giver_info').html(`
            <tr>
                <td>id: ${employee_id}</td>
                <td>${employee_name}</td>
            </tr>
            <tr>
                <td>${status_employee}</td>
                <td>Điểm hồ sơ: ${profile}</td>
            </tr>
        `)
        $.ajax({
            'type': 'get',
            'url': '{{ route("task_info") }}',
            'data': {
                employee_id: employee_id
            }
        })
    })
    $('.staff_report').on('click', function(){
        let task_detail_id = $(this).attr('data-task-detail-id');
        $('#report input[name="task_detail_id"]').val(task_detail_id);
    })
</script>