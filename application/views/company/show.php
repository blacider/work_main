<!-- /section:basics/sidebar -->
<div class="main-content">

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>规则名称</th>
                                    <th>创建时间</th>
                                    <th class="hidden-680">
                                         <a href="<?php echo base_url('company/create')?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a> 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
 <?php
 $m_dict = array();
 $top_category = array();
 if($rules)
 {
foreach($rules as $item){
    $img = "";
    $str = '<tr>';
$username = '<td class="u_username">' . $item['name'] . '</td>';
$role_id =  '<td class="u_role_name">' . $item['lastdt'] . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
$operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit"  data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('/company/delet_rule/'. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
$str = $str . $username . $role_id . $operation_upd . '</tr>';
echo $str;

}
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
                <h4 class="blue bigger"> 创建规则 </h4>
            </div>
            <form method="post" action="<?php echo base_url('company/rule_create'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group col-sm-5">
                                <label for="form-field-username">规则名称</label>
                                <div>
                                    <input class="input-large" type="text" placeholder="规则名称" id="rule_name" name="rule_name" />
                                   <!-- <input type="hidden"  id="category_id" name="category_id" value="0" required /> -->
                                </div>
                            </div>
                       
                              <div class="form-group col-sm-5">
                                <label for="form-field-username">规则名称</label>
                                <div>
                                    <input class="input-large" type="text" placeholder="规则名称" id="rule_name" name="rule_name" />
                                   <!-- <input type="hidden"  id="category_id" name="category_id" value="0" required /> -->
                                </div>

                            </div>

                            <div class="form-group col-sm-5">
                                <label for="form-field-username">规则名称</label>
                          <div>
                                    <input class="input-large" type="text" placeholder="规则名称" id="rule_name" name="rule_name" />
                                   <!-- <input type="hidden"  id="category_id" name="category_id" value="0" required /> -->
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
<script type="text/javascript">
    var __BASEURL = "<?php echo $base_url; ?>";
</script>
<script language="javascript">

$(document).ready(function(){

    $('.edit').each(function(idx, item){
        $(item).click(function(){

            var _title = $(this).data('title');
            var _id = $(this).data('id');

           location.href=__BASEURL+"/company/update/"+ _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/company/delete_rule/" + _id;
            }
        });
    });
});
</script>
