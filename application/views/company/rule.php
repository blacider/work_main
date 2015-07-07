
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/momenshowt.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>

<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('members/docreate');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">规则名称</label>
  rule                              <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" id="rname" name="rule_name" placeholder="规则名称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">手机</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" id="phone" name="mobile" placeholder="手机">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">邮箱</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="email" id="email"  placeholder="邮箱">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="groups" id="ugroups" multiple="multiple" data-placeholder="请选择部门">
                                        <!-- <option value="0">请选择部门</option> -->
                                        <?php foreach($groups['group'] as $g) { ?>
                                        
                                        <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行户名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="account" name="account" type="text" class="form-controller col-xs-12" placeholder="银行户名" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行卡号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" class="form-controller col-xs-12" name="cardno" id="credit_card" placeholder="银行卡号">
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">开户地</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select name="province" id="province">
                                    </select>
                                    <select name="city" id="city">
                                        <option>北京市</option>
                                    </select>
                                    <input id="cardloc" name="cardloc" type="hidden" class="form-controller col-xs-12 br3 inp" placeholder="开户地" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">管理员</label>
                                <div class="col-xs-6 col-sm-6">
                                    <label style="margin-top:8px;">
                                        <input name="admin" class="ace ace-switch btn-rotate" type="checkbox"  style="margin-top:4px;" />
                                        <span class="lbl"></span>
                                    </label>

                                </div>
                            </div>

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                                    <a class="btn btn-white btn-default renew" data-renew="1"><i class="ace-icon fa fa-check "></i>保存再记</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>

                        </div>
            </div>
        </form>
    </div>
</div>

<script language="javascript">
    var __PROVINCE = Array();
function get_province(){
        $.ajax({
            url : __BASE + "static/province.json",
            dataType : 'json',
            method : 'GET',
            success : function(data){
                __PROVINCE = data;
                $(data).each(function(idx, item){
                    var _h = "<option value='" +  item.name + "'>"+  item.name + " </option>";
                    $('#province').append(_h);
                });
            }
        });
        $('#province').change(function(){
            var _p = $(this).val();
            $('#city').html('');
            $(__PROVINCE).each(function(idx, item) {
                if(item.name == _p){
                    $(item.city).each(function(_idx, _item){
                    var _h = "<option value='" +  _item + "'>"+  _item + " </option>";
                    $('#city').append(_h);
                    });
                }
            });
        });
}
function reset_bank(disable, title) {
    $('#modal_title').val();
    $('#account' ).val("");
    $('#id' ).val("");
    $('#cardloc' ).val("");
    $('#cardno'  ).val("");
    $('#cardbank').val("");
    if(!disable) {
        $('.new_card').hide();
        $('#account').attr("disabled",  true);
        $('#cardloc').attr("disabled",  true);
        $('#cardno').attr("disabled",   true);
        $('#cardbank').attr("disabled", true);
    } else {
        $('.new_card').show();
        $('#account').attr("disabled",  false);
        $('#cardloc').attr("disabled",  false);
        $('#cardno').attr("disabled",   false);
        $('#cardbank').attr("disabled", false);
    }
}
$(document).ready(function(){

    get_province();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    $('.renew').click(function(){
        
        var _p = $('#province').val();
        var _c = $('#city').val();
        var _loc = _p + _c;//$('#cardloc').val();
        $('#cardloc').val(_loc);
	var name = $('#name').val();
	var phone = $('#phone').val();
	var email = $('#email').val();
	var groups = $('#ugroups').val();
	var account = $('#account').val();
	var credit_card = $('#credit_card').val();
	if(name=='')
	{	
		show_notify('请输入用户名');
        $('#name').focus();
		return false;
	}

	if(phone==''&& email=='')
	{	
		show_notify('请输入手机号码或email');
        $('#phone').focus();
        $('#email').focus();
		return false;
	}
	

        $('#renew').val($(this).data('renew'));
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
    $('.new_credit').click(function(){
        reset_bank(1, '添加新银行卡');
        $('#credit_model').modal({keyborard: false});
    });


});
</script>

