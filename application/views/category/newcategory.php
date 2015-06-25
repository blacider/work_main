<script src="/static/ace/js/fuelux/fuelux.tree.min.js"></script>
<div class="widget-body">
  <div class="widget-main padding-8">
    <div id="tree2" class="tree"></div>
  </div>
</div>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";

//console.log(__BASE);
</script>
<script src="/static/js/base.js" ></script>
<script type="text/javascript">
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
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
        url: __BASE + "/category/gettreelist",
            method: 'GET',
            dataType: 'json',
            success: function(datas) {
                var _data = Array();
                var _root = Array();
                 var ace_icon = ace.vars['icon'];
                console.log(datas);

                treeDataSource2 = new DataSource({data:datas});
                $('#tree2').ace_tree({
                      dataSource: treeDataSource2 ,
                      loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
                      'open-icon' : 'ace-icon fa fa-folder-open',
                      'close-icon' : 'ace-icon fa fa-folder',
                      'selectable' : false,
                      'selected-icon' : null,
                      'unselected-icon' : null
                    });
          /* 
                */

            },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    },    });
});
</script>