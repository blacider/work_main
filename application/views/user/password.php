<div class="bs-doc-section">
<div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><?php echo $profile['nickname']; ?></h3>
  </div>
  <div class="panel-body">

  <form id="profile_form" class="form-horizontal" role="form" method="post" action="<?php echo base_url('users/update_password'); ?>">
    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">旧密码</label>
 <div class="col-sm-10">
 <input type="password" class="form-control" id="exampleInputEmail1" placeholder="旧密码" name="old_password">
</div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">新密码</label>
    <div class="col-sm-10">
        <input type="password" class="form-control" id="exampleInputEmail1" placeholder="新密码" name="new_password">
    </div>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1" class="col-sm-2 control-label">重复新密码</label>
    <div class="col-sm-10">
        <input type="password" class="form-control" id="exampleInputEmail1" placeholder="重复密码" name="confirm_password">
    </div>
    </div>



    <div class="form-group text-center">
    <div class="col-sm-12">
<input type="submit" value="更新" class="btn btn-primary">
    </div>
    </div>

</form>

  </div>
</div>
</div>

