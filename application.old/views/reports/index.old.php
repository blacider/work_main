<!-- /section:basics/sidebar -->
<div class="main-content">

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                报销管理
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>报表名称</th>
                                    <th>相关的Item数量 </th>
                                    <th>总金额</th>
                                    <th>时间</th>
                                    <th>审核状态</th>
                                    <th class="hidden-680">
                                        <a href="#modal-table" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$m_dict = array();
$top_category = array();
/*
foreach($category as $item){
if($item['pid'] == 0){
$top_category[$item['id']] = $item;
}
}
 */
 $m_dict = array();
foreach($items as $item){
    if($item['status'] == -1) continue;
    $st = '<button class="btn btn-xs"><i class="ace-icon fa fa-pencil align-top bigger-125"></i></button>';
        switch($item['status']) {
        case 1 : {
    $st = '<button class="btn btn-info btn-xs"><i class="ace-icon fa fa-cog align-top bigger-125"></i></button>';
        };break;
        case 2 : {
    $st = '<button class="btn btn-success btn-xs"><i class="ace-icon fa fa-check -align-top bigger-125"></i></button>';
        }; break;
        case 3 : {
    $st = '<button class="btn btn-danger btn-xs"><i class="ace-icon glyphicon glyphicon-remove -align-top bigger-125"></i></button>';
        };break;
        }
$str = '<tr>';
$username = '<td class="u_username">' . $item['title'] . '</td>';
$nickname = '<td class="u_nickname">' . $item['item_count'] . '</td>';
$nickname .= '<td class="u_ntotal">' . $item['amount'] . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
$role_id .= '<td class="u_ntotal">' . $st . '</td>';
//$ascription =  '<td class="u_role_name">' . $item['nickname'] . '</td>';
$image =  '';//'<td class="u_role_name">' . $img  . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

$str = $str . $username . $nickname . $role_id . $image . $operation_upd . '</tr>';
//$str = $str . $username . $nickname . $role_id . $ascription . $image . $operation_upd . '</tr>';
echo $str;
}

?>
</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->

<div id="modal-table" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger"> 创建分类 </h4>
            </div>
            <form method="post" action="<?php echo base_url('category/create'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label for="form-field-username">分类名称</label>
                                <div>
                                    <input class="input-large" type="text"  placeholder="分类名称" id="category_name" name="category_name" />
                                    <input type="hidden"  id="category_id" name="category_id" value="0" required />
                                </div>
                            </div>
                            <div class="space-4"></div>


                            <div class="form-group">
                                <label for="form-field-username">消费限制</label>
                                <div>
                                    <input class="input-large" type="text" placeholder="消费限制" id="max_limit" name="max_limit" />
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label for="form-field-username">预审批</label>
                                <div>
                                    <select name="prove_ahead" class="form-control" id="prove_ahead">
                                        <option value="0">不需要预审核</option>
                                        <option value="1">需要预审核</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label for="form-field-username">隶属</label>
                                <div>
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
                            <div class="space-4"></div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        取消
                    </button>
                    <input type="submit" class="btn btn-sm btn-primary">
                </div>
            </form>
        </div>
    </div>
</div><!-- PAGE CONTENT ENDS -->

</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->



<div id="modal-form" class="modal in" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="blue bigger">发票</h4>
            </div>

            <div class="modal-body">
                <div class="row center" id="img_invoice">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

            </div>
        </div>
    </div>
</div>







<script language="javascript">

$(document).ready(function(){

    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/category/drop/" + _id;
            }
        });
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
        $('#modal-table').modal();

        });
    });
    $('.invoice').each(function(idx, item){
        $(item).click(function(){
            var info = $(this).data('src');
            $('#img_invoice').html('<img src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' + info + '">');
            $('#modal-form').modal({backdrop: 'static', show : true});
        });
    });
});
</script>
