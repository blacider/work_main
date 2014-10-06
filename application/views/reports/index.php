 <div class="bs-doc-section">


 <div class="col-md-3">
 <h4>报表列表</h4>
 </div>
 <div class="col-md-3" style="float:right;padding-top:5px;">
 <button id="add_new_btn" class="btn btn-sm btn-primary" style="float:right;" type="button">添加报销单</button>
 </div>

 <table class="table table-bordered table-striped">
 <tbody>
 <tr>
 <th>
报表名称
 </th>
 <th>
相关的Item数量
 </th>
 <th>
时间
 </th>
 <th>
发起员工
 </th>
 <th>
 操作
 </th>
 </tr>
 <?php
 $m_dict = array();
foreach($items as $item){
$str = '<tr>';
$username = '<td class="u_username">' . $item['title'] . '</td>';
$nickname = '<td class="u_nickname">' . 0 . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
$ascription =  '<td class="u_role_name">' . $item['nickname'] . '</td>';
$image =  '';//'<td class="u_role_name">' . $img  . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username . $nickname . $role_id . $ascription . $image . $operation_upd . '</tr>';
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
<script language="javascript">
$(document).ready(function(){

    $('#add_new_btn').click(function(){
        location.href = __BASEURL + "reports/create";
    });
});
</script>
