var parms = [{
    "cmd": "aCommandName",
    "desc": "A DOMString representing the name of the command"
}, {
    "cmd": "aShowDefaultUI",
    "desc": "A Boolean indicating whether the default user interface should be shown. This is not implemented in Mozilla."
}, {
    "cmd": "aValueArgument",
    "desc": "A DOMString representing some commands (such as insertimage) require an extra value argument (the image's url). Pass an argument of null if no argument is needed."
}];
var commands = [{
    "cmd": "bold",
    "icon": "bold",
    "desc": "In đậm"
},
{
    "cmd": "italic",
    "icon": "italic",
    "desc": "In nghiêng"
},
{
    "cmd": "underline",
    "icon": "underline",
    "desc": "Gạch chân"
},{
    "cmd": "strikeThrough",
    "icon": "strikethrough",
    "desc": "Gạch ngang"
},
{
    "cmd": "justifyLeft",
    "icon": "align-left",
    "desc": "Căn trái"
},{
    "cmd": "justifyCenter",
    "icon": "align-center",
    "desc": "Căn giữa"
},
{
    "cmd": "justifyRight",
    "icon": "align-right",
    "desc": "Căn phải"
}, {
    "cmd": "justifyFull",
    "icon": "align-justify",
    "desc": "Căn đều hai bên"
}, {
    "cmd": "undo",
    "icon": "undo",
    "desc": "Hoàn tác"
}, {
    "cmd": "redo",
    "icon": "repeat",
    "desc": "Làm lại"
}, {
    "cmd": "removeFormat",
    "icon": "eraser",
    "desc": "Xóa hết định dạng"
}];

var commandRelation = {};

function supported(cmd) {
    var css = !!document.queryCommandSupported(cmd.cmd) ? "btn-succes" : "btn-error";
    return css;
};

function icon(cmd) {
    return (typeof cmd.icon !== "undefined") ? "fa fa-" + cmd.icon : "";
};

function doCommand(cmdKey) {
    var cmd = commandRelation[cmdKey];
    if (supported(cmd) === "btn-error") {
        alert("execCommand(“" + cmd.cmd + "”)\nis not supported in your browser");
        return;
    }
    val = (typeof cmd.val !== "undefined") ? prompt("Value for " + cmd.cmd + "?", cmd.val) : "";
    //document.execCommand("styleWithCSS",true ); //not need span style
    document.execCommand(cmd.cmd, false, (val || ""));
    if($('.cmd-' + cmd.cmd).hasClass('actived')){
        $('.cmd-' + cmd.cmd).removeClass('actived');
    }else{
        $('.cmd-' + cmd.cmd).addClass('actived');
    }
}

function init() {
    var html = '<div class="editor-control-group disabled">',
    template = '<span class="editor-control %btnClass%" title="%desc%" onmousedown="event.preventDefault();" onclick="doCommand(\'%cmd%\')"><i class="%iconClass%"></i></span>';
    commands.map(function(command, i) {
        commandRelation[command.cmd] = command;
        var temp = template;
        temp = temp.replace(/%iconClass%/gi, icon(command));
        temp = temp.replace(/%desc%/gi, command.desc);
        //temp = temp.replace(/%btnClass%/gi, supported(command));
        temp = temp.replace(/%btnClass%/gi, 'cmd-' + command.cmd);
        temp = temp.replace(/%cmd%/gi, command.cmd);

        html +=temp;
        if(i==3 || i==7){
            html += '</div><div class="editor-control-group disabled">';
        }
    });
    html += '</div>';
    document.querySelector("#tools").innerHTML = html;
}

init();
$('.exp-content, .box-content,#lto-about, #lto-content').on({
    focus: function () {
        $('.editor-control-group').removeClass('disabled');
        //document.getElementById("tools").disabled = false;
    },

    blur: function () {
        $('.editor-control-group').addClass('disabled');
        //$('.editor-control').removeClass('actived');
        //document.getElementById("tools").disabled = true;
    }
});

setInterval(function () {
    $('.editor-control').removeClass('actived');
    commands.map(function(command, i) {
        if(document.queryCommandState(command.cmd)==true){
            $('.cmd-' + command.cmd).addClass('actived');
        }
    });
}, 100)

$(window).scroll(function(){
    if($(this).scrollTop()>400){
        $('#cvo-toolbar').addClass('fx');
    }else{
        $('#cvo-toolbar').removeClass('fx');
    }
});