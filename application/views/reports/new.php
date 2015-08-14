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
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择标签" id="receiver">
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
                                    <select class="chosen-select tag-input-style" name="cc[]" multiple="multiple" data-placeholder="请选择标签">
                                        <?php foreach($members as $m) {
					if($user['id'] != $m['id']){?>
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
        array_push($item_type,2);
    }
    if(array_key_exists('disable_budget', $__config) && $__config['disable_budget'] == '0')
    {
        array_push($item_type,1);
    }
}
foreach($items as $i){
    if($i['rid'] == 0 && in_array($i['prove_ahead'], $item_type)){
                                        ?>
                                        <tr>
                                            <td><input name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller amount" data-amount = "<?php echo $i['amount'] ?>" ></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['cate_str'];?></td>
                                            <td><?php echo $i['amount']; ?></td>
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


<script language="javascript">
update_tamount();
var __BASE = "<?php echo $base_url; ?>";
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
        //console.log(ev.date);
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

    $('.txdetail').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    $('.txdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/del/" + _id;
        });
    });
    $('.txedit').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/edit/" + _id;
        });
    });
    });

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

        var s = $('#receiver').val();
        var title = $('#title').val();
        if(title == "") {
             show_notify('请添加报告名');
             $('#title').focus();
             return false;
         }
/*	
	if(isNaN(s)){
	     show_notify('请选择审批人');
	     $('#receiver').focus();
	     return false;
	}
*/
	if(s == null){
	     show_notify('请选择审批人');
	     $('#receiver').focus();
	     return false;
	}

	sum=0;

	$('.amount').each(function(){
		if($(this).is(':checked')){
			var amount = $(this).data('amount');
			amount = parseInt(amount.substr(1));
			sum+=amount;
		};
	});



	if(sum <= 0)
	{
		show_notify("报告总额不能小于等于0");
		return false;
	}
        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
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
            amount = parseInt(amount.substr(1));
            sum+=amount;
        };
    });
    $('#tamount').html('￥' + toDecimal2(sum));
}
</script>
