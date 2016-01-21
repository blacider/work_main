<div class="form-group customization_form" data-value='<?php echo htmlspecialchars(json_encode($item_customization_value));?>'>
<label class="col-sm-1 control-label no-padding-right"><?php echo $item_customization_value['title'];?></label>
<div class="col-xs-6 col-sm-6">
    <div class="col-xs-12 col-sm-12" style="padding-left:0px;">
        <ul class="ace-thumbnails clearfix" id="timages">
        </ul>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div id="uploader-demo">
    <!--用来存放item-->
            <div id="fileList" class="uploader-list"></div>
            <div id="imageList" style="width:200%;"></div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 add_attach_pic_btn" style="padding-left: 0px; padding-top: 10px;" >
        <a class="filePicker" id="btn_simg" >添加图片</a>
    </div>
</div>
<input type="hidden" data-title="<?php echo $item_customization_value['title'];?>" class='need_check' name="images" id="images" >
</div>

<script type="text/javascript">
if(PAGE_TYPE != 0)
{
    var _images = $('#html_images').data('value');
}

var flag = 0;
function initUploader() {
    if (flag == 1) {
        return;
    } else {
        flag =1;
    }
var uploader = WebUploader.create({
    // 选完文件后，是否自动上传。
    auto: true,
    // swf文件路径
    swf: '/static/third-party/webUploader/Uploader.swf',
    // 文件接收服务端。
    server: '<?php echo base_url('items/images'); ?>',
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '.filePicker',
    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
// 当有文件添加进来的时候
uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img>' +
                '<div class="glyphicon glyphicon-trash red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),
        $img = $li.find('img');
    // $list为容器jQuery实例
    $('#imageList').append( $li );
    ifUp = 0;
    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
        bind_event();
    }, 150, 150 );
});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');
        ifUp = 0;
    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file ) {
    var $li = $( '#'+file.id ),
        $success = $li.find('div.success');

    // 避免重复创建
    if ( !$success.length ) {
        $success = $('<div class="success blue center"></div>').appendTo( $li );
    }

    $success.text('上传成功');
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error red center"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

uploader.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        // 通过return false来告诉组件，此文件上传有错。
        var imageDom = $('#' + file.file.id);
        imagesDict[file.file.id] = 'WU_FILE_' + String(response['data']['id']);
        if ($("input[name='images']").val() == '') {
            $("input[name='images']").val(response['data']['id']);
        } else {
            $("input[name='images']").val($("input[name='images']").val() + ',' + response['data']['id']);
        }
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
    ifUp = 1;
});
}
function bind_event(){
        $('.del-button').click(function(e) {
            var key = imagesDict[this.parentNode.id].split("WU_FILE_")[1];
            var images = $("input[name='images']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (result == '') result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='images']").val(result);
            $(this.parentNode).remove();
        });
}

function load_exists(){
    var images = _images;
    $('#imageList').empty();
    var result = '', flag_ = 0;
    $(images).each(function(idx, item) {
        if (flag_ == 0) {
            result = String(item.id);
            flag_ = 1;
        }   else {
            result += ',' + String(item.id);
        }
        imagesDict['WU_FILE_'+String(item.id)] = 'WU_FILE_'+String(item.id);
        var $li = $(
            '<div id="WU_FILE_' + item.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img style="width:150px;height:150px;">' +
                '<div class="glyphicon glyphicon-trash red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),$img = $li.find('img');
    // $list为容器jQuery实例
    $('#imageList').append( $li );

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100

        $img.attr('src', item['url']);
    });
    $('input[name="images"]').val(result);
    bind_event();
}
$(document).ready(function(){
    initUploader();
    load_exists();
});
</script>