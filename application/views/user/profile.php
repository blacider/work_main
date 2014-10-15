<div class="bs-doc-section">
<div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><?php echo $profile['nickname']; ?></h3>
  </div>
  <div class="panel-body">

  <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_profile'); ?>">
    <div class="form-group text-center">
    <img src="<?php echo $avatar_path; ?>" alt="" class="img-rounded">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">用户昵称</label>
 <div class="col-sm-10">
 <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $profile['nickname']; ?>" name="nickname">
</div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">邮箱</label>
    <div class="col-sm-10">
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $profile['email']; ?>" name="email">
    </div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">手机</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $profile['phone']; ?>" name="phone">
    </div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">微信</label>
    <div class="col-sm-10">
        <?php 
$display = '尚未绑定';
if($profile['wx_token']){
    $display = '已绑定';
}
?>
    <label for="exampleInputEmail1" class="control-label"><?php echo $display; ?></label>
    </div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">所属的组</label>
    <div class="col-sm-10">
        <?php 
$admin = '';
            if($profile['admin']){
                $admin = "<span class='glyphicon glyphicon-user' style='margin-left:10px' title='管理员标志'></span>";
            }
        ?>
        <label for="exampleInputEmail1" class="control-label"><?php echo $profile['group']['group_name']; echo $admin; ?></label>
    </div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">最近一次更新</label>
    <div class="col-sm-10">
        <label for="exampleInputEmail1" class="control-label"><?php echo date('Y-m-d', $profile['lastdt']); ?></label>
    </div>
    </div>
    <div class="form-group text-center">
    <div class="col-sm-12">
    <a href="javascript:void;" class="btn btn-primary" id="update_btn">更新</a>
    </div>
    </div>

</form>

  </div>
</div>
</div>

<div class="modal fade" id="modal_password">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">安全验证</h4>
      </div>
      <div class="modal-body">



    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="exampleInputEmail1" class="col-sm-4 control-label">请重新输入密码</label>
            <div class="col-sm-6">
                <input type="passsword" name="password" id="password" class="form-control" >
            </div>
        </div>
    </form>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" id="validate" class="btn btn-primary">验证</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script language="javascript">
$(document).ready(function(){
    $("#update_btn").click(function(){
        $('#modal_password').modal();
    });
    $('#validate').click(function(){
        var _password = $('#password').val();
        $('#old_password').val(_password);
        $.post(__BASEURL + "users/validate_pwd", {password : _password})
            .success(function(data){
                var _data = $.parseJSON(data);
                if(_data['status'] > 0) {
                    show_notify("密码验证成功");
                    $('#profile_form').submit();
                } else {
                    show_notify("密码验证错误");
                }
            })
                .error(function(){
                    show_notify("密码验证错误");
                })
                    .complete(function(){
                        $('#modal_password').modal('hide');
                    });
    });
});
</script>
