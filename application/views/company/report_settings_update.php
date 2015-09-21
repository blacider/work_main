<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<!-- <link rel="stylesheet" href="/static/third-party/jqui/jquery-ui.min.css" id="main-ace-style" /> -->

<!-- page specific plugin styles -->
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<div class="page-content">
<div class="page-content-area">
<form role="form" action="<?php echo base_url('company/report_property_new/'.$id);  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
<div class="row">
<div class="col-xs-12 col-sm-12">
<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">报告模板名称</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="report_property_name" id="report_property_name" value="<?php echo $setting['name'];?>" placeholder="报告模板名称" required>
</div>
</div>
<hr>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">配置项:</label>
<div class="col-xs-6 col-sm-6">
<label>借款<input type="checkbox" class="reportProp form-controller col-xs-12" name="borrowing" id="borrowing" value="1"></label>
<label>起始地<input type="checkbox" class="reportProp form-controller col-xs-12" name="location" id="location" value="1"></label>
<label>起始时间<input type="checkbox" class="reportProp form-controller col-xs-12" name="period" id="period" value="1"></label>
<label>银行账户<input type="checkbox" class="reportProp form-controller col-xs-12" name="account" id="account" value="1"></label>
<label>付款方式<input type="checkbox" class="reportProp form-controller col-xs-12" name="payment" id="payment" value="1"></label>
<label>是否有合同<input type="checkbox" class="reportProp form-controller col-xs-12" name="contract" id="contract" value="1"></label>
<label>备注<input type="checkbox" class="reportProp form-controller col-xs-12" name="note" id="note" value="1"></label>
</div>
</div>
<!--
<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">借款￥</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="borrowing" id="borrowing" placeholder="借款" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">账号</label>
<div class="col-xs-6 col-sm-6">
<input type="text" class="form-controller col-xs-12" name="account" id="account" placeholder="账号" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">付款方式</label>
<div class="col-xs-6 col-sm-6">
<input type="radio" class="form-controller col-xs-1" name="contract" value="1">
<label class="col-xs-1 col-sm-1">网银转账</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract" value="2">
<label class="col-xs-1 col-sm-1">现金</label>
<input type="radio" class="form-controller col-xs-1" name="contract" value="3">
<label class="col-xs-1 col-sm-1">支票</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract" value="4">
<label class="col-xs-1 col-sm-1">冲账</label>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">是否有合同</label>
<div class="col-xs-6 col-sm-6">
<input type="radio" class="form-controller col-xs-1" name="contract">
<label class="col-xs-1 col-sm-1">是</label>
<div class="col-xs-1 col-sm-1"></div>
<input type="radio" class="form-controller col-xs-1" name="contract">
<label class="col-xs-1 col-sm-1">否</label>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">消费时间</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker1" name="dt" type="text" class="form-control" />
<span class="input-group-addon">
<i class="fa fa-clock-o bigger-110"></i>
</span>
</div>
</div>
</div>



<div class="form-group" id="endTime">
<label class="col-sm-2 control-label no-padding-right">至</label>
<div class="col-xs-6 col-sm-6">
<div class="input-group">
<input id="date-timepicker2" name="dt_end" type="text" class="form-control" />
<span class="input-group-addon">
<i class="fa fa-clock-o bigger-110"></i>
</span>
</div>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">出差地</label>
<div class="col-xs-3 col-sm-3">
<input type="text" name="start_place" class="form-controller col-xs-12" placeholder="起地">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">至</label>
<div class="col-xs-3 col-sm-3">
<input type="text" name="end_place" class="form-controller col-xs-12" placeholder="终点">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label no-padding-right">备注</label>
<div class="col-xs-6 col-sm-6">
<textarea name="note" id="note" class="col-xs-12 col-sm-12  form-controller" ></textarea>
</div>
</div>

-->



<input type="hidden" id="renew" value="0" name="renew">
<div class="clearfix form-actions col-sm-8 col-xs-8">
<div class="col-md-offset-3 col-md-8">
<a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
</div>
</div>
<input type="reset" style="display:none;" id="reset">

</div>
</div>
<input type="hidden" name="images" id="images" >
</form>
</div>
</div>
<!--
<div class="modal" id="select_img_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择图片</h4>
            </div>
            <div class="modal-body">


        </div>
    </div>
</div>
-->
<!--
<script src="/static/third-party/jquery.ajaxfileupload.js"></script>
<script src="/static/third-party/jquery-image-upload.min.js"></script>
-->
<!--
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
-->

<!--<script src="/static/ace/js/jquery1x.min.js"></script> -->

<script src="/static/ace/js/chosen.jquery.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<!--
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
-->

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<!--
<script src="/static/third-party/jfu/js/vendor/jquery.ui.widget.js"></script>
<script src="/static/third-party/jfu/js/jquery.iframe-transport.js"></script>
-->

<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="/static/third-party/webUploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/static/third-party/webUploader/webuploader.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

     $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
        useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt",
        linkFormat: "YYYY-MM-DD HH:mm:ss",
        sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
        useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "dt_end",
        linkFormat: "YYYY-MM-DD HH:mm:ss",
        sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
    .off('resize.chosen')
    .on('resize.chosen', function() {
        $('.chosen-select').each(function() {
            var $this = $(this);
            $this.next().css({'width': $this.parent().width()});
        })
    }).trigger('resize.chosen');

    
    var _report_config = '<?php echo $setting["config"]?>';
    var report_config = [];
    if(_report_config)
    {
        report_config = JSON.parse(_report_config);
    }
    console.log(report_config);
    
    for(var i in report_config)
    {
        if(report_config[i] == "1")
        {
            $('#'+i).prop('checked',true);
        }
    }


    $('.renew').click(function(){
        
        if(!$('#report_property_name').val().replace(/(^\s*)|(\s*$)/g,''))
        {
            show_notify('报告模板名称不能为空');
            return false;
        }

        $('#itemform').submit();
    });
});

</script>