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
            <input type="hidden" name="id" value="<?php echo $report['id']; ?>" id="hrid">
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
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择标签" id="receiver">
<?php 
$user = $this->session->userdata('user');
$_empty = 0;
    if(!$reports['receivers']['managers']){
        $_empty = 1;
    }
foreach($members as $m) {
    if($_empty == 0 && in_array($m['id'], $report['receivers']['managers']) || ($_empty == 1 && $user['manager_id'] == $m['id'])){
?>
<option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php } else { ?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php 
}
}
 ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="cc[]" id="cc"  multiple="multiple" data-placeholder="请选择标签">
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
                                <label class="col-sm-1 control-label no-padding-right">总额</label>
                                <div class="col-xs-9 col-sm-9">
                                    <span class="middle" id="tamount">0</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">选择消费</label>
                                <div class="col-xs-9 col-sm-9">
                                    <table class="table table-border">
                                        <tr>
                                            <thead>
                                                <td>
                                                   <input name="all_item" id="all_item" type="checkbox" class="form-controller all_item"> 全选</td>
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
                                            <td><input checked='true' name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller amount" data-amount = "<?php echo $i['amount'] ?>" data-id="<?php echo $i['id']; ?>" ></td>
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
                                            <td><input name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller amount" data-amount = "<?php echo $i['amount'] ?>"  data-id="<?php echo $i['id']; ?>" ></td>
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




<div class="modal fade" id="force_submit">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">警告</h4>
      </div>
      <div class="modal-body" id="error">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消提交</button>
        <button type="button" class="btn btn-primary force_submit_btn" >确定提交</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var __SUM = 0;
function do_post(force) {

    var _rid = $('#hrid').val();
    var s = $('#receiver').val();
    var title = $('#title').val();
    if(title == "") {
        show_notify('请添加报告名');
        $('#title').focus();
        return false;
    }


    var sum=0;

    var _ids = Array();
	$('.amount').each(function(){
		if($(this).is(':checked')){
            console.log("Check", $(this).data('id'));
            _ids.push($(this).data('id'));
			var amount = $(this).data('amount');
			amount = parseInt(amount.substr(1));
			sum+=amount;
		};
	});
    if(_ids.length == 0) {
        show_notify('提交的报告不能为空');
        return false;
    }

	if(s == null){
	     show_notify('请选择审批人');
	     $('#receiver').focus();
	     return false;
	}


	if(__SUM <= 0) {
		show_notify("报告总额不能小于等于0");
		return false;
	}
    

    // 获取所有的 条目
    var _cc = $('#cc').val();
    if(!_cc) _cc = Array();
    if(force == 1) {

    }

    var _renew = $('#renew').val();
    $.ajax({
        type : 'POST',
            url : __BASE + "reports/update", 
            data : {
                'item' : _ids,
                    'title' : $('#title').val(),
                    'receiver' : $('#receiver').val(),
                    'cc' : _cc,
                    'id' : _rid,
                    'renew' : _renew,
                    'force' : force
                },
                dataType: 'json',
                success : function(data){
                    if(data.status > 0) {
                        window.location.href = __BASE + 'reports/index';
                        return false;
                    }
                    if(_renew && data.status == -71) {
                        $('#error').html(data.msg);
                        $('#force_submit').modal();
                        return false;
                    }
                    if(data.status < 0 && data.status != -71) {
                        show_notify(data.msg);
                    }
                    return false;
                }
            });
}
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

    $('#all_item').click(function(){
        if($('#all_item').is(":checked"))
        {
            //console.log("checked");
            $('.amount').each(function(){
                $(this).prop('checked',true);
                //console.log($(this).is(":checked"));
               // $(this).trigger('checked');
            });   

            //$("[name='item[]']").prop('checked',true);
        }
        else
        {
            $('.amount').each(function(){
                $(this).prop('checked',false);
              // $(this).removeAttr("checked"); 
            });
           // $("[name='item[]']").prop('checked',false);
        }
        update_tamount();
     });

    $('.renew').click(function(){
        $('#renew').val($(this).data('renew'));
        do_post(0);
        //$('#mainform').submit();
    });
    $('.force_submit_btn').click(function() {
        $('#renew').val(1);
        do_post(1);
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    $('.amount').each(function(idx, item) {
        $(this).click(function(){
            update_tamount();
        });
    });
    update_tamount();
});
function toDecimal2(x) {  
    var f = parseFloat(x);  
    if (isNaN(f)) {  
        return false;  
    }  
    var f = Math.round(x*100)/100;  
    var s = f.toString();  
    var rs = s.indexOf('.');  
    if (rs < 0) {  
        rs = s.length;  
        s += '.';  
    }  
    while (s.length <= rs + 2) {  
        s += '0';  
    }  
    return s;  
}  
function update_tamount(){
    var sum = 0;
    $('.amount').each(function(){
        if($(this).is(':checked')){
            var amount = $(this).data('amount');
            amount = parseInt(amount.replace(/[^0-9]/ig,""))/100;
            sum+=amount;
        };
    });
    //$('#tamount').html(sum);
    $('#tamount').html('￥' + toDecimal2(sum));
    __SUM = sum;
}
</script>
