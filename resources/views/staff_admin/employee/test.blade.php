<style>
    input{
        width: -webkit-fill-available;
    }
</style>
<form action="{{ route('edit_uv_old') }}" method="POST">
@foreach($employees as $employee)
{{$employee->employee_id}} -- 
<br>
uv<img src="https://sanketoan.vn/{{$employee->employee_image}}" width="100px" height="100px" alt="">
<br>

<div>
    <input type="hidden" class="employee_id" value="{{$employee->employee_id}}" name="employee_id[]">
    {{$employee->employee_image}}
    <br>
    <input type="text" class="new" value="{{ str_replace('%20', ' ', $employee->employee_image)}}" name="employee_image[]">
   
</div>


<hr>
@endforeach
<button type="submit">sua</button>
</form>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
    $('button').on('click', function(){
        let old_val = $(this).parent().find('input.old').val();
        let new_val = $(this).parent().find('input.new').val();
        let employee_id = $(this).parent().find('input.employee_id').val();
        $.ajax({
            'type': 'get',
            'url': '{{ route("edit_uv_old") }}',
            'data': {
                old_val: old_val,
                new_val: new_val,
                employee_id: employee_id
            },
            'success': function(res){

            }
        })
    })

</script>