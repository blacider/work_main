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
                                    <th>名称</th>
                                    <th>说明</th>
                                    <th>操作</th>
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
    	$str = "<tr>";
	}
    $title = '<td class="u_username">' . $item['title'] . '</td>';
    $createdt =  '<td class="u_role_name">' . $item['createdt'] . '</td>';
    $lastdt =  '<td class="u_role_name">' . $item['lastdt'] . '</td>';
    $senddt = '<td class="u_role_name">' . $senddt . '</td>';
    $start_icon = '<td style="width:100px;">';
    $show_icon =  '<a href="javascript:void(0);" class="tshow"  data-title="' . $item['title'] . '" data-id="'.$item['id'].'"><span class="ace-icon fa fa-search-plus"></span></a> ';
    $edit_icon =  '<a href="javascript:void(0);" class="edit"  data-title="' . $item['title'] . '" data-id="'.$item['id'].'"><span class="green glyphicon glyphicon-pencil"></span></a> ';
    $copy_icon =  '<a href="javascript:void(0);" class="edit"  data-title="' . $item['title'] . '" data-id="'.$item['id'].'"><span class="gray ace-icon fa fa-copy"></span></a> ';
    $del_icon = '<a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="red glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('/company/delet_rule/'. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
    $end_icon = '</tr>';
    if($item['sent'] == 0)
    {
    	$str = $str . $title . $lastdt . $senddt . $start_icon . $edit_icon . $del_icon . $end_icon;
    }
	else
	{
		$str = $str . $title . $lastdt . $senddt . $start_icon . $show_icon . $copy_icon . $del_icon . $end_icon;
	}
	//$str = $str . $title . $lastdt . $senddt . $operation_upd . '</tr>';
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
            if(confirm('删除本条消息时，客户端上的消息也将删除，是否确认?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "broadcast/delete_info/" + _id;
            }
        });
    });
    $('.tshow').each(function(idx,item){
    	$(item).click(function(){
    		 var _title = $(this).data('title');
	         var _id = $(this).data('id');

	         location.href=__BASEURL+"broadcast/update_info/"+ _id + '/1';
    	});
    
    });
});
</script>
