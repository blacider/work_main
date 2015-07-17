<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<div class="page-content">
<div class="page-content-area">
<form role="form" action="<?php echo base_url('items/create');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
<div class="row">
<div class="col-xs-12 col-sm-12">
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">金额</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="amount" id="amount" placeholder="金额" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">类别</label>
<div class="col-xs-6 col-sm-6">
<select class="form-control" name="category">
<!-- <option value="0">请选择分类</option> -->
<?php foreach($categories as $category) { ?>
<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
<?php } ?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">消费时间</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker1" name="dt" type="text" class="form-control" />
<span class="input-group-addon">
<i class="fa fa-clock-o bigger-110"></i>
</span>
</div>
</div>
</div>


<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">商家</label>
<div class="col-xs-6 col-sm-6">
<input type="text" name="merchant" class="form-controller col-xs-12" placeholder="消费商家">
</div>
</div>

<?php if(count($tags) > 0){ ?>
<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">标签</label>
<div class="col-xs-6 col-sm-6">
<select class="chosen-select tag-input-style" name="tags" multiple="multiple" data-placeholder="请选择标签">
<?php foreach($tags as $category) {?>

<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php } ?>
</select>

</div>
</div>
<?php  } ?>


<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">类型</label>
<div class="col-xs-6 col-sm-6">
<select class="form-control" name="type" data-placeholder="请选择类型">
<option value="0">报销</option>
<option value="1">预算</option>
<option value="2">预借</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">留言</label>
<div class="col-xs-6 col-sm-6">
<textarea name="note" class="col-xs-12 col-sm-12  form-controller" > </textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">照片</label>
<div class="col-xs-6 col-sm-6">
    <div class="col-xs-12 col-sm-12" style="padding-left:0px;">
        <ul class="ace-thumbnails clearfix" id="timages">
        </ul>
    </div>
    <div class="col-xs-12 col-sm-12" style="padding-left: 0px; padding-top: 10px;">
        <a class="btn btn-primary btn-white" id="btn_simg" >添加图片</a>
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

<input type="hidden" id="renew" value="0" name="renew">
<div class="clearfix form-actions col-sm-8 col-xs-8">
<div class="col-md-offset-3 col-md-8">
<a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
<a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>
</div>
</div>
<input type="reset" style="display:none;" id="reset">

</div>
</div>
<input type="hidden" name="images" id="images" >
</form>
</div>
</div>

<div class="modal fade" id="select_img_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择图片</h4>
            </div>
            <div class="modal-body">
            <!--
                <div id="div_thumbnail" class="thumbnail" style="display:none;">
                    <img src="/static/images/loading.gif">
                </div>
                <input type="file" style="display:none;" id="src" name="file[]" data-url="<?php echo base_url('items/images'); ?>">
                <a class="btn btn-primary btn-white" id="btn_cimg" >选择图片</a>
            </div>
            -->
            <!--dom结构部分-->
<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
    <div id="imageList"></div>
</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";

function bind_event(){
    var $overflow = '';
    var colorbox_params = {
        rel: 'colorbox',
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="ace-icon fa fa-arrow-left"></i>',
            next:'<i class="ace-icon fa fa-arrow-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                    onComplete:function(){
                        $.colorbox.resize();
                    }
    };

    $('.rimg').click(function(){
        var _id = $(this).data('id');
        var _new = Array();
        if(_id > 0){
            var _exists = ($('#images').val()).split(",");
            $(_exists).each(function(idx, val){
                if(val != _id) {
                    _new.push(val);
                }
            });
            $('#images').val(_new.join(','));
        }
        $(this).parents('li').remove();
    });
    $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
}

$(document).ready(function(){
    //$('#fileupload').uploadFile();
    //var now = moment();
    // 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/static/third-party/webUploader/Uploader.swf',

    // 文件接收服务端。
    server: '<?php echo base_url('items/images'); ?>',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',

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
            '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<img>' +
                '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
        $img = $li.find('img');


    // $list为容器jQuery实例
    $('#imageList').append( $li );

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
    }, 100, 100 );
});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
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
uploader.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).addClass('upload-state-done');
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

uploader.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        // 通过return false来告诉组件，此文件上传有错。
        console.log(response);
        $("input[name='images']").val(response['data']['id']);
        return ture;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
});

    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm",
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
    /*
    $('#src').uploadFile(
                    {
                        dataType: 'json',
                        progressall: function (e, data) {
                                $('#div_thumbnail').show();
                                $('#btn_cimg').hide();
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                        },
                        done: function (e, data) {
                                console.log(11);
                                $('#div_thumbnail').hide();
                                $('#select_img_modal').modal('hide');
                                $('#btn_cimg').show();
                                var _server_data = data.result;
                                if(_server_data.status == 0) {
                                    show_notify('保存失败');
                                } else {
                                    var _path = _server_data.data.url;
                                    var _id = _server_data.data.id;
                                    if(_id > 0){
                                        var _exists = ($('#images').val()).split(",");
                                        if($.inArray(_id, _exists) < 0){
                                            _exists.push(_id);
                                        }
                                        $('#images').val(_exists.join(','));
                                    }
                                    var _new_img = '<li style="border:0px;" height="150">'
                                        + '<a href="' + _path + '" data-rel="colorbox" class="cboxElement" style="border:0px;">'
                                        + '<img  width="150" alt="150x150" src="' + _path + '"></a>'
                                        + '<div class="tools tools-top text-right" style="text-align:right"><a href="javascript:void(0)" class="rimg" data-id="' + _id + '"><i class="ace-icon fa fa-times red" style="padding-top: 5px;"></i></a></div>'
                                        + '</li>';
                                    $(_new_img).appendTo($('#timages'));
                                    bind_event();
                                }
                            },
                                fileuploadfail : function (){
                                    show_notify('保存失败');
                                }
                    }
    );*/

    $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange'></i>");//let's add a custom loading icon
 
    $('.renew').click(function(){
        if($('#amount').val() == 0) {
            show_notify('请输入金额');
            $('#amount').focus();
            return false;
        }
	var amount = parseInt($('#amount').val());
        if(amount <= 0) {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }
        if(isNaN($('#amount').val())) {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }

        $('#renew').val($(this).data('renew'));
        $('#itemform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    $('#btn_simg').click(function(){
        $('#select_img_modal').modal({keyborard: false});
    });

});
</script>
