<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('items/update');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" value="<?php echo $item['amount']; ?>" class="form-controller col-xs-12" name="amount" placeholder="金额" id="amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="form-control" name="category">
                                        <option value="0">请选择分类</option>
                                        <?php foreach($categories as $category) {
                                            if($category['id'] == $item['category']){
?>
                                        <option selected value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
<?php 
                                            } else { ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="input-group">
                                        <input id="date-timepicker1" type="text" class="form-control" />
                                        <input type="hidden" name="dt" id="dt" value="<?php echo $item['dt']; ?>">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">商家</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" name="merchant" class="form-controller col-xs-12" value="<?php echo $item['merchants']; ?>" placeholder="消费商家">
                                </div>
                            </div>

<?php if(count($tags) > 0){ ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">标签</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="tags" multiple="multiple" data-placeholder="请选择标签">
<?php 
                                                $_tags = explode(",", $item['tags']);
                                                foreach($tags as $category) { 
                                                    if(in_array($category['id'], $_tags)){
                                        ?>

                                        <option selected value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php 
                                                    } else {
?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
<?php 
                                        } } ?>
                                    </select>

                                </div>
                            </div>
<?php  } ?>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">类型</label>
                                <div class="col-xs-6 col-sm-6">
<?php 
                                                $_prove_dict = array('0' => '报销', '1' => '预算', '2' => '预借');
?>
                                    <select class="form-control" name="type" data-placeholder="请选择类型">
<?php 
                                            foreach($_prove_dict as $val => $key){
                                                if($val == $item['prove_ahead']){
?>
<option value="<?php echo $val; ?>" selected><?php echo $key; ?></option>
<?php
                                                } else {
?>
<option value="<?php echo $val; ?>"><?php echo $key; ?></option>
<?php
                                            }
                                            }
?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">留言</label>
                                <div class="col-xs-6 col-sm-6">
                                    <textarea name="note" class="col-xs-12 col-sm-12  form-controller" ><?php echo trim($item['note']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="col-xs-12 col-sm-12">
                                        <ul class="ace-thumbnails clearfix" id="timages">
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <a id="filePicker" >选择图片</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="renew" value="0" name="renew">
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions col-sm-8 col-xs-8">
                                <div class="col-md-offset-3 col-md-8">
                                    <!--
                                    <a class="btn btn-white btn-primary renew" data-renew="1"><i class="ace-icon fa fa-check"></i>提交</a>
                                    -->

                                    <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="images" id="images"  value="<?php echo $images_ids; ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script> -->
<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>
<script src="/static/ace/js/jquery.colorbox-min.js"></script>



<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var _images = '<?php echo $images; ?> ';
var flag = 0;
function initUploader() {
    if (flag == 1) {
        console.log(1);
        return;
    } else {
        console.log(2);
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
    pick: '#filePicker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
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
    show_notify("上传成功");
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    show_notify("上传失败");
});

uploader.on( 'uploadAccept', function( file, response ) {
    if ( response['status'] > 0 ) {
        var x = JSON.parse(_images);
        x.push(response['data']);
        _images = JSON.stringify(x)
        load_exists();
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
});
}
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
function load_exists(){
    var images = eval("(" + _images + ")");
    $('#timages').empty();
    $(images).each(function(idx, item) {
        var _path = item.url;
        var _id = item.id;
        var _new_img = '<li style="border:0px;">'
            + '<a href="' + _path + '" data-rel="colorbox" class="cboxElement" style="border:0px;">'
            + '<img width="150" height="150" alt="150x150" src="' + _path + '"></a>'
            + '<div class="tools tools-top text-right" style="text-align:right"><a href="javascript:void(0)" class="rimg" data-id="' + _id + '"><i class="ace-icon fa fa-times red"></i></a></div>'
            + '</li>';
        $(_new_img).appendTo($('#timages'));
    });
    bind_event();
}
$(document).ready(function(){
    var _dt = $('#dt').val();
    var images = eval("(" + _images + ")");

    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
                defaultDate: _dt,
            format: 'YYYY-MM-DD HH:mm'
    }).next().on(ace.click_event, function(){
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
    load_exists();

    $('.renew').click(function(){
        console.log($('#amount').val());
        if($('#amount').val() == 0) {
            show_notify('请输入金额');
            $('#amount').focus();
            return false;
        }
        if($('#amount').val() == "0") {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }

        //return false;
        if(isNaN($('#amount').val())) {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }
        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        history.go(-1);
        //$('#reset').click();
    });
    initUploader();
});

</script>
