<script src="/static/ace/js/fuelux/fuelux.tree.min.js"></script>



<div class="page-content">
<div class="page-content-area">
<div class="row">
<div class="col-xs-3">
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title default">组织架构</h3></div>
        <div class="panel-body">
            <div id="grouptree" class="tree"></div>
        </div>
    </div>
</div>
<div class="col-xs-9">
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
                    <th>身份</th>
                    <th>操作</th>
                </tr>
<?php 
foreach($members as $m){
?>
<tr>
    <td>
        <a href="/members/editmember/<?php echo $m['id']; ?>"> <?php echo $m['nickname']; ?> </a>
    </td>
    <td>
        <?php echo $m['email']; ?>
    </td>
    <td>

        <?php echo $m['phone']; ?>
    </td>
    <td>
<?php 
        $desc = '员工';
        $color = '<span class="label label-info arrowed">员工</span>';
    if($m['admin'] == 1){
        $desc = '管理员';
        $color = '<span class="label label-success arrowed">管理员</span>';
    }
?>
<a href="javascript:void(0)" title="<?php echo $desc; ?>" data-id="<?php echo $m['id']; ?>" ><?php echo $color; ?></a>
    </td>
    <td>
<a href="/members/editmember/<?php echo $m['id']; ?>"><i  style="margin-left:10px;" alt="<?php echo $desc; ?>" class="ace-icon align-top bigger-125 fa fa-pencil"></i></a>
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


var ___GID = -2;
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

function build_invite(data){
    var _member = data;
    $('#gname').html('已邀请人员');
    $('#gtable').html("");

    var _th = '<tr>'
        + '<th>名称</th>'
        + '<th>邀请日期</th>'
        + '<th>状态</th>'
        + '</tr>';
    $(_th).appendTo($('#gtable'));

    $(_member).each(function(idx, item){
        var _c = 'gray';
        var _p = '未决定';
        //var _p = '已加入';
        if(item['actived'] == 1){
            _p = '已拒绝';
        }
        if(item['actived'] == 2){
            _p = '已加入';
        }


        _th = '<tr>'
            + '<td>' + item.name + '</td>'
            + '<td>' + item.invitedt+ '</td>'
            + '<td>' + _p + '</td>'
            + '</tr>';
        $(_th).appendTo($('#gtable'));

    });
}


function load_group(gid){
    if(gid == undefined) gid = -2;
    if(gid != 0) {
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
                    //show_notify('获取信息成功');
                    if(gid == -1){
                        build_invite(data.data);
                        return;
                    }
                    if(gid == -2){
                        var _gname = '全体员工';
                        var _member = data.data;
                    } else {
                        data = data.data;
                        var _group = data.group;
                        var _member = data.member;
                        var _gname = _group.name;
                    }
                    $('#gname').html(_gname);
                    $('#gtable').html("");

                var _th = '<tr>'
                    + '<th>昵称</th>'
                    + '<th>邮箱</th>'
                    + '<th>手机</th>'
                    + '<th>身份</th>'
                    + '<th>操作</th>'
                    + '</tr>';
                    $(_th).appendTo($('#gtable'));

                    $(_member).each(function(idx, item){
                        var _c = 'gray';
                        var _p = '员工';
                        var _color = '<span class="label label-success arrowed">管理员</span>';
                    switch(item.admin) {
                    case '0' : {
                        _p = '点击设置为管理员'; 
                            var _color = '<span class="label label-success arrowed">管理员</span>';
                    }; break;
                    case '1' : {
                        var _color = '<span class="label label-info arrowed">员工</span>';
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
                    }
                _th = '<tr>'
                    + '<td><a href="' + __BASE + '/members/editmember/' + item.id + '">' + item.nickname+ '</a></td>'
                    + '<td>' + item.email + '</td>'
                    + '<td>' + item.phone + '</td>'
                    + '<td><a href="javascript:void(0)">' + _color + '</a>'
                    + '<td><a href="' + __BASE + '/members/editmember/' + item.id + '"><i class="ace-icon align-top bigger-125 fa fa-pencil " style="margin-left:10px;" ></i></a></td>'
                    + '</tr>';
                    $(_th).appendTo($('#gtable'));

                    });
                }
            }
            });
}
$(document).ready(function(){
    $.ajax({
        url: __BASE + "/members/listtreegroup",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var _data = Array();
                var _root = Array();
                $(data).each(function(idx, val){
                    //_key = 'item' + idx;
                    //_data[_key] = {name : val.name, type : 'item', additionalParameters : {id : val.id}};
                    // $(_data).push({name : val.name, type : 'item', additionalParameters : {id : val.id}});
                    _data.push({name : val.name, type : 'item', additionalParameters : {id : val.id}});

                });
                console.log(_data);
                //_root = {'root' : {name : '全体员工', 'type' : 'folder', 'additionalParameters' : {id : -2, children : _data}}};
                //console.log(_root);
                //var treeDataSource = new DataSource({data : _root});
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
