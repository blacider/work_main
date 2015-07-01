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
                人员管理
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
                                    <th>管理</th>
                                    <th>昵称</th>
                                    <th>邮箱</th>
                                    <th>手机</th>
                                    <th>
                                        <a href="#modal-table" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
<?php
foreach($members as $item){
    $extra = '';
    if($item['admin'] == 1) {
        $extra = "<span class='glyphicon glyphicon-user' style='margin-right:10px'></span>";
    }
    $str = '<tr>';
    $title = '<td style="width:50px">' . $extra . '</td>';
    $title .= '<td>' . $item['nickname'] . '</td>';
    $desc = '<td>' . $item['email']. '</td>';
    $email = '<td>' . $item['phone']. '</td>';
    $role_id = '';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
    $operation = '<td style="width:90px;"><a class="btn btn-xs btn-primary edit" data-id="'.$item['id'].'"href="javascript:void(0);" title="设置为管理员">
        <i class="ace-icon fa fa-user bigger-120"></i>
        </a>&nbsp;<a class="btn btn-xs btn-danger" href="' .  base_url('admin/user/del?id='. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
    $str = $str . $title . $desc . $email . $role_id . $operation . '</tr>';
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
                <h4 class="blue bigger"> 创建公司 </h4>
            </div>
            <form method="post" action="<?php echo base_url('groups/create'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="form-field-username">公司名称</label>
                                <div>
                                    <input class="input-large" type="text" id="form-field-username" placeholder="公司名称" name="groupname" />
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
<script language="javascript">

$(document).ready(function(){
    $('.edit').each(function(idx, item){
        $(item).click(function(){
            var _uid = $(this).data('id');
            location.href = __BASEURL + "groups/setadmin/" + _uid;
        });
    });

});
</script>
