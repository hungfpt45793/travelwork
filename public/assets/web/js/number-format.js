$(document).ready(function () {
    $('.only-number').keypress(function () {
        return event.charCode >= 48 && event.charCode <= 57;
    });
    $('.format-number').keyup(function () {
        $number = $(this).val();
        $formNumber = formPrice($number);
        $(this).val($formNumber);
    });
});
function onlyNumber(e) {
    return event.charCode >= 48 && event.charCode <= 57;
}
function formPrice(number) {
    if (isNaN(parseInt(number.replace(/,/g, '')))) {
        num = 0;
    } else {

        num = parseInt(number.replace(/,/g, ''));
    }
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

function formatNumberString(num) {
    if(num = null){
        return 0;
    }else{
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }
  }