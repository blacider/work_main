<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                分类管理
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
                                    <th>分类名称</th>
                                    <th>消费限制</th>
                                    <th>上级分类</th>
                                    <th>所属帐套</th>
                                    <th>创建时间</th>
                                    <!-- <th>预审批</th> -->
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
        if(array_key_exists($item['pid'], $top_category)){
            $img = $top_category[$item['pid']]['category_name'];
        }
    }
    $billable = $item['prove_before'] == 1 ? '前置审批' : '不需要前置审批';
    $str = '<tr>';
$username = '<td class="u_username">' . $item['category_name'] . '</td>';
$nickname = '<td class="u_nickname">' . $img . '</td>';
$max_limit = '<td class="u_nickname">' . $item['max_limit'] . '</td>';
$acc_name = '<td class="u_sobname">' . $item['sob_name'] . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
//$ascription =  '<td class="u_role_name">' . $billable . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-max="' . $item['max_limit'] . '" data-sob_id="'. $item['sob_id'] . '" data-pid ="' . $item['pid'] . '" data-pb="' . $item['prove_before'] . '" data-title="' . $item['category_name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('admin/user/del?id='. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
$str = $str . $username . $max_limit . $nickname . $acc_name . $role_id  .  $operation_upd . '</tr>';
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
                                <label for="form-field-username">帐套选择</label>
                                <div>
                                    <select name="sob_id" id="sob_id"  class="form-control">
                                    <option value="0">没有帐套</option>
                                    <?php
                                    foreach($sobs as $item){
                                    echo "<option value='" . $item['sob_id'] ."'>" . $item['sob_name'] . "</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>

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
<script type="text/javascript">
    __BASEURL = "<?php echo $base_url; ?>"
</script>
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
            var _sob_id = $(this).data('sob_id');
            var _id = $(this).data('id');
            var _pa = $(this).data('pb');
            var _max_limit = $(this).data('max');
            $('#category_name').val(_title);
            $('#category_id').val(_id);
            $('#max_limit').val(_max_limit);
            $('#prove_ahead').val(_pa);
            $('#pid').val(_pid);
	    $('#sob_id').val(_sob_id);
        $('#modal-table').modal();

        });
    });
});
</script>
