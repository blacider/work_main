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
 <h4>用户列表</h4>
 </div>
 <div class="col-md-3" style="float:right;padding-top:5px;">
 <button id="add_new_btn" class="btn btn-sm btn-primary" style="float:right;" type="button">添加用户</button>
 </div>

 <table class="table table-bordered table-striped">
 <tbody>
 <tr>
 <th>
 用户名
 </th>
 <th>
 昵称
 </th>
 <th>
 角色
 </th>
 <th>
 隶属商户
 </th>
 <th>
 操作
 </th>
 </tr>
 <?php
 $m_dict = array();
foreach($customers as $m){
    $m_dict[$m['id']] = $m;
}
foreach($alist as $item){
$role = $item['role'] == 1 ? '工作人员' : '管理员';
$key = $item['ascription'];
$museum = $item['ascription'] == 0 ? '平台' : '';
if($museum == ''){
    if(array_key_exists($key, $m_dict)){
        $museum = $m_dict[$key]['name'];
    }
    $museum = $museum == "" ? '隶属商户已删除' : $museum;
}
$str = '<tr>';
$username = '<td class="u_username">' . $item['username'] . '</td>';
$nickname = '<td class="u_nickname">' . $item['nickname'] . '</td>';
$role_id =  '<td class="u_role_name">' . $role . '</td>';
$ascription =  '<td class="u_role_name">' . $museum . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username . $nickname . $role_id . $ascription . $operation_upd . '</tr>';
echo $str;
}
?>
</tbody> <!-- /tbody -->
</table> <!-- /table -->
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
