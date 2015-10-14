<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript"> try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){} </script>
<!-- /section:basics/content.searchbox -->
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
<!-- #section:settings.box -->
<div class="ace-settings-container" id="ace-settings-container">
<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
<i class="ace-icon fa fa-cog bigger-150"></i>
</div>

</div><!-- /.ace-settings-container -->

<!-- /section:settings.box -->
<div class="page-content-area">
<div class="page-header">
<h1>
包管理
<small>
<i class="ace-icon fa fa-angle-double-right"></i>
<a href="/install/index" target="_blank">下载链接</a>
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

<th> 版本</th>
<th>平台</th>
<th class="hidden-680">线上版本</th>
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
    $online = '<i class="ace-icon fa fa-globe bigger-120"></i>';
    if($item['online']){
        $online = '<i class="ace-icon fa fa-globe green bigger-120"></i>';
    }
    $platform = 'iOS';

    if($item['platform']) $platform = "Android";

$str = '<tr>';
    $title = '<td>' . $item['version'] . '</td>';
    $desc = '<td>' . $platform . '</td>';
    $path = '<td>' . $online . '</td>';

    $operation = '<td style="width:150px;"><a class="btn btn-xs btn-danger" href="' .  base_url('admin/release/del/'. $item['id']) .'">
            <i class="ace-icon fa fa-trash-o bigger-120"></i>
            </a>
            <a class="btn btn-xs btn-primary" href="' .  base_url('admin/release/set_online/'. $item['id']) .'">
            <i class="ace-icon fa  fa-globe bigger-120"></i>
    </a>
            </td>';

    $str = $str . $title . $desc . $path . $operation . '</tr>';
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
                    <h4 class="blue bigger">添加包</h4>
                </div>
                <form id="module_form" method="post" action="<?php echo base_url('admin/release/add'); ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xs-6 col-sm-6">

                                <div class="form-group">
                                    <label for="form-field-username">平台</label>

                                    <div>
                                        <select name="platform" class="form-control">
                                            <option value="0">iOS</option>
                                            <option value="1">Android</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label for="form-field-username">版本</label>

                                    <div>
                                        <input class="input-large" type="text" id="form-field-username" placeholder="版本" name="version" />
                                    </div>
                                </div>

                                <div class="space-4"></div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="col-xs-12">
                                    <input type="file" id="id-input-file-3" name="package" />
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

    <script type="text/javascript" src='/static/assets/js/dropzone.min.js'> </script>

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
    $('#id-input-file-3').ace_file_input({
        style:'well',
        btn_choose:'拖拽或者点击，随便你',
        btn_change:null,
        no_icon:'ace-icon fa fa-cloud-upload',
        droppable:true,
        thumbnail:'small'//large | fit
        ,icon_remove:null//set null, to hide remove/reset button
        /**,before_change:function(files, dropped) {
        //Check an example below
        //or examples/file-upload.html
        return true;
        }*/
        /**,before_remove : function() {
          return true;
          }*/
        ,
    preview_error : function(filename, error_code) {
    //name of the file that failed
    //error_code values
    //1 = 'FILE_LOAD_FAILED',
    //2 = 'IMAGE_LOAD_FAILED',
    //3 = 'THUMBNAIL_FAILED'
    //alert(error_code);
    }
    
    }).on('change', function(){
        });

});
</script>
