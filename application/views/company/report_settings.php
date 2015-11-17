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
                                    <th>报销单模板名称</th>
                                    <th>最后修改时间</th>
                                    <th class="hidden-680">
                                        <a href="<?php echo base_url('company/report_settings_new');?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a>
                                    </th>
                                </tr>

                                <!--
                                <tr>
                                    <td class="u_username">默认帐套</td>
                                    <td class="u_role_name"></td>
                                   <td style="width:80px;">   <a href="#" class="edit"  data-title="" data-id="0"><span class="glyphicon glyphicon-pencil"></span></a>  <a href="javascript:void(0);" class="copyno" data-id="0"><span class="ace-icon fa fa-copy"></span></a> <a href="javascript:void(0);" class="delno" data-id="0"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                                -->
                            </thead>
                            <tbody>
<?php
//echo json_encode($acc_sets);

foreach($report_settings as $item){
    $img = "";
    $str = '<tr>';
$username = '<td class="u_username">' . $item['name'] . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
$url_edit = base_url('company/report_settings_update/'. $item['id']);
$operation_upd = '<td style="width:80px;">   <a href="' . $url_edit .'" class="edit"  data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>  <a href="#modal-table1" <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:80px;"><a class="btn btn-xs btn-danger" href="' .  base_url('company/report_property_delete/?id='. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
$str = $str . $username . $role_id . $operation_upd . '</tr>';
echo $str;

}?>
</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->


</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->

<!--
<div id="modal-table1" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('category/copy_sob')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 复制帐套 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">输入新帐套名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="cp_name" name="cp_name" class="form-control" />
                        <input type="hidden" id="sob_id" name="sob_id" />
                      </div>
                  </div>   
                </div>    
              </div>    
           </div> 
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="复制" />
         </div>
        </div>
        </form>
  </div>
</div>
-->



<script language="javascript">
var __BASEURL = "<?php echo $base_url; ?>";
var error = "<?php echo $error; ?> ";
$(document).ready(function(){
    if(error.trim())
    {
        show_notify(error);
    }

    $('#send').click(function(){
        /*
    $.ajax({
      url:__BASE+'category/copy_sob'
      ,method:"post"
      ,dataType:"json"
      ,data:{sob_id:$('#sob_id').val(),cp_name:$('#cp_name').val()}
      ,success:function(data){
          if(data.status== 1) {
            $('#modal-table1').modal('hide')
            show_notify("复制成功");
          }
          else
          {
              if(data.data.msg != undefined) {
                show_notify(data.data.msg);
              }
              else {
                show_notify("输入邮箱错误");
              }
          }
      }
    }); */
});

    $('.edit').each(function(idx, item){
        $(item).click(function(){
            var _id = $(this).data('id');
                location.href = __BASEURL + "company/report_settings_update/" + _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "company/report_property_delete/" + _id;
            }
        });
    });


    $('.copy').each(function(){
        $(this).click(function(){
            
                var _id = $(this).data('id');
                $('#sob_id').val(_id)
        });
    });
    $('.delno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许删除')){
              
            }
        });
    });
    $('.copyno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许复制')){
              
            }
        });
    });

/*
      $('.editno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许修改')){
              
            }
        });
    });
  */

});
</script>
