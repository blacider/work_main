<link rel="stylesheet" href="<?php echo base_url('statics/third-party/zTree_v3/css/zTreeStyle/zTreeStyle.css');?>" type="text/css"> 
<div class="bs-doc-section">

<div class="ztree" id="tree"></div>
</div>
<script src="<?php echo base_url('statics/third-party/zTree_v3/js/jquery.ztree.all-3.5.min.js');?>"></script>
<script language="javascript">
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
    };  
    $.fn.zTree.init($("#tree"), setting, __DATA); 
});
</script>
