


<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('members/updategroup');  ?>" method="post"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                         <div class="form-group" style="display:none">
                                <label class="col-sm-1 control-label no-padding-right">部门管理员</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" id="manager" name="manager" data-placeholder="请选择员工">
                                         <option value=0>无</option>
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">上级部门</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" id="pgroups" name= "pgroup" data-placeholder="请选择部门">
                                    <?php 
                                        if($profile['admin'] == 4 && $pid <= 0)
                                        {
                                    ?>
                                            <option value=0>顶级部门</option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value=0>顶级部门</option>
                                    <?php
                                        }
                                    ?>
                                    <?php 
                                    foreach($gnames as $g){
                                        if($profile['admin'] == 4)
                                        {
                                            if(in_array($g['id'], $admin_groups_granted) && $g['id'] != $group['id'])
                                            {
                                        ?>
                                            <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                        <?php
                                            }
                                        }
                                        else
                                        {
                                    ?>
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门名称</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门名称" class="col-xs-12" required="required" id="gname" name="gname" value="<?php echo $group['name']; ?>">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门代码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门代码" class="col-xs-12" required="required" name="gcode" value="<?php echo $group['code']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">员工</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="hidden" name="gid" value="<?php echo $group['id']; ?>" >
                                    <select class="chosen-select tag-input-style" name="uids[]" multiple="multiple"  data-placeholder="请选择员工">
                                    <?php 
                                    foreach($member as $m){
                                        if(in_array($m['id'], $smember)){
                                    ?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                                    <?php } 
                                    else 
                                    { 
                                        if($profile['admin'] == 4)
                                        {
                                            if(array_intersect($m['gids'], $admin_groups_granted))
                                            {
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                                    <?php
                                            }
                                        }
                                        else
                                        {
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                                    <?php
                                        }
                                    }
                                }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">LOGO</label>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="col-xs-12 col-sm-12">
                                      <div id="group_logo_container" class="ace-thumbnails clearfix" style="position:relative;float:left;display: none">
                                        <img id="group_logo" class="thumbnail" style="min-height: 150px; max-height: 300px; min-width: 150px; max-width: 300px;width:150px">
                                        <div href="#" class="red del-button" style="  position: absolute;right: 10px;top: 10px;cursor: pointer;">
                                          <i class="glyphicon glyphicon-trash"></i>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <a id="filePicker" >选择图片</a>
                                    </div>
                                    </div>
                            </div>
                            <input type="hidden" name="images" id="images"  value="<?php echo $group["image"]; ?>">
                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>
<script type="text/javascript">var _pid="<?php echo $pid ?>" ;</script>
<script type="text/javascript">var _manager="<?php echo $manager ?>" ;</script>
<script language="javascript">
$(document).ready(function() {
    load_exists();
});
var _image = '<?php if(array_key_exists('image',$group)){ echo $group["image"];} else {echo '';} ?> ';
var _image_url = '<?php if(array_key_exists('image_url',$group)) { echo $group["image_url"];} else {echo '';} ?>';
$(document).ready(function() {
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
        $img = $("#group_logo");
    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }

        $img.attr( 'src', src );
        $('#group_logo_container').show();
    }, 150, 150 );
});


// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $("#group_logo_container");
    var $percent = $li.find('.progress span');
    

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
        var $li = $("#group_logo_container");
        var $success = $li.find('div.success');

    // 避免重复创建
    if ( !$success.length ) {
        $success = $('<div class="success blue center"></div>').appendTo( $li );
    }
    ifUp = 1;
    $success.text('上传成功');
});


// 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $("#group_logo_container");
        var $error = $li.find('div.error');
        
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
        $("input[name='images']").val(response['data']['id']);
        return true;
    } else return false;
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $("#group_logo_container").find('.progress').remove();
});

$('.del-button').click(function(e) {
    $("input[name=images]").val(0);

    $("#group_logo").attr("src", "");
    $('#group_logo_container').hide();
});

});
function updateSelectSob(data) {
    $("#sobs").empty();
    $("#sobs").append(data);
    $("#sobs").trigger('change');
    $("#sobs").trigger("chosen:updated");
}

function load_exists(){
    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    var $img = $("#group_logo");
    if(_image_url) {
        $img.attr('src', _image_url);
        $('input[name="images"]').val(_image);
        $('#group_logo_container').show();
    }
}

var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    $("#manager").val( _manager ).attr('selected',true);
    $("#manager").trigger("chosen:updated");

    $("#pgroups").val(_pid).attr('selected',true);
    $("#pgroups").trigger("chosen:updated");
    //$("#year option[text="+_pid+"]").attr("selected",true);

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

        $('#renew').val($(this).data('renew'));
        var gname = $('#gname').val();
        if(gname.replace(/(^\s*)|(\s*$)/g,"") == "")
        {
            show_notify("请输入部门名称");
            $('#gname').focus();
            return false;
        }
        if(gname.indexOf('-') >= 0)
        {
            show_notify("部门名称中不能包含'-'");
            $('#gname').focus();
            return false;
        }
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        history.go(-1);
    });
});

</script>
