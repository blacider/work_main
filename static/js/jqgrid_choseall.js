//获取当前显示的表格的所有数据,
// grid 为文本型
// 返回 ids 数组
function jqgrid_choseall_plus(grid) {
	var $grid = $(grid);
	var page = $grid.getGridParam('page');
	var result = new Array();
	for (var i = 1; i <= $grid.getGridParam('lastpage');i++) {
		$grid.trigger("reloadGrid", [{page: i}]);
		result = result.concat($grid.getDataIDs());
	}
	$grid.trigger("reloadGrid", [{page: page}]);
	return result;
}