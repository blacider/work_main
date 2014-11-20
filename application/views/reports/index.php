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
<!--
 <th>
发起员工
 </th>
-->
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
//$ascription =  '<td class="u_role_name">' . $item['nickname'] . '</td>';
$image =  '';//'<td class="u_role_name">' . $img  . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username . $nickname . $role_id . $image . $operation_upd . '</tr>';
//$str = $str . $username . $nickname . $role_id . $ascription . $image . $operation_upd . '</tr>';
echo $str;
}
?>
</tbody> <!-- /tbody -->
</table> <!-- /table -->
</div> <!-- /.well -->
</div><!--/span-->
</div><!--/row-->


<script language="javascript">
$(document).ready(function(){

    $('#add_new_btn').click(function(){
        location.href = __BASEURL + "reports/create";
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm("确认要删除么？")){
                var _id = $(this).data('id');
                location.href = __BASEURL + "reports/del/" + _id;
            }
        });
    });
});
</script>
