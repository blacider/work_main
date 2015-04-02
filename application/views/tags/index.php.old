 <div class="bs-doc-section">
 <div class="well page-header">
 <div class="col-md-3">
 <h4>分类管理</h4>
 </div>
 <div class="col-md-3" style="float:right;padding-top:5px;">
 <button id="add_new_btn" class="btn btn-sm btn-primary" style="float:right;" type="button">添加分类</button>
 </div>

 <table class="table table-bordered table-striped">
 <tbody>
 <tr>
 <th>
标签名称
 </th>
 <th>
时间
 </th>
 <th>
 操作
 </th>
 </tr>
 <?php
 $m_dict = array();
 $top_category = array();
foreach($category as $item){
    $img = "";
    $str = '<tr>';
    $username = '<td class="u_username">' . $item['name'] . '</td>';
    $role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
    $operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username .  $role_id .   $operation_upd . '</tr>';
echo $str;
}
?>
</tbody> <!-- /tbody -->
</table> <!-- /table -->
</div> <!-- /.well -->
</div><!--/span-->
</div><!--/row-->



<div class="modal fade" id="newcategory_dialog">
<div class="modal-dialog">
<div class="modal-content">
<form action="<?php echo base_url('tags/create');?>" method="post"  class="form-horizontal" role="form">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">添加新分类</h4>
</div>
<div class="modal-body">
<div class="form-group">
<label class="col-sm-2 control-label">分类名称</label>
<div class="col-sm-10">
<input type="text"  class="form-control" id="category_name" name="category_name" placeholder="分类名称" required />
<input type="hidden"  id="category_id" name="category_id" value="0" required />
</div>
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
<button type="submit" class="btn btn-success" >提交</button>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script language="javascript">
var _ERROR = "<?php echo $error; ?>";
$(document).ready(function(){
    if(_ERROR) show_notify(_ERROR);
    $('#add_new_btn').click(function(){
        $('#category_id').val('0');
        $('#newcategory_dialog').modal();
    });
    $('.edit').each(function(){
        $(this).click(function(){
            var _title = $(this).data('title');
            var _id = $(this).data('id');

            $('#category_name').val(_title);
            $('#category_id').val(_id);
        $('#newcategory_dialog').modal();

        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/tags/drop/" + _id;
            }
        });
    });
});
</script>


