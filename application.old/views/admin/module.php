
<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
<!-- #section:settings.box -->
<div class="ace-settings-container" id="ace-settings-container">

<div class="ace-settings-box clearfix" id="ace-settings-box">
<div class="pull-left width-50">
<!-- #section:settings.skins -->

<!-- /section:settings.skins -->

<!-- #section:settings.navbar -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
</div>

<!-- /section:settings.navbar -->

<!-- #section:settings.sidebar -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
</div>

<!-- /section:settings.sidebar -->

<!-- #section:settings.breadcrumbs -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
</div>

<!-- /section:settings.breadcrumbs -->

<!-- #section:settings.rtl -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
</div>

<!-- /section:settings.rtl -->

<!-- #section:settings.container -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
<label class="lbl" for="ace-settings-add-container">
Inside
<b>.container</b>
</label>
</div>

<!-- /section:settings.container -->
</div><!-- /.pull-left -->

<div class="pull-left width-50">
<!-- #section:basics/sidebar.options -->
<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
</div>

<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
</div>

<div class="ace-settings-item">
<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
</div>

<!-- /section:basics/sidebar.options -->
</div><!-- /.pull-left -->
</div><!-- /.ace-settings-box -->
</div><!-- /.ace-settings-container -->

<!-- /section:settings.box -->
<div class="page-content-area">
<div class="page-header">
<h1>
模块管理
<small>
<i class="ace-icon fa fa-angle-double-right"></i>
<?php echo $description;?>
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

<th> 模块标题</th>
<th>模块相关描述</th>
<th class="hidden-480">模块访问路径</th>

<th>
所属组
</th>
<th class="hidden-680">
<a href="#modal-table" role="button" class="green" data-toggle="modal">
<i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
</a>
</th>

</tr>
</thead>

<tbody>
<?php
foreach($alist as $item){
    $str = '<tr>';
    $title = '<td>' . $item->title . '</td>';
    $desc = '<td>' . $item->description . '</td>';
    $path = '<td>' . $item->path . '</td>';
    $group_title = '<td>' . $item->group_title . '</td>';

    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('admin/module/del?id='. $item->id) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';

    $str = $str . $title . $desc . $path . $group_title . $operation . '</tr>';
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
    <h4 class="blue bigger">添加模块</h4>
    </div>
    <form id="module_form" method="post" action="<?php echo base_url('admin/module/add'); ?>">
    <div class="modal-body">
    <div class="row">

    <div class="col-xs-12 col-sm-12">

    <div class="form-group">
    <label for="form-field-username">模块名</label>

    <div>
    <input class="input-large" type="text" id="form-field-username" placeholder="模块名" name="title" />
    </div>
    </div>

    <div class="space-4"></div>

    <div class="form-group">
    <label for="form-field-username">相关描述</label>

    <div>
    <input class="input-large" type="text" id="form-field-username" placeholder="相关描述" name="desc" />
    </div>
    </div>

    <div class="space-4"></div>

    <div class="form-group">
    <label for="form-field-username">路径</label>

    <div>
    <input class="input-large" type="text" id="form-field-username" placeholder="路径" name="path"  />
    </div>
    </div>

    <div class="space-4"></div>

    <div class="form-group">
    <label for="form-field-username">所属组</label>

    <div>
    <select id="module_group_id" name="module_group_id">
<?php
$module_group_html = '';
foreach($module_group_list as $_module_group){
    $str = "<option value='{$_module_group->id}'>{$_module_group->title}</option>";
    $module_group_html .= $str;
}
echo $module_group_html;
?>
<option value="0">新建组</option>
    </select>
    <input type="text" name="new_group_title" style="display:none;" placeholder="新组名" />
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

    <button type="button" class="btn btn-sm btn-success" id="commit">
    提交
    <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
    </button>

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
    $('#module_group_id').change(function(){
        if($('#module_group_id').val() == 0){
            $('#modal-table input[name=new_group_title]').show().focus();
        }
        else{
            $('#modal-table input[name=new_group_title]').hide();
        }
    });
    $('#commit').click(function(){
        $('#module_form').submit();
    });
});
</script>
