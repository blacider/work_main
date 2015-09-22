<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<div class="page-content">
<div class="page-content-area">
<form role="form" action="<?php echo base_url('company/report_property_new');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
<div class="row">
<div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">报告模板名称</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="text" class="form-controller col-xs-12" name="report_property_name" id="report_property_name" placeholder="报告模板名称" required></div>
                    </div>
                    <hr>

                    <div class="form-group" style="margin-bottom:30px;">
                        <label class="col-sm-2 control-label no-padding-right">照片</label>
                        <div class="col-xs-6 col-sm-6">
                            <div class="col-xs-12 col-sm-12" style="padding-left:0px;">
                                <ul class="ace-thumbnails clearfix" id="timages"></ul>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div id="uploader-demo">
                                    <!--用来存放item-->
                                    <div id="fileList" class="uploader-list"></div>
                                    <div id="imageList" style="width:200%;"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12" style="padding-left: 0px; padding-top: 10px;">
                                <a class="filePicker" id="btn_simg" onclick="ifOne()">添加图片</a>
                            </div>
                        </div>

                        <!--
<div class="col-xs-6 col-sm-6 dropzone" id="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="" />
                        </div>
                    </div>
                    -->
                </div>
                <label class="col-sm-2 control-label no-padding-right" style="position:absolute;">配置项:</label>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">借款</label>
                    <div class="col-xs-6 col-sm-6">
                        
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="borrowing" id="borrowing" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">起始地</label>
                    <div class="col-xs-6 col-sm-6">
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="location" id="location" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">起始时间</label>
                    <div class="col-xs-6 col-sm-6">
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="period" id="period" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">银行账户</label>
                    <div class="col-xs-6 col-sm-6">
                        <label  style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="account" id="account" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">付款方式</label>
                    <div class="col-xs-6 col-sm-6">
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="payment" id="payment" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">是否有合同</label>
                    <div class="col-xs-6 col-sm-6">
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="contract" id="contract" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label col-sm-offset-2">备注</label>
                    <div class="col-xs-6 col-sm-6">
                        <label style="margin-top:8px;">
                            
                            <input type="checkbox" class="ace ace-switch btn-rotate" name="note" id="note" value="1"><span class="lbl"></span></label>
                    </div>
                </div>
<!--
<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">借款￥</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="borrowing" id="borrowing" placeholder="借款" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">账号</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="account" id="account" placeholder="账号" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">付款方式</label>
<div class="col-xs-6 col-sm-6">
<input type="radio" class="form-controller col-xs-1" name="contract" value="1">
<label class="col-xs-1 col-sm-1">网银转账</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract" value="2">
<label class="col-xs-1 col-sm-1">现金</label>
<input type="radio" class="form-controller col-xs-1" name="contract" value="3">
<label class="col-xs-1 col-sm-1">支票</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract" value="4">
<label class="col-xs-1 col-sm-1">冲账</label>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">是否有合同</label>
<div class="col-xs-6 col-sm-6">
<input type="radio" class="form-controller col-xs-1" name="contract">
<label class="col-xs-1 col-sm-1">是</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract">
<label class="col-xs-1 col-sm-1">否</label>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">消费时间</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker1" name="dt" type="text" class="form-control" />
<span class="input-group-addon">
<i class="fa fa-clock-o bigger-110"></i>
</span>
</div>
</div>
</div>



<div class="form-group" id="endTime">
<label class="col-sm-2 control-label no-padding-right">至</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker2" name="dt_end" type="text" class="form-control" />
<span class="input-group-addon">
<i class="fa fa-clock-o bigger-110"></i>
</span>
</div>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">出差地</label>
<div class="col-xs-3 col-sm-3">
<input type="text" name="start_place" class="form-controller col-xs-12" placeholder="起地">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">至</label>
<div class="col-xs-3 col-sm-3">
<input type="text" name="end_place" class="form-controller col-xs-12" placeholder="终点">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">备注</label>
<div class="col-xs-6 col-sm-6">
<textarea name="note" id="note" class="col-xs-12 col-sm-12  form-controller" ></textarea>
</div>
</div>

-->



<input type="hidden" id="renew" value="0" name="renew">
<div class="clearfix form-actions col-sm-8 col-xs-8">
<div class="col-md-offset-3 col-md-8">
<a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
</div>
</div>
<input type="reset" style="display:none;" id="reset">

</div>
</div>
<input type="hidden" name="images" id="images" >
</form>
</div>
</div>
<!--
<div class="modal" id="select_img_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择图片</h4>
            </div>
            <div class="modal-body">


        </div>
    </div>
</div>
-->
<!--
<script src="/static/third-party/jquery.ajaxfileupload.js"></script>
<script src="/static/third-party/jquery-image-upload.min.js"></script>
-->
<!--
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
-->

<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->

<script src="/static/ace/js/chosen.jquery.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<!--
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
-->

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
-->

<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
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
uploader.on( 'beforeFileQueued', function( file ) {
    if (imagesDict.length >= 1) {
        show_notify("数量超过限制，请删除后再次上传！")；
        return false;
    } else {
        return true;
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
        imagesDict[file.file.id] = String(response['data']['url']);
        if ($("input[name='images']").val() == '') {
            $("input[name='images']").val(String(response['data']['url']));
        } else {
            $("input[name='images']").val($("input[name='images']").val() + ',' + String(response['data']['url']));
        }
        imageUrl[response['data']['url'].split('/')[9]] = response['data']['url'];
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
    ifUp = 1;
});
}
initUploader();
     $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
        useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt",
        linkFormat: "YYYY-MM-DD HH:mm:ss",
        sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
        useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt_end",
        linkFormat: "YYYY-MM-DD HH:mm:ss",
        sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
    .off('resize.chosen')
    .on('resize.chosen', function() {
        $('.chosen-select').each(function() {
            var $this = $(this);
            $this.next().css({'width': $this.parent().width()});
        })
    }).trigger('resize.chosen');

    
    


    $('.renew').click(function(){
    
        $('#itemform').submit();
    });
});
var imagesDict = {};
var imageUrl = new Array();
function ifOne() {
    if (imageDict.length == 1) return false;
    else return true;
}
function bind_event(){
        $('.del-button').click(function(e) {
            //console.log(e);
            var key = imagesDict[this.parentNode.id];
            var images = $("input[name='images']").val();
            var arr_img = images.split(',');
            var result = '';
            for (var item = 0; item < arr_img.length; item++) {
                if (arr_img[item] != key) {
                    if (item == 0) result += arr_img[item];
                    else result += ',' + arr_img[item];
                }
            }
            $("input[name='images']").val(result);
            $(this.parentNode).remove();
        });
}
</script>