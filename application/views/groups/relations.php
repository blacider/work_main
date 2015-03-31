<!-- /section:basics/sidebar -->
<!-- <link rel="stylesheet" href="<?php echo base_url('statics/third-party/zTree_v3/css/zTreeStyle/zTreeStyle.css');?>" type="text/css" />  
<script src="<?php echo base_url('statics/third-party/zTree_v3/js/jquery.ztree.all-3.5.min.js');?>"></script>
-->
<div class="main-content">

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->
    <div class="ace-settings-container" id="ace-settings-container">
    </div><!-- /.ace-settings-container -->

    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                组织关系管理
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="ztree" id="tree"></div>
                    </div><!-- /.span -->
                    <div class="col-sm-8">
<div class="col-xs-12 col-sm-5 center">
<div>
<!-- #section:pages/profile.picture -->
<span class="profile-picture">
<img id="avatar" class="editable img-responsive editable-click editable-empty" alt="用户头像" src=""></img>
</span>

<!-- /section:pages/profile.picture -->
<div class="space-4"></div>

<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
<div class="inline position-relative">
&nbsp;
<span class="white" id="username"></span>
</a>
</div>
</div>
</div>

<div class="space-6"></div>

<div class="profile-user-info">
<div class="profile-info-row">
<div class="profile-info-name"> 公司</div>

<div class="profile-info-value">
<span id="show_corp"></span>
</div>
</div>

<div class="profile-info-row">
<div class="profile-info-name"> 邮箱</div>

<div class="profile-info-value">
<span id="show_email"></span>
</div>
</div>

<div class="profile-info-row">
<div class="profile-info-name"> 手机 </div>

<div class="profile-info-value">
<span id="show_mobile"></span>
</div>
</div>

<div class="profile-info-row">
<div class="profile-info-name"> 最后活动时间 </div>

<div class="profile-info-value">
<span id="show_lastdt"></span>
</div>
</div>

</div>
<!-- #section:pages/profile.contact -->
</div>

<!-- /section:pages/profile.contact -->

<!-- #section:custom/extra.grid -->
<!-- /section:custom/extra.grid -->
</div>
                    </div><!-- /.span -->
                </div><!-- /.row -->

                <div id="modal-table" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="blue bigger"> 创建公司 </h4>
                            </div>
                            <form method="post" action="<?php echo base_url('groups/create'); ?>">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="form-field-username">公司名称</label>
                                                <div>
                                                    <input class="input-large" type="text" id="form-field-username" placeholder="公司名称" name="groupname" />
                                                </div>
                                            </div>

                                            <div class="space-4"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal">
                                        <i class="ace-icon fa fa-times"></i>
                                        取消
                                    </button>
                                    <input type="submit" class="btn btn-sm btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- PAGE CONTENT ENDS -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script src="<?php echo base_url('statics/third-party/zTree_v3/js/jquery.ztree.all-3.5.min.js');?>"></script>
<script language="javascript">
var __PREFIX = "<?php echo base_url(); ?>";
var __DATA = (new Function("", "return " + '<?php echo $members; ?>'))();
$(document).ready(function(){
    var setting = {  
        view: {
            dblClickExpand: false,
                showLine: true
                ,selectedMulti: false
                ,fontCss : 'nickcss'
        },
        data: {
            key : {
                name : 'nickname'
            },
            simpleData: {
                enable:true,
                    name : 'nickname',
                    idKey: "id",
                    pIdKey: "manager_id",
                    rootPId: "0"
            }
        },
            edit : {
                enable : true
                    ,showRemoveBtn : false
            }
        ,callback: {
            onClick: function(event, treeId, treeNode, flag) {
                var uid = treeNode.id;
                $.getJSON(__PREFIX + "users/info/" + uid)
                    .success(function(data){
                        //data = $.parseJSON(data);
                        if(data.code < 0){
                            show_notify(data.data.msg);
                        } else {
                            if(data.avatar) {
                                $('#avatar').attr('src', __PREFIX + data.avatar);
                            } else {
                                $('#avatar').attr('src', '/static/assets/avatars/profile-pic.jpg');
                            }
                            $('#username').html(data.data.nickname);
                            $('#show_corp').html(data.data.group_name);
                            $('#show_email').html(data.data.email);
                            $('#show_mobile').html(data.data.phone);
                            $('#show_lastdt').html(data.data.dt);
                            show_notify("加载信息成功");
                        }
                    })
                        .error(function(){
                            show_notify("加载信息失败");
                        });
            },
            onRename: function(event, treeId, treeNode, isCancel){
                var _data = {
                    uid : treeNode.id
                    ,nickname : treeNode.nickname
                };
                $.post(__PREFIX + "users/update_nickname", _data)
                    .success(function(data){
                        data = $.parseJSON(data);
                        if(data.code < 0){
                            show_notify(data.data.msg);
                        } else {
                            show_notify("修改昵称成功");
                        }
                    })
                        .error(function(){
                        show_notify("修改昵称失败");
                        });
            },
                onDrop : function(event, treeId, treeNodes, targetNode, moveType) {
                    var uid = 0;
                    var _new_manager = 0;
                    var _email = '';
                    $(treeNodes).each(function(idx, item){
                        if(item){
                            uid = item.id;
                            _new_manager = item.manager_id;
                            _email = item.email;
                        }
                    });
                    _new_manager = _new_manager == 0 ? 'top' : _new_manager;
                    var _data = {
                        uid : uid
                            ,manager_id : _new_manager
                    };
                $.post(__PREFIX + "users/update_manager", _data)
                    .success(function(data){
                        if(data.code < 0){
                            show_notify(data.data.msg);
                        } else {
                            show_notify("修改经理成功");
                        }
                    })
                        .error(function(){
                        show_notify("修改经理失败");
                        });
                }
        }
    };  
    $.fn.zTree.init($("#tree"), setting, __DATA); 
});
</script>
<link rel="stylesheet" href="<?php echo base_url('statics/third-party/zTree_v3/css/zTreeStyle/zTreeStyle.css');?>" type="text/css" />  
