<style type="text/css">
 .add_new_pannel {
width:600px;
height:400px;
display:none;
z-index:2;
margin:auto;
position:absolute;
left:50%;
top:50%;
margin-left:-300px;
margin-top:-200px;
}
 .update_pannel {
width:600px;
height:400px;
display:none;
 z-index:2;
margin:auto;
position:absolute;
left:50%;
top:50%;
 margin-left:-300px;
 margin-top:-200px;
  }
 </style>
 <div class="bs-doc-section">
 <div class="well page-header">
 <div class="col-md-3">
 <h4>日志列表</h4>
 </div>
 <div class="col-md-3" style="float:right;padding-top:5px;">
 </div>

 <table class="table table-bordered table-striped">
 <tbody>
 <tr>
 <th>
机器
 </th>
 <th>
消息
 </th>
 <th>
类型
 </th>
 <th>
级别
 </th>
 <th>
时间
 </th>
 </tr>
 <?php
foreach($alist as $item){
$str = '<tr>';
$username = '<td class="u_username">' . $item['host'] . '</td>';
$nickname = '<td class="u_nickname"><p title="' . $item['message'] . '">' . mb_substr($item['message'], 0, 30) . '</p></td>';
$type =  '<td class="u_type_name">' . $item['type'] . '</td>';
$role_id =  '<td class="u_role_name">' . $item['level'] . '</td>';
$ascription =  '<td class="u_role_name">' . $item['lastdt'] . '</td>';
$str = $str . $username . $nickname . $type . $role_id . $ascription . '</tr>';
echo $str;
}
?>
</tbody> <!-- /tbody -->
</table> <!-- /table -->
                <div>
                    <?php echo $pager; ?>
                </div>
</div> <!-- /.well -->

</div><!--/span-->
</div><!--/row-->


<div class="modal fade" id="newuser_dialog">
<div class="modal-dialog">
<div class="modal-content">
<form action="<?php echo base_url('users/create');?>" method="post"  class="form-horizontal" role="form">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">添加新用户</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label class="col-sm-2 control-label">用户名</label>
<div class="col-sm-10">
<input type="text"  class="form-control" id="username" name="username" placeholder="用户名" required />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">密码</label>
<div class="col-sm-10">
<input type="password"  class="form-control" id="password" name="password" placeholder="密码" required />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">昵称</label>
<div class="col-sm-10">
<input type="text" name="nickname"  class="form-control" id="nickname" placeholder="昵称" required />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">角色</label>
<div class="col-sm-10">
<select name="role" id="role"  class="form-control">
<option value="0">管理员</option>
<option value="1">工作人员</option>
</select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">隶属</label>
<div class="col-sm-10">
<select name="ascription" id="ascription"  class="form-control">
<option value="0">平台</option>
<?php
foreach($customers as $item){
echo "<option value='" . $item['id'] ."'>" . $item['name'] . "</option>";
}
?>
</select>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
<button type="submit" class="btn btn-success" >创建</button>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="updateuser_dialog">
<div class="modal-dialog">
<div class="modal-content">
<form action="<?php echo base_url('users/update');?>" method="post"  class="form-horizontal" role="form">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">修改用户</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label class="col-sm-2 control-label">用户名</label>
<div class="col-sm-10">
<label id="lusername"></label>
<input type="hidden"  id="uid" name="uid" value="0" ></label>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">密码</label>
<div class="col-sm-10">
<input type="password"  class="form-control" id="upassword" name="password" placeholder="密码" />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">昵称</label>
<div class="col-sm-10">
<input type="text" name="nickname"  class="form-control" id="unickname" placeholder="昵称"  />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">角色</label>
<div class="col-sm-10">
<select name="role" id="urole"  class="form-control">
<option value="0">管理员</option>
<option value="1">工作人员</option>
</select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">隶属</label>
<div class="col-sm-10">
<select name="ascription" id="uascription"  class="form-control">
<option value="0">平台</option>
<?php
foreach($customers as $item){
echo "<option value='" . $item['id'] ."'>" . $item['name'] . "</option>";
}
?>
</select>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
<button type="submit" class="btn btn-success" >更新</button>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script language="javascript" src="<?php echo base_url('static/js/updatepwd.js'); ?>"></script>

<script type="text/javascript" >
$(document).ready(function(){
        $('#add_new_btn').click(function(){
                $('#newuser_dialog').modal();
            });

        $('.del').each(function(){
                $(this).click(function(){
                        if(confirm('真的要删除吗?')) {
                            var _id = $(this).data('id');
                            if(_id == 0) {
                                alert('参数错误');
                                return false;
                            }
                            location.href = __BASEURL + 'users/delete/' + _id;
                        }

                    });
            });

        $('.edit').each(function(){
                $(this).click(function(){
                        // get data
                        var _id = $(this).data('id');
                        $.getJSON(__BASEURL + 'users/info/' + _id,
                                  function(data){
                                      if(data.status) {
                                          var _user = data.data;
                                          $('#lusername').html(_user.username);
                                          $('#uid').val(_user.id);
                                          $('#unickname').val(_user.nickname);
                                          $('#urole').val(_user.role);
                                          $('#uascription').val(_user.ascription);
                                          $('#updateuser_dialog').modal('show');
                                      } else {
                                          alert(data.msg);
                                      }
                                  });
                    });
            });
    });
</script>
