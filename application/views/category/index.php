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
分类名称
 </th>
 <th>
消费限制
 </th>
 <th>
父级分类
 </th>
 <th>
时间
 </th>
 <th>
预审核
 </th>
 <th>
 操作
 </th>
 </tr>
 <?php
 $m_dict = array();
 $top_category = array();
 foreach($category as $item){
     if($item['pid'] == 0){
         $top_category[$item['id']] = $item;
     }
 }
foreach($category as $item){
    $img = "";
    if($item['pid'] == 0){
        $img = "顶级分类";
    } else {
        $img = $top_category[$item['pid']]['category_name'];
    }
    $billable = $item['prove_before'] == 1 ? '前置审批' : '不需要前置审批';
$str = '<tr>';
$username = '<td class="u_username">' . $item['category_name'] . '</td>';
$nickname = '<td class="u_nickname">' . $img . '</td>';
$max_limit = '<td class="u_nickname">' . $item['max_limit'] . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
$ascription =  '<td class="u_role_name">' . $billable . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-max="' . $item['max_limit'] . '" data-pid="'. $item['pid'] . '" data-pb="' . $item['prove_before'] . '" data-title="' . $item['category_name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username . $max_limit . $nickname . $role_id . $ascription .  $operation_upd . '</tr>';
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
<form action="<?php echo base_url('category/create');?>" method="post"  class="form-horizontal" role="form">
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

<div class="form-group">
<label class="col-sm-2 control-label">消费限制</label>
<div class="col-sm-10">
<input type="text" name="max_limit" id="max_limit" placeholder="消费金额限制" class="form-control">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">预审核</label>
<div class="col-sm-10">
<select name="prove_ahead" class="form-control" id="prove_ahead">
<option value="0">不需要预审核</option>
<option value="1">需要预审核</option>
</select>

</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">隶属</label>
<div class="col-sm-10">
<select name="pid" id="pid"  class="form-control">
<option value="0">顶级</option>
<?php
foreach($top_category as $item){
echo "<option value='" . $item['id'] ."'>" . $item['category_name'] . "</option>";
}
?>
</select>
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
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
            var _pa = $(this).data('pb');
            var _max_limit = $(this).data('max');


            $('#category_name').val(_title);
            $('#category_id').val(_id);
            $('#max_limit').val(_max_limit);
            $('#prove_ahead').val(_pa);
            $('#pid').val(_pid);
        $('#newcategory_dialog').modal();

        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/category/drop/" + _id;
            }
        });
    });
});
</script>


