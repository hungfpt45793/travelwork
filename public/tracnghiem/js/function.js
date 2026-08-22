    // Đăng kí email
function subcribeEmailSubmit(e) {
    var email = $(e).find('.emailSubmit').val();
    var token =  $(e).find('input[name=_token]').val();

    $.ajax({
        type: "POST",
        url: '{!! route('subcribe_email') !!}',
        data: {
            email: email,
            _token: token
        },
        success: function(data) {
            var obj = jQuery.parseJSON(data);

            alert(obj.message);
        }
    });
    return false;
}
    // thêm sản phẩm vào giỏ hàng
function addToOrder(e) {
    var gold = $(e).find('.goldVal').val();
    var size = $(e).find('.sizeVal').val();
    var properties = 'vàng: ' + gold + ' - cỡ: '+ size;
    $(e).find('.properties').val(properties);
    var data = $(e).serialize();

    $.ajax({
        type: "POST",
        url: '{!! route('addToCart') !!}',
        data: data,
        success: function(result){
            var obj = jQuery.parseJSON( result);

            window.location.replace("/gio-hang");
        },
        error: function(error) {
            alert('Lỗi gì đó đã xảy ra!')
        }

    });

    return false;
}
    // cập nhật số lượng đơn hàng
function changeQuantity(e) {
    var unitPrice = $(e).parent().parent().parent().find('.unitPrice').val();
    var quantity = $(e).val();
    var totalPrice = unitPrice*quantity;
    var sum = 0;
    $(e).parent().parent().parent().find('.totalPrice').empty();
    $(e).parent().parent().parent().find('.totalPrice').html(numeral(totalPrice).format('0,0'));

    $('.totalPrice').each(function () {
        var totalPrice = $(this).html();
        console.log(totalPrice);
        sum += parseInt(numeral(totalPrice).value());
    });

    $('.sumPrice').empty();
    $('.sumPrice').html(numeral(sum).format('0,0'));
}
	
	//loc gia
function sortProduct(e) {
    $('.sortProduct').submit();
}
    // liên hệ
function contact(e) {
    var $btn = $(e).find('button').text('Đang tải ...');
    var data = $(e).serialize();

    $.ajax({
        type: "POST",
        url: '{!! route('sub_contact') !!}',
        data: data,
        success: function(result){
            var obj = jQuery.parseJSON( result);
            // gửi thành công
            if (obj.status == 200) {
                alert(obj.message);
                $btn.text('Đăng ký ngay');

                return;
            }

            // gửi thất bại
            if (obj.status == 500) {
                alert(obj.message);
                $btn.text('Đăng ký ngay');

                return;
            }
        },
        error: function(error) {
            //alert('Lỗi gì đó đã xảy ra!')
        }
    });
    return false;
}
