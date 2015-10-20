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
                                    <th class='blue'>消息列表</th>
                                    <th class='blue'>最后修改时间</th>
                                    <th class='blue'>发送时间</th>
                                    <th class='blue'><a href="<?php echo base_url('broadcast/create')?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a> </th>
                                    <!--
                                    <th class="hidden-680">
                                         <a href="<?php echo base_url('company/flow_create')?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a> 
                                    </th> 
                                    -->
                                </tr>
                            </thead>
                            <tbody>
 <?php
 

foreach($broadcast as $item){
    $img = "";
    $senddt = $item['senddt'];
    if($item['sent'] == 0)
    {
    	$str = "<tr class='blue'>";
    	$senddt = '';
    }
    else
    {
    	$str = '<tr>';
	}
    $title = '<td class="u_username">' . $item['title'] . '</td>';
    $createdt =  '<td class="u_role_name">' . $item['createdt'] . '</td>';
    $lastdt =  '<td class="u_role_name">' . $item['lastdt'] . '</td>';
    $senddt = '<td class="u_role_name">' . $senddt . '</td>';
    $operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit"  data-title="' . $item['title'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('/company/delet_rule/'. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
$str = $str . $title . $lastdt . $senddt . $operation_upd . '</tr>';
echo $str;

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
var error = "<?php echo $error;?>";
if(error)
{
	show_notify(error);
}

$(document).ready(function(){

    $('.edit').each(function(idx, item){
        $(item).click(function(){

            var _title = $(this).data('title');
            var _id = $(this).data('id');

           location.href=__BASEURL+"broadcast/update_info/"+ _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "broadcast/delete_info/" + _id;
            }
        });
    });
});
</script>
