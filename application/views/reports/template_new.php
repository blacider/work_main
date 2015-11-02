<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
    
     
	 
	   <script src="/static/ace/js/jquery.colorbox-min.js"></script>
	   
	     <!-- page specific plugin styles -->
	     <link rel="stylesheet" href="/static/ace/css/colorbox.css" />



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('reports/create');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" id="title" class="form-controller col-xs-12" name="title"  placeholder="名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">发送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择审批人" id="receiver">
                                        <?php 
					$user = $this->session->userdata('user');
					foreach($members as $m) {
					if($user['id'] != $m['id']){
                        if ($user['manager_id'] != $m['id']){?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                                        <?php } else {?>
                                        <option selected="true" value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                                        <?php } ?>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="cc[]" id="cc" multiple="multiple" data-placeholder="请选择抄送人">
                                        <?php foreach($members as $m) {
					if($user['id'] != $m['id']){?>
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
                            if($config['config'])
                            {
                                ?>
                            <hr>
                                <?php 
                            }
                            foreach($config['config'] as $field_group){
                            ?>
                                <?php
                                    if(array_key_exists('children', $field_group))
                                    {
                                    foreach($field_group['children'] as $field)
                                    {
                                ?>

                                <?php
                                    switch(intval($field['type']))
                                    {
                            
                                        case 1:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 field_value" data-type="1" data-required="<?php echo $field['required'];?>" data-id="<?php echo $field['id'];?>" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 2:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-3 col-sm-3">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <select class="chosen-select tag-input-style col-xs-6 field_value" data-type="2" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?>>
                                                        <?php foreach($field['property']['options'] as $m) { ?>
                                                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                       
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 3:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 period field_value date-timepicker1" data-type="3" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" name="dt" placeholder="时间" <?php if($field['required'] == 1){echo 'required';}?>>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 4:
                                ?>
                                        <div class="field_value" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" data-required="<?php echo $field['required'];?>" >
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 account" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" placeholder="银行户名" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 cardno" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" placeholder="银行账号" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankname" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" placeholder="开户行名" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankloc" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" placeholder="开户地" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 subbranch" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" placeholder="支行" <?php if($field['required'] == 1){echo 'required';}?>/>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php 
                                    }
                                ?>

                                <?php
                                    }
                                ?>
                            <hr>
<?php
                            }
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
                                                </td>
                                                <td>消费时间</td>
                                                <td>类型</td>
                                                <td>金额</td>
                                                <td>类别</td>
                                                <td>商家</td>
                                                <td>备注</td>
                                                <td>操作</td>
                                            </thead>
                                        </tr>
<?php
    $_config = '';
    if(array_key_exists('config',$profile['group']))
    {
        $_config = $profile['group']['config'];
    }
    $__config = json_decode($_config,True);

$item_type = array();
array_push($item_type,0);
if($__config)
{
    if(array_key_exists('disable_borrow', $__config) && $__config['disable_borrow'] == '0')
    {
        array_push($item_type,1);
    }
    if(array_key_exists('disable_budget', $__config) && $__config['disable_budget'] == '0')
    {
        array_push($item_type,2);
    }
}
foreach($items as $i){
    if($i['rid'] == 0 && in_array($i['prove_ahead'], $item_type)){
                                        $item_amount = '';
                                        if($i['currency'] != 'cny')
                                        {
                                            $item_amount = round($i['amount']*$i['rate']/100,2);
                                        }
                                        else
                                        {
                                            $item_amount = $i['amount']; 
                                        }

                                        ?>
                                        <tr id="<?php echo 'item'.$i['id']?>">
                                        <td>
                                            <input name="item[]" value="<?php echo $i['id']; ?>" 
                                            type="checkbox" class="form-controller amount" 
                                            data-amount = "<?php echo $item_amount; ?>" 
                                            data-id="<?php echo $i['id']; ?>" 
                                            ></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['cate_str'];?></td>
                                            <td><?php echo  $i['coin_symbol'] . $i['amount'];?></td>
                                            <td><?php 
        
                                                $buf = '';
                                                switch($i['prove_ahead']) {
                                                case 0 : $buf = '报销';break;
                                                case 1 : $buf = '预算';break;
                                                case 2 : $buf = '预借';break;
                                                } 
                                                echo $buf;


                                                ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note']; ?></td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del">
                                                    <span class="ui-icon ui-icon ace-icon fa fa-search-plus txdetail" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon green ui-icon-pencil txedit" data-id="<?php echo $i['id']; ?>"></span>
                                                    <span class="ui-icon ui-icon-trash red  txdel" data-id="<?php echo $i['id']; ?>"></span>
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
update_tamount();
var __BASE = "<?php echo $base_url; ?>";

function trim(str){ //删除左右两端的空格
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}

function toDecimal(x) {  
    var f = parseFloat(x);  
    if (isNaN(f)) {  
        return;  
    }  
    f = Math.round(x*100)/100;  
    return f;  
}  
//制保留2位小数，如：2，会在2后面补上00.即2.00  
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



function do_post(force) {
    // 囧

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
           
			amount = parseInt(amount);
			sum+=amount;
		};
	});
    if(_ids.length == 0) {
        show_notify('提交的报告不能为空');
        return false;
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
    var _payment = 0;


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
        if(!_account_name) _account_name = '';
        if(!_account_no) _account_no = '';
        if(!_account) _account = 0;
    } catch(e) {}

    var extra = [];
    var is_submit = 1;
 
    $('.field_value').each(function(){
        var field_value = $(this).val();
        var field_id = $(this).data('id');
        var field_type = $(this).data('type');
        var field_required = $(this).data('required');

        if(field_type == 4)
        {
            var field_bank = $(this).data('bank');
            var field_account = $('.account',this).val();
            var field_cardno = $('.cardno',this).val();
            var field_bankname = $('.bankname',this).val();
            var field_bankloc = $('.bankloc',this).val();
            var field_subbranch = $('.subbranch',this).val();
            if(field_required == 1)
            {
                if(trim(field_account) == '')
                {
                    $('.account',this).focus();
                    show_notify('必填项目不能为空');
                    is_submit = 0;
                    return false;
                }
                if(trim(field_cardno) == '')
                {
                    $('.cardno',this).focus();
                    show_notify('必填项目不能为空');
                    is_submit = 0;
                    return false;
                }
                if(trim(field_bankname) == '')
                {
                    $('.bankname',this).focus();
                    show_notify('必填项目不能为空');
                    is_submit = 0;
                    return false;
                }
                if(trim(field_bankloc) == '')
                {
                    $('.bankloc',this).focus();
                    show_notify('必填项目不能为空');
                    is_submit = 0;
                    return false;
                }
                if(trim(field_subbranch) == '')
                {
                    $('.subbranch',this).focus();
                    show_notify('必填项目不能为空');
                    is_submit = 0;
                    return false;
                }
            }
            extra.push({'id':field_id,'value':JSON.stringify({
                                               'account':field_account,
                                               'cardno':field_cardno,
                                               'bankname':field_bankname,
                                               'bankloc':field_bankloc,
                                               'subbranch':field_subbranch,
                                               'account_type':field_bank
                                               })
                                               ,'type':field_type} );
        }
        else
        {

            if(field_required == 1 && trim(field_value)=='')
            {
                $(this).focus();
                show_notify('必填项目不能为空');
                is_submit = 0;
                return false;
            }
            extra.push({'id':field_id,'value':field_value,'type':field_type});
        }
        
    });

/*
    try {
        _note = $('#note').val();
        if(!_note) _note = '';
    } catch(e) {}

    try {
        _payment = $('input[name="payment"]:checked').val(); 
        if(!_payment) _payment = 0;
    }catch(e){}

    try {
        _borrowing = $('#borrowing').val();
        if(!_borrowing) _borrowing = 0;
    } catch(e) {}

    try {
        _contract = $('input[name="contract"]:checked').val(); 
        if(!_contract) _contract = -1;
    }catch(e){}
    if(_contract == 2) {
        try{
            _contract_note = $('#contract_note').val();
            if(!_contract_note) _contract_note = '';
        }catch(e){}
    }


    try {
        _period_end = (new Date($("#period_end").val())).getTime() / 1000;
        _period_start = (new Date($("#period_start").val())).getTime() / 1000;
        if(!_period_start || _period_start == NaN) _period_start = new Date().getTime() / 1000;
        if(!_period_end || _period_end== NaN) _period_end= new Date().getTime() / 1000;
        _period_start = parseInt(_period_start);
        _period_end = parseInt(_period_end);
    }catch(e){}

    try {
        _location_from = $('#location_from').val();
        if(!_location_from) _location_from = '';
        _location_to = $('#location_to').val();
        if(!_location_to) _location_to= '';
    }catch(e){} */


	if(s == null){
	     show_notify('请选择审批人');
	     $('#receiver').focus();
	     return false;
	}


	if(sum <= 0) {
		show_notify("报告总额不能小于等于0");
		return false;
	}
    
    // 转ajax,否则不能正确处理
    var _renew = $('#renew').val();
    if(_renew == 0) force = 1;
    // 获取所有的 条目
    var _cc = $('#cc').val();
    if(!_cc) _cc = Array();
    if(is_submit)
    {
        $.ajax({
            type : 'POST',
                url : __BASE + "reports/create", 
                    data : {'item' : _ids,
                        'title' : $('#title').val(),
                        'receiver' : $('#receiver').val(),
                        'cc' : _cc,

                        'template_id' : _template_id,
                        'extra':extra,

                        'renew' : _renew,
                        'force' : force
                    },
                    dataType: 'json',
                    success : function(data){
                        if(data.status > 0) {
                            window.location.href = __BASE + 'reports/index';
                        }
                        if(_renew == 1 && data.status == -71) {
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

}

$(document).ready(function(){
    $('#period_start').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#period_end').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#contract_note').hide();
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
    $('.date-timepicker1').each(function(){
        $(this).datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD HH:mm:ss",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
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

    $('.txdetail').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    });
    $('.txdel').each(function() {
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
    $('.txedit').each(function() {
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
        /// 不强制
        do_post(0);
    });
    $('.force_submit_btn').click(function() {
        $('#renew').val(1);
        do_post(1);
    });



    $('.amount').each(function(idx, item) {
        $(this).click(function(){
            update_tamount();
        });
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });

});
function update_tamount(){
    var sum = 0;
    $('.amount').each(function(){
        if($(this).is(':checked')){
            var amount = $(this).data('amount');
            amount = Number(amount);
            sum=Number(sum) + Number(amount);
        };
    });
    $('#tamount').html('￥' + toDecimal2(sum));
}
</script>

