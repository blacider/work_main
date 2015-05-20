<div class="page-content">
    <div class="page-content-area">
        <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_profile'); ?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">头像</label>
                        <div class="col-xs-6 col-sm-6">
                            <?php $user = $member; ?>
                            <?php $disabled = $self == 1 ? '' : 'disabled'; ?>
<?php 
$path = "http://reim-avatar.oss-cn-beijing.aliyuncs.com/" . $user['apath'];
if("" == $user['apath']) {
    $path = base_url('/static/default.png');
}
?>

<!--avatar_container <a id="btn_cimg" style="height:140px;width:140px" href="javascript:void(0)" class="avatar thumbnail"> btn btn-primary btn-white-->
          <a id="btn_cimg" style="height:144px;width:155px" class="btn btn-primary btn-white"><img src="<?php echo $path;?>" style="height:130px;width:130px" /> </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">邮箱</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                            <input type="text" class="col-xs-6 col-sm-6 form-control" value="<?php echo $user['email']; ?>" disabled />
                            <!-- <label class="control-label"><?php echo $user['email']; ?></label> -->
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">手机</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="hidden" name="phone" value="<?php echo $user['phone']; ?>">
                            <!-- <label class="control-label"><?php echo $user['phone']; ?></label> -->
                            <input type="text" class="col-xs-6 col-sm-6 form-control" value="<?php echo $user['phone']; ?>" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">昵称</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="text" class="col-xs-6 col-sm-6 form-control" value="<?php echo $user['nickname']; ?>" <?php echo $disabled; ?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right">银行卡号</label>
                        <div class="col-xs-6 col-sm-6">
                            <input type="text" value="<?php echo $user['credit_card']; ?>" class="form-controller col-xs-12" name="credit_card" placeholder="银行卡号" <?php echo $disabled; ?>>
                        </div>
                    </div>

                    <div class="clearfix form-actions col-md-8">
                        <div class="col-md-offset-3 col-md-12">
                            <a class="btn btn-white btn-primary password" data-renew="1"><i class="ace-icon fa fa-key"></i>修改密码</a>

                            <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                        </div>
                    </div>

                </div>
            </div>
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
                <div id="div_thumbnail" class="thumbnail" style="display:none;">
                    <img src="/static/images/loading.gif">
                </div>
                <input type="file" style="display:none;" id="src" name="file" data-url="<?php echo base_url('items/images'); ?>" data-form-data='{"type": "0"}'>
                <a class="btn btn-primary btn-white" id="btn_cimg" >选择图片</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="password_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">

                <form id="password_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_password'); ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">旧密码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="old_password" type="password" class="form-controller col-xs-12" placeholder="旧密码" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">新密码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="password" type="password" class="form-controller col-xs-12 br3 inp" placeholder="新密码" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">重复新密码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input name="repassword" type="password" class="form-controller col-xs-12 br3 inp" placeholder="重复新密码" />
                                </div>
                            </div>


                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary update_password" data-renew="0"><i class="ace-icon fa fa-save "></i>修改并登出</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
<script src="/static/third-party/jfu/js/jquery.fileupload.js"></script>
<script language="javascript">
    var __self = "<?php echo $self; ?>";
$(document).ready(function(){
    $('#src').fileupload(
                    {
                        dataType: 'json',
                        progressall: function (e, data) {
                                $('#div_thumbnail').show();
                                $('#btn_cimg').hide();
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                        },
                            done: function (e, data) {
                                $('#div_thumbnail').hide();
                                $('#select_img_modal').modal('hide');
                                $('#btn_cimg').show();
                                var _server_data = data.result;
                                if(_server_data.status == 0) {
                                    show_notify('保存失败');
                                } else {
                                    var _path = _server_data.data.url;
                                    var _id = _server_data.data.id;
                                    $('#avatar_container').html('<img src="' + _path + '" style="height:130px;width:130px;">');
                                }
                            },
                                fileuploadfail : function (){
                                    show_notify('保存失败');
                                }
                    }
    );
    $('.avatar').click(function(){
        if(0 == __self) return false;
        $('#btn_cimg').show();
        $('#select_img_modal').modal({keyborard: false});
    });

    $('.renew').click(function(){
        $('#profile_form').submit();
    });

    $('#btn_cimg').click(function(){
        $('#src').click();
    });
    $('.password').click(function(){
        $('#password_modal').modal({keyborard: false});
    });
    $('.update_password').click(function(){
        $('#password_form').submit();
    });
});
</script>



