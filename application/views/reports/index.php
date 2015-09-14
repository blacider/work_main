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
<input name="key" placeholder="ID或标题" value="" type='text' id="globalSearchText">
<button type="button" id="globalSearch">搜索</button>
<div id="mysearch"></div>
<div class="page-content">
  <div class="page-content-area">
    <div class="row">
      <div class="col-xs-12">
        <table id="grid-table"></table>
        <div id="grid-pager"></div>
      </div>
    </div>



    <div id="modal-table" class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 导出报告 </h4>
          </div>
          <form method="post" >
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-sm-12">


                  <div class="form-group">
                    <label for="form-field-username">请输入报告发送的email地址:</label>
                    <div>
                      <input class=" col-xs-8 col-sm-8" type="text" id="email" name="email" class="form-control"></input>
                      <input type="hidden" id="report_id" name="report_id">
                    </div>
                    
                  </div>
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




    </div>
  </div>






  <!-- page specific plugin scripts -->
  <script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
  <script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>

  <script language="javascript">
    var __BASE = "<?php echo $base_url; ?>";
    var _error = "<?php echo $error; ?>";

    $(document).ready(function(){
        if(_error) show_notify(_error);
        //setTimeout(function(){$("#globalSearch").click();}, 1000);
    });

  </script>
  <script src="/static/js/base.js" ></script>
  <script src="/static/js/reports.js" ></script>

	<!--<script type="text/javascript">
$(function() {

	$('#mysearch').filterGrid('#grid-table',{
		enableSearch:true,
		filterModel:[
			{label: 'title', name: 'title', stype: 'text'}
		],
		buttonclass:'search-submit',
		tableclass:'search',
		autosearch:false,
		searchButton:'搜索'});
	$('#mysearch label').css('display','none')
	});

</script>-->
<script type="text/javascript">
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
          //console.log(data);
          //console.log(data.status);
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
