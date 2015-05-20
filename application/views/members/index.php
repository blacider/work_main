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
    <!--
    <table id="grid-table"></table>
    -->
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title default" id="gname">人员信息</h3></div>
        <div class="panel-body">
            <table class="table" id="gtable">
                <tr>
                    <th>昵称</th>
                    <th>邮箱</th>
                    <th>手机</th>
                    <th>银行卡</th>
                    <th>权限</th>
                </tr>
<?php 
foreach($members as $m){
?>
<tr>
    <td>
        <?php echo $m['nickname']; ?>
    </td>
    <td>
        <?php echo $m['email']; ?>
    </td>
    <td>

        <?php echo $m['phone']; ?>
    </td>
    <td>

        <?php echo $m['credit_card']; ?>
    </td>
    <td>
<?php 
    if($m['admin'] == 1){
        echo '管理员';
    } else {
        echo '员工';
    }
?>
    </td>
</tr>
<?php 
}
?>
            </table>
        </div>
    </div>


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


var ___GID = 0;
function update_admin(_admin, uid){
    $.ajax({
        url: __BASE + "/members/setadmin/" + uid + "/" + _admin,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                    show_notify('设置用户信息成功');
                    load_group();
            },
                error: function(data) {
                    show_notify('设置用户信息失败');
                }
    });
}


function load_group(gid){
    if(gid > 0) {
        ___GID = gid;
    } else { 
        gid = ___GID;
    }
    $.ajax({
        url: __BASE + "/members/singlegroup/" + gid,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(!data.status) {
                    show_notify('获取信息失败');
                } else {
                    show_notify('获取信息成功');
                    data = data.data;
                    var _group = data.group;
                    var _member = data.member;
                    $('#gname').html(_group.name);
                    $('#gtable').html("");
                    console.log(_member);

                var _th = '<tr>'
                    + '<th>昵称</th>'
                    + '<th>邮箱</th>'
                    + '<th>手机</th>'
                    + '<th>银行卡</th>'
                    + '<th>权限</th>'
                    + '</tr>';
                    $(_th).appendTo($('#gtable'));

                    $(_member).each(function(idx, item){
                        var _c = 'gray';
                        var _p = '员工';
                    switch(item.admin) {
                    case '0' : {
                        _p = '点击设置为管理员'; 
                    }; break;
                    case '1' : {
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
                    }
                _th = '<tr>'
                    + '<td><a href="' + __BASE + '/members/editmember/' + item.id + '">' + item.nickname+ '</a></td>'
                    + '<td>' + item.email + '</td>'
                    + '<td>' + item.phone + '</td>'
                    + '<td>' + item.credit_card+ '</td>'
                    + '<td><a href="javascript:void(0)" alt="' + _p + '" data-id="' + item.id + '" onclick="update_admin(' + item.admin + ', '+ item.id +')"><i alt="' + _p + '" class="ace-icon align-top bigger-125 fa fa-user ' + _c + '"></i></td>'
                    + '</tr>';
                    $(_th).appendTo($('#gtable'));

                    });
                }
            }
            });
}
$(document).ready(function(){
    $.ajax({
        url: __BASE + "/members/listgroup",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
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
                        var _gid  =  _data.additionalParameters.id;
                        load_group(_gid);
                    })
                    .on('unselected', function(e) { })
                    .on('opened', function(e) { })
                    .on('closed', function(e) { });

            }
    });
});
</script>
