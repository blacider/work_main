<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script src="/static/ace/js/jquery.colorbox-min.js"></script>

<!-- page specific plugin styles -->
<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>

<?php
    $_config = $profile['group']['config'];
    $__config = json_decode($_config,True);
?>


<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('items/update');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
                                <input type="hidden" name="uid" value="<?php echo $item['uid']; ?>" />
                                <input type="hidden" name="rid" value="<?php echo $item['rid']; ?>" />
                                <label class="col-sm-1 control-label no-padding-right">金额</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" value="<?php echo $item['amount']; ?>" class="form-controller col-xs-12" name="amount" placeholder="金额" id="amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">分类</label>
                                <div class="col-xs-6 col-sm-6">
<select class="col-xs-6 col-sm-6" name="sob" id="sobs">
</select>
<select name="category" id="sob_category" class="col-xs-6 col-sm-6 sob_category chosen-select-niu" data-placeholder="类目">
</select>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费时间</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="input-group">
                                        <input id="date-timepicker1" name = 'dt1' type="text" class="form-control" />
                                        <input type="hidden" name="dt" id="dt" value="<?php echo $item['dt']; ?>">
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
                                       <input type="hidden" name="dt_end1" id="dt_end1" value="<?php echo $item_value; ?>">
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
    <input type="hidden" value="<?php echo $item['prove_ahead']; ?>">
<?php 
                                                $_prove_dict = array('0' => '报销', '1' => '预借', '2' => '预算');
?>
    <input type="hidden" value="<?php echo $item['prove_ahead']; ?>">
                                    <select class="form-control" name="type" data-placeholder="请选择类型">
<?php 
                                            foreach($_prove_dict as $val => $key){
                                                if($val == $item['prove_ahead']){
?>
<option value="<?php echo $val; ?>" selected><?php echo $key; ?></option>
<?php
                                                } else {
						if($__config['disable_borrow'] == 0 && $val == 1)
						{
?>
<option value="<?php echo $val; ?>"><?php echo $key; ?></option>
<?php
					    }
					    if($__config['disable_budget'] == 0 && $val == 2)
					    {
?>
<option value="<?php echo $val; ?>"><?php echo $key; ?></option>
<?php
					    }

                                            }
                                            }
?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">备注</label>
                                <div class="col-xs-6 col-sm-6">
                                    <textarea name="note" id="note" class="col-xs-12 col-sm-12  form-controller" ><?php echo trim($item['note']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">照片</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="col-xs-12 col-sm-12">
                                        <ul class="ace-thumbnails clearfix" id="imageList">
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <a id="filePicker" >选择图片</a>
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
var ifUp = 1;
var __BASE = "<?php echo $base_url; ?>";
var _images = '<?php echo $images; ?> ';
var item_value = '<?php echo $item_value; ?>';

var sob_id = <?php echo $sob_id; ?>;
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

var config = '<?php echo $_config?>';
var __config = JSON.parse(config);

var _item_category = '<?php echo $item['category']; ?>';
var flag = 0;
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
                    var _h = '';
                    if(item == sob_id) {
                        _h = "<option selected='selected' value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    } else {
                        _h = "<option value='" +  item + "'>"+  data[item].sob_name + " </option>";
                    }
                    selectDataCategory[item] = data[item]['category'];
                    selectDataSobs += _h;
                }
                selectPostData = data;
                updateSelectSob(selectDataSobs);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {}
        });


        var _sid = 0;
        $('#sobs').change(function(){
            var s_id = $(this).val();
            var _h = '';
            if(selectDataCategory[s_id] != undefined)
            {
                for(var i = 0 ; i < selectDataCategory[s_id].length; i++)
                {
                    if(selectDataCategory[s_id][i].category_id == _item_category) {
                        _sid = s_id;
                        _h += "<option selected='selected' value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name  + " </option>";
                    } else {
                        _h += "<option value='" +  selectDataCategory[s_id][i].category_id + "'>"+  selectDataCategory[s_id][i].category_name  + " </option>";
                    }
                    
                }
            }
            $("#sobs").attr("value", _sid);
            //var selectDom = this.parentNode.nextElementSibling.children[0]
            $(this.nextElementSibling).empty().append(_h).trigger("chosen:updated");
            $('#sob_category').trigger('change');
        });
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

// 当有文件添加进来的时候
uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" style="position:relative;float:left;border: 1px solid #ddd;border-radius: 4px;margin-right: 15px;padding: 5px;">' +
                '<img>' +
                '<div class="glyphicon glyphicon-trash red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;"></div>' +
            '</div>'
            ),
        $img = $li.find('img');
    ifUp = 0;

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
        bind_event();
    }, 150, 150 );
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
    ifUp = 0;
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
    ifUp = 1;
    $success.text('上传成功');
});


// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');
    ifUp = 1;
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
});

function updateSelectSob(data) {
    $("#sobs").empty();
    $("#sobs").append(data);
    $("#sobs").trigger('change');
    $("#sobs").trigger("chosen:updated");
}
function bind_event(){
    $('.del-button').click(function(e) {
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
function load_exists(){
    var images = eval("(" + _images + ")");
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
    get_sobs();
    var _dt = $('#dt').val();
    var images = eval("(" + _images + ")");

    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
        defaultDate: _dt,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt1",
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



$('#sob_category').change(function(){
        var category_id = $('#sob_category').val();
        if(category_id == _item_config['cid'])
        {
            $('#config_id').val(_item_config['id']);
            console.log(_item_config['id']);
            $('#config_type').val(_item_config['type']);
            $('#date-timepicker2').val(item_value);
            var _dt_end = $('#dt_end1').val();
            $('#date-timepicker2').datetimepicker({
            language: 'zh-cn',
            useCurrent: true,
            defaultDate:_dt_end,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt_end",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
             }).next().on('dp.change', function(ev){
            }).on(ace.click_event, function(){
                $(this).prev().focus();
            });

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
        if (ifUp == 0) {
            show_notify('正在上传图片，请稍候');
            return false;
        }
        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        history.go(-1);
        //$('#reset').click();
    });
    //initUploader();
});
var imagesDict = {};
</script>
