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

<input name="key" placeholder="ID、报告名或提交者" value="" type='text' id="globalSearchText" />
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


<div class="modal fade" id="modal-table">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">支付以下报告</h4>
      </div>
      <div class="modal-body">
        <table id="grid-table-new"></table> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="exportExel()">下载汇总报表</button>
        <button type="button" class="btn btn-primary" onclick="pay()">确认已支付</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-table1" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 导出报告 </h4>
          </div>
         <div class="modal-body">
           <div class="container">
              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">请输入报告发送的email地址:</label>
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
</script>


<script language="javascript">
function pay() {
    var _id = chosenids.join('%23');
    location.href = __BASE + "bills/marksuccess/" + _id + "/0";
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

$("#globalSearch").click(function () {
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
});


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

</script>
<script language="javascript" src="/static/js/base.js" ></script>
<script language="javascript" src="/static/js/bills.js" ></script>
