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

                        if($config['account'] == 1){ 
?>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">银行账号</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $extra['account']['name'] . " [" . $extra['account']['no']; ?>" disabled>
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
                            $find = 0;
                            foreach($options as $n) {
                                $check_str = '';
                                if($n['value'] == $extra['payment']) {
                                    $find = 1;
?>
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="支付方式" value="<?php echo $n['desc']; ?>" disabled>

<?php 
                                }
                            }
                            if($find == 0){
?>

                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="支付方式" value="无" disabled>
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
                                <input type="text" class="form-controller col-xs-12" id="borrowing" name="borrowing"  placeholder="已付金额" value="<?php echo $extra['borrowing']; ?>" disabled>
                                </div>
                            </div>

<?php 
                        }
                        if($config['location'] == 1){ 
?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">出差地</label>
                                <div class="col-xs-9 col-sm-9">
                                <input type="text" id="location_from" class="form-controller col-xs-5" name="location_from"  placeholder="出发地" value="<?php echo $extra['location']['start']; ?>" disabled>
                                    <label class="col-sm-1 control-label">到</label>
                                    <input type="text" id="location_to" class="form-controller col-xs-5" name="location_to"  placeholder="到达地" value="<?php echo $extra['location']['dest']; ?>" disabled>
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
                            try {
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
                            } catch(Exception $e) {
                                $s = date('Y-m-d H:i:s');
                                $e = date('Y-m-d H:i:s');
                            }
?>


                                    <input type="text" id="period_start" class="form-controller col-xs-5 period" name="period_start"  placeholder="起始时间" value="<?php echo $s; ?>" disabled />
<input type="hidden" id="sdt" value="<?php echo strtotime($extra['period']['start']); ?>" >
                                    <label class="col-sm-1 control-label">到</label>
                                    <input type="text" id="period_end" class="form-controller col-xs-5 period" name="period_end"  placeholder="结束时间" value="<?php echo $e; ?>"  disabled>
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
                                         <input name="contract" type="radio" id="contract_yes" class="ace contract" value="1" <?php echo $_extra_yes; ?> disabled>
                                             <span class="lbl">有</span>
                                         </label>
                                    </div>
                                    <div class="radio col-xs-2 col-sm-2">
                                         <label>
                                             <input name="contract" type="radio" id="contract_no" class="ace contract" value="2" <?php echo $_extra_no; ?> disabled>
                                             <span class="lbl">无</span>
                                         </label>
                                    </div>
                                    <div class="radio col-xs-8 col-sm-8">
                                    <input type="text" id="contract_note" class="form-controller col-xs-12" name="contract_note"  placeholder="合同备注" value="<?php echo $extra['contract']['note']; ?>"  disabled>
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
                                    <textarea disabled id="note" rows="2" class="form-controller col-xs-12" name="note"><?php echo trim($extra['note']); ?></textarea>
                                    </div>
                                </div>
                            
                            </div>
<?php 
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
                                                $buf = '';
                                                switch($i['prove_ahead']) {
                                                case 0 : $buf = '报销';break;
                                                case 1 : $buf = '预算';break;
                                                case 2 : $buf = '预借';break;
                                                } 
                                                echo $buf;


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
                <h4 class="modal-title">报告将发送至以下审批人，请确认</h4>
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
                        <h4 class="modal-title">是否结束这条报告?</h4>
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
       if(confirm('确认要撤回报告吗?')){
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
