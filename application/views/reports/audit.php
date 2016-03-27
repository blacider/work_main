<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<style>
    .chosen-container  {
        min-width: 400px;
        width: 400px;
    }
</style>
<style type="text/css">
    #globalSearchText{
position: absolute;
  left: 75%;
  top: 60px;
  z-index: 2;
  height: 26px;
  width: 12%;
  border-style: ridge;
    }
    #globalSearch {
  background-color: #fe575f;
  position: absolute;
  left: 88%;
  top: 60px;
  border: 0;
  color: white;
  height: 25px;
  border-radius: 3px;
  font-size: 12px;
   }
   #globalSearch:hover {
    background-color: #ff7075;
   }
</style>
    <input name="key" placeholder="ID、标题或发起人" value="<?php echo $search;?>" type='text' id="globalSearchText">
    <button type="button" id="globalSearch">搜索</button>
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
                <table id="grid-table"></table>
                <div id="grid-pager"></div>
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
                <h4 class="modal-title">报销单将提交至以下审批人，请确认</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;">
                            <?php foreach($members as $m) {
                              if($m['id'] != $profile['id'])
                              {
                              ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
                            <?php }} ?>
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
                <div class="btn btn-primary repass" onClick="chose_others(this.parentNode.parentNode.rid.value)">继续选择</div>
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="modal-table" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 导出报销单 </h4>
          </div>
          <form method="post" >
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-sm-12">


                  <div class="form-group">
                    <label for="form-field-username">请输入报销单发送的Email地址:</label>
                    <div>
                      <input class=" col-xs-8 col-sm-8" type="text" id="email" name="email" class="form-control" value="<?php if(array_key_exists('email',$profile)){ echo $profile['email'];}?>">
                      <input type="hidden" id="report_id" name="report_id">
                    </div>

                  </div>
                  <div class="space-4"></div>
                <br>
                <br>
                <br>
                <br>

                </div>
              </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                  <i class="ace-icon fa fa-times"></i>
                  取消
                </button>
                <input type="button" id='send' class="btn btn-sm btn-primary" value="发送">
              </div>
            </form>
          </div>
        </div>
      </div><!-- PAGE CONTENT ENDS -->

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


<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>


<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var close_directly = "<?php echo $close_directly; ?>";
$(document).ready(function(){
    $("#permit_form .pass").click(function(event) {
      return true;
    });
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

<script src="/static/js/base.js" ></script>
<script type="text/javascript">
$grid = $('#grid-table');
$("#globalSearch").click(function () {
    if ("<?php echo $search;?>" != $("#globalSearchText").val()) {
        window.location.href = "/"+window.location.href.split('/')[3]+"/"+"audit_<?php echo $filter; ?>"+"/"+$("#globalSearchText").val();
    }
});
function doSearch() {
    var rules = [], i, cm, postData = $grid.jqGrid("getGridParam", "postData"),
        colModel = $grid.jqGrid("getGridParam", "colModel"),
        searchText = $("#globalSearchText").val(),
        l = colModel.length;
    for (i = 0; i < l; i++) {
        cm = colModel[i];
        if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
            rules.push({
                field: cm.name,
                op: "cn",
                data: searchText
            });
        }
    }
    postData.filters = JSON.stringify({
        groupOp: "OR",
        rules: rules
    });
    $grid.jqGrid("setGridParam", { search: true });
    $grid.trigger("reloadGrid", [{page: 1, current: true}]);
    return false;
}

function isEmail( str ){
    var myReg = /^[-\._A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
    if(myReg.test(str)) return true;
    return false;
}
$('#send').click(function(){
    if ($('#email').val() == '' || !isEmail($('#email').val())) {
      show_notify("输入邮箱错误");
      return;
    }
    $.ajax({
      url:__BASE+'reports/sendout'
      ,method:"post"
      ,dataType:"json"
      ,data:{report_id:$('#report_id').val(),email:$('#email').val()}
      ,success:function(data){
          if(data.status== 1)
          {
            $('#modal-table').modal('hide')
            show_notify("pdf已经成功发送至您的邮箱");
          }
          else
          {
              if(data.data.msg != undefined)
              {
                show_notify(data.data.msg);
              }
              else
              {
                show_notify("输入邮箱错误");
              }
          }
      }
    });

});
</script>

<script>
var error = "<?php echo $error; ?>";
if(error) show_notify(error);
var filter = "<?=$filter?>";
var can_export_excel = <?=$can_export_excel?>;
</script>

<script type="text/javascript" src="/static/js/jqgrid_choseall.js"></script>
<script src="/static/js/audit.js" ></script>

