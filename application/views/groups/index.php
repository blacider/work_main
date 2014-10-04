 <div class="bs-doc-section">
<div class="panel panel-default">
  <div class="panel-heading" style="min-height:40px">
<div class="panel-title">
<div class="col-xs-8">
<?php
if($group) {
?>
    <?php echo $group['group_name']; ?>
<?php
} else {
?>
    我的组
<?php
}
?>
</div>
<div class="text-right col-xs-4"><span id="new_invite_btn" class="glyphicon glyphicon-plus"></span></div>
</div>
  </div>
 <table class="table table-striped" id="member_table">
<tr>
<td>成员昵称</td> 
<td>操作</td> 
</tr>
<?php
foreach($members as $member){
    $info = '<tr>';
    if($member['admin'] == 1) {
        $info .= "<td><span class='glyphicon glyphicon-user' style='margin-right:10px'></span>" . $member['nickname'] . '</td>';
    } else {
        $info .= "<td><span class='' style='margin-right:22px'></span>" . $member['nickname'] . '</td>';
    }
    $info .= '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$member['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$member['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $info .= "</tr>";
    echo $info;
    

}
?>

  </table>
</div>
</div>


<div class="modal fade" id="invite">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">邀请新员工</h4>
      </div>
      <form action="<?php echo base_url('groups/invite'); ?>" method="post"  role="form">
      <div class="modal-body">
<div class="form-group">
    <label for="exampleInputEmail1">员工账号(邮箱)</label>
    <input type="email" class="form-control" id="username" name="username" placeholder="员工账号">
  </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="邀请">
      </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script language="javascript">
$(document).ready(function(){
    $('#new_invite_btn').click(function(){
        $('#invite').modal(true);
    });
});
</script>
