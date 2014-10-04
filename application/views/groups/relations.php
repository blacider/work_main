<link rel="stylesheet" href="<?php echo base_url('statics/third-party/zTree_v3/css/zTreeStyle/zTreeStyle.css');?>" type="text/css"> 
<div class="bs-doc-section">

<div class="ztree" id="tree"></div>
</div>
<script src="<?php echo base_url('statics/third-party/zTree_v3/js/jquery.ztree.all-3.5.min.js');?>"></script>
<script language="javascript">
var __PREFIX = "<?php echo base_url(); ?>";
var __DATA = (new Function("", "return " + '<?php echo $members; ?>'))();
$(document).ready(function(){
    var setting = {  
        view: {
            dblClickExpand: false,
                showLine: true,
                selectedMulti: false
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
            }
        ,callback: {
            onRename: function(event, treeId, treeNode, isCancel){
                var _data = {
                    uid : treeNode.id
                    ,nickname : treeNode.nickname
                };
                $.post(__PREFIX + "users/update_nickname", _data)
                    .success(function(data){
                        data = $.parseJSON(data);
                        console.log(data);
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
