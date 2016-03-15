//获取当前显示的表格的所有数据,
// grid 为文本型
// 返回 ids 数组

var oldFrom = $.jgrid.from,
    lastSelected;

$.jgrid.from = function (source, initalQuery) {
    var result = oldFrom.call(this, source, initalQuery),old_select = result.select;
    result.select = function (f) {
        lastSelected = old_select.call(this, f);
        return lastSelected;
    };
    return result;
};

function jqgrid_choseall_plus(grid) {
    var postData = $(grid).jqGrid("getGridParam", "postData");
    var rule = {
        groupOp:"OR",
        rules:[],
        groups:[]
    }
    postData.filters = JSON.stringify(rule);
    $(grid).jqGrid("setGridParam", { search: true });
    $(grid).trigger("reloadGrid", [{page: $(grid).getGridParam('page')}]);
    var result = new Array();
    var data = $(grid).jqGrid('getGridParam', 'lastSelected');
    for (var i = data.length - 1; i >= 0; i--) {
        result.push(data[i].id);
    };
    return result;
}