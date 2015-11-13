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
                                    <th>是否生效</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
 <?php
 
$description_dic = array('0'=>'适于用日常报销','1'=>'财务付款后，员工可对已报销内容再做修改，适用借款类流程','2'=>'当业务部门批准后，员工才可之处费用支出，适用于差旅申请报销类型类型');
foreach($item_type_list as $key => $item){
    $_checked = 'checked';
    $_is_able = '';
    if($key == 0)
    {
      $_is_able = 'disabled';
    }
    if($key == 1 && array_key_exists('disable_borrow', $company_config) && $company_config['disable_borrow'])
    {
        $_checked = '';
    }
    if($key == 2 && array_key_exists('disable_budget', $company_config) && $company_config['disable_budget'])
    {
        $_checked = '';
    }
    $str = "<tr>";
    $name = '<td class="u_username">' . $item['name'] . '</td>';
    $description = '<td class="u_username">' . htmlspecialchars($description_dic[$key]) . '</td>';
    $is_effective = '<td><label> <input name="form-field-checkbox" data-type="' . $item['type'] . '" class="disabled_label ace ace-switch" ' . $_checked . ' type="checkbox"' . $_is_able . '/> <span class="lbl"> </span> </label></td>';
    $start_icon = '<td style="width:100px;">';  
    $edit_icon =  '<a href="#modal-table" data-toggle="modal"  class="edit"  data-type="' . $item['type'] . '"' . ' data-name="' . $item['name'] . '"' . ' data-description="' . htmlspecialchars($description_dic[$key]) . '"><span class="blue glyphicon glyphicon-pencil"></span></a> ';
    $end_icon = '</tr>';
    
	  $str = $str . $name . $description . $is_effective . $start_icon . $edit_icon . $end_icon;

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


<div id="modal-table" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('company/update_item_type_name')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 修改消费类型 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row"> 
                  <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right">名称:</label>
                    <div class="col-xs-8 col-sm-8">
                        <input type="text" class="form-controller col-xs-12" name="type_name" id="type_name" placeholder="类型名称" required>
                    </div>
                </div> 
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
              <hr>
              <input type='hidden' name='item_type' id='item_type' value='0'/>
              <div class="col-xs-12 col-sm-12">
                <div class="row"> 

                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->

           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="修改" />
         </div>
        </div>
        </form>
  </div>
</div><!-- PAGE CONTENT ENDS -->

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

            var _type = $(this).data('type');
            var _name = $(this).data('name');
            var _description = $(this).data('description');
            $('#item_type').val(_type);
            $('#type_name').val(_name);
            $('#description').val(_description);
        });
    });

    $('#send').click(function(){
        var _name = $('#type_name').val();
        _name = _name.replace(/(^\s*)|(\s*$)/g,"");
        if(_name.length > 5)
        {
            show_notify('类型名长度不能超过5');
            return false;
        }
        if(!_name)
        {
            show_notify('请输入类型名');
            return false;
        }


    });

    $('.disabled_label').change(function() {
        var _type = $(this).data('type');
        var _key = '';
        var _value = 0;
        if(!$(this).is(':checked'))
        {
          _value = 1; 
        }
        if(_type == 1)
        {
            _key = 'disable_borrow';
        }
        if(_type == 2)
        {
            _key = 'disable_budget';
        }

        var _url = __BASEURL + "/company/active_item_type/" + _key + '/' + _value; 
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
