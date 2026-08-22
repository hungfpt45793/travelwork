<!-- Modal -->
<div class="modal fade" id="popupSearchOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Tra cứu đơn hàng</h4>
            </div>
            <form action="{{ route('orderPerson') }}" method="get">
                <div class="modal-body">
                        <div class="form-group">
                            <input id="email" type="number" class="form-control" name="phone"  placeholder="Nhập Số điện thoại cần tra cứu" required autofocus>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
</div>


