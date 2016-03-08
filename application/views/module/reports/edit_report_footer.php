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
                                                <td>类目</td>
                                                <td>金额</td>
                                                <td>类型</td>
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
    $extra_item_type = [0,1,2];
    if(array_key_exists('type', $config))
    {
        $extra_item_type = $config['type'];
    }
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

foreach($report['items'] as $i){
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
                                        <tr>
                                            <td><input checked='true' name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller amount" data-amount = "<?php echo $item_amount; ?>"
                                                data-id="<?php echo $i['id']; ?>" data-type="<?php echo $i['prove_ahead'];?>"></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['category_name']; ?></td>
                                            <td><?php echo $i['coin_symbol'] . $i['amount'];?></td>
                                            <td><?php echo $item_type_dic[$i['prove_ahead']];?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note']?></td>
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
    if($i['rid'] == 0 && in_array($i['prove_ahead'], $item_type) && in_array($i['prove_ahead'], $extra_item_type)){
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
                                        <tr>
                                            <td><input name="item[]" value="<?php echo $i['id']; ?>" type="checkbox" class="form-controller amount" data-amount = "<?php echo $item_amount; ?>"
                                                    data-id="<?php echo $i['id']; ?>" data-type="<?php echo $i['prove_ahead'];?>"></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['cate_str']; ?></td>

                                            <td><?php echo $i['coin_symbol'] . $i['amount'];?></td>
                                            <td><?php echo $item_type_dic[$i['prove_ahead']];?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note']?></td>
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


<div class="modal fade" id="modal_next">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">根据公司规定，你的报销单需要提交给</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9" id="label_receiver">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success submit_by_rule" value="按照公司规定发送报销单" />
                <input type="submit" class="btn btn-primary my_submit" value="按照我的选择发送报销单" />
                <div class="btn btn-primary" onclick="cancel_modal_next()">取消</div>
            </div>
                <script type="text/javascript">
                  function cancel_modal_next() {
                    $('#modal_next').modal('hide');
                    return;
                  }
                </script>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="credit_model">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_title">添加银行卡</h4>
            </div>
            <div class="modal-body">
                <form id="password_form" class="form-horizontal" role="form" method="post" action="#">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">户名</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="account" name="account" type="text" class="form-controller col-xs-12" placeholder="户名" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">卡号</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="cardno" name="cardno" type="text" class="form-controller col-xs-12" placeholder="卡号" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开卡行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="cardbank" name="cardbank" class="form-control" data-placeholder="请输入或者选择银行">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">卡类型</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="bankCardType" name="cardtype" class="form-control" data-placeholder="请选择卡类型">
                                        <option selected value="">请选择卡类型</option>
                                        <option value="0">借记卡</option>
                                        <option value="1">信用卡</option>
                                        <option value="2">其它</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开户地</label>
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
                                <label class="col-sm-2 control-label no-padding-right">支行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input id="subbranch" name="subbranch" type="text" class="form-controller col-xs-12" placeholder="支行" />
                                </div>
                            </div>

                            <input type="hidden" name="bank_field_id" id="bank_field_id" />
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary new_card" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" id="credit_cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/js/libs/underscore-min.js"></script> 
<script src="/static/js/widgets/input-suggestion.js"></script>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var __SUM = 0;


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


function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
 }


function reset_bank(disable, title,bank_field_id) {
        $('#modal_title').val();
        $('#account' ).val("");
        $('#cardloc' ).val("");
        $('#cardno'  ).val("");
        $('#cardbank').val("");
        $('#subbranch').val("");
        $('#bank_field_id').val(bank_field_id);
        if(!disable) {
            $('.new_card').hide();
            $('#account').attr("disabled",  true);
            $('#cardloc').attr("disabled",  true);
            $('#cardno').attr("disabled",   true);
            $('#cardbank').attr("disabled", true);
            $('#subbranch').attr("disabled",true);
        } else {
            $('.new_card').show();
            $('#account').attr("disabled",  false);
            $('#cardloc').attr("disabled",  false);
            $('#cardno').attr("disabled",   false);
            $('#cardbank').attr("disabled", false);
            $('#subbranch').attr("disabled",false);
        }
        title && $('#credit_model').find('.modal-title').text(title);
        $('.cancel').click(function(){
            $('#credit_model').modal('hide');
        });
    }



    function del_credit(node){
        var _id = $(node).data('id');
        $('#bank_' + _id).remove();
    }


    function update_credit(node){
        var _id = $(node).data('id');
        reset_bank(1, '修改银行卡', _id);

        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
        $('#credit_model').modal('show');
        var i = 1, loc = $(node).data('bankloc');

        do {
            i += 1;
            $('select[name="province"]').val(loc.substr(0,i));
            if(i>loc.length+1)
            {
                break;
            }
        } while ($('select[name="province"]').val() == null);
        /*for(var i=1;i<=loc.length+1;i++)
            {
             $('select[name="province"]').val(loc.substr(0,i));
                        }*/
                        var city = loc.substr(i);
                    $('select[name="province"]').change();
                    $('select[name="city"]').val(city);
    }

    function show_credit(node){
        var _id = $(node).data('id');
        reset_bank(0, '银行卡详情',_id);
        $('#account').val($(node).data('account'));
        $('#cardbank').val($(node).data('bankname'));
        $('#cardloc').val($(node).data('bankloc'));
        $('#cardno').val($(node).data('cardno'));
        $('#subbranch').val($(node).data('subbranch'));
        $('#credit_model').modal('show');
        var i = 1, loc = $(node).data('bankloc');
        do {
            i += 1;
            $('select[name="province"]').val(loc.substr(0,i));
            if(i>loc.length+1)
            {
                break;
            }
        } while ($('select[name="province"]').val() == null);
        var city = loc.substr(i);
        $('select[name="province"]').change();
        $('select[name="city"]').val(city);
    }

    function bind_event(){
        $('.del_bank').click(function(){
            del_credit(this);
        });

        $('.show_bank').click(function(){
            show_credit(this);
        });

        $('.edit_bank').click(function(){
            update_credit(this);
        });


    }


function trim(str){ //删除左右两端的空格
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}
function do_post(force) {

    var _rid = $('#hrid').val();
    var s = $('#receiver').val();
    var title = $('#title').val();
    if(title == "") {
        show_notify('请添加报销单名');
        $('#title').focus();
        return false;
    }


    var sum=0;

    var _ids = Array();
    var report_type = 0;
    var flag = 0;
    var is_submit = 1;
    $('.amount').each(function(){
        if($(this).is(':checked')){
            _ids.push($(this).data('id'));
            var amount = $(this).data('amount');
            var item_type = $(this).data('type');
            if(flag == 0)
            {
                report_type = item_type;
                flag = 1;
            }
            if(report_type != item_type)
            {
                show_notify('同一报销单中不能包含不同的消费类型');
                is_submit = 0;
                return false;
            }

            sum+=amount;
        };
    });
    if(_ids.length == 0) {
        show_notify('提交的报销单不能为空');
        return false;
    }

    if(s == null){
         show_notify('请选择审批人');
         $('#receiver').focus();
         return false;
    }


    if(sum<= 0) {
        show_notify("报销单总额不能小于等于0");
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



    var extra = [];

    $('.field_value').each(function(){
        var field_value = $(this).val();
        var field_id = $(this).data('id');
        var field_type = $(this).data('type');
        var field_required = $(this).data('required');

        if(field_type == 4)
        {
            var field_bank = $(this).data('bank');
            var bank_info = $('#bank_select_' + field_id).val();

            var field_account = '';
            var field_cardno = '';
            var field_bankname = '';
            var field_bankloc = '';
            var field_subbranch = '';

            if(field_required == 1 && !bank_info)
            {
                show_notify('必填银行卡项目不能为空');
                is_submit = 0;
                return false;
            }
            if(bank_info)
            {
                var _bank_info = JSON.parse(bank_info);

                var field_account = _bank_info['account'];
                var field_cardno = _bank_info['cardno'];
                var field_bankname = _bank_info['bankname'];
                var field_bankloc = _bank_info['bankloc'];
                var field_subbranch = _bank_info['subbranch'];
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
*/


    var _renew = $('#renew').val();
    if(is_submit)
    {
        $.ajax({
            type : 'POST',
                url : __BASE + "reports/update",
                data : {
                    'item' : _ids,
                        'title' : $('#title').val(),
                        'receiver' : $('#receiver').val(),
                        'cc' : _cc,

                        'template_id' : _template_id,
                        'extra':extra,
                        'type':report_type,

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
    get_province();

     $('.new_credit').each(function(){
        var _id = $(this).data('id');
        $(this).click(function(){
            reset_bank(1,'添加新银行卡',_id);
            $('#credit_model').modal({keyborard:false});
        });
    });
    $('.new_card').click(function(){
        var _id = $('#bank_field_id').val();
        var _p = $('#province').val();
        var _c = $('#city').val();
        var _account = $('#account').val();
        var _bank = $('#cardbank').val();
        var _card_type = $('#bankCardType').val();
        var _subbranch = $('#subbranch').val();
        var _no = $('#cardno').val();
        var _loc = _p + _c;//$('#cardloc').val();
        var value = {"account":_account,"bankname":_bank,"subbranch":_subbranch,"bankloc":_loc,"cardno":_no};
        var _value = JSON.stringify(value);

        if(_card_type==='') {
            return show_notify('请选择卡类型');
        }
        

        var buf = '<option selected value="'+ escapeHtml(_value) +'">'+ _account + '-' + _bank + '-' + _no +'</option>';
        $('#credit_model').modal('hide');
        $('#bank_select_' + _id).append(buf);
        $('#bank_select_' + _id).trigger('chosen:updated');
        $.ajax({
            url : __BASE + "users/new_credit",
            data : {
                'account' : _account
                    ,'cardbank' : _bank
                    ,'cardno' : _no
                    ,'cardloc' :  _loc
                    ,'cardtype' : _card_type
                    ,'subbranch':_subbranch
                    ,'default':0
            },
            dataType : 'json',
            method : 'POST',
            success:function(data){
                if(data['status'] > 0)
                {
                    show_notify('银行卡添加成功');
                }
            }
        });
    });

    bind_event();

    $('.submit_by_rule').click(function(){
        var _receivers = ($('#hidden_receiver').val());
        if(!_receivers) do_post();
        _receivers = _receivers.split(",");
        $('#receiver').val(_receivers).trigger("chosen:updated");
        do_post();
    });
    $('.my_submit').click(function(){
        do_post();
    });
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
        format: 'YYYY-MM-DD',
        linkField: "sdt",
        sideBySide: false
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#period_end').datetimepicker({
        language: 'zh-cn',
        defaultDate: _edt,
        format: 'YYYY-MM-DD HH:mm:ss',
        linkField: "edt",
        sideBySide: false
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    }catch(e){}

  $('.date-timepicker1').each(function(){
        $(this).datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD",
            pickTime:false
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
        submit_check();
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

new InputSuggestion('#cardbank', {
    onDataLoaded: function(data) {
        var BANK_CODE = (function changeBankDataToMap(argument) {
            var bankMap = {};
            for (var name in data) {
                var prefixArray = data[name];
                for (var i = 0; i < prefixArray.length; i++) {
                    bankMap[prefixArray[i]] = name;
                }
            }
            return bankMap;
        })(data);
        $("#cardno").keyup(function(e) {
            var value = this.value;
            if (value.length < 6) {
                return;
            }
            value = value.substring(0, 6);
            if (BANK_CODE[value] != undefined) {
                $('#cardbank').val(BANK_CODE[value]);
                $('#cardbank').trigger("chosen:updated");
            };
        });
    }
});
</script>