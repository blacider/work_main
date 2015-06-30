
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
           <select id="temp" >
                <option value="a4.yaml">A4模板</option>
                <option value="b5.yaml">B5模板</option>
           </select>

        <div class=" form-actions">
             <div >
                 <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
             </div>
         </div>
         </form>
    </div>

</div>
</div>
<script type="text/javascript">
var __BASE = "<?php echo $base_url; ?>";
   $(document).ready(function(){
   /*	$('.renew').click(function(){
    var _checked = $('#isadmin').is('checked');
    console.log("checked" + _checked);
    $('#profile').submit();
	});*/
        $('.renew').click(function(){
           $.ajax({
                type:"post",
                url:__BASE+"company/profile",
                data:{ischecked:$('#isadmin').is(':checked'),template:$('#temp option:selected').val()},
                dataType:'json',
                success:function(data){
                        console.log(data);
                        console.log(data['hello'])
                       show_notify('保存成功');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },            });
       }); 
    });
</script>

       

