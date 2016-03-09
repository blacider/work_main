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

<script src="/static/js/bank_code.json"></script>

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
                            <?php if (!isset($company_config['enable_report_cc']) || $company_config['enable_report_cc']) { ?>
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
                            <?php } ?>
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
                                 <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right blue"><?php if(array_key_exists('name', $field_group)){echo $field_group['name'];}?></label>

                                </div>
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
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                                    <div class="btn-toolbar" id="<?php echo 'btns' . $field['id'];?>">
                                                        <div class="col-xs-8 col-sm-8">

                                                                <select class="chosen-select tag-input-style col-xs-6 field_value bank_select" id="<?php echo 'bank_select_' . $field['id'];?>" data-type="4" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?>>
                                                                    <?php foreach($banks as $b) { ?>
                                                                            <option value='<?php echo json_encode($b); ?>'><?php echo $b['account']  . '-' . $b['bankname'] . '-' . $b['cardno']; ?></option>

                                                                    <?php } ?>
                                                                </select>

                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-success new_credit" data-id="<?php echo $field['id'];?>">
                                                                <i class="ace-icon fa fa-credit-card icon-only"></i>
                                                                添加银行卡
                                                            </a>
                                                        </div><!-- /.btn-group -->
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
                                <div class="col-xs-11 col-sm-11">
                                    <table class="table table-border">
                                        <tr>
                                            <thead>
                                                <td style="width: 60px;">
                                                   <input name="all_item" id="all_item" type="checkbox" class="form-controller all_item"> 全选</td>
                                                <td style="width: 135px;">消费时间</td>
                                                <td style="min-width:103px;">类目</td>
                                                <td style="width: 60px;">金额</td>
                                                <td style="width: 45px;">类型</td>
                                                <td style="min-width: 100px;">商家</td>
                                                <td>备注</td>
                                                <td style="min-width: 86px;">操作</td>
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
    if(array_key_exists('disable_budget', $__config) && $__config['disable_budget'] == '0')
    {
        array_push($item_type,1);
    }
    if(array_key_exists('disable_borrow', $__config) && $__config['disable_borrow'] == '0')
    {
        array_push($item_type,2);
    }
}
foreach($items as $i){
    if($i['rid'] == 0 && in_array($i['prove_ahead'], $item_type) && in_array($i['prove_ahead'],$extra_item_type)){
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
                                            data-amount = "<?php echo $item_amount; ?>" data-type="<?php echo $i['prove_ahead'];?>"
                                            data-id="<?php echo $i['id']; ?>"
                                            ></td>
                                            <td><?php echo strftime('%Y-%m-%d %H:%M', $i['dt']); ?></td>
                                            <td><?php echo $i['cate_str'];?></td>
                                            <td><?php echo $i['coin_symbol'] . $i['amount'];?></td>
                                            <td><?php echo $item_type_dic[$i['prove_ahead']];?></td>
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
                                    <input id="cardno" name="cardno"type="text" class="form-controller col-xs-12" placeholder="卡号" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">开卡行</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select id="cardbank" name="cardbank" class="form-control" data-placeholder="请输入或者选择银行">
                                        <option value=''></option>
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

<script src="/static/js/libs/underscore-min.js"></script> 
<script src="/static/js/widgets/input-suggestion.js"></script>
<script>
 
update_tamount();
var __BASE = "<?php echo $base_url; ?>";
var allow_no_items = '<?php echo $config['options']['allow_no_items']; ?>';
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
        $('#bankCardType').val($(node).data('cardtype'));
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

function canGetPostData(force) {
    var def = $.Deferred();
    var s = $('#receiver').val();
    var title = $('#title').val();
    if (title == "") {
        show_notify('请添加报销单名');
        $('#title').focus();
        def.resolve(false)
        return def.promise();
    }
    var sum = 0;
    var _ids = Array();
    var report_type = 0;
    var flag = 0;
    $('.amount').each(function() {
        if ($(this).is(':checked')) {
            _ids.push($(this).data('id'));
            var amount = $(this).data('amount');
            var item_type = $(this).data('type');
            if (flag == 0) {
                report_type = item_type;
                flag = 1;
            }
            if (report_type != item_type) {
                show_notify('同一报销单中不能包含不同的消费类型');
                def.resolve(false)
                return def.promise();
            }
            sum += amount;
        };
    });
    if(_ids.length == 0 && allow_no_items==='0') {
        show_notify('提交的报销单不能为空');
        def.resolve(false)
        return def.promise();
    }
    var _period_start = 0;
    var _period_end = 0;
    var _location_from = '';
    var _location_to = '';
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
    } catch (e) {}
    try {
        _account = $('#account').val();
        var s = $("#account option:selected");
        _account_name = $(s).data('name');
        _account_no = $(s).data('no');
        if (!_account_name) _account_name = '';
        if (!_account_no) _account_no = '';
        if (!_account) _account = 0;
    } catch (e) {}
    var extra = [];
    $('.field_value').each(function() {
        var field_value = $(this).val();
        var field_id = $(this).data('id');
        var field_type = $(this).data('type');
        var field_required = $(this).data('required');
        if (field_type == 4) {
            var field_bank = $(this).data('bank');
            var bank_info = $('#bank_select_' + field_id).val();
            var field_account = '';
            var field_cardno = '';
            var field_bankname = '';
            var field_bankloc = '';
            var field_subbranch = '';
            if (field_required == 1 && !bank_info) {
                show_notify('必填银行卡项目不能为空');
                def.resolve(false)
                return def.promise();
            }
            if (bank_info) {
                var _bank_info = JSON.parse(bank_info);
                var field_account = _bank_info['account'];
                var field_cardno = _bank_info['cardno'];
                var field_bankname = _bank_info['bankname'];
                var field_bankloc = _bank_info['bankloc'];
                var field_subbranch = _bank_info['subbranch'];
            }
            extra.push({
                'id': field_id,
                'value': JSON.stringify({
                    'account': field_account,
                    'cardno': field_cardno,
                    'bankname': field_bankname,
                    'bankloc': field_bankloc,
                    'subbranch': field_subbranch,
                    'account_type': field_bank
                }),
                'type': field_type
            });
        } else {
            if (field_required == 1 && trim(field_value) == '') {
                $(this).focus();
                show_notify('必填项目不能为空');
                def.resolve(false)
                return def.promise();
            }
            extra.push({
                'id': field_id,
                'value': field_value,
                'type': field_type
            });
        }
    });
    if (s == null) {
        show_notify('请选择审批人');
        $('#receiver').focus();
        def.resolve(false)
        return def.promise();
    }
    if(sum <= 0 && allow_no_items==='0') {
        show_notify("报销单总额不能小于等于0");
        def.resolve(false)
        return def.promise();
    }
    // 转ajax,否则不能正确处理
    var _renew = $('#renew').val();
    if (_renew == 0) force = 1;
    // 获取所有的 条目
    var _cc = $('#cc').val();
    if (!_cc) _cc = Array();

    def.resolve({
        'item': _ids,
        'title': $('#title').val(),
        'receiver': $('#receiver').val(),
        'cc': _cc,
        'template_id': _template_id,
        'extra': extra,
        'type': report_type,
        'renew': _renew,
        'force': force
    });

    return def.promise();
}

function do_post(force) {

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
    if(_ids.length == 0 && allow_no_items==='0') {
        show_notify('提交的报销单不能为空');
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
 
    if(s == null){
         show_notify('请选择审批人');
         $('#receiver').focus();
         return false;
    }

    if(sum <= 0 && allow_no_items==='0') {
        debugger
        show_notify("报销单总额不能小于等于0");
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
                        'type':report_type,

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
        var _subbranch = $('#subbranch').val();
        var _card_type = $('#bankCardType').val();
        var _no = $('#cardno').val();
        var _loc = _p + _c;//$('#cardloc').val();
        var value = {"account":_account,"bankname":_bank,"subbranch":_subbranch,"bankloc":_loc,"cardno":_no};
        var _value = JSON.stringify(value);
        if(_card_type==='') {
            return show_notify('请选择卡类型');
        }
        if (_account == "") {
            show_notify('请输入户名');
            $('#account').focus();
            return false;
        };
        if (_no.length < 12) {
            show_notify('请输入正确银行卡号');
            $('#cardno').focus();
            return false;
        };
        if (_bank == "" || _bank == null || _bank == undefined) {
            show_notify('请选择银行卡开户行');
            $('#cardbank').focus();
            return false;
        };
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
                    $('#modal_title').val();
                    $('#account' ).val("");
                    $('#cardloc' ).val("");
                    $('#cardno'  ).val("");
                    $('#cardbank').val("");
                    $('#subbranch').val("");
                    $('#bankCardType').val("");
                }
            }
        });

    });

    bind_event();

    $('#period_start').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: false
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#period_end').datetimepicker({
        language: 'zh-cn',
            //locale:  moment.locale('zh-cn'),
            useCurrent: true,
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: false
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

    $('.txdetail').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    });
    $('.txdel').each(function() {
        $(this).click(function(){
            if(confirm('是否确认删除此消费？')){
                var _id = $(this).data('id');
                $.ajax({
                    url:__BASE + "items/del/" + _id + "/1",
                    method:'GET',
                    success:function(data){
                        $('#item'+_id).remove();
                        show_notify('删除成功');
                    }
                });
            }
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
        submit_check(0)
    });
    $('.force_submit_btn').click(function() {
        $('#renew').val(1);
        submit_check(1)
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

function submit_check(force) {
    canGetPostData(force).done(function (data) {
        if(!data) {
            return
        }
        $.ajax({
            type : 'POST',
            url : __BASE + "reports/check_submit",
            data : data,
            dataType: 'json',
            success : function(data){
                if(data.status > 0 && data.data.complete > 0) {
                    do_post();
                } else {
                    var suggest = data.data.suggestion;
                    var _names = [];
                    $(suggest).each(function(idx, value) {
                        $('#receiver option').each(function(_idx, _val) {
                            var _value = $(_val).attr('value');
                            var desc = $(_val).html();
                            if(_value == value) {
                                _names.push(desc);
                            }
                        });
                    });
                    $('#hidden_receiver').val(suggest.join(','));
                    $('#label_receiver').html(_names.join(','));
                    $('#modal_next').modal('show');
                }
                return false;
            }
        });
    })
    
};

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

