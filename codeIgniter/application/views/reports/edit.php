<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('reports/update');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform" >
            <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['title']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">发送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择标签">
<?php 
foreach($members as $m) {
    if(in_array($m['id'], $report['receivers']['managers'])){
?>
<option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php } else { ?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="cc[]" multiple="multiple" data-placeholder="请选择标签">
<?php 
foreach($members as $m) {
    if(in_array($m['id'], $report['receivers']['cc'])){
?>
<option selected="selected" value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php } else { ?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php }} ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">选择消费</label>
                                <div class="col-xs-9 col-sm-9">
                                    <table class="table table-border">
                                        <tr>
                                            <thead>
                                                <td><input type="checkbox" class="form-controller"></td>
                                                <td>消费时间</td>
                                                <td>类型</td>
                                                <td>金额</td>
                                                <td>类别</td>
                                                <td>商家</td>
                                                <td>操作</td>
                                            </thead>
                                        </tr>
<?php 
foreach($report['items'] as $i){
                                        ?>
                                        <tr>
                                            <td><input checked='true' name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller"></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['category_name']; ?></td>
                                            <td><?php echo $i['amount']; ?></td>
                                            <td><?php 
                                                $buf = '';
switch(intval($i['prove_ahead'])) {
case 0 : $buf = '报销';break;
case 1 : $buf = '预算';break;
case 2 : $buf = '预借';break;
} 
echo $buf;

?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="3905"></span>
                                                    <span class="ui-icon green ui-icon-pencil tedit" data-id="3905"></span>
                                                    <span class="ui-icon ui-icon-trash red  tdel" data-id="3905"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php  } ?>
<?php 
foreach($items as $i){
    if($i['rid'] == 0 && $i['prove_ahead'] == 0){
                                        ?>
                                        <tr>
                                            <td><input name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller"></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['category'];  echo $i['status'];?></td>
                                            <td><?php echo $i['amount']; ?></td>
                                            <td><?php echo $i['prove_ahead']; ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="3905"></span>
                                                    <span class="ui-icon green ui-icon-pencil tedit" data-id="3905"></span>
                                                    <span class="ui-icon ui-icon-trash red  tdel" data-id="3905"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" id="renew" value="0" name="renew">
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions col-md-10">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="1"><i class="ace-icon fa fa-check"></i>提交</a>

                                    <a class="btn btn-white btn-default renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="images" id="images" >
        </form>
    </div>
</div>
<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    //var now = moment();
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm",
            sideBySide: true
    }).next().on('dp.change', function(ev){
        console.log(ev.date);
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

    /*
    Dropzone.autoDiscover = false;
    try {
        var myDropzone = new Dropzone("#dropzone" , {
            paramName: "file", 
                url: __BASE + '/items/images',
                maxFilesize: 1.5,
                addRemoveLinks : true,
                dictDefaultMessage : '<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i><br /><span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> 把发票照片拖拽至虚线框</span>  <br /><span class="smaller-80 grey">(或者点击上传)</span> <br />',
                dictResponseError: '照片上传出错!',
                previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
        });
        myDropzone.on('success', function(ev, str_data){
            data = eval("(" + str_data + ")"); 
            if(data.status > 0){
                var _data =  data.data;
                var _id = _data.id;
                if(_id > 0){
                    var _exists = ($('#images').val()).split(",");
                    if($.inArray(_id, _exists) < 0){
                        _exists.push(_id);
                    }
                    $('#images').val(_exists.join(','));
                }
            }
        });
        myDropzone.on('removedfile', function(ev, str_data) {
        });
    } catch(e) {
        console.log(e);
        alert('Dropzone.js does not support older browsers!');
    }
     */


    $('.renew').click(function(){
        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
});
</script>
