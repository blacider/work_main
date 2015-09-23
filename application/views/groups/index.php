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
    <input name="key" placeholder="部门" value="<?php echo $search;?>" type='text' id="globalSearchText">
    <button type="button" id="globalSearch">搜索</button>
<script language='javascript'>
    var _admin = "<?php echo $profile['admin']; ?>";
</script>
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



<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
</script>
<script src="/static/js/base.js" ></script>
<script src="/static/js/groups.js" ></script>
<script type="text/javascript">
	$grid = $('#grid-table');
$("#globalSearch").click(function () {
      if ("<?php echo $search;?>" != $("#globalSearchText").val()) {
        window.location.href = "/"+window.location.href.split('/')[3]+"/"+window.location.href.split('/')[4]+"/"+$("#globalSearchText").val();
      }
});
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
    var groups_ = [{
      groupOp:"AND",
      rules:[{field:"ugs",op:"cn",data:groupId}],
      groups:[{
        groupOp: "OR",
        rules: rules ,
        groups:[]
      }]
    }];
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