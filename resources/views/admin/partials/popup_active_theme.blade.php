<div class="modal fade" id="modalActiveTheme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thay đổi theme</h4>
            </div>
            <form method="post" onsubmit="return changeTheme(this);">
            <div class="modal-body">

                    {!! csrf_field() !!}
                    {{--<div class="form-group selectDomain">--}}
                        {{--<label>Chọn domains</label>--}}
                        {{--<select class="form-control" id="domainId">--}}
                            {{--@foreach (\App\Entity\Domain::showDomainWithUser() as $domains)--}}
                                {{--<option value="{{ $domains->domain_id }}">{{ $domains->name }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label><input type="checkbox" id="newDomain" onclick="return createNewDomain(this);" value="1"/> Tạo domain mới</label>--}}
                    {{--</div>--}}
                    {{--<div class="form-group createNewDomain">--}}
                        {{--<label>Tên domains</label>--}}
                        {{--<input type="text" name="name" id="nameDomain" placeholder="Tên domain" value="" />.vn3c.com--}}
                    {{--</div>--}}
                    <input type="hidden" value="" id="themeId" />
                     <div class="form-group">
                         Bạn có chắc chắn muốn thay đổi theme không ?
                    </div>
                    <div class="form-group errorDomain" style="color: red;">

                    </div>
                    <div class="form-group">

                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Thay đổi</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createNewDomain(e) {
        console.log(1);
        if ($(e).prop('checked')) {
            $('.selectDomain').hide();
            $('.createNewDomain').show();

            return true;
        }

        $('.selectDomain').show();
        $('.createNewDomain').hide();

        return true;
    }
    function changeTheme(e) {
        $('.errorDomain').empty();
        // var domainId = $('#domainId').val();
        // var nameDomain = '';
        var token =  $('input[name=_token]').val();
        var themeId =  $('#themeId').val();
        // neu khong check trang trang thai domain moi
        // if ( $('#newDomain').prop('checked')) {
        //     nameDomain = $('#nameDomain').val();
        // }

        $.ajax({
            type: "POST",
            url: '{!! route('change_theme') !!}',
            data: {
                // domain_id: domainId,
                _token: token,
                // name_domain: nameDomain,
                theme_id : themeId
            },
            success: function(result){
                console.log(1);
                var obj = $.parseJSON(result);
                console.log(obj.status);
                if (obj.status == 500) {
                    $('.errorDomain').append('<p>'+obj.message+'</p>');
                }
                if (obj.status == 200) {
                    alert(obj.message);
                    location.reload();
                }

                return false;
            },
            error: function(error) {
                $('.errorDomain').append('<p>Có một lỗi xảy ra. </p>');

                return false;
            }

        });


        return false;
    }
    function addTheme(e) {
        var themeId = $(e).attr('idTheme');
        $('#themeId').val(themeId);

        $('#modalActiveTheme').modal('show');
    }
</script>
<style>
    .modal-content_1 {
        background: #fff;
    }
    .createNewDomain {
        display: none;
    }
    label {
        cursor: pointer;
    }
</style>