<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<style>
    .chosen-container  {
        min-width: 400px;
        width: 400px;
    }
</style>
<div class="page-content">
    <div class="page-content-area">
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
            <div class="container col-xs-11 col-sm-11">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['title']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交至</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['managers']; ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['cc']; ?>" disabled>
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
                                                    <input type="text" class="form-controller col-xs-8 field_value" data-type="1" data-id="<?php echo $field['id'];?>" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){echo $extra_dic[$field['id']]['value'];}?>" disabled/>
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
                                                    <select class="chosen-select tag-input-style col-xs-6 field_value" data-type="2" data-id="<?php echo $field['id'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?> disabled>
                                                        <?php foreach($field['property']['options'] as $m) { 
                                                                if(array_key_exists($field['id'], $extra_dic) && $m == $extra_dic[$field['id']]['value'])
                                                                {
                                                            ?>
                                                                <option selected value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                       
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                        <?php            
                                                                }
                                                        } ?>
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
                                                    <input type="text" class="form-controller col-xs-8 period field_value date-timepicker1" data-type="3" data-id="<?php echo $field['id'];?>" name="dt" 
                                                            placeholder="时间" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){echo date('Y-m-d',$extra_dic[$field['id']]['value']);}?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 4:
                                ?>
                                        <?php 
                                            $value = array();
                                            if(array_key_exists($field['id'], $extra_dic))
                                            {
                                                $value = json_decode($extra_dic[$field['id']]['value'],True);
                                            }
                                        ?>
                                        <div class="field_value" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>">
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 account" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" 
                                                        placeholder="银行户名" value="<?php if($value && array_key_exists('account', $value)){ echo $value['account'];}?>" <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 cardno" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" 
                                                        placeholder="银行账号" value="<?php if($value && array_key_exists('cardno', $value)){ echo $value['cardno'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>
                                        
                                        </div>


                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankname" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" 
                                                        placeholder="开户行名" value="<?php if($value && array_key_exists('bankname', $value)){ echo $value['bankname'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankloc" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" 
                                                        placeholder="开户地" value="<?php if($value && array_key_exists('bankloc', $value)){ echo $value['bankloc'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>
                                        
                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 subbranch" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" 
                                                        placeholder="支行" value="<?php if($value && array_key_exists('subbranch', $value)){ echo $value['subbranch'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
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
                                <div class="col-xs-10 col-sm-10">
<?php
$amount = 0;
foreach($report['items'] as $i) {
    $rate = 1.0;
    if($i['currency'] && strtolower($i['currency']) != 'cny') {
        $rate = $i['rate'] / 100;
    }
    $amount += $i['amount'] * $rate;
}
    $amount = sprintf("%.02f", $amount);
?>
    <span class="middle" id="tamount">￥  <?php echo $amount; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费列表</label>
                                <div class="col-xs-10 col-sm-10">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>消费时间</td>
                                            <td>类别</td>
                                            <td>金额</td>
                                            <td>类型</td>
                                            <td>商家</td>
                                            <td>备注</td>
                                            <td>详情</td>
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($report['items'] as $i){
                                            $_date_str = strftime('%Y-%m-%d %H:%M', $i['dt']);
                                            $_extra_amount = '';
                                            $_extra_dt = '';
                                            if(count($i['extra'])) {
                                                // TODO 目前情况下每个元素都只有一个了
                                                foreach($i['extra'] as $e) {
                                                    if($e['type']  == 2) {
                                                        // 多时间的
                                                        $sdt = $i['dt'];
                                                        $edt = $e['value'];
                                                        $_day_delta = abs(($sdt - $sdt % 86400) - ($edt - $edt % 86400)) / 86400;
                                                        if(date('H', $sdt) < 12) $_day_delta += 1;
                                                        if(date('H', $edt) > 12) $_day_delta += 1;
                                                        // 都切换到12点去
                                                        $_date_str = strftime('%Y-%m-%d %H:%M', $i['dt']) . '至' . strftime('%Y-%m-%d %H:%M', $edt);
							
                                                        if ($_day_delta > 0) {
                                                            $_date_str = $_date_str . "(共" . $_day_delta . "天)";							
                                                            $_extra_amount = '（' . sprintf("%.2f", $i['amount'] / $_day_delta) . "元/天）";
                                                        }
                                                    }
                                                    if($e['type'] == 5) {
                                                        // 多人的
                                                        $members = $e['value'];
							if ($members > 0) {
                                                            $_extra_amount = '（' . sprintf("%.2f", $i['amount'] / $members) . "元/人 共" . $members . "人）";
							}
                                                    }
                                                }
                                            }
?>
                                        <tr>
                                            <td><?php echo $_date_str; ?></td>
                                            <td>
                                            <?php echo $i['category_name']; ?></td>
<?php 
                                                $update_amount = '';
                                                if($i['src_amount'] > 0) { 
                                                    $update_amount = "[" . $i['currency_logo'] . $i['src_amount'] . " 由  ". $i['lastmodifier'] . "修改]";
                                                }
?>
    <td><?php echo $i['currency_logo']; ?> &nbsp;<?php echo $i['amount']; ?> <?php echo  $update_amount . $_extra_amount; ?> </td>
                                            <td><?php 
                                                echo $item_type_dic[$i['prove_ahead']];
                                                ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note'];?></td>
                                            <td><?php $link = base_url('items/show/' . $i['id'] . "/1"); ?><a href="<?php echo $link; ?>">详情</a></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                        <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">审批流程</label>
                                <div class="col-xs-10 col-sm-10">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>审批人</td>
                                            <td>审批意见</td>
                                            <td>审批时间</td>
                                       
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($flow as $i){ ?>
                                        <tr>
                                   
                                            <td><?php 
                                                if($i['wingman']) 
                                                    {
                                                        echo $i['nickname'].'('.$i['wingman'].'代提交)';
                                                    }
                                                else
                                                {
                                                    echo $i['nickname'];
                                                }
                                             ?></td>
                                            <td><?php echo $i['status']; ?></td>
                                            <td><?php 
if($i['ts'] != '0000-00-00 00:00:00') {
                                                echo $i['ts']; 
}
?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">留言</label>
                                <div class="col-xs-10 col-sm-10">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>姓名</td>
                                            <td>留言</td>
                                            <td>内容</td>
                                       
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($comments as $i){ ?>
                                        <tr>
                                   
                                            <td><?php echo $i['nickname']; ?></td>
                                            <td><?php 
                                            if($i['lastdt'] != '0000-00-00 00:00:00') {
                                                echo $i['lastdt']; 
                                            }
                                            ?></td>
                                            <td><?php echo $i['comment']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
               

<style type="text/css">
     #submit1 {
  background-color: #fe575f;
  border: 0;
  color: white;
  height: 30px;
  border-radius: 3px;   
  font-size: 12px;
   }
   #submit1:hover {
    background-color: #ff7075;
   }
</style>


                            <!--
                            <div class="form-group" style="margin-bottom: 10px;min-weight:40px;">
                                <center>
                                    <button class="btn btn-success">修改</button>
                                </center>
                            </div>
                            -->
                   
                   
                    </div>
        </form>

        <div class="form-group">
            <form method="post" id='comment' action="<?php echo base_url('reports/add_comment');  ?>" > 
                <div class="col-xs-6 col-sm-6 col-xs-offset-2 col-sm-offset-2">
                    <input type="text" name="comment" style="width:100%;">
                </div>
                <input type="hidden" name="rid" value="<?php echo $rid;?>">
                <div class="col-xs-1 col-sm-1">
                    <input type="button" id="submit1" style="margin-top:2px;" value="提交留言">
                </div>
            </form>
        </div>

        <div class="clearfix form-actions col-sm-10 col-xs-10">
            <div class="col-md-offset-3 col-md-9">
                <?php
                $_ruid = $report['uid'];
                $_uid = $profile['id'];
                if($_ruid == $_uid  && (($report['status'] == 1) || ($report['status'] == 2)) ) 
                {
                    ?>
                    <a style="margin-left: 80px;" class="btn btn-white callback" data-renew="-2"><i class="ace-icon fa fa-undo gray bigger-110"></i>撤回</a>
                    <?php 
                }
                if($decision == 1)
                {
                    ?>
                    <a style="margin-left: 20px;" class="btn btn-white tpass" ><i class="ace-icon fa fa-check-square-o gray bigger-110"></i>通过</a>
                    <a style="margin-left: 20px;" class="btn btn-white tdeny" ><i class="ace-icon  glyphicon glyphicon-remove gray bigger-110"></i>退回</a>
                    <?php 
                }
                ?>                               
                <a style="margin-left: 20px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>返回</a>
            </div>
        </div>


    </div>

</div>




<div class="modal fade" id="comment_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">退回理由</h4>
            </div>
            <form action="<?php echo base_url('/reports/permit'); ?>" method="post" id="form_discard">
                <div class="modal-body">
                    <input type="hidden" id="div_id" class="thumbnail" name="rid" style="display:none;" value=""/>
                    <input type="hidden" id="status"  name="status" style="display:none;" value="3" />
                    <div class="form-group">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <a class="btn btn-white btn-primary new_card" data-renew="0"><i class="ace-icon fa fa-save "></i>退回</a>
                            <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="modal_next">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('reports/permit'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">报销单将发送至以下审批人，请确认</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-10 col-sm-10">
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;">
                            <?php foreach($members as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="pass" name="pass" value="0" />
                <input type="submit" class="btn btn-primary" value="确认" />
                <div class="btn btn-primary" onclick="cancel_modal_next()">取消</div>
            </div>
                </form>
                <script type="text/javascript">
                  function cancel_modal_next() {
                    $('#modal_next').modal('hide');
                    return;
                  }
                </script>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal_next_">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('reports/permit'); ?>" method="post" class="form-horizontal" id="permit_form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <input type="hidden" name="rid" value="" id="rid_">
                <input type="hidden" name="status" value="2" id_="status">
                <h4 class="modal-title">是否结束</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-10 col-sm-10">
                        <select style="display:none;" class="chosen-select_ tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;">
                        </select>
                        <h4 class="modal-title">是否结束这条报销单?</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="pass" name="pass" value="0">
                <input type="submit" class="btn btn-primary pass" value="确认结束">
                <div class="btn btn-primary repass" onClick="chose_others(this.parentNode.parentNode.rid.value)">继续选择</div>
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="/static/js/base.js" ></script>
<script src="/static/js/audit.js" ></script>
<?php

$close_directly = 0;
if($profile['gid'] > 0){
    $_config = $profile['group']['config'];
    if($_config) {
        $config = json_decode($_config, True);
        if(array_key_exists('close_directly', $config) && $config['close_directly'] == 1){
            $close_directly = 1;
        }
    }
}
?>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var close_directly = "<?php echo $close_directly; ?>";
$(document).ready(function(){
    $('.new_card').click(function(){
        $('#form_discard').submit();
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
    $('.pass').click(function(){
        $('#pass').val(1);
    });
});
</script>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var rid = "<?php echo $rid; ?>";
var error = "<?php echo $error; ?>";
$(document).ready(function(){
    if(error) show_notify(error);
    $('.cancel').click(function() {
            history.go(-1);
    });

    $('.callback').click(function(){
       if(confirm('确认要撤回报销单吗?')){
                location.href = __BASE + "/reports/revoke/" + rid;
            }
    });

    $('#submit1').click(function(){
        $('#comment').submit();
    });

        $('.tpass').each(function() {
        $(this).click(function(){
            var _id = rid;
            $.ajax({
                type:"GET",
                url:__BASE + "reports/check_permission",
                data: {
                    rid:_id
                },
                dataType: "json",
                success: function(data){
                    if (data['status'] > 0) {
                        getData = data['data'].suggestion;
                        if (data['data'].complete == 0) {
                            $('#rid').val(_id);
                            chose_others_zero(_id);
                        } else {
                            $('#rid_').val(_id);
                            $('#status_').val(2);
                            if(close_directly == 0) {
                                $('#modal_next_').modal('show'); 
                            } else {
                                $('#permit_form').submit();
                            }
                        }
                    }
                }
            });
        });
    });

    $('.tdeny').each(function() {
        $(this).click(function(){
            var _id = rid;
            $('#div_id').val(_id);
            $('#comment_dialog').modal('show');
        });
    });
});
</script>
