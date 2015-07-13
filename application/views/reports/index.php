<style type="text/css">
    #globalSearchText{
position: absolute;
  left: 75%;
  top: 60px;
  z-index: 2;
  height: 26px;
  width: 150px;
  border-style: ridge;
    }
    #globalSearch {
  background-color: #fe575f;
  position: absolute;
  left: 1130px;
  top: 60px;
  border: 0;
  color: white;
  height: 25px;
  border-radius: 3px;   
  font-size: 12px;
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
    </div>
</div>






<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";


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
</script>
