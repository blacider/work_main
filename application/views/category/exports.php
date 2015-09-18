


<div class="page-content">
    <div class="page-content-area">
        <form action="<?php echo base_url('category/imports'); ?>" method="post" enctype="multipart/form-data" id="imports" >
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div>
                            <label class="col-sm-4 form-controller no-padding-right" style="text-align:left">
                                1、下载员工导入模板。
                            </label>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class=" col-md-9">
                            <a href="/static/category.xls" class="btn btn-primary renew" data-renew="0"><i class="ace-icon fa fa-download bigger-110"></i>下载模板</a>
                            <!-- <a class="btn btn-primary renew" data-renew="1"><i class="ace-icon glyphicon glyphicon-log-out  bigger-110"></i>导出</a> -->
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <label class="col-sm-4 form-controller no-padding-right" style="text-align:left">
                            2、上传填写好的分类信息模板。
                        </label>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class=" col-md-9">
                                <input type="file" id="memebers" name="members" style="display:none;">
                                <a class="btn btn-primary upload" data-renew="1"><i class="ace-icon glyphicon glyphicon-log-in bigger-110"></i>导入</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
    var __BASE = "<?php echo base_url(); ?>";
    var _error = "<?php echo $error; ?>";
$(document).ready(function(){
    if(_error) show_notify(_error);

    $('#memebers').on('change', function(){
        console.log("1");
        $('#imports').submit();
        console.log("1");
    });
    $('.renew').click(function(){
        location.href = __BASE + "members/exports";
    });
    $('.upload').click(function(){
        try{
            $('#memebers').click();
        }catch(e){
        }
    });
});
</script>
