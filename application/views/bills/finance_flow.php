<script src="/static/ace/js/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />


<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script src="/static/js/jqgrid_choseall.js"></script>
<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
 .chosen-container  {
  min-width: 400px;
  width: 400px;
}
    #searchBox {
position: absolute;
  right: 20px;
  top: 58px;
  z-index: 3;
  height: 30px;
  width: 12%;
  z-index: 9;
  width: 220px;
  background: #EFF4F9;
    }
    #searchBox input {
      height: 31px;
      line-height: 30px;
      padding: 0 4px;
      position: relative;
      top: 2px;
    }
    #globalSearch {
  background-color: #fe575f;
  border: 0;
  color: white;
  height: 30px;
  border-radius: 3px;
  font-size: 12px;
  z-index: 9999
   }
   #globalSearch:hover {
    background-color: #ff7075;
   }



  #userGroup{
  position: absolute;
  left: 460px;
  top: 60px;
  z-index: 2;
  height: 15px;
  min-width: 120px;
  width: 120px !important;
  white-space: nowrap;
    }
    #userGroupLab {
  background-color: #fe575f;
  position: absolute;
  left: 58%;
  top: 60px;
  border: 0;
  color: white;
  height: 30px;
  border-radius: 3px;
  font-size: 12px;
   }
   #userGroupLab:hover {
    background-color: #ff7075;
   }
   #dataSelect, #dataSelect_  {
    position: absolute;
    left: 580px;
    z-index: 2;
    top: 60px;
    width: 292px;
    height: 30px;
    padding: 1px;
    font-size: 0px !important;
    background: #DADADA;
   }
   #dataSelect.hidden-button {
    width: 262px;
   }
   #dataSelect.hidden-button  button{
      display: none;
   }
   #dataSelect span, #dataSelect_  span {
    font-size: 12px;
    margin: 0 2px;
    color: rgb(127, 140, 141);
   }
   #dataSelect button, #dataSelect_  button {
    border-radius: 2px;
    font-size: 10px;
      border: none;
      line-height: 28px;
      outline: none;
      padding: 0 4px;
      float: right;
      background: #ff575b;
      color: #fff;
      position: relative;
   }
   #dataSelect button:hover, #dataSelect_  button:hover {
     background: #E63754 !important;
   }
   #dataSelect button[disabled], #dataSelect_  button[disabled],
   #dataSelect button[disabled]:hover, #dataSelect_ button[disabled]:hover {
    background: #B5B5B5 !important;
   }
   #dataSelect input,
   #dataSelect_ input {
    width: 120px;
    height: 28px;
   }
  #dataSelect_ {
    left: 876px;
   }
   .dropdown_{
    background-color: transparent !important;
    color: black !important;
   } <?php if ($status == 1) {?>
   #userGroup {
    left: 51%;
    }
    #dataSelect {
    left: 66%;
    }
    <?php }?>

    /*@media*/
    @media screen and (max-width: 990px) {
      #userGroup {
        left: 196px
      }
      #dataSelect {
        left: 318px;
      }
       #dataSelect_  {
          left: 618px;
       }
    }
    @media screen and (min-width: 990px) {
      #userGroup {
        left: 460px;
      }
      #dataSelect {
        left: 580px;
      }
       #dataSelect_  {
          left: 876;
       }
    }

</style>
<script type="text/javascript">
  <?php
    $search_gid = "";
    $search_text = "";
    $search_time1 = "提交时间";
    $search_time2 = "审批时间";


    echo ' var s = "' . $search . '";' ;
    if ($search != "") {
      $search_gid = explode('_',$search)[0];
      $search_time1 = explode('_',$search)[1];
      if ($status == 2) {
      $search_time2 = explode('_',$search)[2];
      $search_text = explode('_',$search)[3];
      } else {
        $search_time2 = explode('_',$search)[2];
        $search_text = explode('_',$search)[2];
      }
    }
  ?>


  jQuery(document).ready(function($) {
    var days = 30 *24* 3600* 1000;

    // init value from url
    var _keyword = "<?php echo $query['keyword'] ?>";
    var _dept = "<?php echo $query['dept'] ?>";
    var _submit_startdate = "<?php echo $query['submit_startdate'] ?>";
    var _submit_enddate = "<?php echo $query['submit_enddate'] ?>";
    var _approval_enddate = "<?php echo $query['approval_enddate'] ?>";
    var _approval_startdate = "<?php echo $query['approval_startdate'] ?>";

    if(_submit_startdate && _submit_enddate) {
      $('#dataSelect').find('button').attr('disabled', false)
    }
    if(_approval_startdate && _approval_enddate) {
      $('#dataSelect_').find('button').attr('disabled', false)
    }

    function format(date) {
      if(!(date instanceof Date)) {
        date = new Date(date);
      }
      return date.Format('yyyy-MM-dd');
    };
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
        useCurrent: false,
        format: 'YYYY-MM-DD',
        // linkField: "dt",
        linkFormat: "YYYY-MM-DD",
        sideBySide: true,
        pickDate: true,
        pickTime: false,
        // minDate: ,
        // maxDate: ,
        showToday: true,
        collapse: true,
        defaultDate: "",
        disabledDates: false,
        enabledDates: false,
        icons: {},
        useStrict: false,
        direction: "auto",
        sideBySide: false,
        daysOfWeekDisabled: false
    }).on('dp.change', function(e){
        var d = e.date.toDate();
        var d2 = $('#date-timepicker2').val();
        if(d>+new Date(d2)) {
          return $('#date-timepicker2').val(format(+d + days)).datetimepicker('update');
        }
        d = +d + days;
        if(!d2) {
          $('#date-timepicker2').val(format(d)).datetimepicker('update');
        } else {
          d2 = new Date(d2);
          if(+d2<d) {
            $('#date-timepicker2').val(format(d2)).datetimepicker('update');
          } else {
            $('#date-timepicker2').val(format(d)).datetimepicker('update');
          }
        }
        $(this).parent().find('button').attr('disabled', false);
    });
    $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
        useCurrent: false,
        format: 'YYYY-MM-DD',
        pickDate: true,
        pickTime: false,
    }).on('dp.change', function(e){
        var d = e.date.toDate();
        var d2 = $('#date-timepicker1').val();
        if(d<+new Date(d2)) {
          return $('#date-timepicker1').val(format(+d - days)).datetimepicker('update');
        }
        d = +d - days;
        if(!d2) {
          $('#date-timepicker1').val(format(d)).datetimepicker('update');
        } else {
          d2 = new Date(d2);
          if(+d2>d) {
            $('#date-timepicker1').val(format(d2)).datetimepicker('update');
          } else {
            $('#date-timepicker1').val(format(d)).datetimepicker('update');
          }
        }
        $(this).parent().find('button').attr('disabled', false);
    });
    $('#date-timepicker3').datetimepicker({
        language: 'zh-cn',
        useCurrent: false,
        format: 'YYYY-MM-DD',
        pickDate: true,
        pickTime: false,
    }).on('dp.change', function(e){
        var d = e.date.toDate();
        var d2 = $('#date-timepicker4').val();
        if(d>+new Date(d2)) {
          return $('#date-timepicker4').val(format(+d + days)).datetimepicker('update');
        }
        d = +d + days;
        if(!d2) {
          $('#date-timepicker4').val(format(d)).datetimepicker('update');
        } else {
          d2 = new Date(d2);
          if(+d2<d) {
            $('#date-timepicker4').val(format(d2)).datetimepicker('update');
          } else {
            $('#date-timepicker4').val(format(d)).datetimepicker('update');
          }
        }
        $(this).parent().find('button').attr('disabled', false);
    });

    $('#date-timepicker4').datetimepicker({
      language: 'zh-cn',
      useCurrent: false,
      format: 'YYYY-MM-DD',
      pickDate: true,
      pickTime: false,
    }).on('dp.change', function(e){
        var d = e.date.toDate();
        var d2 = $('#date-timepicker3').val();
        if(d<+new Date(d2)) {
          return $('#date-timepicker3').val(format(+d - days)).datetimepicker('update');
        }
        d = +d - days;
        if(!d2) {
          $('#date-timepicker3').val(format(d)).datetimepicker('update');
        } else {
          d2 = new Date(d2);
          if(+d2>d) {
            $('#date-timepicker3').val(format(d2)).datetimepicker('update');
          } else {
            $('#date-timepicker3').val(format(d)).datetimepicker('update');
          }
        }
        $(this).parent().find('button').attr('disabled', false);
    });

    $('#dataSelect, #dataSelect_').on('click', 'button', function function_name(e) {
      if($(e.currentTarget).parent().attr('id') == 'dataSelect_') {
        if($('#dataSelect').find('input').eq(0).val() === '' && $('#dataSelect').find('input').eq(1).val() ==='') {
          return show_notify('至少保留一个时间选项');
        }
      }

      if($(e.currentTarget).parent().attr('id') == 'dataSelect') {
        if($('#dataSelect_').length ==0 ) {
          return show_notify('至少保留一个时间选项');
        }
        if($('#dataSelect_').find('input').eq(0).val() === '' && $('#dataSelect_').find('input').eq(1).val() ==='') {
          return show_notify('至少保留一个时间选项');
        }
      }


      $(this).parent().find('input').val('');
      $(this).parent().find('button').attr('disabled', true);
    });

     $("#globalSearch").click(function () {
        // $dept, $start_date, $end_date, $search
        var keyword = $('#globalSearchText').val();
        var dept = $('select[name=gids]').val();
        var submit_startdate = $('#date-timepicker1').val();
        var submit_enddate = $('#date-timepicker2').val();
        var approval_startdate = $('#date-timepicker3').val();
        var approval_enddate = $('#date-timepicker4').val();

        var query = {
          keyword: keyword,
          dept: dept,
          submit_startdate: submit_startdate,
          submit_enddate: submit_enddate,
          approval_startdate: approval_startdate,
          approval_enddate: approval_enddate
        }
        if (__STATUS == 2) {
          window.location.href = "/bills/finance_done?" + $.param(query);
        } else {
          window.location.href = "/bills/finance_flow?" + $.param(query);
        }
    });
     $("#searchBox input").on('keyup', function (e) {
       if(e.keyCode===13) {
        $("#globalSearch").trigger('click')
       }
     })
    // init query string

});

Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
</script>

<!-- <label class="col-sm-2 control-label no-padding-right" id='userGroupLab'>适用范围</label> -->
<div class="col-xs-2 col-sm-2" id="userGroup">
  <select class="chosen-select tag-input-style" name="gids"  data-placeholder="请选择部门" placeholder="请选择部门">
    <option value='0'>公司</option>
    <?php
    foreach($usergroups as $g){
      if ($g['id'] != $query['dept']){
      ?>
      <option value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
      <?php
      } else {
        ?>
        <option selected value="<?php echo $g['id']; ?>"><?php echo $g['name']; ?></option>
        <?php
      }
    }
    ?>
  </select>
</div>
<?php if($status=='2') { ?>
<div class="col-sm-2 col-xs-2" id="dataSelect">
    <!-- <label>提交时间</label> -->
    <input type="text" id="date-timepicker1" placeholder="提交开始时间" title="提交开始时间" value="<?php echo $query['submit_startdate'];?>"/>
    <span>至</span>
    <input type="text" id="date-timepicker2" placeholder="提交结束时间" title="提交结束时间" value="<?php echo $query['submit_enddate'];?>"/>
    <button disabled  title="清除">清除</button>
</div>
<div class="col-sm-2 col-xs-2" id="dataSelect_">
    <!-- <label>提交时间</label> -->
   <input type="text" id="date-timepicker3" placeholder="审批开始时间" title="审批开始时间" value="<?php echo $query['approval_startdate'];?>"/>
    <span>至</span>
    <input type="text"id="date-timepicker4" placeholder="审批结束时间" title="审批结束时间" value="<?php echo $query['approval_enddate'];?>"/>
    <button disabled title="清除">清除</button>
</div>
<?php } ?>
<div id="searchBox" >
  <input name="key" placeholder="ID、报销单名或提交者" value="<?php echo $query['keyword'];?>" type='text' id="globalSearchText" />
  <button type="button" id="globalSearch">搜索</button>
</div>


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
            <form action="<?php echo base_url('/bills/report_finance_deny'); ?>" method="post" id="form_discard">
                <div class="modal-body">
                    <input type="hidden" id="div_id" class="thumbnail" name="rid" style="display:none;" value=""/>
                    <input type="hidden" id="status"  name="status" style="display:none;" value="3" />
                    <div class="form-group">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <a class="btn btn-white btn-primary new_card" data-renew="0"><i class="ace-icon fa fa-save "></i>退回</a>
                            <a style="margin-left: 80px;" class="btn btn-white " data-renew="-1" data-dismiss="modal"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
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
                <form action="<?php echo base_url('bills/report_finance_end'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">报销单将提交至:</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;" data-placeholder="请选择">
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
                <form action="<?php echo base_url('bills/report_finance_end'); ?>" method="post" class="form-horizontal" id="permit_form">
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
                <div class="btn btn-primary" onclick="cancel_modal_next_()">取消</div>
                <input type="submit" class="btn btn-primary pass" value="确认结束">
                <button type="button" style="display: none;" class="one btn btn-primary btn-pay">去支付</button>
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal-table-finish">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">结束以下报销单</h4>
      </div>
      <div class="modal-body">
        <table id="grid-table-finish"></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="exportExel()">下载汇总报表</button>
        <button type="button" class="btn btn-primary" onclick="finish()">确认结束</button>
        <button type="button" style="display: none;" class="btn btn-primary btn-pay">去支付</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-table1" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 导出报销单 </h4>
          </div>
         <div class="modal-body">
           <div class="container">
              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">请输入报销单发送的Email地址:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="email" name="email" class="form-control" value="<?php if(array_key_exists('email',$profile)){ echo $profile['email'];}?>"/>
                        <input type="hidden" id="report_id" name="report_id" />
                      </div>
                  </div>
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="button" id='send' class="btn btn-sm btn-primary" value="发送" />
         </div>
        </div>
  </div>
</div><!-- PAGE CONTENT ENDS -->



<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var __STATUS = "<?php echo $status; ?>";
<?php
    $config = '';
    if(array_key_exists('config', $profile['group'])){
        $config = $profile["group"]["config"];
    }
?>
var __CONFIG = '<?php echo $config; ?>';
if(__CONFIG!='')
{
	var config = JSON.parse(__CONFIG);
}
var error = "<?php echo $error; ?>";
</script>


<script language="javascript">
$(document).ready(function(){
    if(error) show_notify(error);

    $('.chosen-select').chosen({
        allow_single_deselect:true,
        width: 300,
        no_results_text: '无可用选项'
    })
    $('#modal_managers').change(function  (e) {
        if(!$(this).val()) {
          $('#mypass').attr('disabled', true);
        } else {
          $('#mypass').attr('disabled', false);
        }
    });
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    });

function finish() {
    var _id = chosenids.join('%23');
    location.href = __BASE + "bills/report_finance_multiEnd/" + _id;
}

function exportExel() {
        var form=$("<form>");//定义一个form表单
        form.attr("style","display:none");
        form.attr("target","");
        form.attr("method","post");
        form.attr("action", __BASE + "/reports/exports");
        var input1=$("<input>");
        input1.attr("type","hidden");
        input1.attr("name","ids");
        input1.attr("value", chosenids.join(','));
        $("body").append(form);//将表单放置在web中
        form.append(input1);
        form.submit();//表单提交
}

$grid = $('#grid-table');


$('#send').click(function(){
    $.ajax({
      url:__BASE+'reports/sendout'
      ,method:"post"
      ,dataType:"json"
      ,data:{report_id:$('#report_id').val(),email:$('#email').val()}
      ,success:function(data){
          if(data.status== 1) {
            $('#modal-table1').modal('hide')
            show_notify("pdf已经成功发送至您的邮箱");
          }
          else
          {
              if(data.data.msg != undefined) {
                show_notify(data.data.msg);
              }
              else {
                show_notify("输入邮箱错误");
              }
          }
      }
    });
});

$('.new_card').click(function(){
    $('#form_discard').submit();
});

function deny_report()
{
  var report_id = $('#rid').val();
  location.href = __BASE + 'bills/report_finance_deny/' + report_id;
}

function deny_end_report()
{
  var report_id = $('#rid_').val();
  alert(report_id);
  location.href = __BASE + 'bills/report_finance_deny/' + report_id;
}

function cancel_modal_next_()
{
  $('#modal_next_').modal('hide');
}

</script>
<script src="<?= static_url("/static/js/base.js") ?>" ></script>
<script src="<?= static_url("/static/js/finance_flow.js") ?>" ></script>


<script src="/static/js/mod/bills/finance.js"></script>

<script src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">

<script src="/static/plugins/cloud-layer/layer.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-layer/layer.css">
