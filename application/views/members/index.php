<script src="/static/ace/js/fuelux/fuelux.tree.min.js"></script>



<div class="page-content">
<div class="page-content-area">
<div class="row">
<div class="col-xs-4">
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title default">组织架构</h3></div>
            <div class="panel-body">
<div id="grouptree" class="tree"></div>
                      </div>
                  </div>
</div>
<div class="col-xs-8">
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
<script src="/static/js/members.js" ></script>
<script language="javascript">
var DataSource = function (options) {
    this._formatter = options.formatter;
    this._columns = options.columns;
    this._data = options.data;
};
DataSource.prototype = {
    columns: function () {
        return this._columns;
    },

        data: function (options, callback) {

            var self = this;
            if (options.search) {
                callback({ data: self._data, start: start, end: end, count: count, pages: pages, page: page });
            } else if (options.data) {
                callback({ data: options.data, start: 0, end: 0, count: 0, pages: 0, page: 0 });
            } else {
                callback({ data: self._data, start: 0, end: 0, count: 0, pages: 0, page: 0 });
            }
        }
};
$(document).ready(function(){
    $.ajax({
        url: __BASE + "/members/listgroup",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                //data = eval("(" + data + ")");
                var _data = Array();
                $(data).each(function(idx, val){
                    _data.push({name : val.name, type : 'item', additionalParameters : {id : val.id}});
                });
                var treeDataSource = new DataSource({data : _data});
                $('#grouptree').ace_tree({
                    dataSource: treeDataSource ,
                        multiSelect:false,
                        loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
                        'open-icon' : 'ace-icon tree-minus',
                        'close-icon' : 'ace-icon tree-plus',
                        'selectable' : true,
                        'selected-icon' : 'ace-icon fa fa-check',
                        'unselected-icon' : 'ace-icon fa fa-times'
                });
                $('#grouptree').on('updated', function(e, result) {
                })
                    .on('selected', function(e, result) {
                        var _data = result.info[0];
                        console.log(_data);
                    })
                    .on('unselected', function(e) { })
                    .on('opened', function(e) { })
                    .on('closed', function(e) { });

            }
    });
    /*
    var treeDataSource = new DataSource({
        data: [
            { 
                name: 'Folder 1', type: 'folder', additionalParameters: { id: 'F1' },
                    data: [
            { name: 'Sub Folder 1', type: 'folder', additionalParameters: { id: 'FF1' } },
            { name: 'Sub Folder 2', 
            data: [
            {name: 'sub sub folder 1', type: 'folder', additionalParameters: { id: 'FF21' }},
            {name: 'sub sub item', type: 'item', additionalParameters: { id: 'FI2' }}
            ], 
            type: 'folder', additionalParameters: { id: 'FF2' }
            },
            { name: 'Item 2 in Folder 1', type: 'item', additionalParameters: { id: 'FI2' } }
            ]
            },
                    { name: 'Folder 2', type: 'folder', additionalParameters: { id: 'F2' } },
                    { name: 'Item 1', type: 'item', additionalParameters: { id: 'I1' } },
                    { name: 'Item 2', type: 'item', additionalParameters: { id: 'I2' } }
            ],
            delay: 400
    });

    $('#grouptree').ace_tree({
        dataSource: treeDataSource ,
        multiSelect:false,
        loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
        'open-icon' : 'ace-icon tree-minus',
        'close-icon' : 'ace-icon tree-plus',
        'selectable' : true,
        'selected-icon' : 'ace-icon fa fa-check',
        'unselected-icon' : 'ace-icon fa fa-times'
    });
     */ 




                        /**
                            $('#tree1').on('loaded', function (evt, data) {
                            });

                            $('#tree1').on('opened', function (evt, data) {
                            });

                            $('#tree1').on('closed', function (evt, data) {
                            });

                            $('#tree1').on('selected', function (evt, data) {
                            });
                         */
});
</script>
