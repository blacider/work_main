<!--<script src="/static/ace/js/fuelux/fuelux.tree.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>


<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>

    
     
     
       <script src="/static/ace/js/jquery.colorbox-min.js"></script>
       
         <link rel="stylesheet" href="/static/ace/css/colorbox.css" />

<script language='javascript'>
    var _admin = "<?php echo $profile['admin']; ?>";
</script>


<div class="page-content">
<div class="page-content-area">
<div class="row">\



<div class="col-sm-3">
        <div class="widget-box widget-color-blue">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller">帐套结构</h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-8">
                            <div id="tree2" class="tree"></div>
                        </div>
                    </div>
                </div>
            </div>

<div class="col-xs-8">
    <div class="panel panel-primary">
        <div class="panel-heading  clearfix ">
        <h3 class="panel-title default col-sm-10 col-md-10" id="gname">部门信息</h3>
         <div class="btn-group pull-right" id = "fix">
      </div>
  </div>
              
        <div class="panel-body">
            <table class="table table-striped" id="gtable">
               
<?php 
foreach($ugroups as $m){
?>
<tr>
    <td>
        <p> <?php echo $m['name']; ?> </p>
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



<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";


</script>

<script type="text/javascript">
$(document).ready(function(){
    
function load_group(gid,data){
                    //show_notify('获取信息成功');
                    var _data = data[gid];
                    if(gid == -1){
                        build_invite(data.data);
                        return;
                    }
                    if(gid == -2){
                        var _gname = '全体员工';
                        var _member = data.data;
                    } else {
                        var _member = _data['groups'];
                        var _gname = _data['sob_name'];
                    }
                    $('#gname').html(_gname);

                    var _fix = "";
                    if(_admin == 1){
                    _fix += '<a href="' + __BASE + 'category/sob_update/' + gid + '"><i class="ace-icon align-top bigger-125 fa fa-pencil white" style="margin-left:10px;" ></i></a>'
                    _fix += '<a href="javascript:void(0)" class="remove_user" data-id="' + gid + '"><i  style="margin-left:10px;"  class="ace-icon align-top bigger-125 white fa fa-trash-o"></i></a>';
                    }

                    $('#fix').html(_fix);
                    $('#gtable').html("");


                var _th = '<tr>'
                    //+ '<th>部门号</th>'
                   // + '<th>部门名称</th>';
                   /* if(_admin == 1){
                        _th += '<th>操作</th>'
                    }*/
                  
                    _th += '</tr><tr></tr>';
                    $(_th).appendTo($('#gtable'));

                    $(_member).each(function(idx, item){
                        var _c = 'gray';
                        var _p = '员工';
                        var _color = '<span class="label label-success arrowed">管理员</span>';
                    
                _th = '<tr>'
                 //   + '<td><a href="">' + item.group_id+ '</a></td>'
                    + '<td>' + item.group_name + '</td>'
                  ;
                  _th +='<td></td>';
                   
                    _th += '</tr>';
                    $(_th).appendTo($('#gtable'));

                    });
               bind_event();
            
            
}

function bind_event() {
    //console.log("called");
    
    $('.remove_user').each(function(idx, item){
        $(item).unbind('click');
        $(item).click(function(){
           // console.log(this);
            if(confirm('当前帐套会被删除，是否继续？') == true){
                var _id = $(this).data('id');

                if(_id !== undefined) {
                   // console.log(_id);
                    location.href= __BASE + "category/remove_sob/" + _id;
                }
            }
            });

    });
    /*
    $('.remove_user').unbind('click');
    $('.remove_user').click(function(){
        if(confirm('当前帐套会被删除，是否继续？') == true){
            var _id = $(this).data('id');
             console.log(_id);
            location.href= __BASE + "category/remove_sob/" + _id;
        }
    });
*/
}

    var scripts = [null,"/static/ace/js/fuelux/fuelux.tree.min.js", null]
    ace.load_ajax_scripts(scripts, function() {
      //inline scripts related to this page
         jQuery(function($){
           
         $.ajax({
            url:__BASE+ "/category/getsobs",
            method:'GET',
            dataType:'json',
            success:function(data){
              //  console.log(data);
                 //bind_event();
                 var ace_icon = ace.vars['icon'];
                 var js_data = {};
                 for(var idx in data)
                 {
                  //  console.log(idx);
                    js_data[idx] = {name: data[idx]['sob_name'], id: idx ,type: 'folder', 'icon-class':'red'};   
                 };

                 var treeDataSource = new DataSourceTree({data: js_data});

                    $('#tree2').ace_tree({
                        dataSource: treeDataSource ,
                        loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
                        'open-icon' : 'ace-icon fa fa-cog',
                        'close-icon' : 'ace-icon fa fa-cogs',
                        'selectable' : true,
                        'selected-icon' : null,
                        'unselected-icon' : null
                    });
                    
                    
                    $('#tree2')
                    .on('updated', function(e, result) {
                        //result.info  >> an array containing selected items
                        //result.item
                        //result.eventType >> (selected or unselected)
                    })
                    .on('selected', function(e) {
                        console.log("group selected");
                    })
                    .on('unselected', function(e) {
                    })
                    .on('opened', function(e,result) {
                        //var _gid = _data;
                        
                            var _gid = result.id;
                            //console.log(result.id);
                            //console.log(data[_gid]);
                            load_group(_gid,data);
                        
                    })
                    .on('closed', function(e,result) {
                          var _gid = result.id;
                         //   console.log(result.id);
                           // console.log(data[_gid]);
                            load_group(_gid,data);
                    });

            },
            error:function()
            {
                alert("error");
            }
        });
     });
     });




    $('.chosen-select').chosen({allow_single_deselect:true}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');
    });
</script>

<script type="text/javascript">
    
    var DataSourceTree = function(options) {
    this._data  = options.data;
    this._delay = options.delay;
}

DataSourceTree.prototype.data = function(options, callback) {
    var self = this;
    var $data = null;

    if(!("name" in options) && !("type" in options)){
        $data = this._data;//the root tree
        callback({ data: $data });
        return;
    }
    else if("type" in options && options.type == "folder") {
        if("additionalParameters" in options && "children" in options.additionalParameters)
            $data = options.additionalParameters.children;
        else $data = {}//no data
    }
    
    if($data != null)//this setTimeout is only for mimicking some random delay
        setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

    //we have used static data here
    //but you can retrieve your data dynamically from a server using ajax call
    //checkout examples/treeview.html and examples/treeview.js for more info
};

</script>
-->
<!-- /section:basics/sidebar -->
<div class="main-content">

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>标签名称</th>
                                    <th>最后修改时间</th>
                                    <th class="hidden-680">
                                        <a href="<?php echo base_url('category/new_sob');?>" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a>
                                    </th>
                                </tr>

                                <tr>
                                    <td class="u_username">默认帐套</td>
                                    <td class="u_role_name"></td>
                                   <td style="width:50px;">   <a href="#" class="editno"  data-title="" data-id="0"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="delno" data-id="0"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>

                            </thead>
                            <tbody>
<?php
//echo json_encode($acc_sets);

foreach($acc_sets as $item){
    $img = "";
    $str = '<tr>';
$username = '<td class="u_username">' . $item['name'] . '</td>';
$role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
$url_edit = base_url('category/sob_update/'. $item['id']);
$operation_upd = '<td style="width:50px;">   <a href="' . $url_edit .'" class="edit"  data-title="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
    $operation = '<td style="width:50px;"><a class="btn btn-xs btn-danger" href="' .  base_url('category/remove_sob/?id='. $item['id']) .'">
        <i class="ace-icon fa fa-trash-o bigger-120"></i>
        </a></td>';
$str = $str . $username . $role_id . $operation_upd . '</tr>';
echo $str;

}?>
</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->


</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script language="javascript">
var __BASEURL = "<?php echo $base_url; ?>";
$(document).ready(function(){

    $('.edit').each(function(idx, item){
        $(item).click(function(){
            var _id = $(this).data('id');
                location.href = __BASEURL + "category/sob_update/" + _id;
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "category/remove_sob/" + _id;
            }
        });
    });

    $('.delno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许删除')){
              
            }
        });
    });

      $('.editno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许修改')){
              
            }
        });
    });

});
</script>
