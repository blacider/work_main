<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
<div id="uploader-file">
    <!--用来存放文件信息-->
    <div id="theList" class="uploader-list"></div>
    <div class="col-xs-12 col-sm-12 add_attach_pic_btn" style="padding-left: 0px; padding-top: 10px;" >
        <div id="picker">选择附件</div>
        <span style="position: relative;top: -31px;left: 100px;">支持word,PDF,excel,PPT格式文件</span>
    </div>
</div>

</div>
<input type="hidden" data-title="<?php echo $item_customization_value['title'];?>" name="attachments" class='need_check' id="files" >
</div>
<script type="text/javascript">
function getPngByType(filename) {
    var types = filename.split('.');
    var type = types[types.length-1];
    var name_ = "";
    switch(type) {
        case "xls":
        case "xlsx":
            name_ = "excel.png";
            break;
        case "ppt":
        case "pptx":
            name_ = "powerpoint.png";
            break;
        case "docx":
        case "doc":
            name_ = "word.png"
            break;
        case "pdf":
            name_ = "pdf.png"
            break;
        default:
            name_ = "default.png"
            break;
    }
    return name_;
}

function bind_event_file(){
        $('#theList .del-button_').click(function(e) {
            var key = filesDict[this.parentNode.id];
            var images = $("input[name='attachments']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (result == '') result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='attachments']").val(result);
            $(this.parentNode).remove();
        });
        $('#theList .download-button_').click(function(e) {
            var url = filesUrlDict[this.parentNode.id];
            window.open(url);
        });
}


function loadFiles() {
    var __files = item_info['attachments'];
    for (var i = 0; i < __files.length; i++) {
        var file = __files[i];
        var $li = $(
        '<div id="FILE_' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
            '<img style="width:128px">' +
            '<p style="text-align: center;margin: 0;max-width: 128px;">'+decodeURIComponent(file.filename)+'</p>'+
            '<div class="glyphicon glyphicon-trash red del-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;bottom: 10px;cursor: pointer;"></div>' +
        '</div>'
        ),$img = $li.find('img');
        // $list为容器jQuery实例
        $('#theList').append( $li );
        var path = "/static/images/", name_ = getPngByType(file.filename);
        $img.attr( 'src', path+name_);
        bind_event_file();
        var imageDom = $('#' + file.id);
        filesDict["FILE_"+String(file.id)] = String(file.id);
        filesUrlDict["FILE_"+String(file.id)] = String(file.url);
        if ($("input[name='attachments']").val() == '') {
            $("input[name='attachments']").val(file.id);
        } else {
            $("input[name='attachments']").val($("input[name='attachments']").val() + ',' + file.id);
        }
    }
}

$(document).ready(function() {
    var uploader_file = WebUploader.create({
    auto:true,
    // swf文件路径
    swf: '/static/third-party/webUploader/Uploader.swf',

    // 文件接收服务端。
    server: '<?php echo base_url('items/attachment'); ?>',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    accept: {
        title: 'Files',
        extensions: 'pdf,docx,doc,ppt,pptx,xls,xlsx',
        mimeTypes: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/msword,application/vnd.ms-powerpoint,application/vnd.ms-excel'
    }
});


// 当有文件添加进来的时候
uploader_file.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:128px">' +
                '<p style="text-align: center;margin: 0;max-width: 128px;">'+file.name+'</p>'+
                '<div class="glyphicon glyphicon-trash red del-button_" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
                '<div class="ui-icon ace-icon fa fa-download blue download-button_" style="  position: absolute;right: 10px;bottom: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
    // $list为容器jQuery实例
    $('#theList').append( $li );
    var path = "/static/images/", name_ = "";
    switch(file.type) {
        case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        case "application/vnd.ms-excel":
            name_ = "excel.png";
            break;
        case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
        case "application/vnd.ms-powerpoint":
            name_ = "powerpoint.png";
            break;
        case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        case "application/msword":
            name_ = "word.png"
            break;
        case "application/pdf":
            name_ = "pdf.png"
            break;
        default:
            name_ = "default.png";
            break;
    }
    $img.attr( 'src', path+name_);
    bind_event_file();
});
function bind_event_file(){
        $('#theList .del-button_').click(function(e) {
            var key = filesDict[this.parentNode.id];
            var images = $("input[name='attachments']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (result == '') result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='attachments']").val(result);
            $(this.parentNode).remove();
        });
        $('#theList .download-button_').click(function(e) {
            var url = filesUrlDict[this.parentNode.id];
            var aLink = document.createElement('a');
            aLink.href = url;
            aLink.click();
        });
}
// 文件上传过程中创建进度条实时显示。
uploader_file.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');
    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader_file.on( 'uploadSuccess', function( file ) {
    var $li = $( '#'+file.id ),
        $success = $li.find('div.success');

    // 避免重复创建
    if ( !$success.length ) {
        $success = $('<div class="success blue center"></div>').appendTo( $li );
    }

    $success.text('上传成功');
});

// 文件上传失败，显示上传出错。
uploader_file.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error red center"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

uploader_file.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        // 通过return false来告诉组件，此文件上传有错。
        var imageDom = $('#' + file.file.id);
        filesDict[file.file.id] = String(response['data']['id']);
        filesUrlDict[file.file.id] = String(response['data']['url']);
        if ($("input[name='attachments']").val() == '') {
            $("input[name='attachments']").val(response['data']['id']);
        } else {
            $("input[name='attachments']").val($("input[name='attachments']").val() + ',' + response['data']['id']);
        }
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader_file.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
});
    if(PAGE_TYPE !=0 )
    {
        loadFiles();
    }
});
var filesDict = {};
var filesUrlDict = {};
</script>