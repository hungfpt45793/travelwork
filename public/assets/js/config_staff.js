$(document).ready(function() {
    $('.select2').select2({width: '100%', dropdownParent: $("#timkiem"),});
    $('.select22').select2();
    $('.editor').each(function (e) {
        CKEDITOR.replace(this.id, {
            filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
        });
    });
    function uploadImage(e) {
        window.KCFinder = {
            callBack: function (url) {
                window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src", url);
                $(e).next().next().val(url);
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
});

$(".hover_show").hover(function () {
    $('body').addClass("show_ul");
}, function () {
    $('body').removeClass("show_ul")
})
$('.editor').each(function (e) {
    CKEDITOR.replace(this.id, {
        filebrowserImageBrowseUrl: '/kcfinder-master/browse.php?type=images&dir=images/public',
    });
});
function uploadImage(e) {
    window.KCFinder = {
        callBack: function (url) {
            window.KCFinder = null;
            var img = new Image();
            img.src = url;
            $(e).next().attr("src", url);
            $(e).next().next().val(url);
        }
    };
    window.open('/kcfinder-master/browse.php?type=images&dir=images/public',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
    'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}
$('.cellWrap').matchHeight();
bindings();
function bindings() {
    var locker = $('#locker');
    $(document).on('click', 'button.lockButton', function () {

        var that = $(this),
            lidClass = '',
            parent = that.parents('td[class^="lid"]');
        if (parent.length) {
            lidClass = getColumnLidClass(parent);
            lockings = $('td.' + lidClass);
            lockings.addClass('locked');
            that.text('U');
            var fixedColumn = $(getLockedWrapper(lockings, lidClass));
            var index = parent.index();
            fixedColumn.data('index', index);

            if (index === 0) {
                locker.prepend(fixedColumn);
            } else {
                var lockedWraps = $('div.lockedWrap', locker),
                    lwrap = null,
                    indx, appended = false;
                if (!lockedWraps.length) locker.append(fixedColumn);
                lockedWraps.each(function () {
                    lwrap = $(this);
                    indx = lwrap.data('index') * 1;
                    if (!appended && (index < indx)) {
                        lwrap.before(fixedColumn);
                        appended = true;
                        return;
                    }
                });
                if (!appended) locker.append(fixedColumn);
            }
            that.text('L');
        } else {
            parent = that.parents('div.lockedWrap');
            lidClass = getColumnLidClass(parent);
            lockings = $('td.' + lidClass);
            lockings.removeClass('locked');
            parent.remove();
        }
    });
}


function getLockedWrapper(lockings, lidClass) {
    var fixedColumn = [],
        cont;
    lockings.each(function (index, element) {
        cont = $(this).html();
        fixedColumn.push('<div class="cellWrap" style="height:34px; line-height:34px">' + cont + '</div>');
    });
    fixedColumn = '<div class="' + lidClass + ' lockedWrap">' + fixedColumn.join('') + '</div>';
    return fixedColumn;
}

function getColumnLidClass(td) {
    for (var i = 0; i < 100; i++) {
        if (td.hasClass('lid_' + i))
            break;
    }
    return 'lid_' + i;
}
$('.custom-table tr').css('height', '34px');
$('#locker .cellWrap').css('height', '34px');
$('#locker .cellWrap').css('line-height', '34px');
$('.table-scroll').on('scroll', function () {
    $('#locker').scrollTop($(this).scrollTop());
});

$('.d-hvbgrBlueN a.x-anchor').click(function (e) {
    $('a').removeClass('activeTHS');
    $(this).addClass('activeTHS');
});
$('#locker').addClass('tableFixHead');


//can chinh scrollbar
$(".table-wrapper.tableFixHead").floatingScroll();
$(".table-wrapper.tableFixHead").floatingScroll("update");


// Initialize tooltip component
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Initialize popover component
$(function () {
    $('[data-toggle="popover"]').popover()
})

// ajax thêm từ khóa
$(document).ready(function () {
    $('button.LuuTuKhoa').on('click', function () {
        console.log('asds')
        $.ajax({
            type: 'GET',
            url: "{{ route('them_tu_khoa_ajax') }}",
            data: {
                tag_type: $('input[name="tag_type"]').val(),
                tag_title: $('input[name="tag_title"]').val(),
                tag_description: $('textarea[name="tag_description"]').val()
            },
            success: function (res) {
                let html = '';
                let tags = res.input_tags_reload;
                tags.forEach(element => {
                    html += `<option value="${element.tag_title}">
                                        ${element.tag_title}
                                    </option>`
                });
                $('#select-tag').html(html);
                alert('Thêm từ khóa thành công');
            }
        })
    })
})
