<script>
    function uploadImage(e) {
        window.KCFinder = {
            callBack: function (url) {
                window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src", url);
                $(e).next().next().val(url);
                $(e).attr("src", url);
                $(e).next().val(url);
                $(e).next().next().val(url);
                $(e).next().next().next().val(url);
                console.log($(e).next());
                console.log($(e).next().next());
            }
        };
        window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
            'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }
    function openKCFinder(e) {
        window.KCFinder = {
            callBackMultiple: function (files) {
                window.KCFinder = null;
                var urlFiles = "";
                $(e).next().empty();
                for (var i = 0; i < files.length; i++) {
                    $(e).next().append('<img src="' + files[i] + '" width="80" height="" style="margin-left: 5px; margin-bottom: 5px;"/>');
                    urlFiles += files[i];
                    if (i < (files.length - 1)) {
                        urlFiles += ',';
                    }
                }

                $(e).next().next().val(urlFiles);
            }
        };
        window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
            'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }

    function subcribeEmailSubmit(e) {
        var email = $(e).find('.emailSubmit').val();
        var token = $(e).find('input[name=_token]').val();

        $.ajax({
            type: "POST",
            url: '{!! route('subcribe_email') !!}',
            data: {
                email: email,
                _token: token
            },
            success: function (data) {
                var obj = jQuery.parseJSON(data);

                alert(obj.message);
            }
        });
        return false;
    }

    $(document).ready(function () {
        //validate
//validate check email
        jQuery.validator.addMethod("checkEmail", function(value, element) {
            var result = false;
            $.ajax({
                async: false,
                url: '{!! route('check_email_employee') !!}',
                type: 'get',
                dataType: 'json',
                data: {
                    email: value
                }
            }).done(function(response) {
                result = response;
            });
            return result;
        }, 'Email đã tồn tại.');
// validate check phone
        jQuery.validator.addMethod("checkPhone", function(value, element){
            var result = false;
            var checkPhone = $("input[name=phone]").val().split('');
            var dem = checkPhone.length;
            if (checkPhone[0]==0 && dem==10 || dem==15) {
                result = true;
            }else{

            }
            return result;
        }, 'Số điện thoại không hợp lệ.');
// validate năm sinh
        jQuery.validator.addMethod("checkBirthday", function(value, element) {
            var result = false;
            var now = new Date().getFullYear();
            var birthday = $(element).val();
            birthday = birthday.split("-");
            var check = now - birthday[0];
            if (check>=18) {
                result = true;
            }
            return result;
        }, 'Bạn chưa đủ 18 tuổi.');
        jQuery.validator.addMethod("checkBirthday_hople", function(){
            var result = false;
            var now = new Date().getFullYear();
            var birthday = $("input[name=birthday]").val();
            birthday = birthday.split("-");
            var check = now - birthday[0];
            if (check>=0) {
                result = true;
            }else{

            }
            return result;
        }, 'Năm sinh không hợp lệ.');

        // function checkExtensionFile(e) {
        //     let fileName = $(e).val();
        //     if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
        //         $('.js_error_cv').html('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf')
        //         console.log('Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf');
        //     } else {
        //         $('.js_error_cv').html('');
        //     }
        // }
        jQuery.validator.addMethod("checkCV", function(){
            var result = false;
            var fileName = $("input[name=employee_cv]").val();
            if (fileName.search('.doc') == -1 && fileName.search('.docx') == -1 && fileName.search('.pdf') == -1) {
                return false;
            } else {
                return true;
            }
            return result;
        }, 'Bạn chỉ được tải CV với đuôi .doc, .docx hoặc .pdf.');

// vaidate tên
        jQuery.validator.addMethod("checkName", function(value, element){

            // var result = false;
            // var checkName = $(element).val();
            //   var regex = /[^a-zA-Z]+$/;
            //  if (checkName.search(regex)==-1) {
            //      result = true;
//}else{
            //    }
            return true;
        }, 'Họ và tên không hợp lệ.');
        //vai date ngày nộp hồ sơ
        $.validator.addMethod("minDate", function(value, element) {
            var curDate = '{{ date('Y-m-d') }}';
            var inputDate = $(element).val();
            if (curDate < inputDate)
            {
                return true;
            }
            else
            {
                return false;
            }
        }, "Ngày nộp hồ sở phải lớn hơn ngày hiện tại");   // error message
    });
</script>