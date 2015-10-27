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
                                    <th>序号</th>
                                    <th>显示名称</th>
                                    <th>类型</th>
                                    <th>生效</th>
                                    <th>更新时间</th>
                                    <th class="hidden-680">
                                         <a href="<?php echo base_url('company/custom_item_create')?>" role="button" class="green" data-toggle="modal">
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
     $idx = 0;
foreach($rules as $item){
    $idx += 1;
    if($item['type'] != 1) continue;
    if($item['disabled'] == 1) continue;
    $_name = '';
    switch($item['type']) {
    case 1: $_name = '备注'; break;
    case 2: $_name = '多时间段'; break;
    case 3: $_name = '多选'; break;
    case 4: $_name = '多选'; break;
    case 5: $_name = '多人员均值'; break;
    }
    $_disabled = $item['active'];
        $_checked = 'checked';
    if($_disabled == 0) {
    $_checked = '';
    }
        $_disable_str = '<div class="checkbox"> <label> <input name="form-field-checkbox" data-id="' . $item['id'] . '" class="disabled_label ace ace-switch" ' . $_checked . ' type="checkbox" /> <span class="lbl"> </span> </label> </div>';

    $img = "";
    $str = '<tr>';
    $username = '<td class="u_username">' . $idx . '</td>';
    $username .= '<td class="u_username">' . $item['name'] . '</td>';
    $username .= '<td class="u_username">' . $_name . '</td>';
    $username .= '<td class="u_username">' . $_disable_str . '</td>';
    $role_id =  '<td class="u_role_name">' . $item['lastdt'] . '</td>';
    $operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit"  data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    // <a href="javascript:void(0);" class="edit"  data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   
    // 诶呦，实在是懒得写修改了
    $str = $str . $username . $role_id . $operation_upd . '</tr>';
    echo $str;

}
 }
?> 
</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->

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

           location.href=__BASEURL+"/company/custom_item_create/"+ _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/company/delete_custom_item/" + _id;
            }
        });
    });
    $('.disabled_label').change(function() {
        var _id = $(this).data('id');
        var _url = __BASEURL + "/company/deactive_custom_item/" + _id
        if($(this).prop('checked')) {
            _url = __BASEURL + "/company/active_custom_item/" + _id
        }
        $.getJSON(_url, function (data){ 
            if(data.status) {
                show_notify('操作成功');
            } else {
                show_notify('操作失败');
            }
        });

    });
});
</script>
