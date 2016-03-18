<script src="/static/ace/js/fuelux/fuelux.tree.min.js"></script>
<script src="/static/js/util.js"></script>

<script language='javascript'>
    var _admin = "<?php echo $profile['admin']; ?>";
</script>

<style type="text/css">
    #search{
        position: absolute;
        left: 75%;
        top: 64px;
        z-index: 2;
        height: 26px;
        width: 12%;
        border-style: ridge;
    }
    #search-submit {
        background-color: #fe575f;
        position: absolute;
        left: 88%;
        top: 64px;
        z-index: 2;
        border: 0;
        color: white;
        height: 25px;
        border-radius: 3px;   
        font-size: 12px;
   }
   .tree .tree-folder, .tree .tree-item {
        white-space: nowrap !important;
        float: left;
        clear: both;
   }
   .tree .tree-folder-content::after {
        content: "";
        display: block;
        clear: both;
   }
   .tree {
        overflow-x: auto !important;
   }

    .col-1 {
        min-width: 78px;
    }
    .col-2 {
        min-width: 184px;
    }
    .col-3 {
        min-width: 210px;
    }
    .col-4 {
        min-width: 100px;
    }
    .col-5 {
        min-width: 162px;
    }
    .col-6 {
        min-width: 78px;
    }
    .col-7 {
        min-width: 78px;
    }
    .col-8 {
        min-width: 96px;
    }
    .col-9 {
        min-width: 78px;
    }
</style>
<script type="text/javascript">
    function searchSubmit(form) {
        if (form.key.value != '') return true;
        else {
            form.key.focus();
            return false;
        }
    }
</script>
<form action="<?php echo base_url('members/search') ?>" method="get" onsubmit="return searchSubmit(this)">
    <input name="key" placeholder="请输入搜索的内容" value="<?php echo $search ?>" type='text' id="search">
    <button type="submit" id="search-submit">搜索</button>
</form>
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
            <div class="col-sm-3" style="width: 210px;">
                <div class="widget-box widget-color-blue" style="margin-top: 0;border-top-left-radius: 3px;border-top-right-radius: 3px;">
                    <div class="widget-header" style="height: 38px;min-height: 38px;background: #428bca;">
                        <div id="admin_groups_granted" data-gids="<?php echo htmlspecialchars(json_encode($admin_groups_granted))?>"></div>
                        <h4 class="widget-title lighter smaller" style="font-size: 16px;">组织结构</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <div id="tree2" class="tree"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9" style="margin-left: 12px;">
                <div class="panel panel-primary" style="display: inline-block;">
                    <div class="panel-heading" style="padding: 10px 0 18px 0; height: 39px">
                        <h3 class="panel-title default col-sm-11 col-md-11" id="gname">人员信息[<?php echo count($members); ?>]</h3>
                        <p id="g_du"></p>
                    </div>
                    <div class="panel-body">
                        <table class="table" id="gtable">
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>邮箱</th>
                                <th>手机</th>
                                <th>部门</th>
                                <th>职位</th>
                                <th>默认审批人</th>
                                <th>角色</th>
                                <?php if($profile['admin'] == 1 || $profile['admin'] == 3) { ?>
                                <th>操作</th>
                                <?php } ?>
                            </tr>
                                <?php foreach($members as $m){ ?>
                                <?php
                                if($search != '' && substr_count($m['nickname'],$search) + substr_count($m['d'],$search) + substr_count($m['email'],$search) + substr_count($m['phone'],$search) + substr_count($m['client_id'], $search)== 0) {
                                    if (array_key_exists($m['level_id'],$levels)) {
                                        if (substr_count($levels[$m['level_id']],$search) == 0) {
                                            continue;
                                        }
                                    } else {
                                        continue;
                                    }
                                }
                                ?>
                                <tr>
                                    <td class="col-1">
                                        <?php echo $m['client_id']; ?>
                                    </td>
                                    <td class="col-2">
                                        <?php echo $m['nickname']; ?> 
                                    </td>
                                    <td class="col-3">
                                        <?php echo $m['email']; ?>
                                    </td>
                                    <td class="col-4">
                                        <?php echo $m['phone']; ?>
                                    </td>
                                    <td class="col-5">
                                        <?php echo $m['d']; ?>
                                    </td>
                                    <td class="col-6">
                                        <?php if (array_key_exists($m['level_id'],$levels)) {?>
                                        <?php echo $levels[$m['level_id']]; }?>
                                    </td>
                                    <td class="col-7">
                                        <?php echo $m['manager']; ?>
                                    </td>
                                    <td class="col-8">
                                        <?php 

                                            $desc = '员工';
                                            $color = '<span class="label label-info arrowed">员工</span>';

                                            if($m['admin'] == 1){
                                                $desc = '管理员';
                                                $color = '<span class="label label-success arrowed">管理员</span>';
                                            } else if ($m['admin'] == 2){
                                                $desc = '出纳';
                                                $color = '<span class="label label-warning arrowed">出纳</span>';
                                            } else if ($m['admin'] == 3){
                                                $desc = 'IT人员';
                                                $color = '<span class="label label-purple arrowed">IT人员</span>';
                                            } else if ($m['admin'] == 4){
                                                $desc = '部门管理员';
                                                $color = '<span class="label label-purple arrowed">部门管理员</span>';
                                            }
                                        ?>
                                        <a href="javascript:void(0)" title="<?php echo $desc; ?>" data-id="<?php echo $m['id']; ?>" >
                                            <?php echo $color; ?>
                                        </a>
                                    </td>

                                    <?php if($profile['admin'] == 1 ||  $profile['admin'] == 3) { ?>
                                    <td class="col-9">
                                    <a href="/members/editmember/<?php echo $m['id']; ?>">
                                        <i  style="margin-left:10px;" alt="<?php echo $desc; ?>" class="ace-icon align-top bigger-125 fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="remove_user" data-id="<?php echo $m['id']; ?>">
                                        <i  style="margin-left:10px;" alt="<?php echo $desc; ?>" class="ace-icon align-top bigger-125 red fa fa-trash-o"></i>
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
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
var admin_groups_granted = $('#admin_groups_granted').data("gids");
var __BASE = "<?php echo $base_url; ?>";
var error = "<?php echo $error;?>";
console.log(error);
var _levels_dic = '<?php echo json_encode($levels); ?>';
var levels_dic = [];
if(_levels_dic!='')
{
	levels_dic = JSON.parse(_levels_dic);
}



$(document).ready(function(){
    if(error)
    {
        show_notify(error);
    }
  
});

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
    $('#gname').html('已邀请人员[' + _member.length + ']');
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
                    var is_under_control = 0;
                    if(_admin == 4 && in_array(admin_groups_granted,gid))
                    {
                        is_under_control = 1;
                    }
                    //show_notify('获取信息成功');
                    var _g_du = '<a href="' + __BASE + '/members/editgroup/' + gid + '"><i class="ace-icon align-top bigger-125 fa fa-pencil white" style="margin-left:10px;" ></i></a>'
                                 +'<a href="javascript:void(0)" class="remove_group" data-id="' + gid + '"><i  style="margin-left:10px;"  class="ace-icon align-top bigger-125 white fa fa-trash-o"></i></a>';
                    if(_admin == 1 || _admin == 3 || is_under_control)
                    {
                        $('#g_du').html(_g_du);
                    }
                    else
                    {
                        $('#g_du').html('');
                    }
                    if(gid == -1){
                        build_invite(data.data);
                        $('#g_du').html('');
                        return;
                    }
                    if(gid == -2){
                        var _member = data.data;
                        var _gname = '全体员工 [ ' + _member.length + ' ]';
                        $('#g_du').html('');
                    } else {
                        data = data.data;
                        var _group = data.group;
                        var _member = data.member;
                        var _gname = _group.name + " [ " + _member.length + ' ]';
                    }
                    
                    
                        $('#gname').html(_gname);
                    
                    $('#gtable').html("");

                var _th = '<tr>'
                    + '<th>ID</th>'
                    + '<th>名称</th>'
                    + '<th>邮箱</th>'
                    + '<th>手机</th>'
                    + '<th>部门</th>'
                    + '<th>职位</th>'
                    + '<th>默认审批人</th>'
                    + '<th>角色</th>';
                    if(_admin == 1 || _admin == 3){
                        _th += '<th>操作</th>'
                    }
                    _th += '</tr>';
                    $(_th).appendTo($('#gtable'));

                    $(_member).each(function(idx, item){
                        var _c = 'gray';
                        var _p = '员工';
                    var _color = '<span class="label label-success arrowed">管理员</span>';
                    switch(item.admin) {
                    case '4' : {
                        //$desc = '出纳';

                        _color = '<span class="label label-purple arrowed">部门管理员</span>';                        
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
                    case '3' : {
                        //$desc = '出纳';

                        _color = '<span class="label label-purple arrowed">IT人员</span>';                        
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
                    case '2' : {
                        //$desc = '出纳';

                        _color = '<span class="label label-warning arrowed">出纳</span>';                        
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
                    case '1' : {
                        _p = '点击设置为管理员'; 
                            var _color = '<span class="label label-success arrowed">管理员</span>';
                    }; break;
                    case '0' : {
                        var _color = '<span class="label label-info arrowed">员工</span>';
                        _c = 'green';
                        _p = '点击设置为员工'; 
                    }; break;
            
                    }

		var _level_id = item.level_id;
		var _level = '';
		if(levels_dic[_level_id]!=undefined)
		{
			_level = levels_dic[_level_id];
		}
                _th = '<tr>'
                    + '<td>' + item.client_id + '</a></td>'
                    + '<td>' + item.nickname+ '</td>'
                    + '<td>' + item.email + '</td>'
                    + '<td>' + item.phone + '</td>'
                    + '<td>' + item.d + '</td>'
                    + '<td>' + _level + '</td>'
                    + '<td>' + item.manager + '</td>'
                    + '<td><a href="javascript:void(0)">' + _color + '</a>';
                    if(_admin == 1 || _admin == 3 || is_under_control){
                    _th += '<td><a href="' + __BASE + '/members/editmember/' + item.id + '"><i class="ace-icon align-top bigger-125 fa fa-pencil " style="margin-left:10px;" ></i></a>'
                    if(gid > 0)
                    {
                             _th += '<a href="javascript:void(0)" class="remove_from_group" data-gid="'+gid+'" data-id="' + item.id + '"><i  style="margin-left:10px;"  class="ace-icon align-top bigger-125 blue fa fa-sign-out"></i></a>';
                     }
                    _th += '<a href="javascript:void(0)" class="remove_user" data-id="' + item.id + '"><i  style="margin-left:10px;"  class="ace-icon align-top bigger-125 red fa fa-trash-o"></i></a></td>';
       
                    }
                    _th += '</tr>';
                    $(_th).appendTo($('#gtable'));

                    });
                }

                bind_event();
                bind_event_group();
                bind_remove_from_group();
            }
            });

}
function bind_event() {
    $('.remove_user').click(function(){
        if(confirm('删除后，用户当前的item也会被删掉，是否继续？') == true){
            var _id = $(this).data('id');
            location.href= __BASE + "/members/remove_member/" + _id;
        }
    });
}

function bind_event_group() {
    $('.remove_group').click(function(){
        if(confirm('是否删除部门') == true){
            var _id = $(this).data('id');
            location.href= __BASE + "/members/delgroup/" + _id;
        }
    });
}

function bind_remove_from_group() {
    $('.remove_from_group').click(function(){
        if(confirm('是否将员工从部门移除？') == true){
            var _id = $(this).data('id');
            var _gid = $(this).data('gid')
            location.href= __BASE + "/members/remove_from_group/" +_gid+"/"+_id;
        }
    });
}
</script>
<script language="javascript">
    var __BASE = "<?php echo $base_url; ?>";
</script>
<script type="text/javascript">
    Array.prototype.remove = function(obj) {
        for (var i = 0; i < this.length; i++) {
            var temp = this[i];
            if (!isNaN(obj)) {
                temp = i;
            }
            if (temp == obj) {
                for (var j = i; j < this.length; j++) {
                    this[j] = this[j + 1];
                }
                this.length = this.length - 1;
            }
        }
    };
    var scripts = [null, "/static/ace/js/fuelux/fuelux.tree.min.js", null];
    ace.load_ajax_scripts(scripts, function() {
        //inline scripts related to this page
        bind_event();
        jQuery(function($) {
            $.ajax({
                url: __BASE + "/members/getgroups",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var ace_icon = ace.vars['icon'];
                    var js_data = {};
                    var obj = new Array();
                    var unroot = new Array();
                    js_data['0'] = {
                        name: '全体员工',
                        id: '-2',
                        type: 'folder',
                        'icon-class': 'red',
                        additionalParameters: {
                            children: []
                        }
                    };
                    var _tree_structure = [];
                    var _all_node = [];
                    $(data).each(function(idx, item) {
                        var _id = item['id'];
                        var _pid = item['pid'];
                        if (_all_node[_id] == undefined) {
                            _all_node[_id] = {};
                            _all_node[_id]['child'] = [];
                            _all_node[_id]['item'] = item;
                        }
                        if (_all_node[_pid] == undefined) {
                            _all_node[_pid] = {};
                            _all_node[_pid]['child'] = [];
                            _all_node[_pid]['item'] = {
                                'pid': _pid,
                                'name': ''
                            };
                            //_all_node[_pid]['item'] = {};
                        }
                        _all_node[_id]['item'] = item;
                        _all_node[_pid]['child'][_id] = item;
                    });
                    var _valid_node = [];
                    var _stop_flag = 1;
                    var _idx = 0;
                    while (_stop_flag) {
                        if (_idx > 3) {
                            _stop_flag = 0;
                            continue;
                        }
                        _idx += 1;
                        _stop_flag = 0;
                        $(_all_node).each(function(idx, item) {
                            if (idx == 0) {
                                return;
                            }
                            if (item == undefined) return;
                            var _pid = item['item']['pid'];
                            var _id = item['item']['id'];
                            _all_node[_pid]['child'][_id] = item;
                            //if(item['pid'] != 0)
                            //    _all_node[_id]['child'] = [];
                        });
                        var _s_all_node = [];
                        $(_all_node).each(function(idx, item) {
                            if (item == undefined) return;
                            if (item['child'].length == 0) return;
                            if (typeof item['pid'] == undefined) return;
                            //if(item['item']['pid'] == 0) return;
                            var _pid = item['item']['pid'];
                            var _id = item['item']['id'];
                            if (_pid != 0 && _all_node[_pid]['child'][_id] != undefined) return;
                            _s_all_node[idx] = item;
                            _stop_flag = 1;
                        });
                        _all_node = _s_all_node;
                        _stop_flag = 0;
                        // 如果都是顶级节点了，那么就可以退出了
                        _s_all_node = [];
                        $(_all_node).each(function(idx, item) {
                            if (item == undefined) return;
                            if (item['item']['name'] == "") _s_all_node[idx] = item;
                            if (item['item']['pid'] == 0) return;
                            _stop_flag = 1;
                        });
                        _all_node = _s_all_node;
                    }
                    var build_node = function(pid, item) {
                        var node = {
                            name: item['item']['name'],
                            id: item['item']['id'],
                            additionalParameters: {
                                children: []
                            },
                            type: 'folder',
                            'icon-class': 'red'
                        };
                        if (item['child'].length > 0) {
                            $(item['child']).each(function(idx, _item) {
                                if (_item == undefined) return;
                                _child = build_node(_item['item']['id'], _item);
                                node['additionalParameters']['children'].push(_child);
                            });
                        }
                        return node;
                    }
                    _sdata = [];
                    if (_all_node[0] != undefined) {
                        $(_all_node[0]['child']).each(function(idx, item) {
                            if (item != undefined) {
                                _sdata.push(item);
                            }
                        });
                    }
                    $(_sdata).each(function(idx, item) {
                        _child = build_node(idx, item);
                        js_data[0]['additionalParameters']['children'].push(_child);
                    });
                    js_data['已邀请'] = {
                        name: '已邀请',
                        id: '-1',
                        type: 'folder',
                        'icon-class': 'red'
                    };
                    var treeDataSource = new DataSourceTree({
                        data: js_data
                    });
                    $('#tree2').ace_tree({
                        dataSource: treeDataSource,
                        loadingHTML: '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
                        'open-icon': 'ace-icon fa fa-cog',
                        'close-icon': 'ace-icon fa fa-cogs',
                        'selectable': true,
                        'selected-icon': null,
                        'unselected-icon': null
                    });
                    $('#tree2').on('updated', function(e, result) {}).on('selected', function(e) {}).on('unselected', function(e) {}).on('opened', function(e, result) {
                        if (result.id != undefined) {
                            var _gid = result.id;
                            load_group(_gid);
                        }
                    }).on('closed', function(e, result) {
                        var _gid = result.id;
                        load_group(_gid);
                    });
                },
                error: function() {}
            });
        });
    });
</script>
<script type="text/javascript">
var DataSourceTree = function(options) {
    this._data = options.data;
    this._delay = options.delay;
};
DataSourceTree.prototype.data = function(options, callback) {
    var self = this;
    var $data = null;
    if (!("name" in options) && !("type" in options)) {
        $data = this._data; //the root tree
        callback({
            data: $data
        });
        return;
    } else if ("type" in options && options.type == "folder") {
        if ("additionalParameters" in options && "children" in options.additionalParameters) $data = options.additionalParameters.children;
        else $data = {} //no data
    }
    if ($data != null) //this setTimeout is only for mimicking some random delay
        setTimeout(function() {
        callback({
            data: $data
        });
    }, parseInt(Math.random() * 500) + 200);
};

setTimeout(function () {
    $(window).on('resize', function () {
        if($(document.body).width() != document.body.scrollWidth) {
            $(document.body).width(document.body.scrollWidth + 36);
            $('.footer-inner').width($('.footer-inner').parent().width()-268);
        } else {
            $(document.body).width('auto');
        }
    });
    $(window).trigger('resize');
}, 1000)
</script>

