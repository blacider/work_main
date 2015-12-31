//获取当前显示的表格的所有数据,
// grid 为文本型
// 返回 ids 数组
function jqgrid_choseall_plus(grid) {
    var $grid = $(grid);
    var result = new Array();
    var data = jQuery(grid).jqGrid('getGridParam').data;
    for (var i = data.length - 1; i >= 0; i--) {
        result.push(data[i].id);
    };
    return result;
}