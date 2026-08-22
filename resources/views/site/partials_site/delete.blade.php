
<div class="modal fade" tabindex="-1" role="dialog" id="myModalDelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" class="submitDelete" method="post" >
                {!! csrf_field() !!}
                {{ method_field('DELETE') }}
                <div class="modal-header">
                    <h5 class="modal-title">Bạn có chắc chắn muốn xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function submitDelete(e) {
        var url = $(e).attr('href');
        console.log(url);
        $('.submitDelete').attr('action', url);
        return false;
    }
</script>
<style>
    .modal-content_1 {
        background: #fff;
    }
</style>

