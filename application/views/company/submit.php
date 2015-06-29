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
                公司设置
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </small>
            </h1>
        </div><!-- /.page-header -->
    </div>
    <div>
    <form id="profile" method="post" action="<?php echo base_url('company/profile');  ?>">
         <div class="form-group">
            <label class="col-sm-1 control-label no-padding-right">空间选择</label>
            <div class="col-xs-6 col-sm-6">
                <label style="margin-top:8px;">
                    <input name="isadmin" class="ace ace-switch btn-rotate" type="checkbox" id="isadmin" style="margin-top:4px;" />
                    <span class="lbl"></span>
                </label>

            </div>
        </div>

        <div class="clearfix form-actions">
             <div class="col-md-offset-3 col-md-9">
                 <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                 <a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>

                 <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
             </div>
         </div>
         </form>
    </div>

</div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
   	$('.renew').click(function(){
	$("input[name='admin'][checked]").each(function () {
	    console.log(this.value);
	    });

    var _checked = $("#isadmin").is('checked');
    console.log("checked" + _checked);
    if(_checked)
    {
        $('#isadmin').val(1);
    }
    else
    {
        $('#isadmin').val(0);
    }
//		console.log('hello');
	//console.log($("input[name='admin']:checkbox:checked").length);
    
    $('#profile').submit();
	});

   }); 
</script>

       

