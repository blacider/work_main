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


<select class="col-xs-6 col-sm-6" class="form-control" name="sob" id="sobs">
</select>


<select class="col-xs-6 col-sm-6" name="category" id="sob_category" class="sob_category chosen-select-niu" data-placeholder="类目">
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

<div class="form-group" id="endTime" hidden>
<label class="col-sm-1 control-label no-padding-right">至</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker2" name="dt_end" type="text" class="form-control" />
<input type="hidden" id="config_id" name="config_id" />
<input type="hidden" id="config_type" name="config_type"/>
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
<?php
    $_config = '';
    if(array_key_exists('config',$profile['group']))
    {
    	$_config = $profile['group']['config'];
    }
    $__config = json_decode($_config,True);
?>


<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">类型</label>
<div class="col-xs-6 col-sm-6">
<select class="form-control" name="type" data-placeholder="请选择类型">
<option value="0">报销</option>
<?php 
if($__config['disable_borrow']=='0')
{
?>
<option value="1">预借</option>
<?php
}
if($__config['disable_budget'] == '0')
{
?>
<option value="2">预算</option>
<?php
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">备注</label>
<div class="col-xs-6 col-sm-6">
<textarea name="note" id="note" class="col-xs-12 col-sm-12  form-controller" > </textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">照片</label>
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
    
    <div class="col-xs-12 col-sm-12" style="padding-left: 0px; padding-top: 10px;">
        <a class="filePicker" id="btn_simg" >添加图片</a>
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

<script language="javascript">
var ifUp = 1;
var __BASE = "<?php echo $base_url; ?>";
var config = '<?php echo $_config?>';
var __item_config = '<?php echo json_encode($item_config);?>';
var item_config = '';
if(__item_config!='')
{
    item_config = JSON.parse(__item_config);
}
var _item_config = [];
for(var i = 0 ; i < item_config.length; i++)
{
    if(item_config[i].type == 2)
    {
        _item_config = item_config[i];
    }
}
console.log(_item_config);
var __config = '';
if(config !='')
{
    __config = JSON.parse(config);
}
var not_auto_note = "";
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
            console.log(e);
            var key = imagesDict[this.parentNode.id].split("WU_FILE_")[1];
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

    function updateSelectSob(data) {
                                $("#sobs").empty();
                                $("#sobs").append(data);
                                $("#sobs").trigger('change');
                                $("#sobs").trigger("chosen:updated");
                            }
function get_sobs(){
   var selectPostData = {};
   var selectDataCategory = {};
   var selectDataSobs = '';
        $.ajax({
            url : __BASE + "category/get_my_sob_category",
            dataType : 'json',
            method : 'GET',
            success : function(data){
                for(var item in data) {
                    var _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    selectDataCategory[item] = data[item]['category'];
                    selectDataSobs += _h;
                }
                selectPostData = data;
                updateSelectSob(selectDataSobs);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {}
        });


        $('#sobs').change(function(){
            var s_id = $(this).val();
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    var _note = selectDataCategory[s_id][i].note;
                    if(_note) {
                        _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + "( " + _note + " ) </option>";
                    } else{
                        _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name + " </option>";
                    }
                    
                }
            }
            //var selectDom = this.parentNode.nextElementSibling.children[0]
            $(this.nextElementSibling).empty().append(_h).trigger("chosen:updated");
            $('#sob_category').trigger('change');
        });
}

$(document).ready(function(){
    get_sobs();
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

    $('#date-timepicker2').datetimepicker({
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

    $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange'></i>");//let's add a custom loading icon
    
    $('#sob_category').change(function(){
        var category_id = $('#sob_category').val();
        if(category_id == _item_config['cid'])
        {
            $('#config_id').val(_item_config['id']);
            console.log(_item_config['id']);
            $('#config_type').val(_item_config['type']);
            $('#date-timepicker2').val('');
            $('#endTime').show();
        }
        else
        {
            $('#config_id').val('');
            $('#config_type').val('');
            $('#date-timepicker2').val(-1);
            $('#endTime').hide();
        }
    });

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

        if (ifUp == 0) {
            show_notify('正在上传图片，请稍候');
            return false;
        }
        if(isNaN($('#amount').val())) {
            show_notify('请输入有效金额');
            $('#amount').val('');
            $('#amount').focus();
            return false;
        }

         var dateTime = $('#date-timepicker1').val()
        if(__config['not_auto_time'] == 1)
        {
            if(dateTime == '')
            {
                show_notify('请填写时间');
                //$('#date-timepicker1').focus();
                return false;
            }
        }

         var dateTime2 = $('#date-timepicker2').val()
        if(__config['not_auto_time'] == 1)
        {
            if(dateTime2 == '')
            {
                show_notify('请填写结束时间');
                //$('#date-timepicker1').focus();
                return false;
            }
            console.log((dateTime2>0));
            if((dateTime2>'0') && (dateTime2 < dateTime))
            {
                show_notify('结束时间应该大于开始时间');
                return false;
            }
        }

        var note = $('#note').val();
        if(__config['note_compulsory'] == 1)
        {
            if(note.trim()=='')
            {

                show_notify('请输入备注');
                $('#note').focus();
                return false;
            }
        }
        //console.log($('#sob_category').val());
        if($('#sob_category').val() == null)
        {
            show_notify('请选择类目');
            return false;
        }

        $('#renew').val($(this).data('renew'));
       // $('#itemform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    initUploader();
});
var imagesDict = {};
</script>
