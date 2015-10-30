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
                                    <th>报销模板ID</th>
                                    <th>报销模板名</th>
                                    <th><a href="<?php echo base_url('company/create_report_template')?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a> </th>
                                </tr>
                            </thead>
                            <tbody>
 <?php
 

foreach($template_list as $item){
    $str = "<tr>";
    $id = '<td class="u_username">' . $item['id'] . '</td>';
    $name =  '<td class="u_role_name">' . $item['name'] . '</td>';
    $start_icon = '<td style="width:100px;">';
    $show_icon =  '<a href="javascript:void(0);" class="tshow"  data-title="" data-id=""><span class="ace-icon fa fa-search-plus"></span></a> ';
    $edit_icon =  '<a href="javascript:void(0);" class="edit" data-config="" data-id="' . $item['id'] . '" data-name="' . $item['name'] . '"><span class="green glyphicon glyphicon-pencil"></span></a> ';
    $del_icon = '<a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="red glyphicon glyphicon-trash"></span></a></td>';
    $end_icon = '</tr>';
    $str = $str . $id . $name . $start_icon . $edit_icon . $del_icon . $end_icon;
	
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
            var _id = $(this).data('id');
            location.href = __BASEURL + 'company/update_report_template/' + _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('删除模板后将不能恢复，是否确认?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "company/do_delete_report_template/" + _id;
            }
        });
    });
   
});
</script>
