<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />

<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>



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
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择审批人" id="receiver">
<?php 
$user = $this->session->userdata('user');
$_empty = 0;
    if(!$report['receivers']['managers']){
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
                                    <select class="chosen-select tag-input-style" name="cc[]" id="cc"  multiple="multiple" data-placeholder="请选择抄送人">
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
<?php
                        if(!empty($config)) {
?>
                            <input type="hidden" id="template_id" name="template_id" value="<?php echo $config['id']; ?>">
<?php 
                        if($config['account'] == 1){ 
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行账号</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="account" id="account" data-placeholder="请选择银行账号">
                                        <?php foreach($user['banks'] as $m) {
                                            if(array_key_exists('account', $extra) && $extra['account']['id'] == $m['id']){ ?>
                                                <option value="<?php echo $m['id']; ?>"  data-name="<?php echo $m['account']; ?>" data-no="<?php echo $m['cardno']; ?>" selected><?php echo $m['account']; ?> - [<?php echo $m['cardno']; ?> ]</option>
                                       
                                        <?php }  else { ?>
                                                <option value="<?php echo $m['id']; ?>"  data-name="<?php echo $m['account']; ?>" data-no="<?php echo $m['cardno']; ?>"><?php echo $m['account']; ?> - [<?php echo $m['cardno']; ?> ]</option>
<?php } } ?>
                                    </select>
                                </div>
                            </div>
<?php 
                        }
                        if($config['payment'] == 1){ 
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">支付方式</label>
                                <div class="col-xs-9 col-sm-9">
<?php 
                            $options = array(
                                array('desc' => '网银转账', 'value' => 0),
                                array('desc' => '现金', 'value' => 1),
                                array('desc' => '支票', 'value' => 2),
                                array('desc' => '冲账', 'value' => 3)
                            );
                            foreach($options as $n) {
                                $check_str = '';
                                if($n['value'] == $extra['payment']) $check_str = 'checked';
?>

                                    <div class="radio col-xs-3 col-sm-3">
                                         <label>
                                         <input name="payment" type="radio" class="ace payment" value="<?php echo $n['value']; ?>" <?php echo $check_str; ?>>
                                             <span class="lbl"><?php echo $n['desc']; ?></span>
                                         </label>
                                    </div>
<?php 
                            }
?>
                                </div>
                            </div>
<?php 
                        }
                        if($config['borrowing'] == 1){ 
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">已付金额</label>
                                <div class="col-xs-9 col-sm-9">
                                <input type="text" class="form-controller col-xs-12" id="borrowing" name="borrowing"  placeholder="已付金额" value="<?php echo $extra['borrowing']; ?>">
                                </div>
                            </div>

<?php 
                        }
                        if($config['location'] == 1){ 
?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">出差地</label>
                                <div class="col-xs-9 col-sm-9">
                                <input type="text" id="location_from" class="form-controller col-xs-5" name="location_from"  placeholder="出发地" value="<?php echo $extra['location']['start']; ?>">
                                    <label class="col-sm-1 control-label">到</label>
                                    <input type="text" id="location_to" class="form-controller col-xs-5" name="location_to"  placeholder="到达地" value="<?php echo $extra['location']['dest']; ?>">
                                </div>
                            </div>
<?php 
                        }
                        if($config['period'] == 1){ 
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">出差时间</label>
                                <div class="col-xs-9 col-sm-9">
<?php
                            $s = trim($extra['period']['start']);
                            $e =  trim($extra['period']['end']);
                            if($s == "0" || $s == "" || $s == "NaN"){
                                $s = @date('Y-m-d H:i:s');
                            } else {
                                $s = @date('Y-m-d H:i:s', $s);
                            }
                            if($e == "0" || $e == "" || $e == "NaN"){
                                $e = @date('Y-m-d H:i:s');
                            } else {
                                $e = @date('Y-m-d H:i:s', $e);
                            }
?>

                                    <input type="text" id="period_start" class="form-controller col-xs-5 period" name="period_start"  placeholder="起始时间" value="<?php echo $s; ?>" />
<input type="hidden" id="sdt" value="<?php echo strtotime($extra['period']['start']); ?>" >
                                    <label class="col-sm-1 control-label">到</label>
                                    <input type="text" id="period_end" class="form-controller col-xs-5 period" name="period_end"  placeholder="结束时间" value="<?php echo $e; ?>" >
<input type="hidden" id="edt" value="<?php echo strtotime($extra['period']['end']); ?>" >
                                </div>
                            </div>
<?php 
                        }
                        if($config['contract'] == 1){ 
                            $_extra_yes = '';
                            $_extra_no = '';
                            if($extra['contract']['available'] == 0) {
                                $_extra_no = 'checked';
                            } else {
                                $_extra_yes = 'checked';
                            }
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">合同</label>
                                <div class="col-xs-9 col-sm-9">
                                    <div class="radio col-xs-2 col-sm-2">
                                         <label>
                                         <input name="contract" type="radio" id="contract_yes" class="ace contract" value="1" <?php echo $_extra_yes; ?>>
                                             <span class="lbl">有</span>
                                         </label>
                                    </div>
                                    <div class="radio col-xs-2 col-sm-2">
                                         <label>
                                             <input name="contract" type="radio" id="contract_no" class="ace contract" value="0" <?php echo $_extra_no; ?>>
                                             <span class="lbl">无</span>
                                         </label>
                                    </div>
                                    <div class="radio col-xs-8 col-sm-8">
                                    <input type="text" id="contract_note" class="form-controller col-xs-12" name="contract_note"  placeholder="合同备注" value="<?php echo $extra['contract']['note']; ?>" >
                                    </div>
                                </div>
                            </div>
<?php 
                        }
                        if($config['note'] == 1){ 
?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">备注</label>
                                <div class="col-xs-9 col-sm-9">
                                    <div class="radio col-xs-12 col-sm-12">
                                    <textarea id="note" rows="2" class="form-controller col-xs-12" name="note"><?php echo trim($extra['note']); ?></textarea>
                                    </div>
                                </div>
                            
                            </div>
<?php 
                        }
        }
?>


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
                                            <td><?php echo '￥'.$i['amount']; ?></td>
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
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon green ui-icon-pencil tedit" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon ui-icon-trash red  tdel" data-id="<?php echo $i['id']; ?>"></span>
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
                                            <td><?php echo '￥'.$i['amount']; ?></td>
                                            <td><?php echo $i['prove_ahead']; ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon green ui-icon-pencil tedit" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon ui-icon-trash red  tdel" data-id="<?php echo $i['id']; ?>"></span>
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
            _ids.push($(this).data('id'));
			var amount = $(this).data('amount');
			//amount = parseInt(amount.substr(1));
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


	if(sum<= 0) {
		show_notify("报告总额不能小于等于0");
		return false;
	}
    

    // 获取所有的 条目
    var _cc = $('#cc').val();
    if(!_cc) _cc = Array();
    if(force == 1) {

    }

    var _period_start = 0;
    var _period_end = 0;

    var _location_from =  '';
    var _location_to =  '';

    var _contract = 0;
    var _contract_note = '';


    var _account = 0;
    var _account_name = '';
    var _account_no = '';
    var _payment = -1;


    var _borrowing = 0;
    var _note = '';


    var _template_id = 0;

    try {
        _template_id = $('#template_id').val();
    }catch(e){}

    try {
        _account = $('#account').val();
        var s = $("#account option:selected");
        _account_name = $(s).data('name');
        _account_no = $(s).data('no');
    } catch(e) {}

    try {
        _note = $('#note').val();
        if(!_note) _note = '';
    } catch(e) {}


    try {
        _borrowing = $('#borrowing').val();
        if(!_borrowing) _borrowing = 0;
    } catch(e) {}

    try {
        _payment = $('input[name="payment"]:checked').val(); 
        if(!_payment) _payment = -1;
    }catch(e){}
    try {
        _contract = $('input[name="contract"]:checked').val(); 
        if(!_contract) _contract = -1;
    }catch(e){ }
    if(_contract == 0) {
        try{
            _contract_note = $('#contract_note').val();
        }catch(e){}
    }


    try {
        _period_end = (new Date($("#period_end").val())).getTime() / 1000;
        _period_start = (new Date($("#period_start").val())).getTime() / 1000;
        if(!_period_start) _period_start = new Date().getTime() / 1000;
        if(!_period_end) _period_end= new Date().getTime() / 1000;
    }catch(e){}

    try {
        _location_from = $('#location_from').val();
        _location_to = $('#location_to').val();
        if(!_location_from) _location_from = '';
        if(!_location_to) _location_to= '';
    }catch(e){}



    var _renew = $('#renew').val();
    $.ajax({
        type : 'POST',
            url : __BASE + "reports/update", 
            data : {
                'item' : _ids,
                    'title' : $('#title').val(),
                    'receiver' : $('#receiver').val(),
                    'cc' : _cc,

                    'template_id' : _template_id,
                    'account' : _account,
                    'account_name' : _account_name,
                    'account_no' : _account_no,
                    'payment' : _payment,
                    'borrowing' : _borrowing,
                    'location_from' : _location_from,
                    'location_to' : _location_to,
                    'period_start' : _period_start,
                    'period_end' : _period_end,
                    'contract' : _contract,
                    'contract_note' : _contract_note,
                    'note' : _note,



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
String.prototype.trim=function() {
    return this.replace(/(^\s*)(\s*$)/g, '');
}
Date.prototype.format = function(format) {  
        /* 
            *      * eg:format="yyyy-MM-dd hh:mm:ss"; 
        *           */  
        var o = {  
            "M+" : this.getMonth() + 1, // month  
                "d+" : this.getDate(), // day  
        "h+" : this.getHours(), // hour  
        "m+" : this.getMinutes(), // minute  
        "s+" : this.getSeconds(), // second  
        "q+" : Math.floor((this.getMonth() + 3) / 3), // quarter  
        "S" : this.getMilliseconds()  
        };  

        if (/(y+)/.test(format)) {  
            format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4  
                - RegExp.$1.length));  
        }  

        for (var k in o) {  
            if (new RegExp("(" + k + ")").test(format)) {  
                format = format.replace(RegExp.$1, RegExp.$1.length == 1  
                    ? o[k]  
                    : ("00" + o[k]).substr(("" + o[k]).length));  
            }  
        }  
        return format;  
};
$(document).ready(function(){
    //$('#date-timepicker2').val();
    _contract = $('input[name="contract"]:checked').val(); 
    if(_contract == 0) {
                $('#contract_note').show();
    } else {
                $('#contract_note').hide();
    }
    $('.contract').each(function(idx, item) {
        $(this).click(function() {
            var _val = $(this).val();
            if(_val == 0) {
                $('#contract_note').show();
            } else {
                $('#contract_note').hide();
            }
        });
    });
    try{
    var _sdt = $('#sdt').val().trim();
    var _edt = $('#sdt').val().trim();
    if(!_sdt || _sdt == "") { 
        _sdt = new Date(); //new Date();
        _sdt = _sdt.format("yyyy-MM-dd hh:mm:ss");
    }
    if(!_edt || _edt == "") {
        _edt = new Date(); //new Date();
        _edt = _edt.format("yyyy-MM-dd hh:mm:ss");
    }

    $('#period_start').datetimepicker({
        language: 'zh-cn',
        defaultDate: _sdt,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "sdt",
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#period_end').datetimepicker({
        language: 'zh-cn',
        defaultDate: _edt,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "edt",
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    }catch(e){}
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');



$('.tdetail').each(function(){
        $(this).click(function(){

            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    });
    $('.tdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
           // location.href = __BASE + "items/del/" + _id + "/1";
           $.ajax({
            url:__BASE + "items/del/" + _id + "/1",
            method:'GET',
            success:function(data){
                $('#item'+_id).remove();
                show_notify('删除成功');
            }
           });
        });
    });
    $('.tedit').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/edit/" + _id;
        });
    });
    $('#all_item').click(function(){
        if($('#all_item').is(":checked"))
        {
            $('.amount').each(function(){
                $(this).prop('checked',true);
            });   
        }
        else
        {
            $('.amount').each(function(){
                $(this).prop('checked',false);
            });
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
            amount = Number(amount);
            //amount = Number(amount.substr(1));
            sum=Number(sum) + Number(amount);
        };
    });
    $('#tamount').html('￥' + toDecimal2(sum));
}
</script>
