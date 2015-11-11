 <script src="/static/ace/js/chosen.jquery.min.js"></script>
 <link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />


<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/colorbox.css" />
<script type="text/javascript" src="/static/js/jqgrid_choseall.js"></script>
<script src="/static/ace/js/date-time/moment.js"></script>
<!--
<script src="/static/ace/js/date-time/locale/zh-cn.js"></script>
-->

<script src="/static/ace/js/jquery.colorbox-min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>

 <style type="text/css">
    #globalSearchText{
position: absolute;
  left: 80%;
  top: 60px;
  z-index: 3;
  height: 30px;
  width: 12%;
  border-style: ridge;
    }
    #globalSearch {
  background-color: #fe575f;
  position: absolute;
  left: 93%;
  top: 60px;
  border: 0;
  color: white;
  height: 30px;
  border-radius: 3px;   
  font-size: 12px;
   }
   #globalSearch:hover {
    background-color: #ff7075;
   }



  #userGroup{
  position: absolute;
  left: 34%;
  top: 60px;
  z-index: 2;
  height: 15px;
  
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
   #dataSelect {
    position: absolute;
    left: 52.6%;
    z-index: 2;
    top: 55px;
   }
  #dataSelect_ {
    position: absolute;
    left: 63.3%;
    z-index: 3;
    top: 55px;
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
</style>
<script type="text/javascript">
  function changeDropText(str) {
    $('#dropText').text(str);
    return false;
  }
  function getDropText() {
    return $('#dropText').text();
  }
  function changeDropText2(str) {
    $('#dropText2').text(str);
    return false;
  }
  function getDropText2() {
    return $('#dropText2').text();
  }
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
    $('#time-submit').click(function(event) {
        var dateTime1 = $('#date-timepicker1').val();
        var dateTime2 = $('#date-timepicker2').val();
        if(dateTime1 == '' || dateTime2 == '')
        {
                show_notify('请填写时间');
                return false;
        }
        if (dateTime2 < dateTime1) {
          show_notify('请填写正确时间');
          return false;
        }
        $("#dropText").text(dateTime1+ "至" +dateTime2);
        $('#modal-table-time').modal('hide');
    });
    $('#time-submit2').click(function(event) {
        var dateTime1 = $('#date-timepicker3').val();
        var dateTime2 = $('#date-timepicker4').val();
        if(dateTime1 == '' || dateTime2 == '')
        {
                show_notify('请填写时间');
                return false;
        }
        if (dateTime2 < dateTime1) {
          show_notify('请填写正确时间');
          return false;
        }
        $("#dropText2").text(dateTime1+ "至" +dateTime2);
        $('#modal-table-time2').modal('hide');
    });
    $('#date-timepicker1').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

        $('#date-timepicker2').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD',
            linkField: "dt_end",
            linkFormat: "YYYY-MM-DD",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#date-timepicker3').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD',
            linkField: "dt",
            linkFormat: "YYYY-MM-DD",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });

        $('#date-timepicker4').datetimepicker({
        language: 'zh-cn',
            useCurrent: true,
            format: 'YYYY-MM-DD',
            linkField: "dt_end",
            linkFormat: "YYYY-MM-DD",
            sideBySide: true
    }).next().on('dp.change', function(ev){
    }).on(ace.click_event, function(){
        $(this).prev().focus();
    });
     $("#globalSearch").click(function () {
      if ("<?php echo $search_text;?>" != $("#globalSearchText").val() || "<?php echo $search_time1;?>" != $("#dropText").text()||"<?php echo $search_time2;?>" != $("#dropText2").text()|| "<?php echo $search_gid;?>" != $('select[name="gids"]').val()) {
        var text = $("#globalSearchText").val();
        var groupsId = $('select[name="gids"]').val();
        var time = $('#dropText').text().replace(" ","");
        var time2 = $('#dropText2').text().replace(" ","");
        if (__STATUS == 2) {
          window.location.href = "/bills/"+window.location.href.split('/')[4]+"/"+groupsId+"_"+time+"_"+time2+"_"+text;
        } else {
          window.location.href = "/bills/"+window.location.href.split('/')[4]+"/"+groupsId+"_"+time+"_"+text;
        }
      }
  });
     var _dt = new Date().Format('yyyy-MM-dd hh:mm:ss');
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
<div id="modal-table-time" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 选择时间段 </h4>
          </div>
         <div class="modal-body">
           <div class="container">
              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <input id="date-timepicker1" name = 'dt' type="text" class="form-control"/>
                    </div>
                    <label class="col-sm-1">至</label>
                    <div class="col-sm-4">
                      <input id="date-timepicker2" type="text" name = 'dt_end' class="form-control"/>
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
           <div type="button" id='time-submit' class="btn btn-sm btn-primary">确定</div>
         </div>
        </div>
  </div>
</div><!-- PAGE CONTENT ENDS -->

<div id="modal-table-time2" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 选择时间段 </h4>
          </div>
         <div class="modal-body">
           <div class="container">
              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <input id="date-timepicker3" name = 'dt' type="text" class="form-control"/>
                    </div>
                    <label class="col-sm-1">至</label>
                    <div class="col-sm-4">
                      <input id="date-timepicker4" type="text" name = 'dt_end' class="form-control"/>
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
           <div type="button" id='time-submit2' class="btn btn-sm btn-primary">确定</div>
         </div>
        </div>
  </div>
</div><!-- PAGE CONTENT ENDS -->


<!-- <label class="col-sm-2 control-label no-padding-right" id='userGroupLab'>适用范围</label> -->
<div class="col-xs-2 col-sm-2" id="userGroup">
  <select class="chosen-select tag-input-style "  name="gids"  data-placeholder="请选择部门" placeholder="请选择部门">
    <option value='0'>公司</option>
    <?php 
    foreach($usergroups as $g){
      if ($g['id'] != $search_gid){
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
<input name="key" placeholder="ID、报销单名或提交者" value="<?php echo $search_text;?>" type='text' id="globalSearchText" />
<div class="col-sm-2 col-xs-2" id="dataSelect">
  <ul class="nav nav-pills">
    <li class="dropdown all-camera-dropdown active">
           <a class="dropdown-toggle dropdown_" data-toggle="dropdown" href="javascript:void(0);">
           <span id='dropText'><?php echo $search_time1;?></span>
              <b class="caret"></b>
           </a>
    <ul class="dropdown-menu">
            <li data-filter-camera-type="all"><a data-toggle="tab" onclick="changeDropText('提交时间')" href="#">所有时间</a></li>
            <li data-filter-camera-type="Alpha"><a data-toggle="tab" href="#" onclick="changeDropText('一个月内')">一个月内</a></li>
            <li data-filter-camera-type="Zed"><a data-toggle="tab" href="#" onclick="changeDropText('一年内')">一年内</a></li>
            <li class="divider"></li>
            <li data-filter-camera-type="Bravo"><a data-toggle="tab" onclick="$('#modal-table-time').modal('show');return false;" href="#">自定义时间</a></li>

     </ul>
    </li>
  </ul>
</div>

<div class="col-sm-2 col-xs-2" id="dataSelect_" <?php if($status == 1) echo "style='display:none'";?>>
  <ul class="nav nav-pills">
    <li class="dropdown all-camera-dropdown active">
           <a class="dropdown-toggle dropdown_" data-toggle="dropdown" href="javascript:void(0);">
           <span id='dropText2'><?php 
           if ($search_time2 == "所有时间") {
            echo "审批时间";
           } else {
            echo $search_time2;
           }
           ?></span>
              <b class="caret"></b>
           </a>
    <ul class="dropdown-menu">
            <li data-filter-camera-type="all"><a data-toggle="tab" onclick="changeDropText2('审批时间')" href="#">所有时间</a></li>
            <li data-filter-camera-type="Alpha"><a data-toggle="tab" href="#" onclick="changeDropText2('一个月内')">一个月内</a></li>
            <li data-filter-camera-type="Zed"><a data-toggle="tab" href="#" onclick="changeDropText2('一年内')">一年内</a></li>
            <li class="divider"></li>
            <li data-filter-camera-type="Bravo"><a data-toggle="tab" onclick="$('#modal-table-time2').modal('show');return false;" href="#">自定义时间</a></li>

     </ul>
    </li>
  </ul>
</div>
<button type="button" id="globalSearch" >搜索</button>


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
                <form action="<?php echo base_url('bills/report_finance_end'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">报销单将发送至以下审批人，请确认</h4>
                <input type="hidden" name="rid" value="" id="rid">
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
                <input type="submit" class="btn btn-primary pass" value="确认结束">
              <!--  <div class="btn btn-primary" onclick="deny_end_report()">拒绝</div> -->
                <div class="btn btn-primary" onclick="cancel_modal_next_()">取消</div>
                <!--<div class="btn btn-primary repass" onClick="chose_others(this.parentNode.parentNode.rid.value)">取消</div> -->
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
                        <input class="col-xs-4 col-sm-4" type="text" id="email" name="email" class="form-control" />
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

    $('.chosen-select').chosen({allow_single_deselect:true}); 
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

  function doSearch() {
    var rules = [], i, cm, postData = $grid.jqGrid("getGridParam", "postData"),
        colModel = $grid.jqGrid("getGridParam", "colModel"),
        searchText = $("#globalSearchText").val(),
        l = colModel.length;
    var groupId = $('select[name="gids"]').val();
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
    var search_time = "<?php echo $search_time1?>";
    var search_time2 = "<?php echo $search_time2?>";
    var time_groups = [{
        groupOp:"AND",
        rules:[],
        groups:[{
          groupOp: "OR",
          rules: rules ,
          groups:[]
        }]
      }];
      var time_groups2 = [{
        groupOp:"AND",
        rules:[],
        groups:time_groups
      }];
      var startTime = new Date();
      var endTime = new Date();
      var startTime2 = new Date();
      var endTime2 = new Date();
    if (search_time != "提交时间") {
      switch(search_time) {
        case "一个月内":
          endTime = endTime.Format('yyyy-MM-dd');
          startTime.setMonth(startTime.getMonth()-1);
          startTime = startTime.Format('yyyy-MM-dd');
          break;
        case "一年内":
          endTime = endTime.Format('yyyy-MM-dd');
          startTime.setYear(startTime.getYear()-1);
          startTime = startTime.Format('yyyy-MM-dd');
          break;
        default:
          endTime = search_time.split('至')[1];
          startTime = search_time.split('至')[0];
      }
      startTime += " 00:00:00";
      endTime += " 24:60:60";
      
      time_groups = [{
        groupOp:"AND",
        rules:[{field:"date_str",op:"ge",data:startTime},{field:"date_str",op:"le",data:endTime}],
        groups:[{
          groupOp: "OR",
          rules: rules ,
          groups:[]
        }]
      }];
      time_groups2 = [{
        groupOp:"AND",
        rules:[],
        groups:time_groups
      }];
    }
    if (search_time2 != "审批时间") {
      switch(search_time2) {
        case "一个月内":
          endTime2 = endTime2.Format('yyyy-MM-dd');
          startTime2.setMonth(startTime2.getMonth()-1);
          startTime2 = startTime2.Format('yyyy-MM-dd');
          break;
        case "一年内":
          endTime2 = endTime2.Format('yyyy-MM-dd');
          startTime2.setYear(startTime2.getYear()-1);
          startTime2 = startTime2.Format('yyyy-MM-dd');
          break;
        default:
          endTime2 = search_time2.split('至')[1];
          startTime2 = search_time2.split('至')[0];
      }
      startTime2 += " 00:00:00";
      endTime2 += " 24:60:60";
      
      time_groups2 = [{
        groupOp:"AND",
        rules:[{field:"approvaldt_str",op:"ge",data:startTime2},{field:"approvaldt_str",op:"le",data:endTime2}],
        groups:time_groups
      }];
    }
    var groups_ = [{
      groupOp:"AND",
      rules:[{field:"ugs",op:"cn",data:groupId}],
      groups:((__STATUS == 2)?(time_groups2):(time_groups))
    }];
    if (groupId == 0) {
      groups_ = groups_[0].groups;
    }
    //postData.filters = JSON.stringify({
    //    groupOp: "OR",
    //    rules: rules ,
    //    groups:groups_
    //});
    postData.filters = JSON.stringify(groups_[0]);
    $grid.jqGrid("setGridParam", { search: true });
    $grid.trigger("reloadGrid", [{page: 1}]);
    return false;
}
</script>
<script language="javascript" src="/static/js/base.js" ></script>
<script language="javascript" src="/static/js/finance_flow.js" ></script>
