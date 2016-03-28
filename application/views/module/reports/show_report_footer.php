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
                if($_ruid == $_uid)
                {
                    if(($report['status'] == 1) || ($report['status'] == 2))
                    {
                    ?>
                    <a style="margin-left: 80px;" class="btn btn-white callback" data-renew="-2"><i class="ace-icon fa fa-undo gray bigger-110"></i>撤回</a>
                    <?php
                    }
                    else if($report['status'] == 7)
                    {
                    ?>
                    <a style="margin-left: 80px;" class="btn btn-white confirm_success" data-renew="-2"><i class="ace-icon fa fa-check-square-o gray bigger-110"></i>确认已收款</a>
                    <?php
                    }
                }
                if($decision == 1)
                {
                    ?>
                    <a style="margin-left: 20px;" class="btn btn-white tpass" ><i class="ace-icon fa fa-check-square-o gray bigger-110"></i>通过</a>
                    <a style="margin-left: 20px;" class="btn btn-white tdeny" ><i class="ace-icon  glyphicon glyphicon-remove gray bigger-110"></i>退回</a>
                    <?php
                }
                else if(in_array($profile['admin'],[1,2]) && $report['status'] == 2)
                {
                     ?>
                    <a style="margin-left: 20px;" class="btn btn-white tapprove" ><i class="ace-icon fa fa-check-square-o gray bigger-110"></i>通过</a>
                    <a style="margin-left: 20px;" class="btn btn-white finance_tdeny" ><i class="ace-icon  glyphicon glyphicon-remove gray bigger-110"></i>退回</a>
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
                    <input type="hidden" id="div_id" class="thumbnail" name="rid" value="<?php echo $rid; ?>" />
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
                <h4 class="modal-title">报销单将提交至</h4>
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
                  $(document).ready(function() {
                      $('#modal_next').find('input[type="submit"]').click(function(event) {
                          if ($('#modal_next').find('#modal_managers').val() != null) {
                            return true;
                          } else {
                            show_notify("请选择审批人");
                            return false;
                          }
                      });
                  });
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
                <div class="btn btn-primary repass" onClick="chose_others_audit(this.parentNode.parentNode.rid.value)">继续选择</div>
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="finance_modal_next">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('bills/report_finance_end'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">报销单将提交至</h4>
                <input type="hidden" name="rid" value="<?php echo $rid;?>" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
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
                <input type="submit" class="btn btn-primary" id="mypass" value="确认" />
               <!-- <div class="btn btn-primary" onclick="deny_report()">拒绝</div> -->
                <div class="btn btn-primary" onclick="cancel_modal_next(1)">取消</div>
            </div>
                </form>
                <script type="text/javascript">
                  function cancel_modal_next(id) {
                    if(id == 1)
                    {
                        $('#finance_modal_next').modal('hide');
                    }
                    if(id == 0)
                    {
                        $('#finance_modal_next_').modal('hide');
                    }
                    return;
                  }

                </script>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="finance_modal_next_">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('bills/report_finance_end'); ?>" method="post" class="form-horizontal" id="permit_form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <input type="hidden" name="rid" value="<?php echo $rid;?>" id="rid_">
                <input type="hidden" name="status" value="2" id_="status">
                <h4 class="modal-title">是否结束</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                        <select style="display:none;" class="chosen-select_ tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;">
                        </select>
                        <h4 class="modal-title">是否结束这条报销单?</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="pass" name="pass" value="0">
                <input type="submit" class="btn btn-primary pass" value="确认结束">
              <!--  <div class="btn btn-primary" onclick="deny_end_report()">拒绝</div> -->
                <div class="btn btn-primary" onclick="cancel_modal_next(0)">取消</div>
                <!--<div class="btn btn-primary repass" onClick="chose_others(this.parentNode.parentNode.rid.value)">取消</div> -->
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="finance_comment_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">退回理由</h4>
            </div>
            <form action="<?php echo base_url('/bills/report_finance_deny'); ?>" method="post" id="form_discard">
                <div class="modal-body">
                    <input type="hidden" id="div_id" class="thumbnail" name="rid" style="display:none;" value="<?php echo $rid;?>"/>
                    <input type="hidden" id="status"  name="status" style="display:none;" value="3" />
                    <div class="form-group">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <a class="btn btn-white btn-primary finance_deny"  data-renew="0"><i class="ace-icon fa fa-save "></i>退回</a>
                            <a style="margin-left: 80px;" class="btn btn-white" data-renew="-1" data-dismiss="modal"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="/static/js/base.js" ></script>
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
    $('.finance_deny').click(function(){
        $('#form_discard','#finance_comment_dialog').submit();
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

    $('.confirm_success').click(function(){
       if(confirm('确认已经收款?')){
                $.ajax({
                    url:__BASE + "/reports/confirm_success",
                    method:'post',
                    dataType:'json',
                    data:{'rid':rid},
                    success:function(data){
                        location.href = __BASE + "/reports";
                    },
                    error:function(a,b,c){

                    }
                });
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
                        var getData = data['data'].suggestion;
                        if (data['data'].complete == 0) {
                            $('#rid').val(_id);
                            chose_others_zero_audit(getData);
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
            $('#comment_dialog').modal('show');
        });
    });

    $('.tapprove').each(function(){
        $(this).click(function(){
            var _id = rid;
            $.ajax({
                type:"GET",
                url:__BASE + "bills/report_finance_permission/" + _id,
                data: {
                    rid:_id
                },
                dataType: "json",
                success: function(data){
                    if (data['status'] > 0) {
                        if (data['data'].complete == 0) {
                            chose_others_zero(_id,data['data'].suggestion);
                        } else {
                            $('#finance_modal_next_').modal('show');
                        }
                    }
                }
            });
        });
    });
    $('.finance_tdeny').each(function() {
        $(this).click(function(){
            $('#finance_comment_dialog').modal('show');
        });
    });

    function chose_others_zero(item,suggestion) {
        $("#finance_modal_next").find('#modal_managers').val(suggestion).trigger("chosen:updated");
        $('#finance_modal_next').modal('show');
    }

    function chose_others(_id) {
        $('#finance_modal_next_').modal('hide');
        $('#finance_modal_next').modal('show');
    }

});

function chose_others_zero_audit(item) {
    $('#modal_next').find('.chosen-select').val(item).trigger("chosen:updated");
    $('#modal_next').modal('show');
}
function chose_others_audit(_id) {
    $('#modal_next_').modal('hide');
    $('#rid').val(_id);
    $('#modal_next').modal('show');
}
</script>