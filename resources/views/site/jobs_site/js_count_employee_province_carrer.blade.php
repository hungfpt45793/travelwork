<script>
    $(document).ready(function() {
        setTimeout(function(){
            $.ajax({
                type: 'get',
                url: '{{ route('ajax_get_total_job_carrer') }}',
                dataType: 'json',
                async: false,
                success: function(result){
                    var count_employee = result['count_employee'];
                    $.each(count_employee, function(key, item) {
                        var carrer_id = $('.js_sup_total_carrer_'+key).attr('data_id');
                        if(key == carrer_id)
                        {
                            if(item != 0)
                            {
                                $('.js_sup_total_carrer_'+key).append(
                                    '<sup class="clGreen">(' + item + ')</sup>'
                                );
                            }
                        }
                    });
                }
            });
            $.ajax({
                type: 'get',
                url: '{{ route('ajax_get_total_job_province') }}',
                dataType: 'json',
                async: false,
                success: function(result){
                    var count_province_employee = result['count_employee'];
                    $.each(count_province_employee, function(key, item) {
                        var province_id = $('.js_sup_total_province_'+key).attr('data_id');
                        if(key == province_id)
                        {
                            if(item != 0)
                            {
                                $('.js_sup_total_province_'+key).append(
                                    '<sup class="clGreen">(' + item + ')</sup>'
                                );
                            }
                        }
                    });
                }
            });
            $.get('/tim-kiem-huyen/' + city, function (data) {
                $('#county').html('');
                $('#county').html(data);
            });
            $('.js_sup_total_carrer').append('<sup>'+data+'</sup>')
            }, 2000);
    });
</script>